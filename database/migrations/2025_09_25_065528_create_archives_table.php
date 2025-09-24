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
        Schema::create('archives', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulidMorphs('archivable');
            $table->foreignUlid('archived_by')->constrained('users', 'id')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->enum('status', ['upcoming', 'ongoing', 'completed', 'cancelled', 'archived'])
                ->default('upcoming')
                ->change();
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->enum('status', ['active', 'archived'])
                ->default('active')
                ->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archives');

        Schema::table('events', function (Blueprint $table) {
            $table->enum('status', ['upcoming', 'ongoing', 'completed', 'cancelled'])
                ->default('upcoming')
                ->change();
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
