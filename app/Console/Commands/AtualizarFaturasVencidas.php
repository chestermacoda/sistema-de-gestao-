<?php

namespace App\Console\Commands;

use App\Models\Faturas;
use App\Services\FaturaService;
use Illuminate\Console\Command;

class AtualizarFaturasVencidas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:atualizar-faturas-vencidas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {


        // Busca todas as faturas não pagas que já passaram do vencimento
        $faturasPendentes = app(Faturas::class)->whereIn('status', ['Pendente', 'Vencida'])
            ->where('data_vencimento', '<', now())
            ->get();
        foreach ($faturasPendentes as $fatura) {
            app(FaturaService::class)->atualizarMultasEJuros($fatura);
        }

        $this->info('Multas e juros atualizados com sucesso!');
    }
}
