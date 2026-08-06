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
        $table->id(); // o el identificador que estés usando
        $table->string('upc')->unique(); // <-- Agrega esta línea
        $table->string('descripcion');
        $table->decimal('costo', 10, 2);
        $table->decimal('precio', 10, 2);
        $table->integer('existencia');
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
