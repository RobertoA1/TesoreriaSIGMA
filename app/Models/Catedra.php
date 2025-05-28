<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catedra extends Model
{
    use HasFactory;

    protected $table = 'catedras';
    protected $primaryKey = 'id_catedra';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'id_personal',
        'id_curso',
        'año_escolar',
        'id_grado',
        'secciones_nombreSeccion',
    ];
    public $timestamps = false;
    public function cursoGrado()
    {
        return $this->belongsTo(Curso_Grado::class, 'id_curso_grado', 'id_curso_grado');
    }

    public function personal()
    {
        return $this->belongsTo(Personal::class, 'id_personal', 'id_personal');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'id_curso', 'id_curso');
    } 

}
