<?php

namespace App\Models\somos;

use Illuminate\Database\Eloquent\Model;

class CoordenadasTipo extends Model
{
    protected $table = 'coordenadas';

    // Defina as colunas que podem ser preenchidas em massa
    protected $fillable = ['tipoDeCoordenadas'];
}
