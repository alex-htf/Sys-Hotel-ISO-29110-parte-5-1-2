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
        Schema::create('habitaciones', function (Blueprint $table) {
            $table->bigIncrements('habitacion_id');
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')
            ->references('categoria_id')
            ->on('categorias')
            ->onDelete('RESTRICT');   
            $table->unsignedBigInteger('ubicacion_id');
            $table->foreign('ubicacion_id')
            ->references('ubicacion_id')
            ->on('ubicaciones')
            ->onDelete('RESTRICT');   
            $table->string('habitacion',40);
            $table->string('imagen',200)->nullable();
            $table->text('detalles')->nullable();
            $table->decimal('precio',12,2);
            $table->char('estado',1)->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habitacions');
    }
};
