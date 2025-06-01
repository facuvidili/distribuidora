<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard',[DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/admin/settings', [AdminController::class, 'edit'])->name('admin.settings');
    Route::post('/admin/settings', [AdminController::class, 'update'])->name('admin.settings.update');
});

Route::get('/password/change', [PasswordController::class, 'edit'])->name('password.change');
Route::post('/password/change', [PasswordController::class, 'update'])->name('password.update');

Route::middleware(['auth', 'role:Vendedor'])->group(function () {
    Route::get('/ventas/create', [VentaController::class, 'create'])->name('ventas.create');
    Route::post('/ventas/store', [VentaController::class, 'store'])->name('ventas.store');
    Route::get('/ventas/show', [VentaController::class, 'show'])->name('ventas.show');
    Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index');
    Route::get('/ventas/reporte', [VentaController::class, 'reporte'])->name('ventas.reporte');

    Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
    Route::get('/clientes/create', [ClienteController::class, 'create'])->name('clientes.create');
    Route::get('/clientes/edit', [ClienteController::class, 'edit'])->name('clientes.edit');
    
    Route::get('/proveedores', [ProveedorController::class, 'index'])->name('proveedores.index');
    Route::get('/proveedores/create', [ProveedorController::class, 'create'])->name('proveedores.create');
    Route::get('/proveedores/edit', [ProveedorController::class, 'edit'])->name('proveedores.edit');
});

Route::middleware(['auth', 'role:Administrador'])->group(function () {
    Route::get('/ventas/create', [VentaController::class, 'create'])->name('ventas.create');
    Route::post('/ventas/store', [VentaController::class, 'store'])->name('ventas.store');
    Route::get('/ventas/{venta}/show', [VentaController::class, 'show'])->name('ventas.show');
    Route::get('/ventas/{venta}/edit', [VentaController::class, 'edit'])->name('ventas.edit');
    Route::put('/ventas/{venta}/update', [VentaController::class, 'update'])->name('ventas.update');
    Route::delete('/ventas/{venta}', [VentaController::class, 'destroy'])->name('ventas.destroy');
    Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index');
    Route::get('/ventas/reporte', [VentaController::class, 'reporte'])->name('ventas.reporte');

    Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
    Route::get('/clientes/create', [ClienteController::class, 'create'])->name('clientes.create');
    Route::get('/clientes/{cliente}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');
    Route::get('/clientes/{cliente}/show', [ClienteController::class, 'show'])->name('clientes.show');
    Route::post('/clientes/store', [ClienteController::class, 'store'])->name('clientes.store');
    Route::put('/clientes/{cliente}/update', [ClienteController::class, 'update'])->name('clientes.update');
    Route::delete('/clientes/{cliente}', [ClienteController::class, 'destroy'])->name('clientes.destroy');

    Route::get('/proveedores', [ProveedorController::class, 'index'])->name('proveedores.index');
    Route::get('/proveedores/create', [ProveedorController::class, 'create'])->name('proveedores.create');
    Route::get('/proveedores/{proveedor}/edit', [ProveedorController::class, 'edit'])->name('proveedores.edit');
    Route::get('/proveedores/{proveedor}/show', [ProveedorController::class, 'show'])->name('proveedores.show');
    Route::post('/proveedores/store', [ProveedorController::class, 'store'])->name('proveedores.store');
    Route::put('/proveedores/{proveedor}/update', [ProveedorController::class, 'update'])->name('proveedores.update');
    Route::delete('/proveedores/{proveedor}', [ProveedorController::class, 'destroy'])->name('proveedores.destroy');

    Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
    Route::get('/productos/create', [ProductoController::class, 'create'])->name('productos.create');
    Route::get('/productos/{producto}/edit', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::get('/productos/{producto}/show', [ProductoController::class, 'show'])->name('productos.show');
    Route::post('/productos/store', [ProductoController::class, 'store'])->name('productos.store');
    Route::put('/productos/{producto}/update', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/productos/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');

    Route::get('/empresa', [EmpresaController::class, 'show'])->name('empresa.show');
    Route::get('/empresa/create', [EmpresaController::class, 'create'])->name('empresa.create');
    Route::post('/empresa/store', [EmpresaController::class, 'store'])->name('empresa.store');
    Route::get('/empresa/{empresa}/edit', [EmpresaController::class, 'edit'])->name('empresa.edit');
    Route::put('/empresa/{empresa}/update', [EmpresaController::class, 'update'])->name('empresa.update');
    
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::get('/user/edit/{user}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::put('/user/update/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
});


require __DIR__ . '/auth.php';
