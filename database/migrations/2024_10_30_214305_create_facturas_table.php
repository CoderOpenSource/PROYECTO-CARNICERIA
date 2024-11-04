<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturasTable extends Migration
{
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id(); // Número de factura
            $table->foreignId('venta_id')->constrained()->onDelete('cascade');
            $table->foreignId('cliente_id')->constrained('usuarios')->onDelete('cascade'); // Relación con el cliente
            $table->string('ci_nit'); // CI o NIT del cliente
            $table->dateTime('fecha_emision');
            $table->decimal('monto_total', 10, 2); // Monto total incluyendo IVA
            $table->decimal('iva', 10, 2); // IVA del 13% sobre el monto sin IVA
            $table->enum('estado', ['emitida', 'pagada', 'anulada'])->default('emitida');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('facturas');
    }
}
