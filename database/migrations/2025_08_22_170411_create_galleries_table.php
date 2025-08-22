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
        Schema::create('galleries', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('gallery_images', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('gallery_id')->constrained('galleries', 'id')->cascadeOnDelete();
            $table->string('image_url');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_images');
        Schema::dropIfExists('galleries');
    }
};
