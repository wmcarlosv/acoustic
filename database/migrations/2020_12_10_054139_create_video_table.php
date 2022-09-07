<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('song_id')->nullable();
            $table->string('audio_id')->nullable();
            $table->string('video');
            $table->text('description')->nullable();
            $table->text('hashtags')->nullable();
            $table->text('user_tags')->nullable();
            $table->string('screenshot');
            $table->string('language');
            $table->string('view');
            $table->boolean('is_comment')->default(1);
            $table->boolean('is_approved')->default(0);
            $table->string('lat')->nullable();
            $table->string('lang')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video');
    }
}
