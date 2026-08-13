<?php

namespace App\Livewire\Admin\Permissoes;

use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    public $permissoes = null;
    public $roles = null;

    public function mount()
    {
        $this->permissoes = Permission::all()->count();
        $this->roles = role::all()->count();
    }


    public function render()
    {
        return view('Livewire.admin.Permissoes.Index');
    }
}
