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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('regNo')->unique();
            $table->string('idNo');
            // $table->unsignedBigInteger('facials')->nullable();
            $table->unsignedBigInteger('faculty');
            $table->unsignedBigInteger('department');
            $table->unsignedBigInteger('course');
            $table->json('units')->nullable();
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
