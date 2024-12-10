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
        Schema::create('saisons', function (Blueprint $table) {
            $table->id('Id_Saison');
            $table->integer('année_debut');
            $table->integer('année_fin');
            $table->string('championnat', 50);
            $table->string('catégorie', 4);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saisons');
    }
};
