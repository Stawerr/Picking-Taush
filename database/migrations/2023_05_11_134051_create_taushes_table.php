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
        Schema::create('taushes', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('department');
            $table->boolean('digitalized')->default(false);
            $table->string('scan_date')->nullable();
            $table->string('last_scan_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taushes');
    }
};
