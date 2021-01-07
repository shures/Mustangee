<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name')->nullable();;
            $table->text('title')->nullable();
            $table->text('elevation')->nullable();
            $table->text('route')->nullable();
            $table->text('distance')->nullable();
            $table->text('famous_for')->nullable();
            $table->text('about')->nullable();
            $table->integer('like_count')->default(0)->unsigned();
            $table->integer('comment_count')->default(0)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
