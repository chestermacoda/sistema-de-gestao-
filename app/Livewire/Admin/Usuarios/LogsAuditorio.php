<?php

namespace App\Livewire\Admin\Usuarios;

use App\Models\Cliente;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class LogsAuditorio extends Component
{

    public bool $open = false;

    public ?int $logId = null;

    // ===== VARIÁVEIS DA MODAL =====
    public $periodoFiltro = '7';
    public string $search = '';
    public $idLog = null;
    public $dataHora = null;
    public $usuario = null;
    public $acao = null;
    public $descricao = null;
    public $properties = [];
    public $old = [];
    public $new = [];

    protected $listeners = [
        'openAuditModal' => 'loadLog'
    ];

    // ===== FUNÇÃO QUE CARREGA OS DADOS =====
    #[On('verDetalhes-ver')]
    public function loadLog($id)
    {

        $activity = Activity::with('causer:id,name')->find($id);

        if (!$activity) {
            $this->open = false;
            return;
        }

        $this->logId = $activity->id;

        // ===== ATRIBUIÇÃO NAS VARIÁVEIS =====
        $this->idLog = $activity->id;
        $this->dataHora = $activity->created_at?->format('d/m/Y H:i:s');
        $this->usuario = $activity->causer?->name ?? 'Sistema';
        $this->acao = $activity->event;
        $this->descricao = $activity->description;

        $this->properties = $activity->properties?->toArray() ?? [];

        $this->old = $this->properties['old'] ?? [];
        $this->new = $this->properties['attributes'] ?? [];

        $this->dispatch('openModal', 'modal-audits');
    }

    public function close()
    {
        $this->open = false;

        $this->reset([
            'idLog',
            'dataHora',
            'usuario',
            'acao',
            'descricao',
            'properties',
            'old',
            'new'
        ]);
    }



    // ============ RENDER ============
    public function render()
    {


        return view('livewire.admin.usuarios.logs-auditorio');
    }
}