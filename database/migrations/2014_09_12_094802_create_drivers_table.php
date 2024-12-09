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
        Schema::create('drivers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('created_by');
            $table->foreign('created_by')->references('id')->on('admins');
            $table->string('name');
            $table->string('image');
            $table->string('phone_number')->unique();
            $table->string('license_number');
            $table->string('vehicle_name');
            $table->text('address')->nullable();
            $table->string('status')->default('menunggu');
            $table->integer('rate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
