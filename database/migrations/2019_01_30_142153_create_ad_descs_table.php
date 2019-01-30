<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdDescsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_descs', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable(false)->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('ad_id')->nullable(false)->index();
            $table->text('desc')->nullable(false);
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
        Schema::dropIfExists('ad_descs');
    }
}
