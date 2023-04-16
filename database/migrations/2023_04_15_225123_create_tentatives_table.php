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
        Schema::create('Tentatives', function (Blueprint $table) {
            $table->id();
            $table->integer("score");
            $table->foreignId("quizz_id")->constrained("quizzs")->cascadeOnUpdate()->cascadeOnDelete();
            $table->json('reponses');
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
        Schema::dropIfExists('Tentatives');
    }
};
