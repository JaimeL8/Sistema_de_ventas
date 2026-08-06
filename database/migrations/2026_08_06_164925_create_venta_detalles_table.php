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
        Schema::create('venta_detalles', function (Blueprint $table) {
        $table->id();
        
        // Llave foránea hacia ventas
        $table->foreignId('id_venta')->constrained('ventas');
        
        // Llave foránea hacia productos (como el upc es string, lo definimos manualmente)
        $table->string('id_producto', 45);
        $table->foreign('id_producto')->references('upc')->on('productos');
        
        $table->decimal('precio', 8, 2);
        $table->integer('cantidad');
        $table->decimal('utilidad', 8, 2)->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venta_detalles');
    }
};
