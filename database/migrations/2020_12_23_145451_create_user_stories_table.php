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
            $table->unsignedBigInteger('epic_id');
            $table->unsignedBigInteger('user_id');
            $table->text('description');
            $table->integer('priority');
            $table->integer('value');
            $table->integer('risk');
            $table->char('estimate',3);
            $table->longText('acceptance')->nullable();
            $table->text('notes')->nullable();
            $table->char('category',10);
            $table->timestamps();

            $table->foreign('epic_id')
                ->references('id')
                ->on('epics');

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
