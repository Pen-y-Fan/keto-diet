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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/diary', function () {
    return view('diary');
})->name('diary');

Route::middleware(['auth:sanctum', 'verified'])->get('/weight', function () {
    /** @phpstan-ignore-next-line */
    return view('weight');
})->name('weight');

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/diary/{food}/edit', function (\App\Models\Food $food) {
        return view('edit-food', [
            'food' => $food,
        ]);
    })
    ->name('food.edit');

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/diary/{meal}/{date}/add', function (int $meal, \Carbon\Carbon $date) {
        return view('add-food', [
            'meal' => $meal,
            'date' => $date,
        ]);
    })
    ->name('food.add');
