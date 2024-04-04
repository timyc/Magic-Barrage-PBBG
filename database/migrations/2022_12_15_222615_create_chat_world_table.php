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
        Schema::create('chat_world', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('char_id');
            $table->string('name');
            $table->char('gender', 1);
            $table->integer('rank');
            $table->string('message');
            $table->integer('channel')->default(1);
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
        Schema::dropIfExists('chat_world');
    }
};
