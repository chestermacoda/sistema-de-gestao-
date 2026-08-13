<?php

namespace App\Livewire\Admin\Leituras;

use Livewire\Component;

use App\Services\Leituristas;
use App\Models\Leituras;
use App\Models\Medidores;
use App\Models\Cliente;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;

use Livewire\WithFileUploads;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Importarleituras extends Component
{
    use WithFileUploads;

    public $arquivo;
    public string $mes_referencia = '';
    public int $user_id;
    public bool $validar_anomalias = true;
    public bool $ignorar_duplicados = true;

    // Progresso
    public int $total_linhas = 0;
    public int $processadas = 0;
    public int $sucessos = 0;
    public int $erros = 0;
    public int $anomalias = 0;
    public bool $processando = false;
    public bool $concluido = false;
    public float $percentual = 0;

    // Log de erros
    public array $log_erros = [];
    public array $log_anomalias = [];

    protected $rules = [
        'arquivo'          => 'required|file|mimes:xlsx,xls|max:5120', // 5MB
        'mes_referencia'   => 'required|string|size:7', // 2026-05
        'user_id'          => 'required|integer|exists:users,id',
        'validar_anomalias' => 'boolean',
        'ignorar_duplicados' => 'boolean',
    ];

    protected $messages = [
        'arquivo.required'        => 'Selecione um arquivo Excel',
        'arquivo.mimes'           => 'O arquivo deve ser .xlsx ou .xls',
        'arquivo.max'             => 'O arquivo não pode ultrapassar 5MB',
        'mes_referencia.required' => 'Informe o mês de referência',
        'mes_referencia.size'     => 'Formato: AAAA-MM (ex: 2026-05)',
        'user_id.required'        => 'Selecione o leiturista',
    ];

    public function mount()
    {
        $this->mes_referencia = now()->format('Y-m');
        $this->user_id = Auth::id();
    }

    /**
     * Baixa modelo Excel para preenchimento
     */
    public function baixarModelo()
    {

        return app(Leituristas::class)->gerarModeloExcel();
    }

    /**
     * Processa o upload do Excel
     */
    public function importar(): void
    {
        $this->validate();

        $this->processando = true;
        $this->concluido = false;
        $this->processadas = 0;
        $this->sucessos = 0;
        $this->erros = 0;
        $this->anomalias = 0;
        $this->log_erros = [];
        $this->log_anomalias = [];

        try {
            // Lê o Excel
            $caminho = $this->arquivo->getRealPath();
            $dados = app(Leituristas::class)->lerExcelLeituras($caminho);

            $this->total_linhas = count($dados);

            if ($this->total_linhas === 0) {
                $this->dispatch('notify', type: 'warning', message: 'Nenhuma linha válida encontrada no arquivo.');
                $this->processando = false;
                return;
            }

            // Processa em lote
            foreach ($dados as $index => $linha) {
                $this->processarLinha($linha, $index + 1);

                // Atualiza progresso a cada 5 registros (para não sobrecarregar)
                if ($index % 5 === 0) {
                    $this->atualizarProgresso();
                }
            }

            $this->atualizarProgresso();
            $this->concluido = true;

            $msg = sprintf(
                'Importação concluída! %d sucessos, %d anomalias, %d erros.',
                $this->sucessos,
                $this->anomalias,
                $this->erros
            );

            $this->dispatch(
                'notify',
                type: $this->erros > 0 ? 'warning' : 'success',
                message: $msg
            );

            $this->dispatch('reload-leituras');
        } catch (\Exception $e) {
            $this->log_erros[] = ['linha' => 0, 'erro' => 'Erro geral: ' . $e->getMessage()];
            $this->dispatch('notify', type: 'error', message: 'Erro na importação: ' . $e->getMessage());
        } finally {
            $this->processando = false;
            $this->arquivo = null;
        }
    }

    /**
     * Processa uma linha do Excel
     */
    private function processarLinha(array $linha, int $numeroLinha): void
    {
        try {
            // Valida campos obrigatórios
            if (empty($linha['numero_hidrometro']) || empty($linha['leitura_atual'])) {
                $this->erros++;
                $this->log_erros[] = [
                    'linha' => $numeroLinha,
                    'hidrometro' => $linha['numero_hidrometro'] ?? 'N/A',
                    'erro' => 'Número do hidrômetro ou leitura não informados'
                ];
                return;
            }

            // Busca medidor pelo número do hidrômetro
            $medidor = Medidores::where('numero_hidrometro', trim($linha['numero_hidrometro']))
                ->where('status_inicial', 'instalado')
                ->first();

            if (!$medidor) {
                $this->erros++;
                $this->log_erros[] = [
                    'linha' => $numeroLinha,
                    'hidrometro' => $linha['numero_hidrometro'],
                    'erro' => 'Hidrômetro não encontrado ou não instalado'
                ];
                return;
            }

            // Verifica duplicado no mês
            if ($this->ignorar_duplicados) {
                $existe = Leituras::where('medidores_id', $medidor->id)
                    ->where('mes_referencia', $this->mes_referencia)
                    ->exists();

                if ($existe) {
                    $this->erros++;
                    $this->log_erros[] = [
                        'linha' => $numeroLinha,
                        'hidrometro' => $linha['numero_hidrometro'],
                        'erro' => 'Leitura já existe para este mês'
                    ];
                    return;
                }
            }

            // Busca última leitura para calcular anterior
            $ultimaLeitura = Leituras::where('medidores_id', $medidor->id)
                ->latest('data_leitura')
                ->first();

            $leituraAnterior = $ultimaLeitura?->leitura_atual ?? $medidor->cliente?->instalacaoAtiva?->leitura_inicial ?? 0;

            // Prepara dados
            $dados = [
                'cliente_id'       => $medidor->cliente_id,
                'medidores_id'     => $medidor->id,
                'user_id'          => $this->user_id,
                'mes_referencia'   => $this->mes_referencia,
                'data_leitura'     => $linha['data_leitura'] ?? now()->format('Y-m-d'),
                'hora_leitura'     => $linha['hora_leitura'] ?? now()->format('H:i:s'),
                'leitura_anterior' => (float) $leituraAnterior,
                'leitura_atual'    => (float) $linha['leitura_atual'],
                'confirmada_local' => true,
                'origem'           => 'importacao_excel',
            ];

            // Cria pelo Service (que calcula consumo, média e detecta anomalias)
            $leitura = app(Leituristas::class)->create($dados);

            $this->sucessos++;

            // Verifica se gerou anomalia
            if ($leitura->tem_anomalia) {
                $this->anomalias++;
                $this->log_anomalias[] = [
                    'linha' => $numeroLinha,
                    'hidrometro' => $linha['numero_hidrometro'],
                    'cliente' => $medidor->cliente?->nome_completo ?? 'N/A',
                    'consumo' => $leitura->consumo,
                    'tipo' => $leitura->tipo_anomalia,
                    'descricao' => $leitura->descricao_anomalia,
                ];
            }
        } catch (\Exception $e) {
            $this->erros++;
            $this->log_erros[] = [
                'linha' => $numeroLinha,
                'hidrometro' => $linha['numero_hidrometro'] ?? 'N/A',
                'erro' => $e->getMessage()
            ];
        }

        $this->processadas++;
    }

    /**
     * Atualiza percentual de progresso
     */
    private function atualizarProgresso(): void
    {
        $this->percentual = $this->total_linhas > 0
            ? round(($this->processadas / $this->total_linhas) * 100, 1)
            : 0;

        // Força atualização do DOM
        $this->dispatch('progresso-atualizado', [
            'percentual' => $this->percentual,
            'processadas' => $this->processadas,
            'total' => $this->total_linhas,
        ]);
    }



    public function render()
    {
        return view('livewire.admin.leituras.importarleituras');
    }
}