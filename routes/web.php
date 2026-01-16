<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
<<<<<<< HEAD
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AddressController;
=======
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminOrderController; // Tu controlador de Admin
use App\Http\Controllers\OrderController;      // El controlador de tu compañero
use Illuminate\Support\Facades\Route;
>>>>>>> main

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

// Categorías
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categoria/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Carrito
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::delete('/remove-from-cart', [CartController::class, 'remove'])->name('cart.remove');
Route::get('cart/decrease/{id}', [CartController::class, 'decreaseQuantity'])->name('cart.decrease');


/*
|--------------------------------------------------------------------------
| RUTAS DE USUARIO LOGUEADO (Cualquiera registrado)
|--------------------------------------------------------------------------
| Aquí es donde debe estar "Mis Pedidos"
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

    // ✅ AQUÍ ES DONDE DEBE ESTAR (Fuera del grupo Admin, pero dentro de Auth)
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
});


/*
|--------------------------------------------------------------------------
| RUTAS DE ADMINISTRADOR (Solo Role: admin)
|--------------------------------------------------------------------------
| Aquí SOLO lo que sea gestión de la tienda
*/

Route::middleware(['auth', 'admin'])->group(function () {
    
    // Gestión de Productos
    Route::resource('products', ProductController::class);

    // Gestión de Pedidos (La tuya, AdminOrderController)
    Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::put('/admin/orders/{order}', [AdminOrderController::class, 'update'])->name('admin.orders.update');

});

<<<<<<< HEAD
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

=======
require __DIR__.'/auth.php';
>>>>>>> main
