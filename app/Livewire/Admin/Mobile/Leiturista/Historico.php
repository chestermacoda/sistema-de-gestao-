<?php

namespace App\Livewire\Admin\Mobile\Leiturista;

use App\Models\Leituras;
use App\Models\RoteiroLeiturista;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Historico extends Component
{
    use WithPagination;

    public $filtro = 'hoje';

    protected $paginationTheme = 'bootstrap';

    // protected $queryString = [
    //     'page' => ['except' => 1],   // mantém apenas a página
    //     // 'filtro' => ['except' => 'hoje'],  // ← Comente ou remova
    // ];

    public function mount()
    {
        $this->filtro = Carbon::now()->month;
    }
    protected $queryString = [];

    public function updatingFiltro()
    {
        $this->resetPage();
    }

    public function setFiltro($filtro)
    {
        $this->filtro = $filtro;
        $this->resetPage();
    }

    public function getLeiturasProperty()
    {
        $query = RoteiroLeiturista::query()
            ->with(['cliente', 'medidores'])
            ->where('user_id', Auth()->user()->id)
            ->where('status', 'Concluido');
        // ->whereMonth('data_referente', date('m'));
        // =========================
        // FILTROS DAS ABAS
        // =========================
        if ($this->filtro) {
            $query->whereMonth('data_referente', $this->filtro);
        }
        // if ($this->filtro === 'ontem') {
        //     $query->whereDate('created_at', Carbon::yesterday());
        // }

        // if ($this->filtro === 'semana') {
        //     $query->whereBetween('created_at', [
        //         Carbon::now()->startOfWeek(),
        //         Carbon::now()->endOfWeek()
        //     ]);
        // }

        // if ($this->filtro === 'mes') {
        //     $query->whereMonth('created_at', Carbon::now()->month);
        // }

        return $query
            ->orderByDesc('created_at')
            ->paginate(5);
        return $query->orderByDesc('created_at')->paginate(5, ['*'], 'page', null);
    }
    public function render()
    {
        return view('livewire.admin.mobile.leiturista.historico', [
            'leituras' => $this->leituras
        ]);
    }
}
