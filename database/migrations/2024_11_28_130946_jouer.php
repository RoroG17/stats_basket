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
        Schema::create('jouer', function (Blueprint $table) {
            $table->unsignedBigInteger('Id_Match_Basket');
            $table->char('licence', 8);

            // Statistiques
            $table->integer('passe_decisive')->default(0);
            $table->integer('rebond_def')->default(0);
            $table->integer('rebond_off')->default(0);
            $table->integer('interception')->default(0);
            $table->integer('contre')->default(0);
            $table->integer('ballon_perdu')->default(0);
            $table->integer('tir_reussi')->default(0);
            $table->integer('tir_rate')->default(0);
            $table->integer('three_points_reussi')->default(0);
            $table->integer('three_points_rate')->default(0);
            $table->integer('passe_reussi')->default(0);
            $table->integer('passe_rate')->default(0);
            $table->integer('lf_reussi')->default(0);
            $table->integer('lf_rate')->default(0);
            $table->integer('faute')->default(0);
            $table->time('minutes')->nullable();

            // Primary key
            $table->primary(['Id_Match_Basket', 'licence']);

            // Foreign keys
            $table->foreign('Id_Match_Basket')->references('Id_Match_Basket')->on('match_basket')->onDelete('cascade');
            $table->foreign('licence')->references('licence')->on('joueurs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jouer');
    }
};
