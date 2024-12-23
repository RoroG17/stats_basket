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
        Schema::create('matchs', function (Blueprint $table) {
            $table->id('Id_Match');
            $table->date('date_match');
            $table->integer('numero');
            $table->boolean('domicile'); 
            $table->int('score_f'); 
            $table->int('score_a'); 
            $table->unsignedBigInteger('Id_Equipe');
            $table->unsignedBigInteger('Id_Saison');

            // Set foreign keys
            $table->foreign('Id_Equipe')->references('Id_Equipe')->on('equipes')->onDelete('cascade');
            $table->foreign('Id_Saison')->references('Id_Saison')->on('saisons')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match');
    }
};
