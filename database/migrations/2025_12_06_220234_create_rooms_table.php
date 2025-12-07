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
        Schema::create('rooms', function (Blueprint $table) {

            // 主キー（自動 increment の bigint）
            $table->id()->comment('ID');

            // 部屋タイプ名（例：プレミアム、スタンダード）※ユニーク
            $table->string('type_name', 100)->unique()->comment('タイプ名（例：プレミアム、スタンダード）');

            // 部屋タイプの説明（NULL 許可）
            $table->text('description')->nullable()->comment('部屋タイプの説明');

            // 1泊あたりの料金
            $table->integer('price')->default(0)->comment('1泊あたり料金');

            // 最大宿泊人数（デフォルト4人）
            $table->integer('capacity')->default(4)->comment('最大宿泊人数（最大4名）');

            // 同タイプの部屋総数（例: プレミアム: 2室, スタンダード: 3室）
            $table->integer('total_rooms')->default(1)->comment('同タイプの部屋総数');

            // プラン（将来拡張用：0=素泊まり）
            $table->tinyInteger('plan')->default(0)->comment('プラン（0=素泊まり）将来用');

            // created_at, updated_at
            $table->timestamps();

            // 論理削除用（deleted_at カラム追加）
            $table->softDeletes()->comment('論理削除用（削除日時）将来用');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
