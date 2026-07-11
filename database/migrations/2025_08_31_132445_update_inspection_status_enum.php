<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Update existing values to match new enum values
   
        // 2. Change the enum definition
        DB::statement("ALTER TABLE inspections MODIFY status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
  // Revert enum definition
        DB::statement("ALTER TABLE inspections MODIFY status ENUM('pending', 'approved', 'declined') DEFAULT 'pending'");
    }
};
