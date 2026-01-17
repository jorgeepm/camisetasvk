<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Ruta PÚBLICA para el cliente externo
Route::get('/products', function () {
    // Retornamos todos los productos en formato JSON
    // El campo 'image_blob' con el base64 se envía tal cual, permitiendo que el cliente lo pinte
    return response()->json(Product::all());
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
