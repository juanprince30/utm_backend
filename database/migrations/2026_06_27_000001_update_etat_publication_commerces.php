<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ajouter une colonne temporaire string
        Schema::table('commerces', function (Blueprint $table) {
            $table->string('etatPublication_new')->default('draft')->after('conctactResponsable');
        });

        // Migrer les données : true → publie, false → draft
        DB::table('commerces')->where('etatPublication', true)->update(['etatPublication_new' => 'publie']);
        DB::table('commerces')->where('etatPublication', false)->update(['etatPublication_new' => 'draft']);

        Schema::table('commerces', function (Blueprint $table) {
            $table->dropColumn('etatPublication');
        });

        Schema::table('commerces', function (Blueprint $table) {
            $table->renameColumn('etatPublication_new', 'etatPublication');
        });
    }

    public function down(): void
    {
        Schema::table('commerces', function (Blueprint $table) {
            $table->boolean('etatPublication_old')->default(false)->after('conctactResponsable');
        });

        DB::table('commerces')->where('etatPublication', 'publie')->update(['etatPublication_old' => true]);

        Schema::table('commerces', function (Blueprint $table) {
            $table->dropColumn('etatPublication');
        });

        Schema::table('commerces', function (Blueprint $table) {
            $table->renameColumn('etatPublication_old', 'etatPublication');
        });
    }
};
