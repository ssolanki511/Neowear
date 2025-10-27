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
        Schema::create('apply_coupens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('u_id');
            $table->unsignedBigInteger('coupen_id');
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
        Schema::dropIfExists('apply_coupens');
    }
};
