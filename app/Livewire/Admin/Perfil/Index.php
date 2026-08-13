<?php

namespace App\Livewire\Admin\Perfil;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Index extends Component
{
    public $nome_completo;
    public $email;
    public $telefone;
    public $perfil;
    public $zona;
    public $bibliografia;

    public $senha_antiga;
    public $password;
    public function mount()
    {
        $user = User::with('roles')->find(Auth()->user()->id);
        // dd($user->roles[0]);
        $this->nome_completo = $user->name;
        $this->email = $user->email;
        $this->telefone = $user->telefone;
        $this->perfil = $user->roles[0]->name;
        $this->zona = $user->zona;
        $this->bibliografia = "-";
    }

    public function senha()
    {
        $request = $this->validate([
            'senha_antiga' => 'required',
            'password' => 'required|min:6',
        ]);
        $user = auth()->user();
        if (!Hash::check($this->senha_antiga, $user->password)) {

            $this->dispatch('showToast', [
                'message' => "Senha actual incorrecta",
                'type' => 'warning'
            ]);
            return;
        }

        // atualizar senha
        $user->update([
            'password' => Hash::make($this->password)
        ]);
        $this->dispatch('showToast', [
            'message' => "Senha actualizada com sucesso",
            'type' => 'success'
        ]);

        $this->dispatch('closeModal', 'modal-senha');
    }



    public function update()
    {

        $this->validate([
            'nome_completo' => 'required|min:3',
            'email' => 'required',
            'telefone' => 'nullable|min:9',
            'zona' => 'nullable|string',

        ]);

        $data = User::findOrfail(Auth()->user()->id);
        // dd($data);


        $user = $data->update([
            'name' => $this->nome_completo,
            'email' => $this->email,
            'telefone' => $this->telefone,
            'zona' => $this->zona,

            // 'password' => Hash::make($this->password),
            // 'motivos' => $this->motivo,
        ]);
        // $data->syncRoles($this->roleActive);

        $this->dispatch('showToast', [
            'message' => "$this->perfil Editado com sucesso!",
            'type' => 'success'
        ]);
        $this->dispatch('closeModal', 'modal-editar-perfil');
    }




    public function render()
    {
        return view('Livewire.admin.Perfil.Index');
    }
}
