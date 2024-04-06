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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_name', 100);
            $table->string('category_slug', 255);
            $table->string('category_description', 1024);
            $table->string('category_file', 30);
            $table->string('category_mate_name', 255);
            $table->string('category_mate_description', 1024);
            $table->string('category_mate_keyword', 255);
            $table->tinyInteger('category_status')->default('0'); // 0 = available, 1 = Unavailable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};