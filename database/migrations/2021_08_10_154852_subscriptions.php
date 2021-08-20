<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Subscriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('subscriber_id');
            $table->foreign('subscriber_id')->references('id')->on('users');

            $table->unsignedBigInteger('publisher_id');
            $table->foreign('publisher_id')->references('id')->on('users');
            //0 for wating and 1 for accepted.
            $table->boolean('state')->dafault('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
}
