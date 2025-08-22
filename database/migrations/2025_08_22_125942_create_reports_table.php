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
        Schema::create('reports', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('barangay_id')->constrained('barangays', 'id');
            $table->foreignUlid('user_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->string('subject');
            $table->text('description');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('attachments', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('report_id')->constrained('reports', 'id')->cascadeOnDelete();
            $table->text('attachment');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
        Schema::dropIfExists('reports');
    }
};
