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
        Schema::create('routine_completions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('routine_id');
            $table->dateTime('completed_at');
            $table->timestamps();
            $table->foreign('routine_id')->references('id')->on('routines');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routine_completions');
    }
};
