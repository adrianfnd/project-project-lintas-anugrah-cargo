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
        Schema::create('paket', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('tracking_number')->unique();
            $table->string('sender_name');
            $table->text('sender_address');
            $table->decimal('sender_latitude', 10, 8);
            $table->decimal('sender_longitude', 11, 8);
            $table->string('receiver_name');
            $table->text('receiver_address');
            $table->decimal('receiver_latitude', 10, 8);
            $table->decimal('receiver_longitude', 11, 8);
            $table->decimal('weight', 10, 2);
            $table->string('dimensions');
            $table->text('description');
            $table->string('image');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket');
    }
};