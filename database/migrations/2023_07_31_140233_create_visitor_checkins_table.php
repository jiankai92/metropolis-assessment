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
        Schema::create('visitor_checkins', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64);
            $table->string('type', 16);
            $table->string('vehicle_reg_no', 16)->nullable();
            $table->text('remarks')->nullable();
            $table->datetime('checkout_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_checkins');
    }
};
