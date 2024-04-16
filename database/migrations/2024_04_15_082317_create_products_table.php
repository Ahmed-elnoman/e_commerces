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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name', 100);
            $table->string('product_description', 1040);
            $table->integer('product_original_price', false, true);
            $table->integer('product_selling_price', false, true);
            $table->integer('product_quantity', false, true);
            $table->tinyInteger('product_trending')->default('0')->comment('0=> trending, 1=> not trending');
            $table->tinyInteger('product_status')->default('0')->comment('0=> visible, 1=> hidden');
            $table->string('product_meta_name', 100);
            $table->string('product_meta_description', 1011);
            $table->string('product_meta_key', 20);
            // f
            $table->unsignedBigInteger('product_category_id');
            $table->unsignedBigInteger('product_brand_id');

            $table->foreign('product_brand_id')->on('brands')->references('id');
            $table->foreign('product_category_id')->on('categories')->references('id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
