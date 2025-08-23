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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code',10);  //not setting nullable as code may be same for similar subjects for cross program
            $table->foreignId('program_id')->constrained('programs')->onDelete('cascade');
            $table->integer('semester')->unsigned();
            $table->integer('credits')->unsigned();
            $table->string('type', length: 20); // e.g., core, elective, internship
            // add instructor id later while defining the teacher table 
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
