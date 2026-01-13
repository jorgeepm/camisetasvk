<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

use App\Http\Controllers\CategoryController; // <--- 1. IMPORTANTE: Esta línea arriba del todo

// ... (aquí habrá otras rutas como la de welcome o dashboard) ...

// 2. Las rutas de tu tienda:
Route::get('/categorias', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categoria/{category}', [CategoryController::class, 'show'])->name('categories.show');

<<<<<<< HEAD

// 1. Importamos el nuevo controlador
use App\Http\Controllers\ProductController;
// 2. Ruta para el buscador
Route::get('/products/search', [ProductController::class, 'buscar']);
// 3. Ruta para personalizar
Route::post('/products/customize', [ProductController::class, 'guardarPersonalizacion']);
=======
// Rutas del Carrito
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::delete('/remove-from-cart', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store')->middleware('auth');
// Ruta para ver el ticket de compra (GET)
Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])
    ->name('checkout.success')
    ->middleware('auth');

Route::get('cart/decrease/{id}', [CartController::class, 'decreaseQuantity'])->name('cart.decrease');
>>>>>>> main
