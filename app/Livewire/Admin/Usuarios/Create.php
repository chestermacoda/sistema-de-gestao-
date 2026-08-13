<?php

namespace App\Livewire\Admin\Usuarios;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Create extends Component
{
    public $name;
    public $email;
    public $telefone;
    public $zona = 'Todas as Zonas';
    public $status = 'ativo';
    public $roleActive = 'Admin';
    public $password = 'AquaNexus@2026';
    public $motivo = '';
    public $created = '';
    public $send_email = true;
    public $id_user;

    public $showModal = false;
    public $selectedUser;
    public $mode = 'create';





    public function AddRole($set)
    {
        // dd($set);
        $this->roleActive =  $set;
    }


    // protected function rules()
    // {
    //     return [
    //         'name' => 'required|min:3',
    //         'email' => 'required|email|unique:users,email',
    //         'telefone' => 'nullable|min:9',
    //         'zona' => 'nullable|string',
    //         'status' => 'required',
    //         // 'role' => 'required|exists:roles,name',
    //         'password' => [
    //             'required'
    //         ],
    //     ];
    // }
    // protected $messages = [
    //     'name.required' => 'O nome é obrigatório.',
    //     'email.required' => 'O email é obrigatório.',
    //     'email.unique' => 'Este email já está cadastrado.',

    // ];


    public function save()
    {
        // dd($this->roleActive);
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'telefone' => 'nullable|min:9',
            'zona' => 'nullable|string',
            'status' => 'required',
            // 'role' => 'required|exists:roles,name',
            'password' => [
                'required'
            ],
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'telefone' => $this->telefone,
            'zona' => $this->zona,
            'status' => $this->status,
            'password' => Hash::make($this->password),
            'motivos' => '',
        ]);

        // SPATIE ROLE
        $user->assignRole($this->roleActive);

        $this->reset([
            'name',
            'email',
            'telefone',
            'zona',
            'status',
            'roleActive',
        ]);

        $this->password = 'AquaNexus@2026';
        $this->status = 'ativo';
        // $this->roleActive = 'admin';


    }


    #[On('open-editUser')]
    public function editUser($id)
    {
        $selectedUser = User::findOrFail($id);

        $this->name = $selectedUser->name;
        $this->email = $selectedUser->email;
        $this->telefone = $selectedUser->telefone;
        $this->zona = $selectedUser->zona;
        $this->status = $selectedUser->status;
        $this->created = $selectedUser->created_at->format('d/m/Y');
        $this->id_user = $selectedUser->id;
        $this->selectedUser = $selectedUser;
        $this->mode = 'edit';
        $this->dispatch('closeModal', 'modal-ver-usuario');
        $this->dispatch('openModal', 'modal-editar-usuario');
    }


    public function create($mode)
    {
        if ($mode === 'create') {
            $this->save();
            $this->dispatch('showToast', [
                'message' => 'Usuário criado com sucesso!',
                'type' => 'success'
            ]);
            $this->dispatch('closeModal', 'modal-novo-usuario');
            $this->dispatch('show-usuarios');
        } else {
            $this->update();
            $this->dispatch('showToast', [
                'message' => 'Usuario Editado com sucesso!',
                'type' => 'success'
            ]);
            $this->dispatch('closeModal', 'modal-editar-usuario');
            $this->mode = 'create';
        }
    }


    public function update()
    {

        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required',
            'telefone' => 'nullable|min:9',
            'zona' => 'nullable|string',
            'status' => 'required',
        ]);

        $data = User::findOrfail($this->id_user);
        // dd($data);


        $user = $data->update([
            'name' => $this->name,
            'email' => $this->email,
            'telefone' => $this->telefone,
            'zona' => $this->zona,
            'status' => $this->status,
            'password' => Hash::make($this->password),
            'motivos' => $this->motivo,
        ]);
        $data->syncRoles($this->roleActive);

        // remove um adiciona outro
        // $user->removeRole('leiturista');
        // dd($this->roleActive);
        // $user->assignRole($this->roleActive);
        $this->dispatch('show-usuarios');
    }


    public function render()
    {

        return view('Livewire.admin.Usuarios.Create', [
            'roles' => Role::all()
        ]);
    }
}