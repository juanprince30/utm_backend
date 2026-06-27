<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Passe les colonnes de scoring en decimal(2,1) pour stocker des
     * moyennes calculees par l'IA a partir des commentaires (ex: 4.5).
     */
    public function up(): void
    {
        Schema::table('commerces', function (Blueprint $table) {
            $table->decimal('scoringCommerce', 2, 1)->nullable()->change();
        });

        Schema::table('services', function (Blueprint $table) {
            $table->decimal('scoringService', 2, 1)->nullable()->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->decimal('scoringArtisant', 2, 1)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('commerces', function (Blueprint $table) {
            $table->integer('scoringCommerce')->nullable()->change();
        });

        Schema::table('services', function (Blueprint $table) {
            $table->integer('scoringService')->nullable()->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('scoringArtisant')->nullable()->change();
        });
    }
};
