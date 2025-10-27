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
        Schema::create('add_to_carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('u_id');
            $table->unsignedBigInteger('p_id');
            $table->string('p_size');
            $table->integer('p_quantity');
            $table->timestamps();

            $table->foreign('u_id')
              ->references('id')->on('users')
              ->onDelete('cascade');

            $table->foreign('p_id')
                ->references('id')->on('products')
                ->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_to_carts');
    }
};
