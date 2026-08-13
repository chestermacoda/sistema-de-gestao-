<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfiguracaoApp extends Model
{
    use HasFactory;

    protected $table = 'configuracoes_app';

    protected $fillable = [
        'user_id',

        'notif_novas_leituras',
        'notif_anomalias',
        'notif_sincronizacao',

        'tema',

        'modo_offline',
        'fotos_alta_resolucao',

        'cache_utilizado',
    ];

    protected $casts = [
        'notif_novas_leituras' => 'boolean',
        'notif_anomalias' => 'boolean',
        'notif_sincronizacao' => 'boolean',

        'modo_offline' => 'boolean',
        'fotos_alta_resolucao' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
