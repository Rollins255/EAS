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
        Schema::create('lectures', function (Blueprint $table) {
            $table->id();
            $table->string('lecturer');
            $table->string('venue');
            $table->string('time');
            // $table->string('unitCode');
            $table->string('unit');
            // $table->string('unitName');
            // $table->unsignedBigInteger('faculty');
            // $table->unsignedBigInteger('department');
            // $table->unsignedBigInteger('course');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lectures');
    }
};
