<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'isLogin'], function () {
    Route::group(['middleware' => 'isAdmin'], function () {
        Route::get('/user', [UserController::class, 'index'])->name('user.index');

        Route::post('/user', [UserController::class, 'store'])->name('user.store');
        Route::post('/product', [ProductController::class, 'store'])->name('product.store');

        Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
        Route::get('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::put('/product/{product}', [ProductController::class, 'update'])->name('product.update');
        Route::put('/product/stock/{product}', [ProductController::class, 'addStock'])->name('product.stock');
        Route::get('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');

        Route::get('/user-export', [UserController::class, 'export'])->name('user.export');
    });

    Route::group(['middleware' => 'isStaff'], function () {
        Route::get('/sale/create', [SaleController::class, 'create'])->name('sale.create');

        Route::post('/sale/invoice', [SaleController::class, 'invoice'])->name('sale.invoice');
        Route::post('/sale/invoice-data', [SaleController::class, 'invoiceData'])->name('sale.invoice-data');
        Route::get('/sale/{sale}', [SaleController::class, 'destroy'])->name('sale.destroy');
    });

    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/sale', [SaleController::class, 'index'])->name('sale.index');

    Route::get('/product-export', [ProductController::class, 'export'])->name('product.export');
    Route::get('/sale-export', [SaleController::class, 'exportExcel'])->name('sale.export.excel');
    Route::get('/sale/invoice/{sale}', [SaleController::class, 'export'])->name('sale.export');

    Route::get('/logout', [AuthController::class, 'destroy'])->name('logout');
});

Route::group(['middleware' => 'isGuest'], function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});

