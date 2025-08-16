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
        Schema::create('barangays', function (Blueprint $table) {
            $table->id();
            $table->string('province_code');
            $table->string('municipality_code');
            $table->string('code')->unique();
            $table->string('name');
            $table->timestamps();

            $table->foreign('province_code')->references('code')->on('provinces');
            $table->foreign('municipality_code')->references('code')->on('municipalities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangays');
    }
};
