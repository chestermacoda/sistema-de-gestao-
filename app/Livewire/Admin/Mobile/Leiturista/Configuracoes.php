<?php

namespace App\Livewire\Admin\Mobile\Leiturista;

use App\Models\ConfiguracaoApp;
use Livewire\Component;

class Configuracoes extends Component
{
    // ===== PROPRIEDADES DO MODELO =====
    public $configId;

    // Notificações
    public $notif_novas_leituras = true;
    public $notif_anomalias = true;
    public $notif_sincronizacao = false;

    // Aparência
    public $tema = 'claro';

    // Dados e Armazenamento
    public $modo_offline = true;
    public $fotos_alta_resolucao = false;
    public $cache_utilizado = 0;

    // ===== ESTADO DA UI =====
    public $modalAberto = false;
    public $toast = null;
    public $toastTipo = 'success';

    // ===== LISTENERS =====
    protected $listeners = [
        'abrir-configuracoes' => 'abrirModal',
        'fechar-configuracoes' => 'fecharModal',
    ];

    // ===== REGRAS DE VALIDAÇÃO =====
    protected $rules = [
        'notif_novas_leituras' => 'boolean',
        'notif_anomalias' => 'boolean',
        'notif_sincronizacao' => 'boolean',
        'tema' => 'in:claro,escuro,auto',
        'modo_offline' => 'boolean',
        'fotos_alta_resolucao' => 'boolean',
    ];

    // ===== CICLO DE VIDA =====
    public function mount()
    {
        $this->carregarConfiguracoes();
    }

    // ===== CARREGAR CONFIGURAÇÕES DO BANCO =====
    public function carregarConfiguracoes()
    {
        $user = Auth::user();

        if (!$user) {
            return;
        }

        $config = ConfiguracaoApp::firstOrCreate(
            ['user_id' => $user->id],
            [
                'notif_novas_leituras' => true,
                'notif_anomalias' => true,
                'notif_sincronizacao' => false,
                'tema' => 'claro',
                'modo_offline' => true,
                'fotos_alta_resolucao' => false,
                'cache_utilizado' => 0,
            ]
        );

        $this->configId = $config->id;
        $this->notif_novas_leituras = $config->notif_novas_leituras;
        $this->notif_anomalias = $config->notif_anomalias;
        $this->notif_sincronizacao = $config->notif_sincronizacao;
        $this->tema = $config->tema;
        $this->modo_offline = $config->modo_offline;
        $this->fotos_alta_resolucao = $config->fotos_alta_resolucao;
        $this->cache_utilizado = $config->cache_utilizado;

        // Aplica o tema imediatamente ao carregar
        $this->dispatch('tema-alterado', tema: $this->tema);
    }

    // ===== ABRIR / FECHAR MODAL =====
    public function abrirModal()
    {
        $this->modalAberto = true;
        $this->carregarConfiguracoes(); // Recarrega dados atualizados
    }

    public function fecharModal()
    {
        $this->modalAberto = false;
    }

    // ===== ATUALIZAR TOGGLES (Notificações e Dados) =====
    public function atualizarToggle($campo, $valor)
    {
        $this->validateOnly($campo);

        $config = ConfiguracaoApp::find($this->configId);

        if ($config) {
            $config->update([$campo => $valor]);
            $this->$campo = $valor;

            $nomes = [
                'notif_novas_leituras' => 'Notificações de novas leituras',
                'notif_anomalias' => 'Notificações de anomalias',
                'notif_sincronizacao' => 'Notificações de sincronização',
                'modo_offline' => 'Modo offline',
                'fotos_alta_resolucao' => 'Fotos em alta resolução',
            ];

            $this->mostrarToast(
                ($valor ? 'Ativado: ' : 'Desativado: ') . ($nomes[$campo] ?? $campo),
                'success'
            );
        }
    }

    // ===== ALTERAR TEMA =====
    public function alterarTema($novoTema)
    {
        $this->validateOnly('tema');

        if (!in_array($novoTema, ['claro', 'escuro', 'auto'])) {
            return;
        }

        $config = ConfiguracaoApp::find($this->configId);

        if ($config) {
            $config->update(['tema' => $novoTema]);
            $this->tema = $novoTema;

            // Dispara evento para o frontend aplicar o tema
            $this->dispatch('tema-alterado', tema: $novoTema);

            $nomesTema = [
                'claro' => 'Tema Claro',
                'escuro' => 'Tema Escuro',
                'auto' => 'Tema Automático',
            ];

            $this->mostrarToast($nomesTema[$novoTema] . ' ativado', 'success');
        }
    }

    // ===== LIMPAR CACHE =====
    public function limparCache()
    {
        // Simula limpeza de cache (ajuste conforme sua lógica real)
        $cacheSize = $this->cache_utilizado;

        $config = ConfiguracaoApp::find($this->configId);

        if ($config) {
            $config->update(['cache_utilizado' => 0]);
            $this->cache_utilizado = 0;

            $this->mostrarToast(
                'Cache limpo com sucesso! Liberados ' . $this->formatarBytes($cacheSize),
                'success'
            );
        }
    }

    // ===== SALVAR TODAS AS CONFIGURAÇÕES =====
    public function salvarTudo()
    {
        $this->validate();

        $config = ConfiguracaoApp::find($this->configId);

        if ($config) {
            $config->update([
                'notif_novas_leituras' => $this->notif_novas_leituras,
                'notif_anomalias' => $this->notif_anomalias,
                'notif_sincronizacao' => $this->notif_sincronizacao,
                'tema' => $this->tema,
                'modo_offline' => $this->modo_offline,
                'fotos_alta_resolucao' => $this->fotos_alta_resolucao,
            ]);

            $this->dispatch('tema-alterado', tema: $this->tema);
            $this->mostrarToast('Configurações salvas com sucesso!', 'success');
        }
    }

    // ===== TOAST =====
    public function mostrarToast($mensagem, $tipo = 'success')
    {
        $this->toast = $mensagem;
        $this->toastTipo = $tipo;

        // Auto-limpa após 3 segundos
        $this->dispatch('mostrar-toast', mensagem: $mensagem, tipo: $tipo);
    }

    // ===== HELPERS =====
    private function formatarBytes($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' B';
    }
    public function render()
    {
        return view('Livewire.Admin.Mobile.Leiturista.Configuracoes');
    }
}
