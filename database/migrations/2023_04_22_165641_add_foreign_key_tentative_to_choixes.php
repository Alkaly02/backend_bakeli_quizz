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
        Schema::table('choixes', function (Blueprint $table) {
            $table->foreignId('tentative_id')->constrained("tentatives");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('choixes', function (Blueprint $table) {
            $table->dropColumn('tentative_id');
        });
    }
};
