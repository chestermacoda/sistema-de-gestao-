<?php

namespace App\Livewire\Admin\Mobile\Leiturista;

use App\Models\RoteiroLeiturista;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    public $concluidos;
    public $pendente;
    public $total;







    #[On('reload-appleitura')]
    public function refresh() {}



    public function render()
    {
        $user = Auth()->user();
        $id_user = $user->id;


        // dd($this->telefone);
        $this->concluidos = RoteiroLeiturista::where('user_id', $id_user)
            ->where('status', 'Concluido')
            ->count();
        $this->pendente = RoteiroLeiturista::where('user_id', $id_user)
            ->where('status', 'Pendente')
            ->count();
        $this->total = RoteiroLeiturista::where('user_id', $id_user)
            ->count();

        $percentual = $this->total > 0 ? round(($this->concluidos / $this->total) * 100) : 0;

        return view('Livewire.admin.Mobile.Leiturista.Index');
    }
}
