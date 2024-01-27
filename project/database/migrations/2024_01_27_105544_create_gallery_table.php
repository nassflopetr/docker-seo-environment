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
        Schema::create('gallery', function (Blueprint $table) {
            $table->comment('Галерея зображень для кожної із вистав');

            $table->id();
            $table->unsignedBigInteger('show_id')->nullable(false)->comment('Вистава');
            $table->string('src')->nullable(false)->comment('Посилання на зображення');
            $table->text('alt')->nullable(false)->comment('Альтернативний текст зображення');
            $table->timestamps();

            $table->foreign('show_id')->references('id')->on('shows')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery');
    }
};
