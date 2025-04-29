<?php

use Illuminate\Support\Facades\Route;

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
    return view('principal');
})->name('principal');


Route::get('/grimorio', [\App\Http\Controllers\GrimoireController::class, 'index'])->name('grimoire');
Route::get('/ranking', [\App\Http\Controllers\GrimoireController::class, 'ranking'])->name('ranking');
Route::get('/market', [\App\Http\Controllers\MarketController::class, 'index'])->name('market');
Route::get('/recipes', [\App\Http\Controllers\RecipeController::class, 'index'])->name('recipes');


Route::middleware('auth')->group(function () {
    // Rutas protegidas para usuarios autenticados
    Route::get('/inventory', [\App\Http\Controllers\InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/search', [\App\Http\Controllers\InventoryController::class, 'searchItems']);
    Route::get('/character', [\App\Http\Controllers\InventoryController::class, 'character'])->name('character');
    Route::post('/market/buy', [\App\Http\Controllers\MarketController::class, 'buyItem'])->name('market.buy');
    Route::post('/market/putInMarket', [\App\Http\Controllers\MarketController::class, 'putInMarket'])->name('putInMarket');
    Route::post('/market/cancel', [\App\Http\Controllers\MarketController::class, 'cancel'])->name('cancel');
    Route::get('/exchange', [\App\Http\Controllers\InventoryController::class, 'exchange'])->name('exchange');


});

Route::get('/variant-info/{id}', [\App\Http\Controllers\RecipeController::class, 'show']);

use App\Http\Controllers\AuthController;

Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');



