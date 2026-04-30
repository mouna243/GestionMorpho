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
        Schema::table('workshifts', function (Blueprint $table) {
            $table->dropColumn(['check_in', 'check_out']);
            $table->time('check_in');
            $table->time('check_out');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workshifts', function (Blueprint $table) {
            $table->dropColumn(['check_in', 'check_out']);
            $table->date('check_in');
            $table->date('check_out');
        });
    }
};
