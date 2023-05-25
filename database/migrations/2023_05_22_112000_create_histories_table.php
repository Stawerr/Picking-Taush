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
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->enum('log_type', ['success', 'error']);
            $table->string('reference');
            $table->foreignId('picking_id')->nullable()->constrained();
            $table->foreignId('taush_id')->nullable()->constrained();
            $table->dateTime('scan_date_time');
            $table->string('log_message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
