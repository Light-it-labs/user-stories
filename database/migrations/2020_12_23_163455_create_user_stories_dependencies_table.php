<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStoriesDependenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_stories_dependencies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_story_id');
            $table->unsignedBigInteger('user_story_predecessor_id');
            $table->timestamps();


            $table->foreign('user_story_id')
                ->references('id')
                ->on('user_stories');

            $table->foreign('user_story_predecessor_id')
                ->references('id')
                ->on('user_stories');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_stories_dependencies');
    }
}
