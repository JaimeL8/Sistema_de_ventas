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
        Schema::create('ventas', function (Blueprint $table) {
        $table->id();
        
        // Llaves foráneas
        $table->foreignId('id_empleado')->constrained('empleados');
        $table->foreignId('id_cliente')->constrained('clientes');
        
        $table->decimal('total', 9, 2)->default(0.00);
        $table->tinyInteger('estatus')->default(0)->comment('0: Abierta, 1: Cobrada, 2: Cancelada');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
