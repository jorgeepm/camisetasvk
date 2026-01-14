<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CategoryController; // He movido esto arriba para que esté ordenado
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (Puede entrar cualquiera)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Rutas de Categorías (Catálogo)
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categoria/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Rutas del Carrito (Públicas para poder añadir sin loguearse, opcionalmente)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::delete('/remove-from-cart', [CartController::class, 'remove'])->name('cart.remove');
Route::get('cart/decrease/{id}', [CartController::class, 'decreaseQuantity'])->name('cart.decrease');


/*
|--------------------------------------------------------------------------
| RUTAS DE USUARIO LOGUEADO (Role: user o admin)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Checkout (Pago) - Solo si estás logueado
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
});


/*
|--------------------------------------------------------------------------
| RUTAS DE ADMINISTRADOR (Solo Role: admin)
|--------------------------------------------------------------------------
| Aquí es donde actúa tu middleware IsAdmin
*/

Route::middleware(['auth', 'admin'])->group(function () {
    
    // CRUD Completo de Productos (Solo el Admin puede crear, editar o borrar)
    Route::resource('products', ProductController::class);

    // Si en el futuro tienes gestión de categorías o usuarios, ponlas aquí dentro
});


require __DIR__.'/auth.php';