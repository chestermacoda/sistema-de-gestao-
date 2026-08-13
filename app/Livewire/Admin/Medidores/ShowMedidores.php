<?php

namespace App\Livewire\Admin\Medidores;

use App\Models\Medidores;
use App\Models\Cliente;
use App\Models\Leituras;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

class ShowMedidores extends Component
{
    use WithPagination;

    // Filtros dinâmicos
    public string $search = '';
    public string $statusFilter = '';
    public string $diametroFilter = '';
    public string $marcaFilter = '';
    public array  $medidoresComLeituraMes = [];

    // View toggle: 'cards' ou 'lista'
    public string $viewMode = 'cards';

    protected string $paginationTheme = 'tailwind';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'diametroFilter' => ['except' => ''],
        'marcaFilter' => ['except' => ''],
        'viewMode' => ['except' => 'cards'],
    ];


    public function mount(): void
    {
        $this->atualizarMedidoresComLeitura();
    }

    /**
     * Atualiza lista de medidores que já têm leitura no mês atual
     * Chamado no mount e quando recebe evento de leitura salva
     */
    public function atualizarMedidoresComLeitura(): void
    {
        $mesAtual = Carbon::now()->format('Y-m');

        $this->medidoresComLeituraMes = Leituras::where('mes_referencia', 'like', $mesAtual . '%')
            ->pluck('medidores_id')
            ->toArray();
    }


    /**
     * Recebe evento do RegistrarLeitura quando uma leitura é salva
     * Atualiza a lista para esconder o botão "Registrar Leitura"
     */
    #[On('leitura-salva')]
    public function onLeituraSalva(int $medidorId): void
    {
        // Adiciona o medidor à lista de "já lidos"
        if (!in_array($medidorId, $this->medidoresComLeituraMes)) {
            $this->medidoresComLeituraMes[] = $medidorId;
        }

        // Força re-renderização do componente
        // Isso atualiza a lista de medidores automaticamente
        $this->dispatch('$refresh');
    }


    /**
     * Verifica se medidor já tem leitura no mês atual
     */
    public function temLeituraMesAtual(int $medidorId): bool
    {
        return in_array($medidorId, $this->medidoresComLeituraMes);
    }

    /**
     * Ações disponíveis - AGORA COM VERIFICAÇÃO DE LEITURA
     */
    public function getAcoes(Medidores $medidor): array
    {
        $acoesBase = match ($medidor->status_inicial) {
            'instalado' => ['ver', 'leitura', 'manutencao', 'cortar'],
            'Manutencao' => ['ver', 'finalizar_manutencao'],
            'Cortada', 'Ligação Cortada' => ['ver', 'religar'],
            'Descartado' => ['ver'],
            default => ['ver', 'instalar'],
        };

        // ========== AQUI ESTÁ A MÁGICA ==========
        // Se já tem leitura no mês atual, remove 'leitura' das ações
        if ($this->temLeituraMesAtual($medidor->id)) {
            $acoesBase = array_diff($acoesBase, ['leitura']);
        }

        return array_values($acoesBase);
    }



    public function updated($property): void
    {
        if (in_array($property, ['search', 'statusFilter', 'diametroFilter', 'marcaFilter'])) {
            $this->resetPage();
        }
    }

    public function setViewMode(string $mode): void
    {
        $this->viewMode = $mode;
    }

    #[Computed]
    public function medidores()
    {
        return Medidores::query()
            // CORRIGIDO: carrega cliente direto (não mais via instalacaoAtiva)
            ->with([
                'cliente',              // Cliente atual (via medidores.cliente_id)
                'ultimaLeitura',        // Última leitura direta
                'instalacaoAtiva',      // Info adicional da instalação
            ])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('numero_hidrometro', 'like', '%' . $this->search . '%')
                        ->orWhere('numero_serie', 'like', '%' . $this->search . '%')
                        ->orWhere('marca', 'like', '%' . $this->search . '%')
                        ->orWhere('modelo', 'like', '%' . $this->search . '%')
                        // CORRIGIDO: busca no cliente direto (não via hasMany)
                        ->orWhereHas('cliente', function ($sq) {
                            $sq->where('nome_completo', 'like', '%' . $this->search . '%')
                                ->orWhere('numero_matricula', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->statusFilter, function ($query) {
                // CORRIGIDO: filtra direto no status_inicial do medidor
                $query->where('status_inicial', $this->statusFilter);
            })
            ->when($this->diametroFilter, function ($query) {
                $query->where('diametro', $this->diametroFilter);
            })
            ->when($this->marcaFilter, function ($query) {
                $query->where('marca', $this->marcaFilter);
            })
            ->latest()
            ->paginate(6);
    }

    // ============================================
    // HELPERS DE STATUS - SIMPLIFICADOS
    // ============================================

    /**
     * Determina o status visual do medidor
     * SIMPLIFICADO: agora baseado apenas em status_inicial e cliente_id
     */
    public function getStatusMedidor(Medidores $medidor): array
    {
        return match ($medidor->status_inicial) {
            'instalado' => [
                'class' => 'ativo',
                'text' => '● Em Operação',
                'label' => 'Em Operação',
                'cardClass' => 'ativo',
                'badgeClass' => 'badge-success',
            ],

            'Manutencao' => [
                'class' => 'manutencao',
                'text' => '● Em Manutenção',
                'label' => 'Em Manutenção',
                'cardClass' => 'manutencao',
                'badgeClass' => 'badge-warning',
            ],
            'Cortada', 'Ligação Cortada' => [
                'class' => 'inativo',
                'text' => '● Ligação Cortada',
                'label' => 'Ligação Cortada',
                'cardClass' => 'inativo',
                'badgeClass' => 'badge-danger',
            ],
            'Descartado' => [
                'class' => 'inativo',
                'text' => '● Descartado',
                'label' => 'Descartado',
                'cardClass' => 'inativo',
                'badgeClass' => 'badge-danger',
            ],
            default => [  // 'Estoque' ou qualquer outro
                'class' => 'pendente',
                'text' => '● Em Estoque',
                'label' => 'Em Estoque',
                'cardClass' => 'pendente',
                'badgeClass' => 'badge-info',
            ],
        };
    }

    // ============================================
    // HELPERS DE LEITURA - SIMPLIFICADOS
    // ============================================

    /**
     * Dados da leitura para exibição
     * SIMPLIFICADO: usa ultimaLeitura direto do medidor
     */
    public function getLeituraData(Medidores $medidor): array
    {
        $leitura = $medidor->ultimaLeitura;

        // Medidor instalado ativo - mostra leitura real
        if ($medidor->status_inicial === 'instalado' && $leitura) {
            return [
                'valor' => number_format($leitura->leitura_atual ?? 0, 0, ',', '.') . ' m³',
                'label' => 'Leitura Atual — ' . ($leitura->data_leitura?->format('d/m/Y') ?? '-'),
                'style' => '',
                'valorColor' => '',
                'labelColor' => '',
                'pode_registrar' => true,
            ];
        }

        // Instalado mas sem leitura ainda
        if ($medidor->status_inicial === 'instalado' && !$leitura) {
            return [
                'valor' => '0 m³',
                'label' => 'Aguardando primeira leitura',
                'style' => 'background: rgba(0, 131, 143, 0.1);',
                'valorColor' => 'color: var(--tertiary);',
                'labelColor' => 'color: var(--tertiary);',
                'pode_registrar' => true,
            ];
        }

        // Manutenção
        if ($medidor->status_inicial === 'Manutencao') {
            return [
                'valor' => '—',
                'label' => 'Leitura Suspensa — Manutenção',
                'style' => 'background: var(--warning-light);',
                'valorColor' => 'color: var(--warning);',
                'labelColor' => 'color: var(--warning);',
                'pode_registrar' => false,
            ];
        }

        // Cortado
        if ($medidor->status_inicial === 'Cortada' || $medidor->status_inicial === 'Ligação Cortada') {
            $ultima = $leitura?->leitura_atual ?? 0;
            return [
                'valor' => number_format($ultima, 0, ',', '.') . ' m³',
                'label' => 'Última Leitura — ' . ($leitura?->data_leitura?->format('d/m/Y') ?? '-'),
                'style' => 'background: var(--danger-light);',
                'valorColor' => 'color: var(--danger);',
                'labelColor' => 'color: var(--danger);',
                'pode_registrar' => false,
            ];
        }

        // Estoque (padrão)
        return [
            'valor' => '0 m³',
            'label' => 'Leitura Inicial — Novo',
            'style' => 'background: rgba(0,131,143,0.1);',
            'valorColor' => 'color: var(--tertiary);',
            'labelColor' => 'color: var(--tertiary);',
            'pode_registrar' => false,
        ];
    }

    // ============================================
    // HELPERS DE CLIENTE/LOCAL - SIMPLIFICADOS
    // ============================================

    /**
     * Informações do cliente/local
     * SIMPLIFICADO: usa cliente direto (não via instalacaoAtiva)
     */
    public function getClienteInfo(Medidores $medidor): array
    {
        $cliente = $medidor->cliente;

        // Medidor instalado - cliente direto
        if (trim(strtolower($medidor->status_inicial)) === 'instalado'  && !empty($cliente)) {
            return [
                'nome' => $cliente->nome_completo,
                'local' => $cliente->zona_distribuicao ?? '-',
                'instalacao' => $medidor->instalacaoAtiva?->data_instalacao?->format('d/m/Y')
                    ?? $medidor->data_aquisicao?->format('d/m/Y')
                    ?? '-',
                'matricula' => 'Matrícula: ' . ($cliente->numero_matricula ?? 'N/A'),
                'numero_matricula' => $cliente->numero_matricula,
                'cliente_id' => $cliente->id,
            ];
        }

        // Cortado - mostra último cliente (se houver)
        if (($medidor->status_inicial === 'Cortada' || $medidor->status_inicial === 'Ligação Cortada') && $cliente) {
            return [
                'nome' => $cliente->nome_completo,
                'local' => $cliente->zona_distribuicao ?? '-',
                'instalacao' => $medidor->instalacaoAtiva?->data_instalacao?->format('d/m/Y') ?? '-',
                'matricula' => 'Matrícula: ' . ($cliente->numero_matricula ?? 'N/A'),
                'numero_matricula' => $cliente->numero_matricula,
                'cliente_id' => $cliente->id,
            ];
        }

        // Em manutenção - mostra cliente se vinculado
        if ($medidor->status_inicial === 'Manutencao' && $cliente) {
            return [
                'nome' => $cliente->nome_completo . ' (Manutenção)',
                'local' => $cliente->zona_distribuicao ?? 'Oficina',
                'instalacao' => $medidor->instalacaoAtiva?->data_instalacao?->format('d/m/Y') ?? '-',
                'matricula' => 'Matrícula: ' . ($cliente->numero_matricula ?? 'N/A'),
                'numero_matricula' => $cliente->numero_matricula,
                'cliente_id' => $cliente->id,
            ];
        }

        // Estoque/Descartado/Padrão
        return [
            'nome' => '— Disponível —',
            'local' => 'Depósito Central',
            'instalacao' => $medidor->data_aquisicao?->format('d/m/Y') ?? '-',
            'matricula' => 'Lote: ' . ($medidor->nota_fiscal ?? 'N/A'),
            'numero_matricula' => null,

        ];
    }

    // ============================================
    // HELPERS DE AÇÕES
    // ============================================

    /**
     * Ações disponíveis baseadas no status
     * SIMPLIFICADO
     */
    // public function getAcoes(Medidores $medidor): array
    // {
    //     return match ($medidor->status_inicial) {
    //         'instalado' => ['ver', 'leitura', 'manutencao', 'cortar'],
    //         'Manutencao' => ['ver', 'finalizar_manutencao'],
    //         'Cortada', 'Ligação Cortada' => ['ver', 'religar'],
    //         'Descartado' => ['ver'],
    //         default => ['ver', 'instalar'],
    //     };
    // }

    // ============================================
    // HELPERS DE CALIBRAÇÃO (PERFEITO)
    // ============================================

    public function getCalibracaoStatus(Medidores $medidor): array
    {
        if (!$medidor->validade_certificado) {
            return ['class' => 'neutral', 'text' => 'Sem certificado'];
        }

        $dias = Carbon::now()->diffInDays($medidor->validade_certificado, false);

        if ($dias < 0) {
            return ['class' => 'danger', 'text' => 'Vencido'];
        }

        if ($dias <= 30) {
            return ['class' => 'warning', 'text' => 'Vence em ' . ceil($dias) . ' dias'];
        }

        return ['class' => 'success', 'text' => 'Válido até ' . $medidor->validade_certificado->format('d/m/Y')];
    }


    // ===== HELPERS DE ESTOQUE =====

    public function getEstoqueInfo(Medidores $medidor): array
    {
        $total = $medidor->quantidade ?? 1;
        $instalados = $medidor->instalados_count ?? 0;
        $manutencao = $medidor->manutencao_count ?? 0;
        $disponivel = max(0, $total - $instalados - $manutencao);

        return [
            'total' => $total,
            'instalados' => $instalados,
            'manutencao' => $manutencao,
            'disponivel' => $disponivel,
        ];
    }

    public function render()
    {
        return view('livewire.admin.medidores.show-medidores');
    }
}