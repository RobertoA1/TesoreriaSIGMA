<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePago extends Model
{
    use HasFactory;

    protected $table = 'detalle_pago'; 

    protected $primaryKey = ['id_detalle','id_pago'];

    public $incrementing = false;

    protected $fillable = [
        'id_detalle',
        'id_pago',
        'nro_recibo',
        'fecha_pago',
        'monto',
        'observacion',
        'estado',
        'metodo_pago',
        'voucher_path',
        'voucher_texto',
        'estado_validacion'
    ];

    protected function casts(): array
    {
        return [
            'fecha_pago' => 'datetime', 
            'monto' => 'decimal:2',
            'estado' => 'boolean',
        ];
    }
}

