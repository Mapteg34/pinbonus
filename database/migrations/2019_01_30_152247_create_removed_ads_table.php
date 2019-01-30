<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemovedAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('removed_ads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable(false)->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('ad_id')->nullable(false)->index();
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
        Schema::dropIfExists('removed_ads');
    }
}
