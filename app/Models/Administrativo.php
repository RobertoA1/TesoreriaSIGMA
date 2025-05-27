<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrativo extends Model
{
    /** @use HasFactory<\Database\Factories\AdministrativoFactory> */
    use HasFactory;

    protected $fillable = [
        'apellido_paterno',
        'apellido_materno',
        'primer_nombre',
        'otros_nombres',
        'dni',
        'direccion',
        'estado_civil',
        'telefono',
        'seguro_social',
        'fecha_ingreso',
        'cargo',
        'sueldo'
    ];

    protected $primaryKey = 'id_administrativo';
}
