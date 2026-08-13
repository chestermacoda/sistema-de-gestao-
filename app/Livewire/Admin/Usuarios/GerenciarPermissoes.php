<?php

namespace App\Livewire\Admin\Usuarios;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class GerenciarPermissoes extends Component
{

    public ?User $user = null;

    public array $selectedPermissions = [];

    public array $permissionsGrouped = [];

    public $roles = [];
    public array $rolePermissions = [];
    public array $moduleIcons = [

        'dashboard' => '
        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
        <polyline points="9 22 9 12 15 12 15 22"/>
    ',

        'clientes' => '
        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
        <circle cx="9" cy="7" r="4"/>
        <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
    ',

        'medidores' => '
        <circle cx="12" cy="12" r="10"/>
        <path d="M12 6v6l4 2"/>
    ',

        'leituras' => '
        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
        <polyline points="14 2 14 8 20 8"/>
        <line x1="16" x2="8" y1="13" y2="13"/>
        <line x1="16" x2="8" y1="17" y2="17"/>
    ',

        'faturas' => '
        <rect width="20" height="14" x="2" y="5" rx="2"/>
        <line x1="2" x2="22" y1="10" y2="10"/>
    ',

        'pagamentos' => '
        <line x1="12" x2="12" y1="2" y2="22"/>
        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
    ',

        'usuarios' => '
        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
        <circle cx="9" cy="7" r="4"/>
    ',

        'configuracoes' => '
        <circle cx="12" cy="12" r="3"/>
        <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18"/>
    ',
    ];

    // public function mount(User $user)
    // {
    //     $this->user = $user;

    //     /**
    //      * Permissões do usuário
    //      */
    //     $this->selectedPermissions = $user
    //         ->getAllPermissions()
    //         ->pluck('name')
    //         ->toArray();

    //     /**
    //      * Todas as roles (presets)
    //      */
    //     $this->roles = Role::with('permissions')->get();

    //     /**
    //      * Agrupar permissões por módulo
    //      */
    //     $permissions = Permission::all();

    //     $grouped = [];

    //     foreach ($permissions as $permission) {

    //         $parts = explode('.', $permission->name);

    //         $module = $parts[0] ?? 'geral';

    //         $action = $parts[1] ?? $permission->name;

    //         $grouped[$module][] = [
    //             'name' => $permission->name,
    //             'label' => $this->formatLabel($action),
    //         ];
    //     }

    //     $this->permissionsGrouped = $grouped;
    // }

    public function mount()
    {
        $this->roles = Role::with('permissions')->get();

        $permissions = Permission::all();

        $grouped = [];

        foreach ($permissions as $permission) {

            $parts = explode('.', $permission->name);

            $module = strtolower($parts[0]);

            $action = $parts[1] ?? $permission->name;

            $grouped[$module][] = [
                'name' => $permission->name,
                'label' => $this->formatLabel($action),
            ];
        }

        $this->permissionsGrouped = $grouped;
    }
    // #[On('permitions-user')]
    // public function permissionsUser($id)
    // {
    //     $this->user = User::findOrFail($id);

    //     /**
    //      * Carrega permissões do usuário
    //      */
    //     // $this->selectedPermissions = $this->user
    //     //     ->getAllPermissions()
    //     //     ->pluck('name')
    //     //     ->toArray();
    //     $this->selectedPermissions = $this->user
    //         ->permissions
    //         ->pluck('name')
    //         ->toArray();

    //     $this->rolePermissions = $this->user
    //         ->getPermissionsViaRoles()
    //         ->pluck('name')
    //         ->toArray();

    //     $this->dispatch('openModal', 'modal-permissoes');
    // }

    #[On('permitions-user')]
    public function permissionsUser($id)
    {
        // 💡 CORREÇÃO AQUI: Carrega o utilizador trazendo também as roles E as permissões dessas roles
        $this->user = User::with(['roles.permissions', 'permissions'])->findOrFail($id);

        // Carrega permissões DIRETAS
        $this->selectedPermissions = $this->user
            ->permissions
            ->pluck('name')
            ->toArray();

        // 💡 CORREÇÃO AQUI: Vamos pegar os nomes de forma direta e blindada via Eloquent,
        // caso o getPermissionsViaRoles() se perca no ciclo do Livewire
        $this->rolePermissions = [];
        if ($this->user->roles) {
            foreach ($this->user->roles as $role) {
                $permissionsNames = $role->permissions->pluck('name')->toArray();
                $this->rolePermissions = array_merge($this->rolePermissions, $permissionsNames);
            }
            // Remove duplicados apenas por segurança
            $this->rolePermissions = array_unique($this->rolePermissions);
        }

        $this->dispatch('openModal', 'modal-permissoes');
    }

    public function formatLabel($value): string
    {
        return match ($value) {

            'ver' => 'Visualizar',
            'editar' => 'Editar',
            'excluir' => 'Excluir',
            'create' => 'Criar',

            'manutencao' => 'Manutenção',
            'registrar' => 'Registrar',
            'importar' => 'Importar Lote',
            'validar' => 'Validar Anomalias',
            'gerar' => 'Gerar',
            'cancelar' => 'Cancelar / Estornar',
            'confirmar' => 'Confirmar',
            'recibo' => 'Gerar Recibo',
            'permissoes' => 'Alterar Permissões',
            'api' => 'Gerenciar API',
            'logs' => 'Logs do Sistema',

            default => ucfirst(str_replace('_', ' ', $value)),
        };
    }

    public function aplicarPreset($roleId)
    {
        $role = Role::find($roleId);

        if (! $role) {
            return;
        }

        $this->selectedPermissions = $role
            ->permissions
            ->pluck('name')
            ->toArray();
    }

    public function resetarPermissoes()
    {
        $this->selectedPermissions = [];

        $this->user->syncPermissions([]);
    }

    public function salvarPermissoes()
    {
        // $this->user->syncPermissions($this->selectedPermissions);


        $this->user->syncPermissions($this->selectedPermissions);

        // app()[PermissionRegistrar::class]
        //     ->forgetCachedPermissions();

        $this->user->refresh();

        $this->selectedPermissions = $this->user
            ->permissions
            ->pluck('name')
            ->toArray();



        $this->dispatch('showToast', [
            'message' => 'Permisão Editada com sucesso!',
            'type' => 'success'
        ]);
        // $this->dispatch('closeModal', 'modal-permissoes');
        // $this->dispatch('permissoes-salvas');
    }


    public function render()
    {
        return view('Livewire.admin.usuarios.Gerenciar-permissoes');
    }
}