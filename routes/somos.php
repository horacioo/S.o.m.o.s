<?php


use App\Http\Controllers\somos\documentosController;
use App\Http\Controllers\somos\coordenadasController;


Route::get('/', function () { return view('somos.home'); });


Route::middleware('auth')->group(function () {


    Route::get('/trabalhos/pesquisa', [documentosController::class, 'pesquisa'])->middleware(['auth', 'verified'])->name('Trabalhos.pesquisa');



    Route::get('/trabalhos/cadastro', [documentosController::class, 'cadTrab'])->middleware(['auth', 'verified'])->name('TrabalhosCadastros');
    
    
    Route::post('/trabalhos/cadastro', [documentosController::class, 'store'])->middleware(['auth', 'verified'])->name('TrabalhosCadastrosSave');


    Route::post('/trabalhos/api/cadastro', [documentosController::class, 'CadastraDocumentos'])->middleware(['auth', 'verified'])->name('trabalhos.api.cadastro');
    
    
     /**trata  as coordenadas**/
    Route::get('/api/coordenadas/validaCoordenadas', [documentosController::class, 'apiSalvaColetas'])->middleware(['auth', 'verified'])->name('coord.api.valida');


    /**salva os dados completos do formulário**/
    Route::post('/api/trabalhos/salva', [documentosController::class, 'store'])->middleware(['auth', 'verified'])->name('trabalhos.api.salva');


    Route::get('/bloco/desenhaMapa', [coordenadasController::class, 'desenha'])->middleware(['auth', 'verified'])->name('coord.pedaco.desenha');

    ###aqui  eu vou  buscar o formulário de coordenadas decimal
    Route::get('/bloco/decimal', [coordenadasController::class, 'decimal'])->middleware(['auth', 'verified'])->name('coord.pedaco.decimal');

    //Lista meus trabalhos para  editar/ 
    Route::get('trabalhos/minhaLista', [documentosController::class, 'minhalistadeTrabalhos'])->name('minhaListaEdit'); // Confirme se esse controller está correto


    Route::get('trabalhos/{id}', [documentosController::class, 'trabalhoID'])->name('trabalhoId'); // Confirme se esse controller está correto


    Route::post('trabalhos/salvaAlteracao', [documentosController::class, 'UpdateDocumento'])->name('trabalhos.updateData'); // Confirme se esse controller está correto


    Route::get('/bloco/mapaselecao/{coord}', [coordenadasController::class, 'pesquisaDesenho'])->middleware(['auth', 'verified'])->name('coord.pedaco.selecao');


    Route::get('/bloco/mapaMunicipio/{municipio}', [coordenadasController::class, 'pesquisaMunicipio'])->middleware(['auth', 'verified'])->name('coord.pedaco.municipio');


    Route::get('/bloco/mapaDatas/{data}', [coordenadasController::class, 'pesquisaData'])->middleware(['auth', 'verified'])->name('coord.pedaco.data');

});
