<?php

namespace Badge\Migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BadgeMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('badges', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('action');
            $table->unsignedInteger('action_count');
        });

        Schema::create('badge_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('badge_id');
            $table->unsignedInteger('user_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('badge_id')->references('id')->on('badges')->onDelete('cascade');

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
        Schema::dropIfExists('badges');
        Schema::dropIfExists('badge_user');
    }
}
