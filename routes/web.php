<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CustomerController;

use App\Http\Controllers\SettingController;


use App\Http\Controllers\EggInventoryController;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderSimulationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MachineController;


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


Route::resource('customers', CustomerController::class);



Route::get('/settings', [SettingController::class, 'edit'])
    ->name('settings.edit');

Route::put('/settings', [SettingController::class, 'update'])
    ->name('settings.update');




Route::get('/machines', [MachineController::class, 'index'])
    ->name('machines.index');


    Route::get('/inventory', [EggInventoryController::class, 'edit'])
    ->name('inventory.edit');

Route::put('/inventory', [EggInventoryController::class, 'update'])
    ->name('inventory.update');






Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');



    Route::get('/machine/{id}', [App\Http\Controllers\MachineController::class, 'show'])
    ->name('machine.show');



Route::prefix('orders/{order}')->group(function () {

    Route::get('/start', [OrderSimulationController::class, 'start']);
    Route::get('/next-day', [OrderSimulationController::class, 'nextDay']);
    Route::get('/day-18', [OrderSimulationController::class, 'day18']);
    Route::get('/day-21', [OrderSimulationController::class, 'day21']);

});


Route::prefix('orders')->group(function () {

    Route::get('/', [OrderController::class, 'index'])
        ->name('orders.index');

    Route::get('/create', [OrderController::class, 'create'])
        ->name('orders.create');

    Route::post('/', [OrderController::class, 'store'])
        ->name('orders.store');

    Route::get('/{order}', [OrderController::class, 'show'])
        ->name('orders.show');

     Route::get('/orders/{order}/transfer',
            [OrderSimulationController::class, 'transferToHatchers']
        );

});