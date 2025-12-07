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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            // 予約者(ユーザーID)
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // 部屋(部屋ID)
            $table->foreignId('room_id')
                  ->constrained('rooms')
                  ->onDelete('cascade');

            //宿泊日(チェックインのみ)
            $table->date('check_in');

            // 宿泊人数(1～4名)
            $table->unsignedTinyInteger('guests')->defult(1);

            // 予約時の料金(コピー保存)
            $table->unsignedInteger('total_price');

            // 状態(confirmed / cancelled)
            $table->enum('status',['confirmed','cancelled'])
                  ->default('confirmed');

            $table->timestamps();

            // 空室判定用
            $table->index(['room_id', 'check_in']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
