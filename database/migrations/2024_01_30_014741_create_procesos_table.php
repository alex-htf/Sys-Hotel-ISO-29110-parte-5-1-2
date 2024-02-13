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
        Schema::create('procesos', function (Blueprint $table) {
            $table->bigIncrements('proceso_id');
            $table->unsignedBigInteger('habitacion_id');
            $table->foreign('habitacion_id')
            ->references('habitacion_id')
            ->on('habitaciones')
            ->onDelete('RESTRICT');
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')
            ->references('persona_id')
            ->on('personas')
            ->onDelete('RESTRICT');  
            // $table->unsignedBigInteger('tarifa_id');
            // $table->foreign('tarifa_id')
            // ->references('tarifa_id')
            // ->on('tarifas')
            // ->onDelete('RESTRICT');  
            // $table->unsignedBigInteger('tipo_comprobante_id');
            // $table->foreign('tipo_comprobante_id')
            // ->references('tipo_comprobante_id')
            // ->on('tipo_comprobantes')
            // ->onDelete('RESTRICT');  
            // $table->char('serie',4);
            // $table->char('numero',8);
            // $table->decimal('precio',12,2);
            $table->integer('cant_noches');
            $table->integer('cant_personas');
            $table->decimal('total',12,2);
            $table->dateTime('fecha_entrada',0);
            $table->dateTime('fecha_salida',0);
            $table->integer('toallas');
            // $table->char('estado_pago',1);
            $table->char('tipo_pago',1);
            $table->char('nro_operacion',20)->nullable();
            $table->text('observaciones')->nullable();
            $table->char('estado',1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procesos');
    }
};
