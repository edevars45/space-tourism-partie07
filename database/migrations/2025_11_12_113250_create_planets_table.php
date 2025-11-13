<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('planets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();

            // Position d’affichage (colonne qui manquait)
            // NB: SQLite accepte "order", mais si un jour tu veux être 100% safe
            // tu pourras renommer en "sort_order" partout.
            $table->integer('order')->default(0);

            $table->text('description')->nullable();
            $table->string('distance')->nullable();
            $table->string('travel_time')->nullable();
            $table->string('image')->nullable();
            $table->boolean('published')->default(false);

            $table->timestamps();

            // (optionnel) petit index utile pour les tris
            $table->index('order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('planets');
    }
};
