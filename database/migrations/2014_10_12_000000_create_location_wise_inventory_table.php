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
        Schema::create('location_wise_inventory', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('inventory_id');
            $table->foreignId('location_id');
            $table->float('master_quantity')->default(0);            
            $table->float('master_price')->default(0);  
            $table->float('quantity');

            $table->string('category_name')->default(null);
            $table->string('unit_name')->default(null);
            $table->string('item_name')->default(null);

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
        Schema::dropIfExists('location_wise_inventory');
    }
};

