<?php

namespace App\Livewire\Admin\Leituras;

use App\Models\Cliente;
use App\Models\Medidores;
use App\Models\Leituras;
use App\Models\ClienteMedidor;
use App\Services\Leituristas;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class VerLeituraEspecifica extends Component
{
    /**
     * Dados carregados do cliente, medidor e leitura
     */
    public ?array $data = null;
    /**
     * Recebe evento para abrir modal com dados específicos
     */
    #[On('ver-leitura')]
    public function getLeituraEspecifica(int $idCliente, int $idMedidor, ?int $idLeitura = null): void
    {
        // 1. Busca cliente e medidor
        // $cliente = Cliente::find($idCliente);
        // $medidor = Medidores::where('id', $idMedidor)
        //     ->where('cliente_id', $idCliente)
        //     ->first();

        // if (!$cliente || !$medidor) {
        //     $this->dispatch('notify', type: 'error', message: 'Dados não encontrados.');
        //     return;
        // }

        // // 2. Busca leitura específica ou a mais recente
        // if ($idLeitura) {
        //     $this->leituraAtual = Leituras::with('leiturista')
        //         ->where('id', $idLeitura)
        //         ->where('medidores_id', $idMedidor)
        //         ->first();
        // } else {
        //     $this->leituraAtual = Leituras::with('leiturista')
        //         ->where('medidores_id', $idMedidor)
        //         ->latest('data_leitura')
        //         ->first();
        // }

        // // 3. Carrega histórico de consumo (últimos 6 meses)
        // $this->historicoConsumo = $this->carregarHistoricoConsumo($idMedidor);

        // // 4. Carrega timeline de eventos
        // $this->timeline = $this->carregarTimeline($idMedidor);

        // // 5. Busca dados da instalação atual
        // $instalacao = ClienteMedidor::where('cliente_id', $idCliente)
        //     ->where('medidor_id', $idMedidor)
        //     ->where('status', 'instalado')
        //     ->first();

        // // 6. Monta array de dados para o modal
        // $this->data = [
        //     'cliente' => [
        //         'nome_completo' => $cliente->nome_completo,
        //         'numero_matricula' => $cliente->numero_matricula,
        //         'bi' => $cliente->bi,
        //         'nuit' => $cliente->nuit,
        //         'email' => $cliente->email,
        //         'telefone' => $cliente->telefone,
        //         'endereco' => $cliente->endereco,
        //         'bairro' => $cliente->bairro,
        //         'cidade' => $cliente->cidade,
        //         'categoria_consumo' => $cliente->categoria_consumo,
        //         'status' => $cliente->status,
        //     ],
        //     'medidor' => [
        //         'numero_hidrometro' => $medidor->numero_hidrometro,
        //         'numero_serie' => $medidor->numero_serie,
        //         'marca' => $medidor->marca,
        //         'modelo' => $medidor->modelo,
        //         'diametro' => $medidor->diametro,
        //         'tipo_hidrometro' => $medidor->tipo_hidrometro,
        //         'classe_metrologica' => $medidor->classe_metrologica,
        //         'ano_fabricacao' => $medidor->ano_fabricacao,
        //         'status_inicial' => $medidor->status_inicial,
        //     ],
        //     'instalacao' => $instalacao ? [
        //         'data_instalacao' => $instalacao->data_instalacao?->format('d/m/Y'),
        //         'leitura_inicial' => $instalacao->leitura_inicial,
        //         'local_instalacao' => $instalacao->local_instalacao,
        //         'condicao_hidrometro' => $instalacao->condicao_hidrometro,
        //         'numero_lacre' => $instalacao->numero_lacre,
        //     ] : null,
        //     'leitura' => $this->leituraAtual ? [
        //         'id' => $this->leituraAtual->id,
        //         'mes_referencia' => $this->leituraAtual->mes_referencia,
        //         'data_leitura' => $this->leituraAtual->data_leitura?->format('d/m/Y'),
        //         'hora_leitura' => $this->leituraAtual->hora_leitura,
        //         'leitura_anterior' => $this->leituraAtual->leitura_anterior,
        //         'leitura_atual' => $this->leituraAtual->leitura_atual,
        //         'consumo' => $this->leituraAtual->consumo,
        //         'consumo_medio' => $this->leituraAtual->consumo_medio,
        //         'status' => $this->leituraAtual->status,
        //         'tem_anomalia' => $this->leituraAtual->tem_anomalia,
        //         'tipo_anomalia' => $this->leituraAtual->tipo_anomalia,
        //         'descricao_anomalia' => $this->leituraAtual->descricao_anomalia,
        //         'observacoes' => $this->leituraAtual->observacoes,
        //         'origem' => $this->leituraAtual->origem,
        //     ] : null,
        //     'leiturista' => $this->leituraAtual?->leiturista ? [
        //         'nome' => $this->leituraAtual->leiturista->name ?? 'N/A',
        //         'matricula' => $this->leituraAtual->leiturista->matricula ?? 'N/A',
        //     ] : null,
        // ];

        $this->data = app(Leituristas::class)->getDetalhesLeitura($idCliente, $idMedidor, null);

        $this->dispatch('openModal', 'modal-ver-leitura');
    }
    /**
     * Gera fatura para a leitura atual
     */
    public function gerarFatura(): void
    {
        if (!$this->leituraAtual) {
            $this->dispatch('notify', type: 'error', message: 'Nenhuma leitura selecionada.');
            return;
        }

        // Aqui você implementa a lógica de geração de fatura
        // Exemplo: dispatch para outro componente ou chamada de serviço
        $this->dispatch('gerar-fatura', leituraId: $this->leituraAtual->id);
        $this->dispatch('notify', type: 'success', message: 'Fatura gerada com sucesso!');
    }

    public function render()
    {
        return view('livewire.admin.leituras.ver-leituraespecifica');
    }
}
