<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    use HasFactory;

    protected $table = 'secciones';

    public $incrementing = false;



    protected $fillable = [
        'id_grado',
        'nombreSeccion'
    ];

    public function grado()
    {
        return $this->belongsTo(Grado::class, 'id_grado', 'id_grado');
    }

    public function matriculas()
    {
        return $this->hasMany(Matricula::class, ['id_grado','nombreSeccion'], ['id_grado','nombreSeccion']);
    }

    //public function alumnos()
    //{
     //   return $this->hasMany(Alumno::class)
    //}

}
