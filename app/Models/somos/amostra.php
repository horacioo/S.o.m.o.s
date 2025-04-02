<?php

namespace App\Models\somos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class amostra extends Model
{
    use HasFactory;

    protected $fillable = [
        'latitude',
        'longitude',
        'ligacao',
        'tipo_de_coleta_id',
    ];

    // Definindo os relacionamentos
    public function documento()
    {
        return $this->belongsTo(Documento::class); // Relacionamento com a tabela 'documentos'
    }

    public function tipoDeColeta()
    {
        return $this->belongsTo(TipoDeColeta::class); // Relacionamento com a tabela 'tipo_de_coleta'
    }
}
