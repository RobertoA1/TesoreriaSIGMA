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
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

}
