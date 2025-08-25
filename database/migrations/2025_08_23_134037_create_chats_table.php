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
        Schema::create('chats', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('created_by')->constrained('users', 'id')->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->enum('type', ['private', 'group']);
            $table->text('last_message')->nullable();
            $table->timestamp('last_message_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('chat_participants', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('chat_id')->constrained('chats', 'id')->cascadeOnDelete();
            $table->foreignUlid('user_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('chat_pairs', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('chat_id')->constrained('chats', 'id')->cascadeOnDelete();
            $table->foreignUlid('sender_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignUlid('receiver_id')->constrained('users', 'id')->cascadeOnDelete();
        });

        Schema::create('chat_messages', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('chat_id')->constrained('chats', 'id')->cascadeOnDelete();
            $table->foreignUlid('user_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->text('message')->nullable();
            $table->text('attachment')->nullable();
            $table->timestamps();
        });

        Schema::create('chat_message_reads', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('chat_message_id')->constrained('chat_messages', 'id')->cascadeOnDelete();
            $table->foreignUlid('user_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->timestamp('read_at')->nullable();

            $table->unique(['chat_message_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_pairs');
        Schema::dropIfExists('chat_message_reads');
        Schema::dropIfExists('chat_participants');
        Schema::dropIfExists('chat_messages');
        Schema::dropIfExists('chats');
    }
};
