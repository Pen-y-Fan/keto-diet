<?php

declare(strict_types=1);

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

Route::middleware(['guest'])->get('/', function () {
    return view('welcome');
})->name('home');

Route::group([
    'middleware' => ['auth:sanctum', 'verified'],
], static function () {
    Route::get('/dashboard', static function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/diary/{date?}', static function ($date = null) {
        $date ??= now()->format('Y-m-d');
        return view('diary', [
            'date' => $date,
        ]);
    })->name('diary');

    Route::get('/weight', static function () {
        return view('weight');
    })->name('weight');

    Route::get('/diary/{food}/edit', static function (\App\Models\Food $food) {
        return view('edit-food', [
            'food' => $food,
        ]);
    })
        ->name('food.edit');

    Route::get('/diary/{meal}/{date}/add', static function (int $meal, string $date) {
        return view('add-food', [
            'meal' => $meal,
            'date' => $date,
        ]);
    })
        ->name('food.add');
});
