<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItinerairesAVisiterTable extends Migration
{
    public function up()
    {
        Schema::create('itineraires_a_visiter', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('itineraire_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('itineraire_id')->references('id')->on('itineraires')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('itineraires_a_visiter');
    }
}
