<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE offers MODIFY status ENUM('pending', 'approved', 'accepted', 'declined', 'completed', 'draft') DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("UPDATE offers SET status = 'pending' WHERE status = 'draft'");
        DB::statement("ALTER TABLE offers MODIFY status ENUM('pending', 'approved', 'accepted', 'declined', 'completed') DEFAULT 'pending'");
    }
};
