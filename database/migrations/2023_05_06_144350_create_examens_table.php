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
        Schema::create('examens', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('sous_domaine_id')->constrained('sous_domaines')->cascadeOnDelete();
            $table->enum('session', ['normal', 'rattrapage'])->default('normal');
            $table->enum('status', ['blocked', 'active'])->default('blocked');
            $table->time('duree');
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
        Schema::dropIfExists('examens');
    }
};
