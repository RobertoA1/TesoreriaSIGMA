<?php
namespace App\Http\Controllers;

use App\Models\Familiar;


class FamiliarController extends Controller

{
    public function show($id)
    {
        $familiar = Familiar::findOrFail($id);
        return view('gestiones.familiar.show_students', compact('familiar'));
    }

}

