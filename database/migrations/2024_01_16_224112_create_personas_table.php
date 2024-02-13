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
        Schema::create('personas', function (Blueprint $table) {
            $table->bigIncrements('persona_id');
            $table->unsignedBigInteger('tipo_documento_id');
            $table->foreign('tipo_documento_id')
            ->references('tipo_documento_id')
            ->on('tipo_documentos')
            ->onDelete('RESTRICT'); 
            $table->string('documento',14);
            $table->string('nombre',60);
            // $table->string('razon_social',250);
            $table->text('direccion')->nullable();
            $table->string('telefono',20)->nullable();
            $table->string('email',100)->nullable();
            // $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
