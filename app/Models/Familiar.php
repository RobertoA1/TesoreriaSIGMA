<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Familiar extends Model
{
    use HasFactory;

    protected $table = "familiares";
    protected $primaryKey = 'idFamiliar';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'id_usuario',
        'dni',
        'apellido_paterno',
        'apellido_materno',
        'primer_nombre',
        'otros_nombres',
        'numero_contacto',
        'correo_electronico',
        'estado',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class, 'composiciones_familiares', 'id_familiar', 'id_alumno')
        ->withPivot('parentesco')
        ->withTimestamps();
    }

}
