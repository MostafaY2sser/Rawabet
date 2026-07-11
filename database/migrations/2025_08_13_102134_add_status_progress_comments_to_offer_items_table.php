<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('offer_items', function (Blueprint $table) {
            $table->enum('status', ['pending', 'active', 'completed','request_payment','paid'])->default('pending')->after('total_days');
            $table->decimal('progress', 5, 2)->default(0)->after('status');
            $table->text('comments')->nullable()->after('progress');
            $table->date('end_date')->nullable()->after('start_date');
        });
    }

    public function down(): void
    {
        Schema::table('offer_items', function (Blueprint $table) {
            $table->dropColumn(['status', 'progress', 'comments','end_date']);
        });
    }
};
