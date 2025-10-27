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
        Schema::create('order__items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->integer('product_id');
            $table->integer('quantity');
            $table->string('size');
            $table->integer('price');
            $table->string('product_image');
            $table->text('product_name');
            $table->timestamps();

            $table->foreign('order_id')
                ->references('id')->on('orders')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order__items', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
        });
        Schema::dropIfExists('order__items');
    }
};
