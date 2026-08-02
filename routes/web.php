<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeverageController;
use App\Http\Controllers\BottleController;
use App\Http\Controllers\FilledBottleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/beverages', [BeverageController::class, 'index'])->name('beverages.index');
Route::post('/beverages', [BeverageController::class, 'store'])->middleware('owner')->name('beverages.store');
Route::get('/beverages/edit/{beverage}', [BeverageController::class, 'edit'])->middleware('owner')->name('beverages.edit');
Route::post('/beverages/edit/{beverage}', [BeverageController::class, 'update'])->middleware('owner')->name('beverages.update');
Route::get('/beverages/delete/{beverage}', [BeverageController::class, 'confirmDelete'])->middleware('owner')->name('beverages.delete');
Route::post('/beverages/delete/{beverage}', [BeverageController::class, 'destroy'])->middleware('owner')->name('beverages.destroy');
Route::get('/beverages/{beverage}', [BeverageController::class, 'show'])->name('beverages.show');

Route::get('/bottles', [BottleController::class, 'index'])->name('bottles.index');
Route::get('/bottles/{bottle}', [BottleController::class, 'show'])->name('bottles.show');

Route::get('/filledbottles', [FilledBottleController::class, 'index'])->name('filled-bottles.index');
Route::post('/filledbottles', [FilledBottleController::class, 'store'])->middleware('owner')->name('filled-bottles.store');
Route::get('/filledbottles/delete/{filledBottle}', [FilledBottleController::class, 'confirmDelete'])->middleware('owner')->name('filled-bottles.delete');
Route::post('/filledbottles/delete/{filledBottle}', [FilledBottleController::class, 'destroy'])->middleware('owner')->name('filled-bottles.destroy');

Route::match(['get', 'post'], '/search', [SearchController::class, 'index'])->name('search');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
