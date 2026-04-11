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
        Schema::create('workshifts', function (Blueprint $table) {
            $table->id();
            $table->integer('departement_id');
            $table->foreign('departement_id')->references('id')->on('departements')->onDelete('cascade');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->date('check_in');
            $table->date('check_out');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workshifts');
    }
};
