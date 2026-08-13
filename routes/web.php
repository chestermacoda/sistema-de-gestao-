<?php

use App\Http\Controllers\Auth\ClienteLoginController;
use App\Http\Controllers\ProfileController;
use App\Models\Cliente;
use App\Models\relatorio;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

// Route::get('/atualizar-senhas', function () {
//     $senhaHash = Hash::make('123456');

//     Cliente::query()->update([
//         'password' => $senhaHash,
//     ]);

//     return 'Senhas atualizadas com sucesso!';
// });

Route::prefix('cliente')->name('cliente.')->group(function () {
    Route::get('/login', [ClienteLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [ClienteLoginController::class, 'login']);
    Route::post('/logout', [ClienteLoginController::class, 'logout'])->name('logout');

    Route::middleware('auth:cliente')->group(function () {
        // Route::get('/painel', function () {
        //     return view('cliente.painel');
        // })->name('painel');
        Route::get('/App', App\Livewire\Admin\Mobile\Clientes\Index::class)->name('app.clientes');
    });
});


Route::get('/download-relatorio/{id}', function ($id) {

    $r = relatorio::where('pagamentos_id', $id)->firstOrFail();

    $path = public_path($r->ficheiro_caminho);

    if (!file_exists($path)) {
        abort(404, 'Arquivo não encontrado.');
    }

    return response()->download($path);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'role:Admin|Super Admin|Financeiro'])->group(function () {

    Route::get('/', App\Livewire\Admin\Home\Index::class)->name('admin.home');


    Route::get('/Clientes', App\Livewire\Admin\Clientes\Index::class)->name('admin.clientes');


    Route::get('/Medidores', App\Livewire\Admin\Medidores\Index::class)->name('admin.medidores');


    Route::get('/Leituras', App\Livewire\Admin\Leituras\Index::class)->name('admin.leituras');


    Route::get('/Faturas', App\Livewire\Admin\Faturas\Index::class)->name('admin.faturas');


    Route::get('/Pagamentos', App\Livewire\Admin\Pagamentos\Index::class)->name('admin.pagamentos');


    Route::get('/Usuarios', App\Livewire\Admin\Usuarios\Index::class)->name('admin.usuarios');


    Route::get('/Perfil', App\Livewire\Admin\Perfil\Index::class)->name('admin.perfil');


    Route::get('/Configuracoes', App\Livewire\Admin\Configuracoes\Index::class)->name('admin.configuracoes');


    Route::get('/Permissoes', App\Livewire\Admin\Permissoes\Index::class)->name('admin.permissoes');

    Route::get('/Roteiro', App\Livewire\Admin\Roteiro\Index::class)->name('admin.roteiro');
});


Route::middleware(['auth', 'role:Leiturista'])->group(function () {
    Route::get('/App/leiturista', App\Livewire\Admin\Mobile\Leiturista\Index::class)->name('app.leiturista');
});





require __DIR__ . '/auth.php';