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
            $table->comment('Замовлення');

            $table->id();
            $table->unsignedBigInteger('show_id')->nullable(false)->comment('Вистава');
            $table->string('full_name')->nullable(false)->comment('Прізвище, Ім\'я, По батькові');
            $table->string('phone')->nullable(false)->comment('Номер телефону');
            $table->string('email')->nullable(false)->comment('Адреса електронної пошти');
            $table->text('comment')->nullable(true)->comment('Коментар');
            $table->timestamps();

            $table->foreign('show_id')->references('id')->on('shows')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
