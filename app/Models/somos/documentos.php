<?php

namespace App\Models\somos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class documentos extends Model
{
    use HasFactory;

    protected $table = 'documentos';

    protected $fillable = [
        'programa',
        'tipo_do_documento',
        'titulo',
        'autor',
        'citacao',
        'orientador',
        'data_deposito',
        'link'
    ];

    /**
     * Relação com a tabela "tipo_de_amostra" (tipoAmostra)
     */
    public function tipoAmostra()
    {
        return $this->belongsTo(TipoDeAmostra::class, 'tipoAmostra');
    }

    /**
     * Relação com a tabela "coordenadas" (tipoCoordenadas)
     */
    public function tipoCoordenadas()
    {
        return $this->belongsTo(Coordenadas::class, 'tipoCoordenadas');
    }

    /**
     * Relação com a tabela "amostras"
     */
    public function amostras()
    {
        return $this->hasMany(Amostra::class, 'coleta', 'id');
    }
}
