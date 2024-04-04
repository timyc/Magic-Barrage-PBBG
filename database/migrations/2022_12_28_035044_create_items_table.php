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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('slot');
            $table->string('type');
            $table->string('element')->default('none');
            $table->string('file')->default('none.png');
            $table->unsignedTinyInteger('rarity')->default(1);
            $table->unsignedBigInteger('level')->default(1);
            $table->unsignedBigInteger('cost')->default(0);
            $table->boolean('sell')->default(true);
            $table->unsignedBigInteger('salvage')->default(0);
            $table->unsignedBigInteger('quantity')->default(1);
            $table->unsignedTinyInteger('currency')->default(1);
            $table->unsignedBigInteger('health')->default(0);
            $table->unsignedBigInteger('attack')->default(0);
            $table->unsignedBigInteger('defense')->default(0);
            $table->unsignedBigInteger('accuracy')->default(0);
            $table->unsignedBigInteger('evasion')->default(0);
            $table->unsignedBigInteger('luck')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
};
