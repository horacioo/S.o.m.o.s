<?php

namespace App\Models\somos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class amostras extends Model
{
    use HasFactory;

    protected $table = 'coordenadas';

    protected $fillable = [
        'latitude',
        'longitude',
        'documento_id',
        'tipo_de_coleta_id',
    ];

    
    public function documento()
    {
        return $this->belongsTo(Documento::class);
    }

    public function tipoDeColeta()
    {
        return $this->belongsTo(TipoDeColeta::class, 'tipo_de_coleta_id');
    }
}
