<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicApiController extends Controller
{
    public function docs()
    {
        return response()->json([
            'info' => 'Documentación de la API pública. Aquí puedes listar endpoints y ejemplos.'
        ]);
    }
}
