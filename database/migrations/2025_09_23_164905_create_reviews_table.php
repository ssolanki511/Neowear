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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('u_id');
            $table->unsignedBigInteger('p_id');
            $table->integer('star');
            $table->text('description');
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
        Schema::dropIfExists('reviews');
    }
};
