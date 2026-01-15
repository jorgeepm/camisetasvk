<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AddressController;

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

// Rutas del Carrito
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::delete('/remove-from-cart', [CartController::class, 'remove'])->name('cart.remove');
Route::get('cart/decrease/{id}', [CartController::class, 'decreaseQuantity'])->name('cart.decrease');

// --- ZONA CORREGIDA DEL CHECKOUT ---

// 1. PANTALLA DE RESUMEN (GET): Para ver el formulario
Route::get('/checkout', [CheckoutController::class, 'index'])
    ->name('checkout.index')
    ->middleware('auth');

// 2. PROCESAR PAGO (POST): Para guardar los datos cuando das al botón
Route::post('/checkout', [CheckoutController::class, 'store'])
    ->name('checkout.store')
    ->middleware('auth');

// 3. TICKET DE COMPRA (GET): Para ver el "Gracias" al final
Route::get('/checkout/success/{order}', [CheckoutController::class, 'success']) // Asegúrate que el método sea 'success'
    ->name('checkout.success')
    ->middleware('auth');

// -----------------------------------

// Ruta para ver mis pedidos
Route::get('/mis-pedidos', [OrderController::class, 'index'])
    ->name('orders.index')
    ->middleware('auth');

// ---------

// Rutas de la dirección (Address) del cliente
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/addresses', [AddressController::class, 'index'])->name('profile.addresses');
    Route::post('/profile/addresses', [AddressController::class, 'store'])->name('profile.addresses.store');
    Route::delete('/profile/addresses/{address}', [AddressController::class, 'destroy'])->name('profile.addresses.destroy');
});

