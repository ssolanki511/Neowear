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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('o_id');
            $table->unsignedBigInteger('u_id');
            $table->string('u_name');
            $table->text('o_address');
            $table->integer('total_amount');
            $table->string('o_phone_number');
            $table->string('o_status')->default('Pending');
            $table->string('o_payment_method');
            $table->timestamps();

            $table->foreign('u_id')
              ->references('id')->on('users')
              ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order__items'); 
        Schema::dropIfExists('orders');
    }
};
