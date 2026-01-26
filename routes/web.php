<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AddressController; // <--- FALTABA ESTO
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Livewire\ShopFilters;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (Accesibles para todos)
|--------------------------------------------------------------------------
*/

// Página de bienvenida
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// 1. HOME / DASHBOARD PÚBLICO
Route::get('/home', function () {
    // Top 3 productos más vendidos
    $topProductsIds = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_qty'))
        ->groupBy('product_id')
        ->orderBy('total_qty', 'desc')
        ->take(3)
        ->pluck('product_id');

    $featuredProducts = Product::whereIn('id', $topProductsIds)->get();

    return view('dashboard', compact('featuredProducts'));
})->name('home');


// 2. CATÁLOGO COMPLETO (Livewire)
// Apunta al componente de filtros que hemos arreglado
Route::get('/catalogo', ShopFilters::class)->name('catalog.all');


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
| RUTAS DE USUARIO LOGUEADO (Middleware 'auth')
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    
    // Dashboard logueado (misma lógica que home)
    Route::get('/dashboard', function () {
        $topProductsIds = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('product_id')
            ->orderBy('total_qty', 'desc')
            ->take(3)
            ->pluck('product_id');

        $featuredProducts = Product::whereIn('id', $topProductsIds)->get();
        return view('dashboard', compact('featuredProducts'));
    })->name('dashboard');

    // Perfil de Usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Direcciones de Envío (Address)
    Route::get('/profile/addresses', [AddressController::class, 'index'])->name('profile.addresses');
    Route::post('/profile/addresses', [AddressController::class, 'store'])->name('profile.addresses.store');
    Route::delete('/profile/addresses/{address}', [AddressController::class, 'destroy'])->name('profile.addresses.destroy');

    // Checkout (Proceso de pago)
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Mis Pedidos (Historial)
    Route::get('/mis-pedidos', [OrderController::class, 'index'])->name('orders.index');
});


/*
|--------------------------------------------------------------------------
| RUTAS DE ADMINISTRADOR (Middleware 'auth' + 'admin')
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {
    // Gestión de Productos (CRUD completo menos show que es público)
    Route::resource('products', ProductController::class)->except(['show']);
    
    // Gestión de Categorías
    Route::get('/admin/categories', [CategoryController::class, 'indexAdmin'])->name('admin.categories.index');
    Route::post('/admin/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::delete('/admin/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

    // Gestión de Pedidos (Ver ventas)
    Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::put('/admin/orders/{order}', [AdminOrderController::class, 'update'])->name('admin.orders.update');
});

// Carga las rutas de autenticación (Login, Registro...)
require __DIR__.'/auth.php';