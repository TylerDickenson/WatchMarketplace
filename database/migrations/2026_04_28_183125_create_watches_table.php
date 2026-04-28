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
        Schema::create('watches', function (Blueprint $table) {
            $table->id();
            $table->string('brand');
            $table->string('family')->nullable();
            $table->string('model')->nullable();
            $table->string('reference')->unique();
            $table->string('movement_calibre')->nullable();
            $table->text('movement_functions')->nullable();
            $table->string('limited')->nullable();
            $table->string('case_material')->nullable();
            $table->string('glass')->nullable();
            $table->string('back')->nullable();
            $table->string('shape')->nullable();
            $table->string('diameter')->nullable();
            $table->string('thickness')->nullable();
            $table->string('water_resistance')->nullable();
            $table->string('dial_colour')->nullable();
            $table->string('indexes')->nullable();
            $table->string('hands')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('watches');
    }
};
