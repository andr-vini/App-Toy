<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_timers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_toy');
            $table->foreign('service_toy')->references('id')->on('toys');
            $table->unsignedBigInteger('owner_user');
            $table->foreign('owner_user')->references('id')->on('users');
            $table->time('time')->nullable();
            $table->double('total_price')->nullable();
            $table->string('name_client');
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
        Schema::dropIfExists('client_timers');
    }
};
