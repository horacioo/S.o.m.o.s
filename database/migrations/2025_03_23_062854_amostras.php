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
        Schema::create('amostras', function (Blueprint $table) {
            $table->id(); // Criar o campo id automaticamente
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            //$table->bigInteger('ligacao')->nullable();
            $table->foreignId('documento_id')->constrained()->onDelete('cascade'); // Relacionamento com a tabela documentos
            $table->foreignId('tipo_de_coleta_id')->constrained()->onDelete('cascade'); // Relacionamento com a tabela tipo_de_coleta
            $table->timestamps(); // created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amostras');
    }
};
