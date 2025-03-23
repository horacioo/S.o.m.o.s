<?php

namespace App\Models\somos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmostrasTipo extends Model
{
    use HasFactory;

    // Defina o nome da tabela, caso seja diferente do plural do nome do model
    protected $table = 'tipo_de_amostra';

    // Defina as colunas que podem ser preenchidas em massa
    protected $fillable = [
        'tipoAmostra',
        'coordenadas',
        'tipoCoordenadas',
        'data',
    ];

    // Defina os relacionamentos com outras tabelas, se aplicável
    public function tipoAmostra()
    {
        return $this->belongsTo(TipoDeAmostra::class, 'tipoAmostra');
    }

    public function tipoCoordenadas()
    {
        return $this->belongsTo(TipoDeAmostra::class, 'tipoCoordenadas');
    }
}
