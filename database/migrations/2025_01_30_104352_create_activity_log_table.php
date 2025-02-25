<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('activity_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('activity_message');
            $table->timestamps();

            // Foreign key constraint
            // $table->foreign('user_id')->references('id')->on('users_data')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('activity_log');
    }
};