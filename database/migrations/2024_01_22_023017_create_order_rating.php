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
        Schema::create('order_rating', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->smallInteger('rating');
            $table->text('message')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_rating');
    }
};
