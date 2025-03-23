<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\somos\documentosController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () { return view('dashboard'); })->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::get('/trabalhos/cadastro', [documentosController::class, 'cadTrab'])->middleware(['auth', 'verified'])->name('TrabalhosCadastros');
Route::post('/trabalhos/cadastro', [documentosController::class, 'store'])->middleware(['auth', 'verified'])->name('TrabalhosCadastrosSave');



require __DIR__.'/auth.php';
