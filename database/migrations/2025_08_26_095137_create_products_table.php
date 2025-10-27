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
            $table->string('p_name');
            $table->json('p_size_quatity')->nullable();
            $table->integer('p_price');
            $table->integer('p_offer');
            $table->string('p_category');
            $table->string('p_image');
            $table->string('p_other_images');
            $table->text('p_description');
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
