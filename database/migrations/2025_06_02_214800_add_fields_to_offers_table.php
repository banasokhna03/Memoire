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
        Schema::table('offers', function (Blueprint $table) {
            // Renommer la colonne published_by en user_id
            $table->renameColumn('published_by', 'user_id');
            
            // Ajouter les nouveaux champs
            $table->boolean('is_published')->default(false)->after('is_validated');
            $table->string('duration')->nullable()->after('budget');
            $table->text('required_skills')->nullable()->after('duration');
            $table->string('company')->nullable()->after('required_skills');
            $table->string('email')->nullable()->after('company');
            $table->string('phone')->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offers', function (Blueprint $table) {
            // Supprimer les champs ajoutés
            $table->dropColumn([
                'is_published',
                'duration',
                'required_skills',
                'company',
                'email',
                'phone'
            ]);
            
            // Renommer la colonne user_id en published_by
            $table->renameColumn('user_id', 'published_by');
        });
    }
};
