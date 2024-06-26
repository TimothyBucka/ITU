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
        Schema::create('body_data', function (Blueprint $table) {
            $table->id();
            $table->float('height');
            $table->float('weight');
            $table->unsignedInteger('age');
            $table->float('goal_target');
            $table->float('bmi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('body_data');
    }
};
