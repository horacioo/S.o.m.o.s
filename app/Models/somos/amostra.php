<?php

namespace App\Models\somos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amostra extends Model
{
    use HasFactory;

    protected $table = 'amostras'; // Nome correto da tabela

    protected $fillable = [
        'latitude',
        'longitude',
        'documento_id',
        'tipo_de_coleta_id',
    ];

    // Definindo os relacionamentos
    public function documento()
    {
        return $this->belongsTo(\App\Models\somos\Documento::class, 'documento_id');
    }

    public function tipoDeColeta()
    {
        return $this->belongsTo(\App\Models\somos\TipoDeColeta::class, 'tipo_de_coleta_id');
    }
}
