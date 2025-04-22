<?php


use App\Http\Controllers\somos\documentosController;
use App\Http\Controllers\somos\coordenadasController;





Route::middleware('auth')->group(function () {


    Route::get('/trabalhos/pesquisa', [documentosController::class, 'pesquisa'])->middleware(['auth', 'verified'])->name('Trabalhos.pesquisa');



    Route::get('/trabalhos/cadastro', [documentosController::class, 'cadTrab'])->middleware(['auth', 'verified'])->name('TrabalhosCadastros');
    
    
    Route::post('/trabalhos/cadastro', [documentosController::class, 'store'])->middleware(['auth', 'verified'])->name('TrabalhosCadastrosSave');


    Route::post('/trabalhos/api/cadastro', [documentosController::class, 'CadastraDocumentos'])->middleware(['auth', 'verified'])->name('trabalhos.api.cadastro');
    
    
     /**trata  as coordenadas**/
    Route::get('/api/coordenadas/validaCoordenadas', [documentosController::class, 'apiSalvaColetas'])->middleware(['auth', 'verified'])->name('coord.api.valida');


    /**salva os dados completos do formulário**/
    Route::post('/api/trabalhos/salva', [documentosController::class, 'store'])->middleware(['auth', 'verified'])->name('trabalhos.api.salva');


    /**pega coordenadas que foram desenhadas**/
    ////Route::get('/api/coordenadas/buscaDesenhos', [coordenadasController::class, 'pesquisaDesenho'])->middleware(['auth', 'verified'])->name('coord.api.selecionados');

    //Route::get('/api/coordenadas/buscaDesenhos',[coordenadasController::class, 'pesquisaDesenho'])->middleware(['auth', 'verified'])->name('coord.api.selecionados');

    Route::get('/bloco/mapaselecao/{coord}', [coordenadasController::class, 'pesquisaDesenho'])->middleware(['auth', 'verified'])->name('coord.pedaco.selecao');

    Route::get('/bloco/desenhaMapa', [coordenadasController::class, 'desenha'])->middleware(['auth', 'verified'])->name('coord.pedaco.desenha');

    ###aqui  eu vou  buscar o formulário de coordenadas decimal
    Route::get('/bloco/decimal', [coordenadasController::class, 'decimal'])->middleware(['auth', 'verified'])->name('coord.pedaco.decimal');

});
