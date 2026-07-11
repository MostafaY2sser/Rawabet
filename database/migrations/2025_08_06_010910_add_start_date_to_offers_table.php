<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->date('start_date')->nullable()->after('id'); // adjust position with `after()` if needed
        });
    }

    public function down(): void
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn('start_date');
        });
    }
};
