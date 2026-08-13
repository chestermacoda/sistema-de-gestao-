<?php

namespace App\Livewire\Admin\Usuarios;

use App\Models\Cliente;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;

class Log extends Component
{

    use WithPagination;


    public string $search = '';
    public string $tipoFiltro = '';
    public string $periodoFiltro = '7';
    public ?string $dataInicio = null;
    public ?string $dataFim = null;
    public ?int $usuarioFiltro = null;
    public ?int $clienteFiltro = null;
    public ?int $roleFiltro = null;
    public int $porPagina = 15;

    // Modal
    public ?Activity $logSelecionado = null;

    // Listas
    public $usuarios = [];
    public $clientes = [];
    public $roles = [];


    public array $tiposAtividade = [
        'created' => 'Criação',
        'updated' => 'Atualização',
        'deleted' => 'Exclusão',
        'login' => 'Login',
        'logout' => 'Logout',
        'password_reset' => 'Reset de Senha',
        'permission_changed' => 'Permissão Alterada',
        'role_changed' => 'Role Alterada',
    ];

    public array $coresTipo = [
        'created' => 'usr-create',
        'updated' => 'usr-update',
        'deleted' => 'usr-delete',
        'login' => 'usr-login',
        'logout' => 'usr-logout',
        'password_reset' => 'usr-warning',
        'permission_changed' => 'usr-permission',
        'role_changed' => 'usr-role',
    ];

    public array $iconesTipo = [
        'created' => '<path d="M5 12h14"/><path d="M12 5v14"/>',
        'updated' => '<path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>',
        'deleted' => '<path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>',
        'login' => '<path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>',
        'logout' => '<path d="M9 21H5a2 2 0 0 1-2-2V5"/>',
        'password_reset' => '<rect x="3" y="11" width="18" height="11"/>',
        'permission_changed' => '<path d="M12.22 2h-.44a2 2 0 0 0-2 2"/>',
        'role_changed' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5"/>',
    ];

    // =====================================================
    // 📌 QUERY STRING
    // =====================================================
    // protected $queryString = [
    //     'search' => ['except' => ''],
    //     'tipoFiltro' => ['except' => ''],
    //     'periodoFiltro' => ['except' => '7'],
    //     'usuarioFiltro' => ['except' => ''],
    //     'clienteFiltro' => ['except' => ''],
    //     'roleFiltro' => ['except' => ''],
    //     'porPagina' => ['except' => 15],
    // ];

    // =====================================================
    // 📌 MOUNT
    // =====================================================
    public function mount()
    {
        $this->carregarListas();
    }

    // =====================================================
    // 📌 DADOS AUXILIARES
    // =====================================================
    public function carregarListas(): void
    {
        $this->usuarios = User::select('id', 'name')->orderBy('name')->get();
        $this->clientes = Cliente::select('id', 'nome_completo as name')->orderBy('nome_completo')->get();
        $this->roles = Role::select('id', 'name')->orderBy('name')->get();
    }

    // ============ LIMPAR FILTROS ============
    public function limparFiltros(): void
    {
        $this->reset([
            'search',
            'tipoFiltro',
            'dataInicio',
            'dataFim',
            'usuarioFiltro',
            'clienteFiltro',
            'roleFiltro',
        ]);
        $this->periodoFiltro = '7';
        $this->resetPage();
    }
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedTipoFiltro(): void
    {
        $this->resetPage();
    }

    public function updatedPeriodoFiltro(): void
    {
        if ($this->periodoFiltro !== 'custom') {
            $this->dataInicio = null;
            $this->dataFim = null;
        }
        $this->resetPage();
    }

    public function updatedDataInicio(): void
    {
        $this->resetPage();
    }

    public function updatedDataFim(): void
    {
        $this->resetPage();
    }

    public function updatedUsuarioFiltro(): void
    {
        $this->resetPage();
    }

    public function updatedClienteFiltro(): void
    {
        $this->resetPage();
    }

    public function updatedRoleFiltro(): void
    {
        $this->resetPage();
    }

    public function updatedPorPagina(): void
    {
        $this->resetPage();
    }

    // ============ PERÍODO ============
    private function getPeriodoDatas(): array
    {
        $fim = now()->endOfDay();

        return match ($this->periodoFiltro) {
            '1'     => [now()->subDay()->startOfDay(), $fim],
            '7'     => [now()->subDays(7)->startOfDay(), $fim],
            '30'    => [now()->subDays(30)->startOfDay(), $fim],
            '90'    => [now()->subDays(90)->startOfDay(), $fim],
            '365'   => [now()->subYear()->startOfDay(), $fim],
            'custom' => [
                $this->dataInicio
                    ? Carbon::parse($this->dataInicio)->startOfDay()
                    : now()->subDays(7)->startOfDay(),
                $this->dataFim
                    ? Carbon::parse($this->dataFim)->endOfDay()
                    : $fim,
            ],
            default => [now()->subDays(7)->startOfDay(), $fim],
        };
    }

    // ============ QUERY ============
    public function getLogsQuery()
    {
        [$inicio, $fim] = $this->getPeriodoDatas();

        return Activity::with(['causer', 'subject'])
            ->whereBetween('created_at', [$inicio, $fim])
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('description', 'like', "%{$this->search}%")
                        ->orWhere('log_name', 'like', "%{$this->search}%")
                        ->orWhere('event', 'like', "%{$this->search}%");
                });
            })
            ->when($this->tipoFiltro, fn($q) => $q->where('event', $this->tipoFiltro))
            ->when($this->usuarioFiltro, fn($q) => $q->where('causer_id', $this->usuarioFiltro)->where('causer_type', User::class))
            ->when($this->clienteFiltro, fn($q) => $q->where('subject_id', $this->clienteFiltro)->where('subject_type', Cliente::class))
            ->when($this->roleFiltro, function ($q) {
                $q->where(function ($q) {
                    $q->where('properties->role_id', $this->roleFiltro)
                        ->orWhere('properties->attributes->role_id', $this->roleFiltro)
                        ->orWhere('properties->old->role_id', $this->roleFiltro);
                });
            })
            ->latest();
    }


    // =====================================================
    // 📌 VIEW
    // =====================================================


    public function render()
    {
        $query = $this->getLogsQuery();
        return view('livewire.admin.usuarios.log', [
            'logs'      => $query->paginate($this->porPagina),
            'totalLogs' => $query->count(),

            // Listas para os selects (cacheadas no mount)
            'usuarios'  => $this->usuarios,
            'clientes'  => $this->clientes,
            'roles'     => $this->roles,
        ]);
    }
}