<?php

namespace App\Livewire\Admin\Permissoes;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;
use Livewire\Attributes\On;

class CreateRoles extends Component
{

    public string $name = '';

    public string $slug = '';

    public string $guard_name = 'web';

    public string $color = 'primary';

    public string $description = '';

    public array $selectedPermissions = [];

    //public $paletas = 'primary'; // valor padrão
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
    // public function permition()
    // {
    //     // $this->permissoes = Permission::all();
    //     $this->permissoes = Permission::all()->groupBy('module')->toArray();
    // }


    protected function rules()
    {
        return [

            'name' => ['required', 'string', 'max:255'],

            'slug' => ['required', 'string', 'unique:roles,name'],

            'guard_name' => ['required'],

            'color' => ['required'],

            'selectedPermissions' => ['array'],
        ];
    }

    public function updatedName()
    {
        $this->slug = str($this->name)
            ->slug()
            ->toString();
    }



    public function save()
    {
        $this->validate();

        $role = Role::create([
            'name' => $this->name,
            'guard_name' => $this->guard_name,
            'slug' => Str::slug($this->slug),
            'description' => $this->description,
            'color' => $this->color,
        ]);

        $permissions = Permission::whereIn('id', $this->selectedPermissions)->get();
        $role->syncPermissions($permissions);

        $this->reset([
            'name',
            'slug',
            'description',
            'selectedPermissions',
        ]);

        $this->guard_name = 'web';
        $this->color = 'primary';
        $this->dispatch('show-roles');
        $this->dispatch('showToast', [
            'message' => 'Role criada com sucesso!',
            'type' => 'success'
        ]);
        $this->dispatch('closeModal', 'modal-nova-role');
    }

    // public function getPermissoesProperty()
    // {
    //     return Permission::query()
    //         ->select('id', 'name', 'module')
    //         ->orderBy('module')
    //         ->get()
    //         ->groupBy('module');
    // }

    #[On('show-permition-on-roles')]
    public function refreshList() {}

    public function render()
    {
        // $this->permissoes = Permission::all()->groupBy('module')->toArray();
        return view('Livewire.admin.Permissoes.Create-roles', [
            'permissoes' => Permission::all()->groupBy('module')->toArray()
        ]);
    }
}
