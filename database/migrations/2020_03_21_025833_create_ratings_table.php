<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rating', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('buku_id')->unsigned();
            $table->bigInteger('pengunjung_id')->unsigned();
            $table->bigInteger('nilai');
            $table->string('ulasan')->nullable();
            $table->timestamps();
            $table->foreign('buku_id')->references('id')->on('buku')->onDelete('cascade');
            $table->foreign('pengunjung_id')->references('id')->on('pengunjung')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ratings');
    }
}
