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
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('name')->unique();
            $table->char('gender', 1)->default('M');
            $table->unsignedTinyInteger('race');
            $table->unsignedTinyInteger('class')->default(0);
            $table->unsignedInteger('level')->default(1);
            $table->unsignedBigInteger('exp')->default(0);
            $table->unsignedTinyInteger('mode')->default(1);
            $table->unsignedInteger('access')->default(1);
            $table->unsignedBigInteger('coins')->default(0);
            $table->unsignedBigInteger('food')->default(0);
            $table->unsignedBigInteger('wood')->default(0);
            $table->unsignedBigInteger('stone')->default(0);
            $table->unsignedBigInteger('iron')->default(0);
            //$table->foreignId('clan_id')->nullable()->constrained('clans');
            $table->unsignedInteger('health')->default(2);
            $table->unsignedInteger('attack')->default(2);
            $table->unsignedInteger('defense')->default(0);
            $table->unsignedInteger('accuracy')->default(0);
            $table->unsignedInteger('evasion')->default(0);
            $table->unsignedInteger('luck')->default(0);
            $table->unsignedInteger('crit_chance')->default(0);
            $table->unsignedInteger('crit_damage')->default(0);
            $table->unsignedInteger('crit_resistance')->default(0);
            $table->unsignedInteger('multiattack')->default(0);
            $table->unsignedInteger('reputation')->default(0);
            $table->unsignedSmallInteger('main_hand')->default(0);
            $table->unsignedSmallInteger('off_hand')->default(0);
            $table->unsignedSmallInteger('helmet')->default(0);
            $table->unsignedSmallInteger('gauntlets')->default(0);
            $table->unsignedSmallInteger('shoulders')->default(0);
            $table->unsignedSmallInteger('torso')->default(0);
            $table->unsignedSmallInteger('leggings')->default(0);
            $table->unsignedSmallInteger('boots')->default(0);
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
        Schema::dropIfExists('characters');
    }
};
