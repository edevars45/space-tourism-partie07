<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    // Je crée la table "crew_members" pour le module Équipage
    public function up(): void {
        Schema::create('crew_members', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);          // je stocke le nom affiché
            $table->string('slug', 120)->unique(); // je crée un identifiant unique pour les URLs internes
            $table->string('role', 100)->nullable(); // je stocke la fonction (Commandant, Pilote, etc.)
            $table->text('bio')->nullable();        // je stocke la biographie
            $table->string('image_path')->nullable(); // je stocke le chemin d’image (disk public)
            $table->boolean('is_published')->default(true); // je permets de masquer/afficher
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('crew_members');
    }
};
