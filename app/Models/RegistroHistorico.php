<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroHistorico extends Model
{
    use HasFactory;

    protected $table = 'registros_historicos'; 

    protected $primaryKey = 'id_registro_historico'; 
    public $incrementing = true; 
    protected $keyType = 'int'; 

    protected $fillable = [
        'id_autor',
        'id_concepto_accion',
        'id_afectado',
        'fecha_accion',
        'observacion',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'fecha_accion' => 'datetime', 
            'estado' => 'boolean', 
        ];
    }



}
