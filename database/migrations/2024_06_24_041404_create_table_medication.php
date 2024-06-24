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
        Schema::create('medications', function (Blueprint $table) {
           
                $table->id(); // Primary key
                $table->unsignedBigInteger('user_id'); // Foreign key to identify the user/patient
                $table->string('medication_name'); // Name of the medication
                $table->string('dosage'); // Dosage of the medication
                $table->string('frequency'); // Frequency of the dosage (e.g., 'once a day', 'twice a day')
                $table->integer('interval'); // Specific time of day for the medication
                $table->boolean('before_eat')->default(false); // Additional instructions for the medication
                $table->boolean('is_active')->default(true); // To track if the schedule is currently active
                $table->timestamps(); // Laravel's created_at and updated_at columns
                
                // Foreign key constraint
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medications');
    }
};
