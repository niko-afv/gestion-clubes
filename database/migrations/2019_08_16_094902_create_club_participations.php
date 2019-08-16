<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClubParticipations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('club_participations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('snapshot')->nullable();
            $table->integer('status')->default(1);
            $table->integer('invoice_id')->unsigned()->nullable();
            $table->integer('club_id')->unsigned();
            $table->integer('event_id')->unsigned();
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
        Schema::dropIfExists('club_participations');
    }
}
