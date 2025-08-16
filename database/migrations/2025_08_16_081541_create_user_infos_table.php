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
        Schema::create('user_infos', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id')->constrained('users', 'id');
            $table->foreignUlid('position_id')->nullable()->constrained('positions', 'id');
            $table->string('firstname', 100);
            $table->string('middlename', 100)->nullable();
            $table->string('lastname', 100);
            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->integer('age')->nullable();
            $table->string('phone_number', 11)->nullable();
            $table->date('birthdate')->nullable();
            $table->string('province_code')->nullable();
            $table->string('municipality_code')->nullable();
            $table->string('barangay_code')->nullable();
            $table->string('addtional_address')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('province_code')->references('code')->on('provinces');
            $table->foreign('municipality_code')->references('code')->on('municipalities');
            $table->foreign('barangay_code')->references('code')->on('barangays');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_infos');
    }
};
