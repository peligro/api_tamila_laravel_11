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
        Schema::create('gastos_fijos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 200);
            $table->integer('monto');
            $table->datetime('fecha')->default(date("Y-m-d H:i:s"));
            $table->unsignedBigInteger('estados_id');
            $table->foreign('estados_id')->references('id')->on('estados')->onDelete('cascade');
            $table->unsignedBigInteger('proveedores_id');
            $table->foreign('proveedores_id')->references('id')->on('proveedores')->onDelete('cascade');

             
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gastos_fijos');
    }
};
