<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_user', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('user_id')->nullable();
            $table->string('image')->default("noimage.jpg");
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('bdate')->nullable();
            $table->string('gender')->nullable();
            $table->text('bio')->nullable();
            $table->rememberToken();
            $table->boolean('status')->default(1);
            $table->boolean('is_verify')->default(0);
            $table->integer('otp')->nullable();
            $table->text('device_token')->nullable();
            $table->text('not_interested')->nullable();
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
        Schema::dropIfExists('app_user');
    }
}
