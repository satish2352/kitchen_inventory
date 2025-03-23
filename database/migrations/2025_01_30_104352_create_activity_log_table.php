<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('activity_log', function (Blueprint $table) {
            $table->id();
            $table->string('user_role')->nullable();
            $table->string('location')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('activity_message');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('activity_log');
    }
};