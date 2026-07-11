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
        Schema::table('payment_schedules', function (Blueprint $table) {
            $table->enum('type', ['stage', 'deposite'])->after('percentage')->default('deposite');
            $table->enum('status', ['paid', 'pending'])->after('type')->default('pending');

            $table->foreignId('stage_id')->nullable()->after('type')->constrained('offer_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_schedules', function (Blueprint $table) {
            $table->dropForeign(['stage_id']);
            $table->dropColumn(['type', 'stage_id']);
        });
    }
};
