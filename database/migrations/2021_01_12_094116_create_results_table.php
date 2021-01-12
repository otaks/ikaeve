<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('win_team_id')->comment('勝利チームID')->nullable();
            $table->unsignedInteger('lose_team_id')->comment('敗北チームID')->nullable();
            $table->tinyInteger('win_score')->comment('勝利点')->nullable();
            $table->tinyInteger('lose_score')->comment('敗北点')->nullable();
            $table->tinyInteger('turn')->comment('何試合目か')->nullable();
            $table->boolean('unearned_win')->comment('不戦勝(0:なし/1:あり)')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('win_team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('lose_team_id')->references('id')->on('teams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('results');
    }
}
