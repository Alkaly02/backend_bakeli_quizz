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
        Schema::table('domaines', function (Blueprint $table) {
            $table->longText("image")->nullable();
            $table->string("theme")->nullable();
            $table->string("text_color")->nullable();
            $table->longText("description")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('domaines', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->dropColumn('theme');
            $table->dropColumn('text_color');
            $table->dropColumn('description');
        });
    }
};
