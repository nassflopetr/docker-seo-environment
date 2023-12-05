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
        Schema::create('order_hall_seats', function (Blueprint $table) {
            $table->comment('Зв\'язка замовлень із виставами та місцями');

            $table->id();
            $table->unsignedBigInteger('order_id')->nullable(false)->comment('Замовлення');
            $table->unsignedBigInteger('show_id')->nullable(false)->comment('Вистава');
            $table->unsignedTinyInteger('seat')->nullable(false)->comment('Місце');
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('show_id')->references('id')->on('shows')->onDelete('cascade');

            $table->unique(['show_id', 'seat']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_hall_seats');
    }
};
