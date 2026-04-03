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

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('age');
            $table->string('CIN');
            $table->string('telephon');
            $table->enum('role' , ['client' , 'admin' , 'staff'])->default("client");
            $table->string('salaire')->nullable();
            $table->integer('departement_id')->nullable();
            $table->foreign('departement_id')->references('id')->on('departements');
            $table->string('experience')->nullable();
            $table->string('langage')->nullable();
            $table->string('password')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
