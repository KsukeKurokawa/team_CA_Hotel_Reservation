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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // PK
            $table->string('name', 100); // 必須
            $table->string('email', 255)->unique(); // 必須 + unique
            $table->string('phone', 20); // 必須
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255); // 必須
            $table->string('role', 20)->default('customer')->index(); // 必須 + default + index
            $table->string('status', 20)->default('active'); // 必須 + default
            $table->timestamp('last_login_at')->nullable(); // NULL可
            $table->softDeletes(); // deleted_at + index
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
