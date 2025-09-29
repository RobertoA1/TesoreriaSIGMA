<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ValidacionPagoController extends Controller
{
    public function index(Request $request){
        return view('gestiones.validacion_pago.index');
    }
}
