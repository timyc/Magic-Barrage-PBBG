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
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->integer('level');
            $table->unsignedTinyInteger('distance_x');
            $table->unsignedTinyInteger('distance_y');
            $table->bigInteger('req_item')->unsigned()->nullable();
            $table->timestamps();
        });
        // add foreign key
        Schema::table('areas', function (Blueprint $table) {
            $table->foreign('req_item')->references('id')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('areas');
    }
};
