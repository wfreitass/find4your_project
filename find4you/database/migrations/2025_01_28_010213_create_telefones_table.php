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
        Schema::create('telefones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fornecedor_id') // Chave estrangeira para fornecedores
                ->constrained('fornecedores')
                ->onDelete('cascade'); // Apaga os endereços se o fornecedor for deletado
            $table->string('dd', 2); // DD do estado (ex: SP, RJ)
            $table->string('telefone', 15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telefones');
    }
};
