<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_stories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('epic_id');
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->text('description');
            $table->integer('priority');
            $table->integer('value');
            $table->integer('risk');
            $table->char('estimate',3);
            $table->longText('acceptance');
            $table->text('notes');
            $table->char('category',10);
            $table->timestamps();


            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->onDelete('cascade');

            $table->foreign('epic_id')
                ->references('id')
                ->on('epics')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_stories');
    }
}
