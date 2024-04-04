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
        Schema::create('chat_whisper', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sender_id');
            $table->string('sender_name');
            $table->bigInteger('receiver_id');
            $table->string('receiver_name');
            $table->string('message');
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
        Schema::dropIfExists('chat_whisper');
    }
};
