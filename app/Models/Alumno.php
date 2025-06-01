<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_alumno';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'codigo_educando',
        'codigo_modular',
        'año_ingreso',
        'dni',
        'apellido_paterno',
        'apellido_materno',
        'primer_nombre',
        'otros_nombres',
        'sexo',
        'fecha_nacimiento',
        'pais',
        'departamento',
        'provincia',
        'distrito',
        'lengua_materna',
        'estado_civil',
        'religion',
        'fecha_bautizo',
        'parroquia_bautizo',
        'colegio_procedencia',
        'direccion',
        'telefono',
        'medio_transporte',
        'tiempo_demora',
        'material_vivienda',
        'energia_electrica',
        'agua_potable',
        'desague',
        'ss_hh',
        'num_habitaciones',
        'num_habitantes',
        'situacion_vivienda',
        'escala',
    ];

    protected function casts(): array{
        return [
            'fecha_nacimiento' => 'date',
            'fecha_bautizo' => 'date',
            'año_ingreso' => 'integer', 
            'num_habitaciones' => 'integer', 
            'num_habitantes' => 'integer',
        ];
    }

}
