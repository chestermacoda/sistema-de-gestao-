<?php

use App\Models\BackupConfiguracao;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Storage;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


// schedule::call(function () {

//     $dir = storage_path('app/backups');

//     // cria diretório manualmente
//     if (!file_exists($dir)) {
//         mkdir($dir, 0777, true);
//     }

//     $file = $dir . '/teste.sql';

//     file_put_contents($file, 'FUNCIONOU');

//     dd([
//         'pasta_existe' => file_exists($dir),
//         'arquivo_existe' => file_exists($file),
//         'caminho' => $file
//     ]);
// })->everyMinute();

// Schedule::command('faturas:atualizar-multas')->daily();
Schedule::command('faturas:atualizar-multas')->everyMinute();
Schedule::command('db:backup')->everyMinute();

// Schedule::call(function () {
//     try {

//         $dir = storage_path('app/backups');

//         if (!file_exists($dir)) {
//             mkdir($dir, 0777, true);
//         }

//         $fileName = 'backup_' . now()->format('Ymd_His') . '.sql';

//         $filePath = $dir . '/' . $fileName;

//         // dados do banco
//         $database = env('DB_DATABASE');
//         $username = env('DB_USERNAME');
//         $password = env('DB_PASSWORD');
//         $host = env('DB_HOST');

//         // caminho do mysqldump
//         $mysqldump = 'C:\\xampp\\mysql\\bin\\mysqldump.exe';

//         // comando
//         $command = "\"{$mysqldump}\" --user={$username} --password={$password} --host={$host} {$database} > \"{$filePath}\"";

//         exec($command, $output, $result);

//         if ($result === 0) {

//             echo "BACKUP CRIADO: {$filePath}" . PHP_EOL;

//             BackupConfiguracao::create([
//                 'arquivo' => $fileName,
//                 'tipo' => 'sql',
//                 'origem' => 'automatico',
//             ]);
//         } else {

//             echo "ERRO AO GERAR BACKUP";
//         }
//     } catch (\Exception $e) {

//         echo $e->getMessage();
//     }
// })->everyMinute();
// })->dailyAt('02:00');
