<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->string('title');             // Event title
            $table->text('description')->nullable(); // Event description
            $table->string('location')->nullable();   // Event location
            $table->date('date');                 // Event date (e.g., event day)
            $table->dateTime('start_time');      // Event start datetime
            $table->dateTime('end_time');        // Event end datetime
            $table->enum('status', ['upcoming', 'ongoing', 'completed', 'cancelled'])->default('upcoming'); // Event status

            $table->unsignedBigInteger('created_by');  // Foreign key to users table for event manager/creator

            $table->timestamps();

            // Foreign key constraint linking to users table
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};


