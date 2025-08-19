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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('ulid')->unique();
            $table->string('barcode');
            $table->string('order_number')->nullable();
            $table->string('part_number')->nullable();
            $table->string('sequence')->nullable();
            $table->string('standard_pack')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'validated'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
