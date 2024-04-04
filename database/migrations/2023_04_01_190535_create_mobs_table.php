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
        Schema::create('mobs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('hp');
            $table->bigInteger('atk');
            $table->bigInteger('def');
            $table->bigInteger('agi');
            $table->bigInteger('acc');
            $table->integer('crit');
            $table->integer('xhit');
            $table->bigInteger('coins');
            $table->bigInteger('exp');
            $table->set('race', ['Human', 'Elf', 'Dwarf', 'Orc', 'Goblin', 'Troll', 'Ogre', 'Undead', 'Demon', 'Dragon', 'Drake', 'Naga', 'Merfolk', 'Saurian', 'Wose', 'Dunefolk', 'Mechanical', 'God', 'Alien', 'Other']);
            $table->set('element', ['Blade', 'Pierce', 'Impact', 'Fire', 'Cold', 'Arcane', 'Other']);
            $table->bigInteger('area')->unsigned();
            $table->timestamps();
        });
        // add foreign key 
        Schema::table('mobs', function (Blueprint $table) {
            $table->foreign('area')->references('id')->on('areas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobs');
    }
};
