<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Backup_historico;
use App\Models\BackupConfiguracao;

class DatabaseBackupCommand extends Command
{
    protected $signature = 'db:backup';

    protected $description = 'Gerar backup do banco de dados';

    public function handle()
    {
        try {



            // $config = BackupConfiguracao::first();

            // if (!$config || !$config->ativo) {
            //     $this->info('Backup desativado.');
            //     return;
            // }

            // $now = now();

            // if ($now->format('H:i') !== $config->horario) {
            //     $this->info('Fora do horário.');
            //     return;
            // }

            // $executar = false;

            // if ($config->frequencia === 'diario') {
            //     $executar = true;
            // }

            // if ($config->frequencia === 'semanal') {
            //     $executar = $now->isMonday();
            // }

            // if ($config->frequencia === 'mensal') {
            //     $executar = $now->day === 1;
            // }

            // if (!$executar) {
            //     $this->info('Frequência não permite execução hoje.');
            //     return;
            // }


            $dir = storage_path('app/backups');

            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }

            $fileName = 'backup_' . now()->format('Ymd_His') . '.sql';

            $filePath = $dir . '/' . $fileName;

            $database = env('DB_DATABASE');
            $username = env('DB_USERNAME');
            $password = env('DB_PASSWORD');
            $host = env('DB_HOST');

            $mysqldump = 'C:\\xampp\\mysql\\bin\\mysqldump.exe';

            $command = "\"{$mysqldump}\" --user={$username} --password={$password} --host={$host} {$database} > \"{$filePath}\"";

            exec($command, $output, $result);

            if ($result === 0) {

                $size = round(filesize($filePath) / 1024 / 1024, 2);

                Backup_historico::create([
                    'arquivo' => $fileName,
                    'tipo' => 'sql',
                    'tamanho_mb' => $size,
                    'origem' => 'automatico',
                ]);

                $this->info("Backup criado: {$fileName}");
            } else {

                $this->error('Erro ao gerar backup');
            }
        } catch (\Exception $e) {

            $this->error($e->getMessage());
        }
    }
}
