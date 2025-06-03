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
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('event_name');
        $table->string('event_type');
        $table->string('package_type')->nullable();
        $table->date('event_date');
        $table->time('start_time');
        $table->time('end_time');
        $table->string('venue_name');
        $table->string('event_duration')->nullable();
        $table->integer('guest_count')->nullable();
        $table->string('guest_list_path')->nullable();
        $table->boolean('enable_rsvp')->default(false);
        $table->date('rsvp_deadline')->nullable();
        $table->boolean('allow_plus_one')->default(false);
        $table->string('reminder_schedule')->nullable();
        $table->decimal('total_price', 10, 2)->nullable();
        $table->enum('status', ['upcoming', 'ongoing', 'completed', 'cancelled'])->default('upcoming'); // Event status
        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn([
                'user_id', 'event_name', 'event_type', 'package_type',
                'event_date', 'start_time', 'end_time', 'venue_name',
                'event_duration', 'guest_count', 'guest_list_path',
                'enable_rsvp', 'rsvp_deadline', 'allow_plus_one',
                'reminder_schedule', 'total_price'
            ]);
        });
    }
};
