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
        Schema::create('notifications', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('type');
            $table->ulidMorphs('notifiable');
            $table->text('data');
            $table->timestamps();
        });

        Schema::create('notification_users', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('notification_id')->constrained('notifications', 'id');
            $table->foreignUlid('user_id')->constrained('users', 'id');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_users');
        Schema::dropIfExists('notifications');
    }
};
