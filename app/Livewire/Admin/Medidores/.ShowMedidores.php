<?php

namespace App\Livewire\Admin\Medidores;

use App\Models\Medidores;
use App\Models\ClienteMedidor;
use App\Models\Cliente;
use App\Models\Leitura;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

class ShowMedidores extends Component
{
    use WithPagination;

    // Filtros dinâmicos
    public string $search = '';
    public string $statusFilter = '';
    public string $diametroFilter = '';
    public string $marcaFilter = '';

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

    // Resetar paginação quando filtros mudam
    public function updated($property): void
    {
        if (in_array($property, ['search', 'statusFilter', 'diametroFilter', 'marcaFilter'])) {
            $this->resetPage();
        }
    }

    // Toggle view mode
    public function setViewMode(string $mode): void
    {
        $this->viewMode = $mode;
    }

    #[Computed]
    public function medidores()
    {
        return Medidores::query()
            ->with([
                'instalacaoAtiva.cliente',
                'instalacaoAtiva.ultimaLeitura'
            ])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('numero_hidrometro', 'like', '%' . $this->search . '%')
                        ->orWhere('numero_serie', 'like', '%' . $this->search . '%')
                        ->orWhere('marca', 'like', '%' . $this->search . '%')
                        ->orWhere('modelo', 'like', '%' . $this->search . '%')
                        ->orWhereHas('instalacaoAtiva.cliente', function ($sq) {
                            $sq->where('nome_completo', 'like', '%' . $this->search . '%')
                                ->orWhere('numero_matricula', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->statusFilter, function ($query) {
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

    // Helpers para status
    public function getStatusMedidor(Medidores $medidor): array
    {
        $instalacao = $medidor->instalacaoAtiva;

        if (!$instalacao) {
            return [
                'class' => 'pendente',
                'text' => '● Em Estoque',
                'label' => 'Em Estoque',
                'cardClass' => 'pendente',
            ];
        }

        return match ($instalacao->status) {
            'Ativo' => [
                'class' => 'ativo',
                'text' => '● Em Operação',
                'label' => 'Em Operação',
                'cardClass' => 'ativo',
            ],
            'Manutencao', 'Em Manutenção' => [
                'class' => 'manutencao',
                'text' => '● Em Manutenção',
                'label' => 'Em Manutenção',
                'cardClass' => 'manutencao',
            ],
            'Cortada' => [
                'class' => 'inativo',
                'text' => '● Ligação Cortada',
                'label' => 'Ligação Cortada',
                'cardClass' => 'inativo',
            ],
            default => [
                'class' => 'pendente',
                'text' => '● ' . $instalacao->status,
                'label' => $instalacao->status,
                'cardClass' => 'pendente',
            ],
        };
    }

    // Helper para leitura
    public function getLeituraData(Medidores $medidor): array
    {
        $instalacao = $medidor->instalacaoAtiva;
        $leitura = $instalacao?->ultimaLeitura;

        if (!$instalacao) {
            return [
                'valor' => '0 m³',
                'label' => 'Leitura Inicial — Novo',
                'style' => 'background: rgba(0,131,143,0.1);',
                'valorColor' => 'color: var(--tertiary);',
                'labelColor' => 'color: var(--tertiary);',
            ];
        }

        if ($instalacao->status === 'Manutencao' || $instalacao->status === 'Em Manutenção') {
            return [
                'valor' => '—',
                'label' => 'Leitura Suspensa — Manutenção',
                'style' => 'background: var(--warning-light);',
                'valorColor' => 'color: var(--warning);',
                'labelColor' => 'color: var(--warning);',
            ];
        }

        if ($instalacao->status === 'Cortada') {
            $ultimaLeitura = $leitura?->leitura_atual ?? 0;
            return [
                'valor' => number_format($ultimaLeitura, 0, ',', '.') . ' m³',
                'label' => 'Última Leitura — ' . ($leitura?->data_leitura?->format('d/m/Y') ?? '-'),
                'style' => 'background: var(--danger-light);',
                'valorColor' => 'color: var(--danger);',
                'labelColor' => 'color: var(--danger);',
            ];
        }

        // Ativo
        $valor = $leitura?->leitura_atual ?? 0;
        return [
            'valor' => number_format($valor, 0, ',', '.') . ' m³',
            'label' => 'Leitura Atual — ' . ($leitura?->data_leitura?->format('d/m/Y') ?? '-'),
            'style' => '',
            'valorColor' => '',
            'labelColor' => '',
        ];
    }

    // Helper para info do cliente/local
    public function getClienteInfo(Medidores $medidor): array
    {
        $instalacao = $medidor->instalacaoAtiva;
        $cliente = $instalacao?->cliente;

        if (!$instalacao) {
            return [
                'nome' => '— Disponível —',
                'local' => 'Depósito Central',
                'instalacao' => $medidor->data_aquisicao?->format('d/m/Y') ?? '-',
                'matricula' => 'Lote: ' . ($medidor->nota_fiscal ?? 'N/A'),
                'numero_matricula' => null,
            ];
        }

        return [
            'nome' => $cliente?->nome_completo ?? '—',
            'local' => $cliente?->zona_distribuicao ?? '-',
            'instalacao' => $instalacao->data_instalacao?->format('d/m/Y') ?? '-',
            'matricula' => 'Matrícula: ' . ($cliente?->numero_matricula ?? 'N/A'),
            'numero_matricula' => $cliente?->numero_matricula,
        ];
    }

    // Helper para ações disponíveis baseado no status
    public function getAcoes(Medidores $medidor): array
    {
        $instalacao = $medidor->instalacaoAtiva;
        $status = $instalacao?->status ?? 'Estoque';

        return match ($status) {
            'Ativo' => ['ver', 'leitura', 'manutencao'],
            'Manutencao', 'Em Manutenção' => ['ver', 'finalizar_manutencao'],
            'Cortada' => ['ver', 'religar'],
            default => ['ver', 'instalar'],
        };
    }
    public function render()
    {
        return view('Livewire.admin.Medidores.Show-medidores');
    }
}
