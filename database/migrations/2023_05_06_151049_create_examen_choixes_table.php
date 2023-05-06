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
        Schema::create('examen_choixes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('examen_question_id')->constrained('examen_questions');
            $table->foreignId('examen_reponse_id')->constrained('examen_reponses');
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
        Schema::dropIfExists('examen_choixes');
    }
};
