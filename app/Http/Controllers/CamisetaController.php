<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PersonalizarCamisetaRequest;
use App\Models\Camiseta;

class CamisetaController extends Controller
{
    public function guardarPersonalizacion(PersonalizarCamisetaRequest $request)
    {
        $datos = $request->validated();
        return response()->json([
            'mensaje' => "Camiseta personalizada con el nombre: " . $datos['nombre_jugador'],
            'dorsal' => $datos['dorsal']
        ]);
    }

    public function buscar(Request $request)
    {
        // Importante: usamos Camiseta::query()
        $camisetas = Camiseta::query()
            ->liga($request->liga)
            ->equipo($request->equipo)
            ->get();

        return response()->json($camisetas);
    }
}