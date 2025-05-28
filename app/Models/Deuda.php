<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deuda extends Model
{
    use HasFactory;

    protected $table = 'deudas'; 

    protected $primaryKey = 'id_deuda'; 
    public $incrementing = true; 
    protected $keyType = 'int'; 

    protected $fillable = [
        'id_alumno',
        'id_concepto',
        'fecha_limite',
        'monto_total',
        'periodo',
        'monto_a_cuenta',
        'monto_adelantado',
        'observacion',
        'estado',
    ];

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'fecha_limite' => 'date', 
            'monto_total' => 'integer', 
            'monto_a_cuenta' => 'integer', 
            'monto_adelantado' => 'integer', 
            'estado' => 'boolean', 
        ];
    }

}
