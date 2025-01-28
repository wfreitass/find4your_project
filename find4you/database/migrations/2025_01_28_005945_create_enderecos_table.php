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
        Schema::create('enderecos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fornecedor_id') // Chave estrangeira para fornecedores
                ->constrained('fornecedores')
                ->onDelete('cascade'); // Apaga os endereços se o fornecedor for deletado
            $table->string('logradouro', 255); // Rua, avenida, etc.
            $table->string('numero', 20); // Número do endereço
            $table->string('bairro', 100);
            $table->string('cidade', 100);
            $table->string('estado', 2); // Sigla do estado (ex: SP, RJ)
            $table->string('cep', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enderecos');
    }
};
