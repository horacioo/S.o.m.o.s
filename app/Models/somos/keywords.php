<?php

namespace App\Models\somos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class keywords extends Model
{
    use HasFactory;

    protected $fillable = ['keyword', 'documento_id'];

    public function documento()
    {
        return $this->belongsTo(Documento::class, 'documento_id');
    }
}
