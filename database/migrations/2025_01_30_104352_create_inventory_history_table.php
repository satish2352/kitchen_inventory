<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('inventory_id');
            $table->foreignId('location_id');
            $table->integer('quantity');
            $table->integer('is_active')->default(true);
            $table->integer('is_deleted')->default(false);
            $table->tinyInteger('approved_by')->default(0)->comment('0 = Pending, 1 = Sended From manager, 2 = Approved by Admin, 3 = Approved by Super Admin');
            $table->timestamps(); // Created at & Updated at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_history');
    }
};

