<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('regions', function (Blueprint $table) {
            // Drop foreign key first, then index, then column
            $table->dropForeign(['city_id']);
            $table->dropIndex(['city_id']); // or dropIndex('regions_city_id_index') if named
            $table->dropColumn('city_id');
        });
    }

    public function down(): void
    {
        Schema::table('regions', function (Blueprint $table) {
            $table->unsignedBigInteger('city_id')->nullable()->after('id');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->index('city_id', 'regions_city_id_index');
        });
    }
};
