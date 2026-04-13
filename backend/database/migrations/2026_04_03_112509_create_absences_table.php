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

/*
- id : integer

- date_debut : date

- date_fin : date

- justification : bool

- pdf : string
 */

        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->integer('workshift_id');
            $table->foreign('workshift_id')->references('id')->on('workshifts')->onDelete('cascade');
            $table->integer('staff_id');
            $table->foreign('staff_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('is_justified')->default(false);
            $table->string('pdf')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absences');
    }
};
