<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    use HasFactory;

    protected $table = 'matriculas';   
    protected $primaryKey = 'id_matricula';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'id_alumno',
        'año_escolar',
        'fecha_matricula',
        'escala',
        'observaciones',
        'id_grado',
        'nombreSeccion',
        'estado'
    ];


    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'id_alumno', 'id_alumno');
    }
    public function seccion()
    {
        return $this->belongsTo(Seccion::class, 'nombreSeccion', 'nombreSeccion');
    }

    protected function casts(): array
    {
        return [
            'año_escolar' => 'integer',   
            'fecha_matricula' => 'date',    
            'estado' => 'boolean',          
        ];
    }

}
