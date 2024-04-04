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
        Schema::create('characters_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('character_id')->constrained('characters')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            $table->boolean('equipped')->default(false);
            $table->unsignedBigInteger('quantity');
            $table->unsignedTinyInteger('quality');
            $table->timestamps();
            $table->unique(['character_id', 'item_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('characters_items');
    }
};
