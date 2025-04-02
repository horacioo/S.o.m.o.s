<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $table->bigInteger('documentoId')->unsigned();
        $table->bigInteger('amostraId')->unsigned();
        $table->bigInteger('id')->unsigned(); // A chave primária ou identificador

        // Definindo as chaves estrangeiras
        $table->foreign('documentoId')->references('id')->on('documentos')->onDelete('cascade');
        $table->foreign('amostraId')->references('id')->on('amostras')->onDelete('cascade');

        // Definindo a chave primária composta
        $table->primary(['documentoId', 'amostraId']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos_amostras');
    }
};
