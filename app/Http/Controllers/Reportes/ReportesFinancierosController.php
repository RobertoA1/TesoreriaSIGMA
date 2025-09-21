<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportesFinancierosController extends Controller
{
    public static function index()
    {
        return view('gestiones.estadisticas.reportes_financieros.index');
    }
}
