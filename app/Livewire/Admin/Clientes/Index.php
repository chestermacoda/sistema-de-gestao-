<?php

namespace App\Livewire\Admin\Clientes;

use App\Models\Cliente;
use App\Models\ClienteMedidor;
use App\Models\zona_distribuicao;
use App\Models\Leituras;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

class Index extends Component
{
    use WithPagination;

    // Filtros dinâmicos
    public string $search = '';
    public string $categoriaFilter = '';
    public string $statusFilter = '';
    public string $zonaFilter = '';
    public string $leituraStatusFilter = ''; // Novo: filtro por status de leitura

    protected string $paginationTheme = 'tailwind';

    // Resetar paginação quando filtros mudam
    public function updated($property): void
    {
        if (in_array($property, ['search', 'categoriaFilter', 'statusFilter', 'zonaFilter', 'leituraStatusFilter'])) {
            $this->resetPage();
        }
    }

    #[Computed]
    public function clientes()
    {
        return Cliente::query()
            ->with([
                'medidor',
                'ultimaLeitura' => function ($query) {
                    // Garante que carregamos apenas a última leitura por cliente
                    $query->select('leituras.*');
                }
            ])
            ->withCount('leituras') // Contagem total de leituras do cliente
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nome_completo', 'like', '%' . $this->search . '%')
                        ->orWhere('numero_matricula', 'like', '%' . $this->search . '%')
                        ->orWhere('bi', 'like', '%' . $this->search . '%')
                        ->orWhere('nuit', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->categoriaFilter, function ($query) {
                $query->where('categoria_consumo', $this->categoriaFilter);
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->zonaFilter, function ($query) {
                $query->where('zona_distribuicao', $this->zonaFilter);
            })
            // ->when($this->leituraStatusFilter, function ($query) {
            //     // Filtro por status da última leitura (via whereExists ou join)
            //     $query->whereHas('ultimaLeitura', function ($q) {
            //         $q->where('status', $this->leituraStatusFilter);
            //     });
            // })
            ->latest()
            ->paginate(10);
    }

    // Helper para iniciais do avatar
    public function getIniciais(string $nome): string
    {
        $palavras = explode(' ', trim($nome));
        $iniciais = '';

        foreach ($palavras as $i => $palavra) {
            if ($i < 2 && !empty($palavra)) {
                $iniciais .= strtoupper(substr($palavra, 0, 1));
            }
        }

        return $iniciais ?: '??';
    }

    // Helper para cor do avatar baseado na categoria
    public function getAvatarColor(string $categoria): string
    {
        return match ($categoria) {
            'Residencial' => 'var(--primary), var(--primary-light)',
            'Comercial' => 'var(--tertiary), var(--tertiary-light)',
            'Industrial' => 'var(--secondary), var(--secondary-light)',
            'Público' => 'var(--warning), #b45309',
            'Rural' => '#059669, #10b981',
            default => 'var(--neutral-dark), var(--neutral)',
        };
    }

    // Helper para badge da categoria
    public function getCategoriaBadge(string $categoria): array
    {
        return match ($categoria) {
            'Residencial' => ['class' => 'badge-success', 'style' => ''],
            'Comercial' => ['class' => 'badge-warning', 'style' => ''],
            'Industrial' => ['class' => 'badge-info', 'style' => ''],
            'Público' => ['class' => 'badge-neutral', 'style' => ''],
            'Rural' => ['class' => '', 'style' => 'background: #d1fae5; color: #059669;'],
            default => ['class' => 'badge-neutral', 'style' => ''],
        };
    }

    // Helper para badge do status do cliente
    public function getStatusBadge(string $status): array
    {
        return match ($status) {
            'ativo' => ['class' => 'badge-success', 'text' => '● Ativo'],
            'Cortada' => ['class' => 'badge-danger', 'text' => '● Cortada'],
            'Inadimplente' => ['class' => 'badge-warning', 'text' => '● Inadimplente'],
            'Desativado' => ['class' => 'badge-neutral', 'text' => '● Desativado'],
            default => ['class' => 'badge-neutral', 'text' => '● ' . $status],
        };
    }

    // Helper para badge do status da leitura
    public function getLeituraStatusBadge(?Leituras $leitura): array
    {
        if (!$leitura) {
            return ['class' => 'badge-neutral', 'text' => '—'];
        }

        return match ($leitura->status) {
            'Normal' => ['class' => 'badge-success', 'text' => '● Normal'],
            'Anomalia' => ['class' => 'badge-warning', 'text' => '● Anomalia'],
            'Revisar' => ['class' => 'badge-danger', 'text' => '● Revisar'],
            'Editada' => ['class' => 'badge-info', 'text' => '● Editada'],
            default => ['class' => 'badge-neutral', 'text' => '● ' . $leitura->status],
        };
    }

    // Helper para consumo formatado
    public function getConsumo(?Leituras $leitura): string
    {
        if (!$leitura) {
            return '—';
        }

        if ($leitura->consumo !== null) {
            return number_format($leitura->consumo, 0, ',', '.') . ' m³';
        }

        // Calcula se não tiver campo consumo
        if ($leitura->leitura_atual !== null && $leitura->leitura_anterior !== null) {
            $consumo = $leitura->leitura_atual - $leitura->leitura_anterior;
            return number_format(max(0, $consumo), 0, ',', '.') . ' m³';
        }

        return number_format($leitura->leitura_atual ?? 0, 0, ',', '.') . ' m³';
    }

    // Helper para verificar anomalia
    public function temAnomalia(?Leituras $leitura): bool
    {
        return $leitura && ($leitura->tem_anomalia || $leitura->tipo_anomalia);
    }

    // Helper para tooltip de anomalia
    public function getAnomaliaDescricao(?Leituras $leitura): ?string
    {
        if (!$this->temAnomalia($leitura)) {
            return null;
        }

        return $leitura->tipo_anomalia . ($leitura->descricao_anomalia ? ': ' . $leitura->descricao_anomalia : '');
    }















    public function render()
    {
        return view('Livewire.Admin.Clientes.Index', [
            'zona'=>zona_distribuicao::all(),
            'Cliente' => Cliente::all(),
            'ClienteMedidor' => ClienteMedidor::all(),
        ]);
    }
}
