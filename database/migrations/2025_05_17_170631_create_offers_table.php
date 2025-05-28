<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->date('deadline')->nullable();
            $table->unsignedBigInteger('published_by');  // utilisateur qui publie l'offre
            $table->boolean('is_validated')->default(false);
            $table->string('type')->nullable();     // ex: public, privé, international
            $table->string('sector')->nullable();   // secteur d’activité
            $table->string('region')->nullable();   // région géographique
            $table->bigInteger('budget')->nullable(); // budget en FCFA
            $table->timestamps();

            // Clé étrangère vers la table users
            $table->foreign('published_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('offers');
    }
};
