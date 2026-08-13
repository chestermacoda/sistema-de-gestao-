<?php

namespace App\Livewire\Admin\Permissoes;

use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class ShowPermissoes extends Component
{
    use WithPagination;

    public string $search = '';
    public string $moduleFilter = '';
    protected $paginationTheme = 'tailwind'; // opcional


    public $permissionSelected = null;

    public $selectedPermission = null;

    public $id;
    public $name;
    public $display_name;
    public $module;
    public $guard_name;
    public $description;
    public $data_create;

    #[On('show-Permittion')]
    public function refreshList() {}

    public function updating($field)
    {
        if (in_array($field, ['search', 'moduleFilter'])) {
            $this->resetPage();
        }
    }
    public function getPermissionsProperty()
    {

        return Permission::query()
            ->with('roles')
            ->withCount('users') // 👈 ADICIONADO AQUI
            ->when($this->search, function ($q) {
                $q->where('name', 'like', "%{$this->search}%");
            })
            ->when($this->moduleFilter, function ($q) {
                $q->where('module', $this->moduleFilter);
            })
            ->latest()
            ->paginate(6);
    }

    // #[On('ver-permissao')]
    // public function ver($id)
    // {
    //     $this->permissionSelected = Permission::with('roles')->findOrFail($id);

    //     $this->dispatch('open-modal-ver');
    // }

    #[On('editar-permissao')]
    public function edit($id, $modal)
    {
        // dd($id);
        // $permission = Permission::with('roles')->findOrFail($id);


        $this->selectedPermission = Permission::with('roles')
            ->where('id', $id)
            ->first();
        // dd($this->selectedPermission);

        $this->permissionSelected = $this->selectedPermission;

        $this->id = $this->selectedPermission->id;
        $this->name = $this->selectedPermission->name;
        $this->display_name = $this->selectedPermission->display_name;
        $this->module = $this->selectedPermission->module;
        $this->guard_name = $this->selectedPermission->guard_name;
        $this->description = $this->selectedPermission->description;
        $this->data_create = $this->selectedPermission->created_at->format('d/m/Y');

        // dd();
        if ($modal === 'editar') {
            $this->dispatch('openModal', 'modal-editar-permissao');
        } else {
            $this->dispatch('openModal', 'modal-ver-permissao');
        }
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
    // 🔵 SALVAR EDIT
    public function update()
    {

        $this->validate();
        $this->permissionSelected->update([
            'display_name' => $this->display_name,
            'module' => $this->module,
            'guard_name' => $this->guard_name,
            'description' => $this->description,
        ]);

        // $this->dispatch('close-modal-edit');
        $this->dispatch('showToast', [
            'message' => 'Permissão atualizada com sucesso!',
            'type' => 'success'
        ]);
    }

    #[On('delete-permissao')]
    public function delete($id)
    {

        Permission::findOrFail($id)->delete();

        $this->dispatch('showToast', [
            'message' => 'Permissão deletada com sucesso!',
            'type' => 'success'
        ]);
    }




    public function render()
    {
        return view('Livewire.admin.Permissoes.Show-Permissoes', [
            'permissions' => $this->permissions
        ]);
    }
}
