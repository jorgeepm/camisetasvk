<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\OrderController;
use App\Models\Product;
use App\Models\OrderItem; // Necesario para contar ventas
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB; // Necesario para las sumas de ventas
use App\Livewire\ShopFilters;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

// Página de bienvenida
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// 1. HOME / DESTACADOS: Muestra el diseño "Dashboard" (Oscuro, Top 3) para todos
Route::get('/home', function () {
    // Lógica para sacar los 3 productos más vendidos (Copiada de tu dashboard antiguo)
    $topProductsIds = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_qty'))
        ->groupBy('product_id')
        ->orderBy('total_qty', 'desc')
        ->take(3)
        ->pluck('product_id');

    $featuredProducts = Product::whereIn('id', $topProductsIds)->get();

    // CARGAMOS LA VISTA 'dashboard' QUE ES LA QUE TE GUSTA
    // (Gracias a que arreglamos el navigation, ahora funciona sin estar logueado)
    return view('dashboard', compact('featuredProducts'));
})->name('home');


// 2. CATÁLOGO COMPLETO: Para el botón "Ver todas" (Usa Livewire)
Route::get('/catalogo', App\Livewire\ShopFilters::class)->name('catalog.all');


// Categorías
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categoria/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Detalle de Producto y Personalización
Route::get('/shirts/{product}', [ProductController::class, 'show'])->name('products.show');
Route::post('/customize-product/{id}', [CartController::class, 'addToCartCustomized'])->name('products.customize');

// Carrito
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::delete('/remove-from-cart', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/increase/{id}', [CartController::class, 'increaseQuantity'])->name('cart.increase');
Route::get('/cart/decrease/{id}', [CartController::class, 'decreaseQuantity'])->name('cart.decrease');


/*
|--------------------------------------------------------------------------
| RUTAS DE USUARIO LOGUEADO
|--------------------------------------------------------------------------
*/

// Mantenemos la ruta dashboard original por si acaso, aunque ahora la Home es igual.
Route::get('/dashboard', function () {
    $topProductsIds = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_qty'))
        ->groupBy('product_id')
        ->orderBy('total_qty', 'desc')
        ->take(3)
        ->pluck('product_id');

    $featuredProducts = Product::whereIn('id', $topProductsIds)->get();

    return view('dashboard', compact('featuredProducts'));
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

    // Mis Pedidos
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
});


/*
|--------------------------------------------------------------------------
| RUTAS DE ADMINISTRADOR
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('products', ProductController::class)->except(['show']);
    
    Route::get('/admin/categories', [CategoryController::class, 'indexAdmin'])->name('admin.categories.index');
    Route::post('/admin/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::delete('/admin/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

    Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::put('/admin/orders/{order}', [AdminOrderController::class, 'update'])->name('admin.orders.update');
});

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

require __DIR__.'/auth.php';
require __DIR__.'/auth.php';
