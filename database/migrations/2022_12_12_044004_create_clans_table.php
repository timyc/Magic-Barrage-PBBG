<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('tag')->unique();
            $table->string('description');
            $table->smallInteger('max_size')->default(10);
            $table->smallInteger('level')->default(1);
            $table->bigInteger('exp')->default(0);
            $table->bigInteger('coins')->default(0);
            $table->bigInteger('food')->default(0);
            $table->bigInteger('wood')->default(0);
            $table->bigInteger('stone')->default(0);
            $table->bigInteger('iron')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clans');
    }
};
