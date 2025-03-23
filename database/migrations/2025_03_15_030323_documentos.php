<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()  // Alterado para 'up'
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->string('programa');
            $table->string('tipo_do_documento');
            $table->string('titulo');
            $table->string('autor');
            $table->text('citacao');
            $table->string('orientador');
            $table->string('palavra_chave');
            $table->date('data_deposito');
            $table->integer('coleta');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
