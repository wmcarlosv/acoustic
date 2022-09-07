<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('app_name')->nullable();
            $table->string('app_version')->nullable();
            $table->string('app_footer')->nullable();
            $table->string('bg_img')->nullable();
            $table->string('color')->nullable();
            $table->string('white_logo')->nullable();
            $table->string('black_logo')->nullable();
            $table->string('color_logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('splash_screen')->nullable();
            $table->string('currency_code')->nullable();
            $table->string('currency_symbol')->nullable();
            $table->string('mapkey')->nullable();
            $table->integer('radius');
            $table->text('terms_of_use')->nullable();
            $table->text('privacy_policy')->nullable();
            $table->text('app_id')->nullable();
            $table->text('api_key')->nullable();
            $table->text('auth_key')->nullable();
            $table->text('project_no')->nullable();
            $table->string('mail_host')->nullable();
            $table->string('mail_port')->nullable();
            $table->string('mail_username')->nullable();
            $table->string('mail_password')->nullable();
            $table->string('sender_email')->nullable();
            $table->string('twilio_acc_id')->nullable();
            $table->string('twilio_phone_no')->nullable();
            $table->string('twilio_auth_token')->nullable();
            $table->text('license_code')->nullable();
            $table->string('license_client_name')->nullable();
            $table->boolean('license_status')->default(0);

            $table->boolean('auto_approve')->default(1);
            $table->boolean('is_verify')->default(1);
            
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
        Schema::dropIfExists('settings');
    }
}
