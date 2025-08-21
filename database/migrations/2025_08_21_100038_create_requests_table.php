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
        Schema::create('requests', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id')->constrained('users', 'id');
            $table->foreignUlid('request_type_id')->constrained('request_types', 'id');
            $table->string('name', 250);
            $table->text('description');
            $table->date('date_needed');
            $table->text('attachment')->nullable();
            $table->ulidMorphs('receivable');
            $table->enum('status', ['pending', 'approved', 'disapproved', 'completed', 'cancelled'])->default('pending');
            $table->date('approved_date')->nullable();
            $table->foreignUlid('approved_by')->nullable()->constrained('users', 'id');
            $table->date('disapproved_date')->nullable();
            $table->foreignUlid('disapproved_by')->nullable()->constrained('users', 'id');
            $table->text('reason')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
