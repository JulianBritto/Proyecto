<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::create('solicitudes', function (Blueprint $table) {
        $table->id();
        $table->string('nombre', 100);
        $table->string('email', 150);
        $table->string('asunto', 150);
        $table->text('descripcion');
        $table->string('categoria', 150)->nullable();     // campo texto
        $table->string('subcategoria', 150)->nullable();  // campo texto
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('solicitudes');
    }
};