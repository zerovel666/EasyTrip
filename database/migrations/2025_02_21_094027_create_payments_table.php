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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('num_pay');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('phone');
            $table->string('email');
            $table->string('full_name');
            $table->string('type');
            $table->string('num_card');
            $table->string('fn_mn_card');
            $table->string('trip_name');
            $table->float('amount');
            $table->string('currency')->default('KZT');
            $table->boolean('paid')->default(true);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
