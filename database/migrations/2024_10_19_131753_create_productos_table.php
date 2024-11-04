<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->decimal('precio_compra', 8, 2);
            $table->decimal('precio_por_unidad', 8, 2); // Precio por unidad de medida (e.g., precio por kg)
            $table->decimal('peso_disponible', 8, 2); // Peso total disponible en inventario
            $table->string('unidad_medida')->default('kg'); // Unidad de medida (kg, g, etc.)
            $table->string('foto_url')->nullable();
            $table->foreignId('categoria_id')->constrained('categoria_productos');
            $table->foreignId('proveedor_id')->constrained('usuarios')->onDelete('cascade'); // Relación con proveedores usando proveedor_id
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
