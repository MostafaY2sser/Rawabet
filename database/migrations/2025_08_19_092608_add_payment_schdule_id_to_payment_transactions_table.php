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
        Schema::table('payment_transactions', function (Blueprint $table) {
              $table->foreignId('payment_schedule_id')
                ->nullable()
                ->constrained('payment_schedules')
                ->onDelete('set null')
                ->after('contract_id'); // place it logically near related fields
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_transactions', function (Blueprint $table) {
                    $table->dropForeign(['payment_schedule_id']);
            $table->dropColumn('payment_schedule_id');
        });
    }
};
