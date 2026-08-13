<?php

namespace App\Livewire\Admin\Roteiro;

use App\Models\Cliente;
use App\Models\Faturas;
use App\Models\RoteiroLeiturista;
use Carbon\Carbon;
use Livewire\Component;

class VisualizarZona extends Component
{


    // ─── Propriedades da Zona ──────────────────────────────
    public ?string $zona = null;
    public ?string $dataReferente = null;
    public ?int $userId = null; // Leiturista (opcional)

    // ─── Dados da Zona ─────────────────────────────────────
    public array $zonaInfo = [];
    public array $clientes = [];
    public array $resumo = [
        'total_clientes' => 0,
        'total_medidores' => 0,
        'lidos' => 0,
        'pendentes' => 0,
        'anomalias' => 0,
        'nao_lidos' => 0,
        'problemas' => 0,
        'faturas_abertas' => 0,
        'faturas_pagas' => 0,
        'faturas_vencidas' => 0,
        'percentual_concluido' => 0,
    ];

    // ─── Filtros ─────────────────────────────────────────────
    public string $filtroStatus = 'todos';
    public string $busca = '';
    public string $ordenacao = 'ordem'; // ordem, nome, endereco, status
    public string $direcao = 'asc';

    // ─── Detalhes do Cliente Selecionado ───────────────────
    public ?int $clienteSelecionado = null;
    public array $detalhesCliente = [];
    public bool $mostrarDetalhes = false;

    // ─── Estado ──────────────────────────────────────────────
    public bool $carregando = false;

    // ═══════════════════════════════════════════════════════════
    // CARREGAR ZONA
    // ═══════════════════════════════════════════════════════════

    #[\Livewire\Attributes\On('visualizar-Zona')]
    public function carregarZona($zona, $dataReferente = null, $userId = null): void
    {

        $this->resetAll();
        $this->dispatch('openModal', 'modal-visualizar-zona');

        $this->zona = $zona;
        $this->dataReferente = $dataReferente;
        $this->userId = $userId;

        try {
            $this->carregando = true;

            // ─── Buscar clientes da zona ──────────────────────
            $queryClientes = Cliente::with(['medidores', 'faturas', 'roteiroLeiturista' => function ($q) use ($dataReferente) {
                if ($dataReferente) {
                    $q->whereDate('data_referente', $dataReferente);
                }
            }])
                ->where('zona_distribuicao', $zona)
                ->orWhere('bairro', $zona);

            $clientes = $queryClientes->get();

            if ($clientes->isEmpty()) {
                $this->dispatch('notify', [
                    'type' => 'warning',
                    'message' => "Nenhum cliente encontrado na zona '{$zona}'.",
                ]);
                $this->carregando = false;
                return;
            }

            // ─── Info da zona ─────────────────────────────────
            $this->zonaInfo = [
                'nome' => $zona,
                'data_referente' => $dataReferente ? Carbon::parse($dataReferente)->format('d/m/Y') : 'Todas',
                'mes_ano' => $dataReferente ? Carbon::parse($dataReferente)->translatedFormat('F/Y') : 'Todas',
                'total_clientes' => $clientes->count(),
            ];

            // ─── Processar cada cliente ───────────────────────
            $this->clientes = $clientes->map(function ($cliente) use ($dataReferente) {
                // Buscar medidor principal
                $medidor = $cliente->medidores->first();

                // Buscar roteiro/leitura do período
                $roteiroQuery = RoteiroLeiturista::where('cliente_id', $cliente->id);
                if ($dataReferente) {
                    $roteiroQuery->whereDate('data_referente', $dataReferente);
                }
                $roteiro = $roteiroQuery->latest()->first();

                // Buscar fatura do período
                $faturaQuery = Faturas::where('cliente_id', $cliente->id);
                if ($dataReferente) {
                    $faturaQuery->whereDate('data_vencimento', '>=', Carbon::parse($dataReferente)->startOfMonth())
                        ->whereDate('data_vencimento', '<=', Carbon::parse($dataReferente)->endOfMonth());
                }
                $fatura = $faturaQuery->latest()->first();

                // Determinar status
                $status = $this->determinarStatusCliente($cliente, $roteiro, $fatura);

                // Calcular consumo
                $consumo = null;
                if ($roteiro && $roteiro->leitura_atual !== null && $roteiro->leitura_anterior !== null) {
                    $consumo = max(0, (float) $roteiro->leitura_atual - (float) $roteiro->leitura_anterior);
                }

                return [
                    'id' => $cliente->id,
                    'nome' => $cliente->nome_completo ?? 'N/A',
                    'matricula' => $cliente->numero_matricula ?? 'N/A',
                    'nuit' => $cliente->nuit ?? 'N/A',
                    'endereco' => $this->formatarEndereco($cliente),
                    'contacto' => $cliente->contacto ?? 'N/A',
                    'medidor' => $medidor?->numero_serie ?? 'N/A',
                    'tipo_medidor' => $medidor?->tipo ?? 'N/A',
                    'status' => $status,
                    'leitura_anterior' => $roteiro?->leitura_anterior,
                    'leitura_atual' => $roteiro?->leitura_atual,
                    'consumo' => $consumo,
                    'lido_em' => $roteiro?->lido_em?->format('d/m/Y H:i') ?? null,
                    'leiturista' => $roteiro?->user?->name ?? 'Não atribuído',
                    'fatura_status' => $fatura?->status ?? 'Sem fatura',
                    'fatura_valor' => $fatura?->valor_total ?? 0,
                    'fatura_vencimento' => $fatura?->data_vencimento?->format('d/m/Y') ?? null,
                    'fatura_codigo' => $fatura?->codigo_fatura ?? null,
                    'observacoes' => $roteiro?->observacoes ?? null,
                    'foto' => $roteiro?->foto ?? null,
                    'ordem' => $roteiro?->ordem ?? 999,
                    'data_referente' => $roteiro?->data_referente?->format('d/m/Y') ?? null,
                ];
            })->toArray();

            // ─── Calcular resumo ──────────────────────────────
            $this->calcularResumo();

            $this->carregando = false;
        } catch (\Exception $e) {
            $this->dispatch('showToast', [
                'type' => 'error',
                'message' => 'Erro ao carregar dados da zona: ' . $e->getMessage(),
            ]);
            $this->carregando = false;
        }
    }

    // ═══════════════════════════════════════════════════════════
    // DETERMINAR STATUS DO CLIENTE
    // ═══════════════════════════════════════════════════════════

    protected function determinarStatusCliente($cliente, $roteiro, $fatura): string
    {
        // Se tem leitura atual
        if ($roteiro && $roteiro->leitura_atual !== null) {
            $consumo = (float) $roteiro->leitura_atual - (float) ($roteiro->leitura_anterior ?? 0);

            // Verificar anomalia (consumo negativo ou muito alto)
            if ($consumo < 0 || $consumo > 500) {
                return 'Anomalia';
            }

            // Verificar se há foto de problema
            if ($roteiro->foto && empty($roteiro->leitura_atual)) {
                return 'Problema';
            }

            return 'Concluido';
        }

        // Se tem foto mas sem leitura
        if ($roteiro && $roteiro->foto) {
            return 'Problema';
        }

        // Se está no roteiro mas não lido
        if ($roteiro && !$roteiro->lido_em) {
            return 'Nao lido';
        }

        // Se tem fatura pendente/vencida
        if ($fatura && in_array($fatura->status, ['Pendente', 'Vencida'])) {
            return 'Pendente';
        }

        // Se tem fatura paga
        if ($fatura && $fatura->status === 'Paga') {
            return 'Pago';
        }

        return 'Pendente';
    }

    // ═══════════════════════════════════════════════════════════
    // FORMATAR ENDEREÇO
    // ═══════════════════════════════════════════════════════════

    protected function formatarEndereco($cliente): string
    {
        $partes = array_filter([
            $cliente->rua,
            $cliente->numero ? 'Nº ' . $cliente->numero : null,
            $cliente->bairro,
            $cliente->cidade,
        ]);

        return implode(' — ', $partes) ?: 'Endereço incompleto';
    }

    // ═══════════════════════════════════════════════════════════
    // CALCULAR RESUMO
    // ═══════════════════════════════════════════════════════════

    protected function calcularResumo(): void
    {
        $total = count($this->clientes);

        $this->resumo = [
            'total_clientes' => $total,
            'total_medidores' => collect($this->clientes)->where('medidor', '!=', 'N/A')->count(),
            'lidos' => collect($this->clientes)->where('status', 'Concluido')->count(),
            'pendentes' => collect($this->clientes)->where('status', 'Pendente')->count(),
            'anomalias' => collect($this->clientes)->where('status', 'Anomalia')->count(),
            'nao_lidos' => collect($this->clientes)->where('status', 'Nao lido')->count(),
            'problemas' => collect($this->clientes)->where('status', 'Problema')->count(),
            'pagos' => collect($this->clientes)->where('status', 'Pago')->count(),
            'faturas_abertas' => collect($this->clientes)->whereIn('fatura_status', ['Pendente', 'Vencida'])->count(),
            'faturas_pagas' => collect($this->clientes)->where('fatura_status', 'Paga')->count(),
            'faturas_vencidas' => collect($this->clientes)->where('fatura_status', 'Vencida')->count(),
            'percentual_concluido' => $total > 0 ? round((collect($this->clientes)->whereIn('status', ['Concluido', 'Pago'])->count() / $total) * 100) : 0,
        ];
    }

    // ═══════════════════════════════════════════════════════════
    // COMPUTED: CLIENTES FILTRADOS
    // ═══════════════════════════════════════════════════════════

    public function getClientesFiltradosProperty(): array
    {
        $clientes = collect($this->clientes);

        // Filtro por status
        if ($this->filtroStatus !== 'todos') {
            $clientes = $clientes->filter(
                fn($c) =>
                strtolower($c['status']) === strtolower(str_replace('-', ' ', $this->filtroStatus))
            );
        }

        // Filtro por busca
        if ($this->busca) {
            $termo = strtolower($this->busca);
            $clientes = $clientes->filter(function ($c) use ($termo) {
                return str_contains(strtolower($c['nome']), $termo) ||
                    str_contains(strtolower($c['endereco']), $termo) ||
                    str_contains(strtolower($c['matricula']), $termo) ||
                    str_contains(strtolower($c['medidor']), $termo) ||
                    str_contains(strtolower($c['nuit']), $termo) ||
                    str_contains(strtolower($c['leiturista']), $termo);
            });
        }

        // Ordenação
        $clientes = $clientes->sortBy(function ($c) {
            return match ($this->ordenacao) {
                'nome' => strtolower($c['nome']),
                'endereco' => strtolower($c['endereco']),
                'status' => $c['status'],
                'ordem' => (int) ($c['ordem'] ?? 999),
                default => (int) ($c['ordem'] ?? 999),
            };
        }, SORT_REGULAR, $this->direcao === 'desc');

        return $clientes->values()->toArray();
    }

    // ═══════════════════════════════════════════════════════════
    // VER DETALHES DO CLIENTE
    // ═══════════════════════════════════════════════════════════

    public function verDetalhes(int $clienteId): void
    {
        $this->clienteSelecionado = $clienteId;
        $this->mostrarDetalhes = true;

        $cliente = collect($this->clientes)->firstWhere('id', $clienteId);

        if (!$cliente) {
            $this->dispatch('showToast', [
                'type' => 'error',
                'message' => 'Cliente não encontrado.',
            ]);
            return;
        }

        // Buscar histórico de leituras
        $historicoLeituras = RoteiroLeiturista::where('cliente_id', $clienteId)
            ->whereNotNull('leitura_atual')
            ->orderBy('data_referente', 'desc')
            ->take(6)
            ->get()
            ->map(fn($r) => [
                'data' => $r->data_referente?->format('d/m/Y'),
                'leitura' => $r->leitura_atual,
                'consumo' => $r->leitura_anterior !== null
                    ? max(0, (float) $r->leitura_atual - (float) $r->leitura_anterior)
                    : null,
                'status' => $r->status,
            ])->toArray();

        // Buscar histórico de faturas
        $historicoFaturas = Faturas::where('cliente_id', $clienteId)
            ->orderBy('data_vencimento', 'desc')
            ->take(6)
            ->get()
            ->map(fn($f) => [
                'codigo' => $f->codigo_fatura,
                'valor' => $f->valor_total,
                'status' => $f->status,
                'vencimento' => $f->data_vencimento?->format('d/m/Y'),
            ])->toArray();

        $this->detalhesCliente = [
            ...$cliente,
            'historico_leituras' => $historicoLeituras,
            'historico_faturas' => $historicoFaturas,
        ];
    }

    public function fecharDetalhes(): void
    {
        $this->mostrarDetalhes = false;
        $this->clienteSelecionado = null;
        $this->detalhesCliente = [];
    }

    // ═══════════════════════════════════════════════════════════
    // AÇÕES
    // ═══════════════════════════════════════════════════════════

    public function exportarPDF(): void
    {
        $this->dispatch('exportarZonaPDF', [
            'zona' => $this->zona,
            'data_referente' => $this->dataReferente,
            'clientes' => $this->clientes,
        ]);
    }

    public function exportarExcel(): void
    {
        $this->dispatch('exportarZonaExcel', [
            'zona' => $this->zona,
            'data_referente' => $this->dataReferente,
        ]);
    }

    public function imprimir(): void
    {
        $this->dispatch('imprimirZona');
    }

    // ═══════════════════════════════════════════════════════════
    // ORDENAR
    // ═══════════════════════════════════════════════════════════

    public function ordenarPor(string $campo): void
    {
        if ($this->ordenacao === $campo) {
            $this->direcao = $this->direcao === 'asc' ? 'desc' : 'asc';
        } else {
            $this->ordenacao = $campo;
            $this->direcao = 'asc';
        }
    }

    // ═══════════════════════════════════════════════════════════
    // UTILITÁRIOS
    // ═══════════════════════════════════════════════════════════

    public function resetAll(): void
    {
        $this->reset([
            'zona',
            'dataReferente',
            'userId',
            'zonaInfo',
            'clientes',
            'resumo',
            'filtroStatus',
            'busca',
            'ordenacao',
            'direcao',
            'clienteSelecionado',
            'detalhesCliente',
            'mostrarDetalhes',
            'carregando',
        ]);
        $this->resumo = [
            'total_clientes' => 0,
            'total_medidores' => 0,
            'lidos' => 0,
            'pendentes' => 0,
            'anomalias' => 0,
            'nao_lidos' => 0,
            'problemas' => 0,
            'pagos' => 0,
            'faturas_abertas' => 0,
            'faturas_pagas' => 0,
            'faturas_vencidas' => 0,
            'percentual_concluido' => 0,
        ];
    }

    public function render()
    {
        return view('livewire.admin.roteiro.visualizar-zona');
    }
}