<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminOrderController; // Tu controlador de Admin
use App\Http\Controllers\OrderController;      // El controlador de tu compañero
use App\Models\Product;                        // ✅ Necesario para la página principal
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

// ✅ CORREGIDO: Ahora carga el catálogo completo en la home
Route::get('/', function () {
    // 1. Obtenemos todos los productos (12 por página)
    $products = Product::paginate(12);
    
    // 2. Cargamos la vista 'catalog' (la que creaste nueva)
    return view('catalog', compact('products'));
})->name('home');


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

    // Mis Pedidos (Correctamente colocado aquí para el usuario)
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
});


/*
|--------------------------------------------------------------------------
| RUTAS DE ADMINISTRADOR (Solo Role: admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {
    
    // Gestión de Productos
    Route::resource('products', ProductController::class);

    // Gestión de Pedidos (Panel de Admin)
    Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::put('/admin/orders/{order}', [AdminOrderController::class, 'update'])->name('admin.orders.update');

});

require __DIR__.'/auth.php';
