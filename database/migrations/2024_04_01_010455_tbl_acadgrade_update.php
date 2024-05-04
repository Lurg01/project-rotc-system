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
        Schema::table('acadgrade', function (Blueprint $table) {
            $table->unsignedBigInteger('new_stud_id')->nullable();
            $table->foreign('new_stud_id')->references('id')->on('students');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('acadgrade', function (Blueprint $table) {
            $table->unsignedBigInteger('new_stud_id')->nullable();
            $table->foreign('new_stud_id')->references('id')->on('students');
        });
    }
};
