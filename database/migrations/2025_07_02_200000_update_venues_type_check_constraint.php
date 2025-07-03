<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Drop the old check constraint if it exists
        DB::statement("ALTER TABLE venues DROP CONSTRAINT IF EXISTS venues_type_check");

        // Add the new check constraint including 'church'
        DB::statement("ALTER TABLE venues ADD CONSTRAINT venues_type_check CHECK (type IN ('indoor', 'outdoor', 'both', 'church'))");
    }

    public function down()
    {
        // Revert to the old constraint (without 'church')
        DB::statement("ALTER TABLE venues DROP CONSTRAINT IF EXISTS venues_type_check");
        DB::statement("ALTER TABLE venues ADD CONSTRAINT venues_type_check CHECK (type IN ('indoor', 'outdoor', 'both'))");
    }
}; 