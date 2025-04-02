<?php


use App\Http\Controllers\somos\documentosController;






Route::middleware('auth')->group(function () {

    Route::get('/trabalhos/cadastro', [documentosController::class, 'cadTrab'])->middleware(['auth', 'verified'])->name('TrabalhosCadastros');
    Route::post('/trabalhos/cadastro', [documentosController::class, 'store'])->middleware(['auth', 'verified'])->name('TrabalhosCadastrosSave');
    Route::post('/trabalhos/api/cadastro', [documentosController::class, 'apiSalvaColetas'])->middleware(['auth', 'verified'])->name('trabalhos.api.cadastro');
    Route::get('/api/coordenadas/validaCoordenadas', [documentosController::class, 'apiSalvaColetas'])->middleware(['auth', 'verified'])->name('coord.api.valida');

});
