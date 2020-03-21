<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSimilaritiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('similarity', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('buku_id1');
            $table->unsignedBigInteger('buku_id2');
            $table->unsignedBigInteger('pengunjung_id');
            $table->double('nilai_cosine');
            $table->foreign('buku_id1')->references('id')->on('buku')->onDelete('cascade');
            $table->foreign('buku_id2')->references('id')->on('buku')->onDelete('cascade');
            $table->foreign('pengunjung_id')->references('id')->on('pengunjung')->onDelete('cascade');

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
        Schema::dropIfExists('similarities');
    }
}
