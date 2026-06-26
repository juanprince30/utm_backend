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
        Schema::create('commerces', function (Blueprint $table) {
            $table->id();
            $table->string('nomCormmercial');
            $table->string('categorie');
            $table->string('position');
            $table->string('ville');
            $table->json('horaire');
            $table->string('emailCommerce')->unique()->nullable();
            $table->integer('conctactResponsable');
            $table->boolean('etatPublication');
            $table->string('lienCommerce')->nullable();
            $table->integer('scoringCommerce')->nullable();
            $table->json('photos');
            $table->foreignId('IdUser')
                ->constrained('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commerces');
    }
};
