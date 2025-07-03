<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_church')->default(false)->after('id');
            $table->string('name');
            $table->enum('type', ['indoor', 'outdoor', 'both']);
            $table->integer('capacity');
            $table->string('price_range');
            $table->text('description');
            $table->string('main_image');
            $table->string('address');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('venues');
        Schema::table('venues', function (Blueprint $table) {
            $table->dropColumn('is_church');
        });
    }
};