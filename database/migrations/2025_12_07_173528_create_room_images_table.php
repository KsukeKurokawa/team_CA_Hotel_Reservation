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
        Schema::create('room_images', function (Blueprint $table) {
            // 主キー
            $table->id()->comment('ID');

            // 外部キー
            $table->foreignId('room_id')
                ->constrained('rooms')
                ->onDelete('cascade')
                ->comment('対応する部屋タイプID');

            // 画像URL
            $table->string('image_url', 255)->comment('画像URL');

            // 表示順 
            $table->tinyInteger('sort_order')->default(1)->comment('表示順');

            // 登録日時・更新日時
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_images');
    }
};
