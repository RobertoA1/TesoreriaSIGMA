<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    
    use HasFactory;

    protected $table = 'pagos'; 

    protected $primaryKey = 'id_pago';
    public $incrementing = true; 
    protected $keyType = 'int';

    protected $fillable = [
        'nro_recibo',
        'fecha_pago',
        'monto',
        'observaciones',
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
