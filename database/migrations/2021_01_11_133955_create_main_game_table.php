<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainGameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_games', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('block')->comment('ブロック')->nullable();
            $table->unsignedInteger('turn')->comment('上から何番目か')->nullable();
            $table->string('sheet', 1)->comment('A~P')->nullable();
            $table->unsignedInteger('order')->comment('通過順位(1~2)')->nullable();
            $table->unsignedInteger('team_id')->comment('チームID')->nullable();
            $table->boolean('result')->comment('勝ち負け(0:負け/1:勝ち)')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('main_games');
    }
}
