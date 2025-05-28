<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NivelEducativo extends Model
{
    use HasFactory;

    protected $primaryKey = "id_nivel";

    public $incrementing = true;

    protected $keyType = 'int';

    protected $filliable = [
        'nombre_nivel',
        'descripcion'
    ];
}
