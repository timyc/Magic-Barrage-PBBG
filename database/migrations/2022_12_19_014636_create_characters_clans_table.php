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
        Schema::create('characters_clans', function (Blueprint $table) {
            // character_id foreign key should be unique
            $table->foreignId('character_id')->constrained('characters');
            $table->foreignId('clan_id')->constrained('clans')->cascadeOnDelete();
            $table->unsignedTinyInteger('rank')->default(1);
            $table->unsignedBigInteger('contribution')->default(0);
            $table->timestamps();
        });
        Schema::table('characters_clans', function (Blueprint $table) {
            $table->unique(['character_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('characters_clans');
    }
};
