<?php

namespace App\Livewire\Admin\Permissoes;

use App\Models\User;
use Livewire\Component;

class Usuarios extends Component
{
    public $roleFilter = null;

    public function getUsersProperty()
    {
        return User::query()
            ->with(['roles', 'permissions'])
            ->when($this->roleFilter, function ($query) {
                $query->whereHas('roles', function ($q) {
                    $q->where('name', $this->roleFilter);
                });
            })
            ->get();
    }

    public function setRoleFilter($role)
    {
        $this->roleFilter = $role === 'all' ? null : $role;
    }
    public function render()
    {
        return view('Livewire.admin.Permissoes.Usuarios', [
            'users' => $this->users
        ]);
    }
}
