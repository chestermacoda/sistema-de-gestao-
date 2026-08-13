<?php

namespace App\Livewire\Admin\Permissoes;

use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MatrizAcesso extends Component
{
    use WithPagination;

    public $searchModulo = '';
    public $modulosInfo = [
        'Dashboard' => '<path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" /><polyline points="9 22 9 12 15 12 15 22" />',
        'Clientes' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" /><circle cx="9" cy="7" r="4" /><path d="M22 21v-2a4 4 0 0 0-3-3.87" /><path d="M16 3.13a4 4 0 0 1 0 7.75" />',
        'Medidores' => '<circle cx="12" cy="12" r="10" /><path d="M12 6v6l4 2" />',
        'Leituras' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" /><polyline points="14 2 14 8 20 8" /><line x1="16" x2="8" y1="13" y2="13" /><line x1="16" x2="8" y1="17" y2="17" /><polyline points="10 9 9 9 8 9" />',
        'Faturas' => '<rect width="20" height="14" x="2" y="5" rx="2" /><line x1="2" x2="22" y1="10" y2="10" />',
        'Pagamentos' => '<line x1="12" x2="12" y1="2" y2="22" /><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />'
    ];



    public function updatingSearchModulo()
    {
        $this->resetPage();
    }
    public function togglePermission($roleId, $permissionName)
    {
        $role = Role::findById($roleId);
        if ($role->hasPermissionTo($permissionName)) {
            $role->revokePermissionTo($permissionName);
        } else {
            $role->givePermissionTo($permissionName);
        }

        // Força atualização dos computed properties
        unset($this->permissions);           // Remove cache interno
        unset($this->groupedPermissions);    // Remove cache interno

        // Mensagem de feedback (opcional)
        $this->dispatch('showToast', [
            'type' => 'success',
            'message' => "Permissão '{$permissionName}' atualizada no role '{$role->name}'"
        ]);
    }



    // Reseta página quando filtro mudar
    public function updatedSearchModulo()
    {
        $this->resetPage();
    }

    #[Computed]
    public function roles()
    {
        return Role::withCount('users')->get();
    }

    #[Computed()]
    public function permissions()
    {
        return Permission::query()
            ->when($this->searchModulo, function ($query) {
                $query->where('name', 'like', $this->searchModulo . '.%');
            })
            ->paginate(10);
    }

    #[Computed]
    public function groupedPermissions()
    {
        return $this->permissions
            ->getCollection()
            ->groupBy(function ($permission) {
                $parts = explode('.', $permission->name);
                return ucfirst($parts[0] ?? 'Outros');
            });
    }

    public function render()
    {
        // Buscamos todas as roles para o cabeçalho
        // $roles = Role::withCount('users')->get();

        // Paginação das permissões agrupadas por módulo
        // Assumindo que o nome da permissão segue o padrão "modulo.acao"
        // $permissionsQuery = Permission::query();

        // if (!empty($this->searchModulo)) {
        //     // $permissionsQuery->where('name', 'like', strtolower($this->searchModulo) . '.%');

        //     $permissionsQuery->where('name', 'like', $this->searchModulo . '.%');
        // }

        // $permissions = $permissionsQuery->paginate(10);

        // // Agrupamos as permissões da página atual por módulo para renderizar os títulos
        // $groupedPermissions = $permissions->getCollection()->groupBy(function ($item) {
        //     return ucfirst(explode('.', $item->name)[0]);
        // });

        // $groupedPermissions = $permissions->groupBy(function ($item) {
        //     return ucfirst(explode('.', $item->name)[0]);
        // });

        return view('Livewire.admin.Permissoes.Matriz-acesso', [
            'roles' => $this->roles,
            'groupedPermissions' => $this->groupedPermissions,
            'permissions' => $this->permissions
        ]);
    }
}
