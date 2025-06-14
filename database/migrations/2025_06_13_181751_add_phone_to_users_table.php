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
        Schema::table('users', function (Blueprint $table) {
            // Ajoute la colonne 'phone' de type string avec une longueur max de 20, et la rend nullable (optionnelle)
            // Positionne-la après la colonne 'email' pour l'organisation (facultatif)
            $table->string('phone', 20)->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Supprime la colonne 'phone' si la migration est annulée
            $table->dropColumn('phone');
        });
    }
};