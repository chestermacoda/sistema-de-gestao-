<?php

namespace App\Livewire\Admin\Permissoes;

use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreatePermissao extends Component
{

    public $showModal = false;

    public $name;
    public $display_name;
    public $module;
    public $guard_name = 'web';
    public $description;
    public $assign_to_super_admin = true;




    public function fecharModal()
    {
        $this->showModal = false;
    }





    protected function rules()
    {
        return [
            'name' => [
                'required',
                'regex:/^[a-z]+\.[a-z]+$/',
                'unique:permissions,name',
            ],
            'display_name' => 'nullable|string|max:255',
            'module' => 'required|string|max:255',
            'guard_name' => 'required|string',
            'description' => 'nullable|string',
        ];
    }

    protected $messages = [
        'name.regex' => 'Use o formato modulo.acao',
    ];

    public function save()
    {
        $this->validate();

        $permission = Permission::create([
            'name' => $this->name,
            'guard_name' => $this->guard_name,
            'display_name' => $this->display_name,
            'module' => $this->module,
            'description' => $this->description,
        ]);
        /**
         * Atribuir ao Super Admin
         */
        if ($this->assign_to_super_admin) {

            // $role = Role::where('name', 'Super Admin')->first();

            $role = Role::firstOrCreate([
                'name' => 'Super Admin',
                'guard_name' => 'web',
            ]);

            if ($role) {
                $role->givePermissionTo($permission);
            }
        }

        $this->dispatch('show-Permittion');
        $this->dispatch('show-permition-on-roles');
        $this->resetForm();
        $this->dispatch('showToast', [
            'message' => 'Permissão criada com sucesso!',
            'type' => 'success'
        ]);

        $this->dispatch('closeModal', 'modal-nova-permissao');
    }

    public function resetForm()
    {
        $this->reset([
            'name',
            'display_name',
            'module',
            'description',
        ]);

        $this->guard_name = 'web';
        $this->assign_to_super_admin = true;
    }

    public function render()
    {
        return view('Livewire.admin.Permissoes.Create-permissao');
    }
}
