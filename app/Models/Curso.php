<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_curso';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'codigo_curso',
        'nombre_curso',
        'id_nivel',
        'estado',
    ];

    public function grados()
    {
         return $this->belongsToMany(Grado::class, 'cursos_grados', 'id_curso', 'id_grado')
                     ->withPivot('id_curso_grado', 'año_escolar'); 
    }

    public function nivel(){
        return $this->hasOne(NivelEducativo::class, 'id_nivel', 'id_nivel');
    }

}
