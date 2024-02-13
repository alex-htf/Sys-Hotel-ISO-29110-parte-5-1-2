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
        Schema::create('users', function (Blueprint $table) {
            // $table->id();
            $table->bigIncrements('user_id');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('usuario');
            $table->string('email')->unique();
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->text('foto')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->char('estado',1)->default(1);
            $table->char('oculto',1)->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
