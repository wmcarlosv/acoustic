<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('all_reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_user_id');
            $table->string('user_id')->nullable();
            $table->string('video_id')->nullable();
            $table->string('comment_id')->nullable();
            $table->string('reason_id');
            $table->string('type');
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
        Schema::dropIfExists('all_reports');
    }
}
