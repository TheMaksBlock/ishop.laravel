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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('category_id');
            $table->unsignedTinyInteger('brand_id');
            $table->string('title');
            $table->string('alias')->unique();
            $table->text('content')->nullable();
            $table->float('price');
            $table->float('old_price');
            $table->enum('status', ['0', '1'])->default('1');
            $table->string('keywords')->nullable();
            $table->string('description')->nullable();
            $table->string('img')->default('no_image.jpg');
            $table->enum('hit', ['0', '1'])->default('0');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
