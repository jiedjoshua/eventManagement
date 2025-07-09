<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('church_id')->nullable()->after('venue_id')->constrained('venues')->onDelete('restrict');
            $table->foreignId('reception_id')->nullable()->after('church_id')->constrained('venues')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['church_id']);
            $table->dropForeign(['reception_id']);
            $table->dropColumn(['church_id', 'reception_id']);
        });
    }
}; 