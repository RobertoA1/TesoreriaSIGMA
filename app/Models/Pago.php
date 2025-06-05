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
        'id_deuda',
        'fecha_pago',
        'monto',
        'observaciones',
        'estado',
    ];



    protected function casts(): array
    {
        return [
            'fecha_pago' => 'datetime', 
            'monto' => 'decimal:2',     
            'estado' => 'boolean',      
        ];
    }

    public function deuda()
    {
        return $this->belongsTo(\App\Models\Deuda::class, 'id_deuda', 'id_deuda');
    }

    public function conceptoPago()
    {
        return $this->deuda ? $this->deuda->conceptoPago() : null;
    }

    public function alumno()
    {
        return $this->deuda ? $this->deuda->alumno() : null;
    }

}
