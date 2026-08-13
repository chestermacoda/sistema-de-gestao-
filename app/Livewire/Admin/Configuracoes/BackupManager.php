<?php

namespace App\Livewire\Admin\Configuracoes;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use App\Models\Backup_historico;
use App\Models\BackupConfiguracao;
use Livewire\Component;
use Livewire\WithPagination;

class BackupManager extends Component
{

    use WithPagination;
    protected $paginationTheme = 'tailwind'; // opcional

    public $frequencia;
    public $horario;
    public $retencao_dias;
    public $ativo;

    public $backups = [];

    public function mount()
    {
        $config = BackupConfiguracao::first();

        if ($config) {
            $this->frequencia = $config->frequencia;
            $this->horario = $config->horario;
            $this->retencao_dias = $config->retencao_dias;
            $this->ativo = $config->ativo;
        }

        $this->loadBackups();
    }

    public function loadBackups()
    {
        $this->backups = Backup_historico::latest()->get();
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORTAR BACKUP
    |--------------------------------------------------------------------------
    */

    public function export($type = 'sql')
    {
        $fileName = 'backup_' . now()->format('Ymd_His') . '.' . $type;

        Artisan::call('db:backup');

        Storage::disk('local')->put("backups/{$fileName}", 'SQL DUMP AQUI');
        $this->Backups();
        $this->dispatch('showToast', [
            'message' => 'Backup efectuado com sucesso!',
            'type' => 'success'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SALVAR CONFIG
    |--------------------------------------------------------------------------
    */

    public function saveConfig()
    {
        $this->validate([
            'frequencia' => 'required',
            'horario' => 'required',
            'retencao_dias' => 'required',
        ]);
        BackupConfiguracao::updateOrCreate(
            ['id' => 1],
            [
                'frequencia' => $this->frequencia,
                'horario' => $this->horario,
                'retencao_dias' => $this->retencao_dias,
                'status' => $this->ativo,
            ]
        );


        $this->dispatch('showToast', [
            'message' => 'Configurações salvas com sucesso!',
            'type' => 'success'
        ]);
        $this->dispatch('closeModal', 'modal-backup');
    }

    /*
    |--------------------------------------------------------------------------
    | RESTAURAR (BASE)
    |--------------------------------------------------------------------------
    */

    public function restore($id)
    {
        $backup = Backup_historico::findOrFail($id);

        // aqui você implementa restore real depois
        session()->flash('success', "Backup {$backup->arquivo} restaurado (simulação)");
    }


    public function Backups()
    {
        return Backup_historico::all();
    }

    public function download($id)
    {
        $down = Backup_historico::findOrFail($id);


        $this->dispatch('showToast', [
            'message' => 'Baixando com sucesso...',
            'type' => 'success'
        ]);

        // dd(storage_path('app/backups', $down->arquivo));
        // storage_path('app/backups')
        // return Storage::disk('public')->download($down->arquivo);
        $dir = storage_path('app/backups');

        return $dir->download($down->arquivo);
    }

    public function render()
    {
        return view(
            'livewire.admin.configuracoes.backup-manager',
            [
                'backups' => $this->Backups()
            ]
        );
    }
}
