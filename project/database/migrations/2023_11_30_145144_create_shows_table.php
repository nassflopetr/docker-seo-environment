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
        Schema::create('shows', function (Blueprint $table) {
            $table->comment('Вистави');

            $table->id();
            $table->unsignedBigInteger('hall_id')->nullable(false)->comment('Зал');
            $table->json('metadata')->nullable(true)->comment('Метадані');
            $table->string('title')->nullable(false)->comment('Назва');
            $table->text('description')->nullable(false)->comment('Опис');
            $table->dateTime('start_at')->nullable(false)->comment('Початок');
            $table->dateTime('end_at')->nullable(false)->comment('Кінець');
            $table->unsignedInteger('price')->nullable(false)->comment('Ціна');
            $table->timestamps();

            $table->foreign('hall_id')->references('id')->on('halls')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shows');
    }
};
