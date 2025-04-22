<?php

namespace App\Models\somos;

use Illuminate\Database\Eloquent\Model;

class cidades extends Model
{
    protected $table = 'cidades';

    protected $fillable = [
        'municipio',
    ];

    public $timestamps = false; // Não tem campos created_at nem updated_at

    public function documentos()
    {
        return $this->hasMany(Documentos::class, 'municipio');
    }
}
