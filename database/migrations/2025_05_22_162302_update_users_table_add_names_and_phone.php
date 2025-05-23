<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTableAddNamesAndPhone extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add new columns
            $table->string('first_name')->after('id');
            $table->string('last_name')->after('first_name');
            $table->string('phone_number')->nullable()->after('email');
            
            // Drop the old 'name' column
            $table->dropColumn('name');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add 'name' column back
            $table->string('name')->after('email');
            
            // Drop new columns
            $table->dropColumn(['first_name', 'last_name', 'phone_number']);
        });
    }
}
