<?php

namespace App\Livewire\Admin\Roteiro;

use App\Models\Cliente;
use App\Models\Faturas;
use App\Models\Medidores;
use App\Models\RoteiroLeiturista;
use App\Models\Tarifa;
use App\Services\Relatorio\RelatorioService;
use Carbon\Carbon;
use Livewire\Component;

class PreviewRoteiro extends Component
{

    // ─── Propriedades do Roteiro ──────────────────────────────
    public ?int $roteiroId = null;
    public ?int $userId = null;
    public ?string $dataReferente = null;
    public ?string $zona = null;

    // ─── Dados Calculados ────────────────────────────────────
    public array $roteiro = [];
    public array $leiturista = [];
    public array $itens = [];
    public array $timeline = [];
    public array $resumo = [
        'total' => 0,
        'ok' => 0,
        'pendentes' => 0,
        'anomalias' => 0,
        'nao_lidos' => 0,
        'problemas' => 0,
        'percentual' => 0,
    ];

    // ─── Filtros ─────────────────────────────────────────────
    public string $filtroStatus = 'todos';
    public string $busca = '';

    // ─── Estado ──────────────────────────────────────────────
    public bool $mostrarTimeline = true;
    public bool $carregando = false;
    public bool $verFaturas = false;
    public $relatorio;

    // ═══════════════════════════════════════════════════════════
    // CARREGAR ROTEIRO
    // ═══════════════════════════════════════════════════════════

    #[\Livewire\Attributes\On('preview-roteiro')]
    public function carregarRoteiro(int $userId, $dataReferente = null, ?string $zona = null): void
    {

        $this->resetAll();
        $this->dispatch('openModal', 'modal-preview');

        $this->userId = $userId;
        $this->dataReferente = $dataReferente;
        $this->zona = $zona;

        $query = RoteiroLeiturista::with(['cliente', 'user', 'medidores'])
            ->where('user_id', $userId);

        if ($dataReferente) {
            $query->whereDate('data_referente', $dataReferente);
        }

        if ($zona) {
            $query->where('Zona', $zona);
        }

        $itens = $query->orderBy('ordem', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        if ($itens->isEmpty()) {
            $this->dispatch('notify', [
                'type' => 'warning',
                'message' => 'Nenhum roteiro encontrado para os critérios selecionados.',
            ]);
            return;
        }

        // ─── Dados do leiturista ──────────────────────────────
        $primeiroItem = $itens->first();
        $leiturista = $primeiroItem->user;

        $this->leiturista = [
            'id' => $leiturista?->id,
            'nome' => $leiturista?->name ?? 'N/A',
            'email' => $leiturista?->email ?? 'N/A',
            'matricula' => $leiturista?->numero_matricula ?? 'N/A',
        ];

        // ─── Período do roteiro ───────────────────────────────
        $dataRef = $primeiroItem->data_referente;
        $mesAno = $dataRef ? Carbon::parse($dataRef)->translatedFormat('F/Y') : 'N/A';

        $this->roteiro = [
            'zona' => $primeiroItem->Zona ?? 'N/A',
            'data_referente' => $dataRef?->format('d/m/Y') ?? 'N/A',
            'mes_ano' => $mesAno,
            'status' => $this->calcularStatusGeral($itens),
            'data_inicio' => $itens->whereNotNull('data_inicio')->first()?->data_inicio?->format('d/m/Y H:i') ?? null,
            'data_fim' => $itens->whereNotNull('data_fim')->first()?->data_fim?->format('d/m/Y H:i') ?? null,
        ];

        // ─── Processar itens ──────────────────────────────────
        $this->itens = $itens->map(function ($item, $index) {
            $status = $this->determinarStatusItem($item);

            return [
                'id' => $item->id,
                'ordem' => $item->ordem ?? ($index + 1),
                'endereco' => $this->formatarEndereco($item->cliente),
                'medidor' => $item->medidores?->numero_serie ?? 'N/A',
                'matricula' => $item->cliente?->numero_matricula ?? 'N/A',
                'cliente_nome' => $item->cliente?->nome_completo ?? 'N/A',
                'leitura_anterior' => $item->leitura_anterior,
                'leitura_atual' => $item->leitura_atual,
                'consumo' => $this->calcularConsumo($item),
                'status' => $status,
                'lido_em' => $item->lido_em?->format('d/m/Y H:i') ?? null,
                'observacoes' => $item->observacoes,
                'foto' => $item->foto,
            ];
        })->toArray();

        // ─── Calcular resumo ──────────────────────────────────
        $this->calcularResumo();

        // ─── Gerar timeline ───────────────────────────────────
        $this->gerarTimeline($itens);


        $this->dispatch('openModal', 'modal-preview');
    }


    public function print_faturas()
    {
        // $this->resetAll();
        // $this->dispatch('openModal', 'modal-preview');

        $userId = $this->userId;
        $dataReferente =   $this->dataReferente;
        $zona = $this->zona;


        $query = RoteiroLeiturista::with(['cliente', 'user', 'medidores'])
            ->where('user_id', $userId);

        if ($dataReferente) {
            $query->whereDate('data_referente', $dataReferente);
        }

        if ($zona) {
            $query->where('Zona', $zona);
        }

        $itens = $query->orderBy('ordem', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        if ($itens->isEmpty()) {
            $this->dispatch('notify', [
                'type' => 'warning',
                'message' => 'Nenhum roteiro encontrado para os critérios selecionados.',
            ]);
            return;
        }





        // ─── Dados do leiturista ──────────────────────────────
        $primeiroItem = $itens->first();
        $leiturista = $primeiroItem->user;


        $this->leiturista = [
            'id' => $leiturista?->id,
            'nome' => $leiturista?->name ?? 'N/A',
            'email' => $leiturista?->email ?? 'N/A',
            'matricula' => $leiturista?->numero_matricula ?? 'N/A',
        ];

        // ─── Período do roteiro ───────────────────────────────
        $dataRef = $primeiroItem->data_referente;
        $mesAno = $dataRef ? Carbon::parse($dataRef)->translatedFormat('F/Y') : 'N/A';

        $this->roteiro = [
            'zona' => $primeiroItem->Zona ?? 'N/A',
            'data_referente' => $dataRef?->format('d/m/Y') ?? 'N/A',
            'mes_ano' => $mesAno,
            'status' => $this->calcularStatusGeral($itens),
            'data_inicio' => $itens->whereNotNull('data_inicio')->first()?->data_inicio?->format('d/m/Y H:i') ?? null,
            'data_fim' => $itens->whereNotNull('data_fim')->first()?->data_fim?->format('d/m/Y H:i') ?? null,
        ];

        $normas = '31/07/2026';


        // dd($fatura);

        // ─── Processar itens ──────────────────────────────────
        $this->itens = $itens->map(function ($item, $index) {
            $status = $this->determinarStatusItem($item);
            $tafiras = $this->DevolverTarifas($item->cliente?->categoria_consumo);
            $fatura = $this->FaturasRecente($item->cliente?->id);
            $medidors = Medidores::where('cliente_id', $item->cliente?->id)->first();
            return [
                'id' => $item->id,
                'ordem' => $item->ordem ?? ($index + 1),
                'endereco' => $this->formatarEndereco($item->cliente),

                'medidor' => $medidors?->numero_serie ?? 'N/A',

                'medidor_numero' => $medidors?->numero_hidrometro ?? 'N/A',

                'matricula' => $item->cliente?->numero_matricula ?? 'N/A',
                'cliente_nome' => $item->cliente?->nome_completo ?? 'N/A',
                'leitura_anterior' => $item->leitura_anterior,
                'cliente_dados' => $item->cliente->first(),
                'leitura_atual' => $item->leitura_atual,
                'consumo' => $this->calcularConsumo($item),
                'status' => $status,
                'categoria' => $item->cliente?->categoria_consumo,
                'tarifas' => [
                    'categoria' => $tafiras->categoria,
                    'valor_m3' => $tafiras->valor_m3,
                    'taxa_minima' => $tafiras->taxa_minima,
                    'limite_m3' => $tafiras->limite_m3,
                ],
                'Fatura' => [
                    'codgo_fatura' => $fatura->codigo_fatura,
                    'valor_total' => $fatura->valor_total,
                    'valor_pago' => $fatura->valor_pago,
                    'saldo_atual' => $fatura->saldo_atual,
                    'consumo_m3' => $fatura->consumo_m3,
                    'status' => $fatura->status,
                    'multa' => $fatura->multa,

                    'periodo_inicio' => $fatura->data_emissao?->format('d/m/Y'),
                    'periodo_fim' => $fatura->data_vencimento?->format('d/m/Y'),
                    'mes_referencia' => $fatura->mes_referencia,
                ],

                'fatura_id' => $fatura->id,
                'cliente_id' => $item->cliente?->id,

                'lido_em' => $item->lido_em?->format('d/m/Y H:i') ?? null,
                'observacoes' => $item->observacoes,
                'foto' => $item->foto,
                'data_referencia' =>   $this->dataReferente,

            ];
        })->toArray();

        // ─── Calcular resumo ──────────────────────────────────
        // $this->calcularResumo();

        // ─── Gerar timeline ───────────────────────────────────
        // $this->gerarTimeline($itens);
        $dataRef = $this->dataReferente;
        $dados = [
            'user_id' => $this->userId,
            'data_referencia' =>   $dataRef,
            'origem' => 'Fatura-' . $this->userId,
            'zona' => $zona,
        ];
        $this->relatorio = app(RelatorioService::class)->FaturaConsumo($this->itens, $dados);
        $this->verFaturas = true;
        $this->dispatch('openModal', 'modal-editar-roteiros');
    }


    public function DevolverTarifas($tarifa)
    {
        return Tarifa::where('categoria', $tarifa)->first();
    }
    public function FaturasRecente($fatura)
    {
        return Faturas::where('cliente_id', $fatura)
            ->latest('mes_referencia')
            ->first();
    }

    // ═══════════════════════════════════════════════════════════
    // DETERMINAR STATUS DO ITEM
    // ═══════════════════════════════════════════════════════════

    protected function determinarStatusItem($item): string
    {
        // Se tem leitura_atual preenchida
        if ($item->leitura_atual !== null) {
            // Verifica se há anomalia
            $consumo = $this->calcularConsumo($item);
            if ($consumo < 0 || $consumo > 500) {
                return 'Anomalia';
            }
            return 'OK';
        }

        // Se tem foto mas sem leitura
        if ($item->foto) {
            return 'Problema';
        }

        // Se tem data de início mas não leu
        if ($item->data_inicio && !$item->lido_em) {
            return 'Não lido';
        }

        // Status baseado no campo status
        return match ($item->status) {
            'Concluido' => 'OK',
            'Em andamento' => 'Pendente',
            'Problema' => 'Problema',
            'Não lido' => 'Não lido',
            default => 'Pendente',
        };
    }

    // ═══════════════════════════════════════════════════════════
    // CALCULAR CONSUMO
    // ═══════════════════════════════════════════════════════════

    protected function calcularConsumo($item): ?float
    {
        if ($item->leitura_atual === null || $item->leitura_anterior === null) {
            return null;
        }

        $consumo = (float) $item->leitura_atual - (float) $item->leitura_anterior;
        return max(0, $consumo);
    }

    // ═══════════════════════════════════════════════════════════
    // FORMATAR ENDEREÇO
    // ═══════════════════════════════════════════════════════════

    protected function formatarEndereco(?Cliente $cliente): string
    {
        if (!$cliente) {
            return 'Endereço não disponível';
        }

        $partes = array_filter([
            $cliente->rua,
            $cliente->numero ? 'Nº ' . $cliente->numero : null,
            $cliente->bairro,
            $cliente->cidade,
        ]);

        return implode(' — ', $partes) ?: 'Endereço incompleto';
    }

    // ═══════════════════════════════════════════════════════════
    // CALCULAR STATUS GERAL DO ROTEIRO
    // ═══════════════════════════════════════════════════════════

    protected function calcularStatusGeral($itens): string
    {
        $total = $itens->count();
        $lidos = $itens->whereNotNull('leitura_atual')->count();
        $anomalias = $itens->filter(fn($i) => $this->determinarStatusItem($i) === 'Anomalia')->count();
        $problemas = $itens->where('status', 'Problema')->count();

        if ($problemas > 0) {
            return 'Problema';
        }

        if ($anomalias > 0) {
            return 'Em andamento';
        }

        if ($lidos === 0) {
            return 'Pendente';
        }

        if ($lidos === $total) {
            return 'Concluido';
        }

        return 'Em andamento';
    }

    // ═══════════════════════════════════════════════════════════
    // CALCULAR RESUMO
    // ═══════════════════════════════════════════════════════════

    protected function calcularResumo(): void
    {

        // dd(collect($this->itens));
        $total = count($this->itens);

        $ok = collect($this->itens)->where('status', 'OK')->count();
        $pendentes = collect($this->itens)->where('status', 'Pendente')->count();
        $anomalias = collect($this->itens)->where('status', 'Anomalia')->count();
        $naoLidos = collect($this->itens)->where('status', 'Não lido')->count();
        $problemas = collect($this->itens)->where('status', 'Problema')->count();

        $this->resumo = [
            'total' => $total,
            'ok' => $ok,
            'pendentes' => $pendentes,
            'anomalias' => $anomalias,
            'nao_lidos' => $naoLidos,
            'problemas' => $problemas,
            'percentual' => $total > 0 ? round((($ok + $anomalias) / $total) * 100) : 0,
        ];
    }

    // ═══════════════════════════════════════════════════════════
    // GERAR TIMELINE
    // ═══════════════════════════════════════════════════════════

    protected function gerarTimeline($itens): void
    {
        $this->timeline = [];

        // Evento: Início do roteiro
        $primeiroLido = $itens->whereNotNull('data_inicio')->first();
        if ($primeiroLido) {
            $this->timeline[] = [
                'tipo' => 'inicio',
                'titulo' => 'Roteiro Iniciado',
                'descricao' => $this->leiturista['nome'] . ' iniciou o roteiro de leitura na ' . ($this->roteiro['zona'] ?? 'zona'),
                'data' => Carbon::parse($primeiroLido->data_inicio)->format('d/m/Y H:i'),
                'autor' => $this->leiturista['nome'],
                'status' => 'OK',
            ];
        }

        // Evento: Marcos de progresso (25%, 50%, 75%)
        $total = $itens->count();
        $lidos = $itens->whereNotNull('leitura_atual');

        $marcos = [0.25, 0.50, 0.75];
        foreach ($marcos as $marco) {
            $qtdMarco = (int) ceil($total * $marco);
            $itemMarco = $lidos->skip($qtdMarco - 1)->first();

            if ($itemMarco && $itemMarco->lido_em) {
                $percentual = (int) ($marco * 100);
                $this->timeline[] = [
                    'tipo' => 'progresso',
                    'titulo' => $percentual . '% Concluído',
                    'descricao' => $qtdMarco . ' medidores lidos. ' .
                        collect($this->itens)->where('status', 'Anomalia')->count() . ' anomalias detectadas.',
                    'data' => $itemMarco->lido_em->format('d/m/Y H:i'),
                    'autor' => $this->leiturista['nome'],
                    'status' => 'OK',
                ];
            }
        }

        // Evento: Anomalias detectadas
        $anomalias = $itens->filter(fn($i) => $this->determinarStatusItem($i) === 'Anomalia');
        foreach ($anomalias->take(3) as $anomalia) {
            $this->timeline[] = [
                'tipo' => 'anomalia',
                'titulo' => 'Anomalia Detectada',
                'descricao' => 'Consumo anormal no medidor ' . ($anomalia->medidores?->numero_serie ?? 'N/A') .
                    '. Leitura: ' . $anomalia->leitura_atual . ' m³.',
                'data' => $anomalia->lido_em?->format('d/m/Y H:i') ?? now()->format('d/m/Y H:i'),
                'autor' => 'Sistema Auto',
                'status' => 'Anomalia',
            ];
        }

        // Evento: Conclusão
        $ultimoLido = $itens->whereNotNull('data_fim')->first();
        if ($ultimoLido && $this->resumo['percentual'] >= 100) {
            $this->timeline[] = [
                'tipo' => 'conclusao',
                'titulo' => 'Roteiro Concluído',
                'descricao' => 'Todos os ' . $total . ' medidores foram lidos com sucesso.',
                'data' => Carbon::parse($ultimoLido->data_fim)->format('d/m/Y H:i'),
                'autor' => $this->leiturista['nome'],
                'status' => 'OK',
            ];
        }

        // Ordenar por data
        usort(
            $this->timeline,
            fn($a, $b) =>
            Carbon::createFromFormat('d/m/Y H:i', $a['data'])->timestamp <=>
                Carbon::createFromFormat('d/m/Y H:i', $b['data'])->timestamp
        );
    }

    // ═══════════════════════════════════════════════════════════
    // FILTRAR ITENS
    // ═══════════════════════════════════════════════════════════

    public function getItensFiltradosProperty(): array
    {
        $itens = collect($this->itens);

        // Filtro por status
        if ($this->filtroStatus !== 'todos') {
            $itens = $itens->where('status', ucfirst($this->filtroStatus));
        }

        // Filtro por busca
        if ($this->busca) {
            $termo = strtolower($this->busca);
            $itens = $itens->filter(function ($item) use ($termo) {
                return str_contains(strtolower($item['cliente_nome']), $termo) ||
                    str_contains(strtolower($item['endereco']), $termo) ||
                    str_contains(strtolower($item['medidor']), $termo) ||
                    str_contains(strtolower($item['matricula']), $termo);
            });
        }

        return $itens->values()->toArray();
    }

    // ═══════════════════════════════════════════════════════════
    // AÇÕES
    // ═══════════════════════════════════════════════════════════

    public function exportarPDF(): void
    {
        $this->dispatch('exportarRoteiroPDF', [
            'user_id' => $this->userId,
            'data_referente' => $this->dataReferente,
            'zona' => $this->zona,
        ]);
    }

    public function enviarParaApp(): void
    {
        $this->dispatch('enviarRoteiroApp', [
            'user_id' => $this->userId,
            'data_referente' => $this->dataReferente,
            'zona' => $this->zona,
        ]);

        $this->dispatch('showToast', [
            'type' => 'success',
            'message' => 'Roteiro enviado para o app mobile do leiturista!',
        ]);
    }

    // ═══════════════════════════════════════════════════════════
    // UTILITÁRIOS
    // ═══════════════════════════════════════════════════════════

    public function resetAll(): void
    {
        $this->reset([
            'roteiroId',
            'userId',
            'dataReferente',
            'zona',
            'roteiro',
            'leiturista',
            'itens',
            'timeline',
            'resumo',
            'filtroStatus',
            'busca',
            'mostrarTimeline',
            'carregando',
        ]);
        $this->resumo = [
            'total' => 0,
            'ok' => 0,
            'pendentes' => 0,
            'anomalias' => 0,
            'nao_lidos' => 0,
            'problemas' => 0,
            'percentual' => 0,
        ];
    }



    public function render()
    {
        return view('livewire.admin.Roteiro.preview-roteiro');
    }
}