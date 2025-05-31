<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    use HasFactory;

    protected $table = 'secciones';

    public $incrementing = false;

    protected $primaryKey = ['id_grado', 'nombreSeccion'];

    protected $fillable = [
        'id_grado',
        'nombre_seccion'
    ];

    public function grado()
    {
        return $this->belongsTo(Grado::class, 'id_grado', 'id_grado');
    }


}
