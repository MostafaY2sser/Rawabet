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
        Schema::table('projects', function (Blueprint $table) {
             $table->date('open_for_offers_date')->nullable()->after('id'); 

             $table->date('accept_offer_date')->nullable()->after('id'); 

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
                        $table->dropColumn('open_for_offers_date');
                        $table->dropColumn('accept_offer_date');
        });
    }
};
