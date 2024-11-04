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
        Schema::create('caja', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->unique(); // Fecha de la caja, debe ser única por día
            $table->decimal('saldo_inicial', 10, 2)->default(0); // Saldo inicial del día
            $table->decimal('saldo_final', 10, 2)->nullable(); // Saldo final al cerrar la caja
            $table->enum('estado', ['abierta', 'cerrada'])->default('abierta'); // Estado de la caja
            $table->timestamp('fecha_apertura')->nullable(); // Fecha y hora de apertura
            $table->timestamp('fecha_cierre')->nullable(); // Fecha y hora de cierre
            $table->decimal('total_entradas', 10, 2)->default(0); // Total de entradas en el día
            $table->decimal('total_salidas', 10, 2)->default(0); // Total de salidas en el día
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caja');
    }
};
