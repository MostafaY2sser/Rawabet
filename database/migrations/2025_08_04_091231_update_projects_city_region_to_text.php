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
            // Drop foreign key constraints first
            $table->dropForeign(['city_id']);
            $table->dropForeign(['region_id']);

            // Drop the old unsignedBigInteger columns
            $table->dropColumn(['city_id', 'region_id']);

            // Add new string (text) columns
            $table->string('city')->nullable()->after('category_id')->comment('City name as text');
            $table->string('region')->nullable()->after('city')->comment('Region name as text');

            // Add country text field
            $table->string('country')->nullable()->after('region')->comment('Country name as text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Drop the text fields
            $table->dropColumn(['city', 'region', 'country']);

            // Recreate the old foreign key fields
            $table->unsignedBigInteger('city_id')->nullable()->comment('Related city');
            $table->unsignedBigInteger('region_id')->nullable()->comment('Related region');

            $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('set null');
        });
    }
};
