<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('clientes');

        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nomeCliente');
            $table->string('cpf', 14)->unique();
            $table->string('email');
            $table->string('telefone');
            $table->string('endereco');
            $table->string('cidade');
            $table->string('estado', 2);
            $table->string('cep', 9);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
}; 