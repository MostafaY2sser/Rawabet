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
        Schema::create('partners_discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->float('price');
            $table->foreignId('section_id')->constrained('partners_discounts_sections')->onDelete('cascade');
            $table->foreignId('partner_id')->constrained('partners')->onDelete('cascade');
            $table->integer('discount');
            $table->float('shipping_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners_discounts');
    }
};
