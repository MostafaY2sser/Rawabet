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
        Schema::table('projects', function (Blueprint $table) {
            // لإعادة تعريف enum بقيم جديدة - استخدم change()
            $table->enum('status', [
                'require_complete',
                'pending',
                'accepted',
                'first_inspection_scheduled',
                'first_inspection_completed',
                'open_for_offers',
                'in_progress',
                'completed',
                'cancelled',
            ])->default('require_complete')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // إعادة الحقل إلى القيم الأصلية في حال التراجع
            $table->enum('status', [
                'require_complete',
                'pending',
                'completed',
                'cancelled',
            ])->default('require_complete')->change();
        });
    }
};
