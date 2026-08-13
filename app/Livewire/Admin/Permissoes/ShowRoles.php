<?php

namespace App\Livewire\Admin\Permissoes;

use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ShowRoles extends Component
{
    public $name;
    public $slug;
    public $description;
    public $permissoes;
    public $guard_name;
    public $created_at;
    public $updated_at;
    public array $selectedPermissions = [];
    public $roleId;

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

    #[On('show-roles')]
    public function refreshList() {}
    public function getRolesProperty()
    {
        return Role::with('permissions')->withCount('permissions')->withCount('users')->get();
    }

    public function editar($id, $modals)
    {
        $role = Role::with('permissions')
            ->withCount('permissions')
            ->withCount('users')
            ->findOrFail($id);

        $this->roleId = $role->id;

        // dados da role
        $this->name = $role->name;
        $this->slug = $role->slug;
        $this->guard_name  = $role->guard_name;
        $this->created_at  = $role->created_at->format('d/m/Y');
        $this->updated_at  = $role->updated_at;
        $this->description = $role->description;

        // TODAS permissões agrupadas


        // permissões da role (IMPORTANTE)
        $this->selectedPermissions = $role->permissions
            ->pluck('id')
            ->toArray();

        if ($modals === 'editar') {

            $this->permissoes = Permission::all()
                ->groupBy('module')
                ->toArray();
            $this->dispatch('closeModal', 'modal-ver-role');
            $this->dispatch('openModal', 'modal-editar-role');
        } else {
            $this->permissoes = $role->permissions->groupBy('module')->toArray();
            $this->dispatch('openModal', 'modal-ver-role');
        }
    }

    public function updateRole()
    {
        $this->validate([
            'name' => 'required',
        ]);

        $role = Role::findOrFail($this->roleId);

        $role->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        // sincroniza permissões
        $role->syncPermissions($this->selectedPermissions);

        $this->dispatch('showToast', [
            'type' => 'success',
            'message' => 'Role atualizada com sucesso'
        ]);

        $this->dispatch('closeModal', 'modal-editar-role');
    }

    #[On('delete-roles')]
    public function delete($id)
    {
        Role::findOrFail($id)->delete();

        $this->dispatch('showToast', [
            'message' => 'Role deletada com sucesso!',
            'type' => 'success'
        ]);
    }




    public function render()
    {
        // dd($this->roles);
        return view('Livewire.admin.Permissoes.Show-roles');
    }
}
