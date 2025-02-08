<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('location'); // Added location field
            $table->string('user_role');
            $table->string('email');
            $table->string('phone');
            $table->string('password');   
            $table->string('added_by');
            $table->string('added_byId');
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('is_deleted')->default(false);
            $table->timestamps();

            // $table->id();
            // $table->string('name');
            // $table->string('location')->nullable(); // Added location field
            // $table->string('role')->nullable(); // Added role field
            // $table->string('email');
            // $table->string('phone');
            // $table->timestamp('email_verified_at')->nullable();
            // $table->string('password');
            // $table->rememberToken();
            // $table->integer('is_active')->default(true);
            // $table->integer('is_deleted')->default(false);
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_data');
    }
};
