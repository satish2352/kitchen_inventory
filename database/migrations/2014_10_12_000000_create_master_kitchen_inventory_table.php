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
        Schema::create('master_kitchen_inventory', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // Category name or ID
            $table->string('item_name'); // Item name
            $table->float('quantity')->default(0); // Quantity
            $table->string('location_id');
            $table->string('unit'); // Unit (e.g., kg, pcs, liters)
            $table->float('price'); // Price with 2 decimal places
            $table->integer('priority')->default(0);
            $table->integer('is_active')->default(true);
            $table->integer('is_deleted')->default(false);
            $table->timestamps(); // Created at & Updated at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_kitchen_inventory');
    }
};

