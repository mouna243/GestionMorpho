<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        /*  - id : integer
         - image : string
         - name : string
         - description : string
         - status : boolean
         */
        Schema::create('plats', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('name');
            $table->string('description');
            $table->numeric('prix');
            $table->boolean('is_available')->default('true');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plats');
    }
};
