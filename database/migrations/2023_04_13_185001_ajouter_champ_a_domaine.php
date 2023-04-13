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
            $table->string("image")->nullable();
            $table->string("theme")->nullable();
            $table->string("description")->nullable();
        });

        Schema::table('cours', function (Blueprint $table) {
            $table->string("image")->nullable();
            $table->string("description")->nullable();
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
            $table->dropColumn('description');
        });

        Schema::table('cours', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->dropColumn('description');
        });
    }
};
