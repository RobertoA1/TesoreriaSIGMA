<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePago extends Model
{
    use HasFactory;

    protected $table = 'detalle_pago'; 

    protected $primaryKey = ['id_pago', 'id_deuda'];

    public $incrementing = false;


    protected $fillable = [
        'id_pago',
        'id_deuda',
        'id_concepto',
        'fecha_pago',
        'monto',
        'observacion',
        'estado',
    ];

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'fecha_pago' => 'datetime', 
            'monto' => 'decimal:2',
            'estado' => 'boolean',   
        ];
    }

}
