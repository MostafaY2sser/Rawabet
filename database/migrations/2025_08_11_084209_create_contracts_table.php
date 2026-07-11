<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_id')->nullable()->constrained('offers')->onDelete('set null');
            $table->decimal('deposit', 10, 2);
            $table->decimal('remaining', 10, 2);
            $table->boolean('deposit_paid')->default(false);
            $table->boolean('signtured')->default(false);
            $table->boolean('mobile_verified')->default(false);
            $table->string("mobile_verification")->default('');
            $table->enum('status', ['pending', 'active', 'cancelled'])->default('pending');
$table->text('signture')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
