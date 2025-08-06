<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('customer_requests', function (Blueprint $table) {
            $table->id(); // Primary key

            $table->string('sku_code');             // Store's internal SKU code
            $table->string('vendor');               // Vendor name
            $table->string('brand');                // Brand name
            $table->string('product_description');  // Full product name
            $table->integer('quantity');            // Requested quantity

            $table->string('customer_name')->nullable();  // Optional
            $table->string('contact_no')->nullable();     // Optional
            $table->string('associate')->nullable();      // Who took the request

            $table->enum('status', [
                'requested',
                'ordered_from_vendor',
                'ready_for_pickup',
                'called_to_pickup',
                'completed',
                'cancelled',
                'item_on_backorder',
                'item_discontinued',
                'called_item_in_bo',
                'called_item_dcd',
            ])->default('requested');

            $table->timestamp('called_to_pickup_at')->nullable();

            $table->text('notes')->nullable();      // Additional notes if needed

            $table->timestamps(); // created_at and updated_at
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_requests');
    }
};
