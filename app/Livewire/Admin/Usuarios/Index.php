<?php

namespace App\Livewire\Admin\Usuarios;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // FILTERS
    public $search = '';
    public $status = '';
    public $role = '';
    public $zona = '';
    public $tab = 'todos';

    public $selectedPermissions = [];
    public $permissoes = [];
    public $sessions = '';
    public $user = null;
    // USER
    public $selectedUser;
    public $permissionsByModule = [];

    protected $queryString = [
        'search',
        'status',
        'role',
        'zona',
        'tab',
    ];



    public array $moduleIcons = [

        'Dashboard' => '
        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
        <polyline points="9 22 9 12 15 12 15 22"/>
    ',

        'Clientes' => '
        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
        <circle cx="9" cy="7" r="4"/>
        <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
    ',

        'Medidores' => '
        <circle cx="12" cy="12" r="10"/>
        <path d="M12 6v6l4 2"/>
    ',

        'Leituras' => '
        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
        <polyline points="14 2 14 8 20 8"/>
        <line x1="16" x2="8" y1="13" y2="13"/>
        <line x1="16" x2="8" y1="17" y2="17"/>
    ',

        'Faturas' => '
        <rect width="20" height="14" x="2" y="5" rx="2"/>
        <line x1="2" x2="22" y1="10" y2="10"/>
    ',

        'Pagamentos' => '
        <line x1="12" x2="12" y1="2" y2="22"/>
        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
    ',

        'Usuarios' => '
        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
        <circle cx="9" cy="7" r="4"/>
    ',

        'Configuracoes' => '
        <circle cx="12" cy="12" r="3"/>
        <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18"/>
    ',
    ];


    public $modules;

    public function mount()
    {
        $this->modules =
            Permission::query()
            ->select('module')
            ->distinct()
            ->pluck('module');
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function updatingRole()
    {
        $this->resetPage();
    }

    public function updatingZona()
    {
        $this->resetPage();
    }

    public function setTab($tab)
    {
        $this->tab = $tab;
        $this->resetPage();
    }

    // public ?User $user = null;

    public function viewUser($id)
    {
        $this->selectedUser = User::findOrFail($id);
        // $this->showViewModal = true;
        $this->user = User::with(['roles', 'permissions'])->findOrFail($id);
        $this->loadSessions($this->user->id);
        // dd($id);

        $role = $this->user->roles->first();


        // dd($this->user);
        $this->permissoes = $role
            ? $role->permissions->groupBy('module')->toArray()
            : [];


        /*
            Se o usuário puder ter múltiplos roles e você quiser juntar todas as permissões:
              $permissions = $this->user->roles
                ->flatMap(fn($role) => $role->permissions)
                ->unique('id');

            $this->permissoes = $permissions
                ->groupBy('module')
                ->toArray();

            */

        $this->dispatch('openModal', 'modal-ver-usuario');
        // dd($this->user->name);
    }

    public function loadSessions($id)
    {

        $this->sessions = DB::table('sessions')
            ->where('user_id', $id)
            ->orderByDesc('last_activity')
            ->get();

        // dd($this->sessions);
    }

    /*
    |--------------------------------------------------------------------------
    | Encerrar sessão
    |--------------------------------------------------------------------------
    */
    public function encerrarSessao($sessionId)
    {
        DB::table('sessions')
            ->where('id', $sessionId)
            ->delete();

        $this->loadSessions($sessionId);

        session()->flash('message', 'Sessão encerrada com sucesso.');
    }

    public function permissionsUser($id)
    {
        $this->selectedUser = User::findOrFail($id);

        // $this->showPermissionModal = true;

        $this->dispatch('openModal', 'modal-permissoes');
    }

    public function activateUser($id)
    {
        $user = User::findOrFail($id);

        $user->status = 'ativo';

        $user->save();

        $this->dispatch('showToast', [
            'message' => 'Usuário ativado com sucesso!',
            'type' => 'success'
        ]);
    }

    public function rejectUser($id)
    {
        $user = User::findOrFail($id);

        $user->status = 'inativo';

        $user->save();

        $this->dispatch('showToast', [
            'message' => 'Usuário rejeitado!',
            'type' => 'danger'
        ]);
    }

    public function reactivateUser($id)
    {
        $user = User::findOrFail($id);

        $user->status = 'ativo';

        $user->save();

        $this->dispatch('showToast', [
            'message' => 'Usuário reativado!',
            'type' => 'success'
        ]);
    }

    public function export()
    {
        $this->dispatch('showToast', [
            'message' => 'Exportação iniciada...',
            'type' => 'info'
        ]);
    }


    public function getUsersProperty()
    {
        return User::query()

            ->when($this->search, function ($query) {

                $query->where(function ($q) {

                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                    // ->orWhere('matricula', 'like', '%' . $this->search . '%');
                });
            })

            ->when($this->status, function ($query) {

                $query->where('status', $this->status);
            })

            ->when($this->zona, function ($query) {

                $query->where('zona', $this->zona);
            })

            ->when($this->role, function ($query) {

                $query->role($this->role);
            })

            ->when($this->tab !== 'todos', function ($query) {

                if ($this->tab === 'ativos') {
                    $query->where('status', 'ativo');
                }

                if ($this->tab === 'pendentes') {
                    $query->where('status', 'pendente');
                }

                if ($this->tab === 'inativos') {
                    $query->where('status', 'inativo');
                }
            })

            ->latest()
            ->paginate(10);
    }





    // public function getUsuariosProperty() {}

    // No método do componente pai (ex: UsuariosIndex)
    // public function abrirPermissoes($userId)
    // {
    //     $this->dispatch('permitions-user', id: $userId);
    // }

    #[On('show-usuarios')]
    public function refreshList() {}
    public function render()
    {


        return view('Livewire.admin.Usuarios.Index', [
            'usuario' => User::all(),
            'users' => $this->users,
            'roles' => Role::all(),
        ]);
    }
}