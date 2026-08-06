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
        Schema::create('clientes', function (Blueprint $table) {
        $table->id(); // Crea un id autoincrementable (unsignedBigInteger)
        $table->string('nombre', 45);
        $table->string('apellido', 45);
        $table->string('direccion', 100)->nullable();
        $table->string('email', 45)->unique()->nullable();
        $table->string('usuario', 45)->unique()->nullable();
        $table->date('fecha_nacimiento')->nullable();
        $table->timestamps(); // Crea created_at y updated_at
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
