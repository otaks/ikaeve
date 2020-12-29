<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weapons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->comment('名前')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('team_id')->comment('チームID')->nullable();
            $table->string('name', 8)->comment('名前')->nullable();
            $table->string('twitter', 255)->comment('ツイッターID')->nullable();
            $table->string('discord', 255)->comment('discordID')->nullable();
            $table->unsignedInteger('xp')->comment('xp')->nullable();
            $table->unsignedInteger('weapon_id')->comment('使用武器')->nullable();
            $table->text('note')->comment('備考')->nullable();
            $table->boolean('ban')->comment('拒否')->default(0);

            $table->timestamps();
            $table->softDeletes();
            $table->foreign('weapon_id')->references('id')->on('weapons')->onDelete('cascade');
        });

        Schema::create('teams', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('event_id')->comment('大会ID')->nullable();
            $table->string('name', 50)->comment('名前')->nullable();
            $table->unsignedInteger('member_id')->comment('代表者ID')->nullable();
            $table->string('friend_code', 255)->comment('フレンドコード')->nullable();
            $table->text('note')->comment('備考')->nullable();
            $table->boolean('approval')->comment('許可')->default(0);
            $table->boolean('abstention')->comment('棄権')->default(0);
            $table->string('pass', 4)->comment('修正用パスワード')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });

        Schema::create('wanteds', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('event_id')->comment('大会ID')->nullable();
            $table->string('name', 255)->comment('名前')->nullable();
            $table->text('note')->comment('内容')->nullable();
            $table->string('pass', 4)->comment('修正用パスワード')->nullable();
            $table->boolean('end')->comment('終了')->default(0);

            $table->timestamps();
            $table->softDeletes();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wanteds');
        Schema::dropIfExists('teams');
        Schema::dropIfExists('members');
        Schema::dropIfExists('weapons');
    }
}
