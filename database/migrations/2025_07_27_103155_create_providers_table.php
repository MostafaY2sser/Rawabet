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
        Schema::create('providers', function (Blueprint $table) {
            $table->id();

            // step 1
            $table->string('company_name')->nullable();
            $table->integer('legal_entity_type');
            $table->string('owner_id');
            $table->string('commercial_registration');
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
               $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');

            // Foreign key to regions table
            $table->unsignedBigInteger('region_id')->nullable();
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('set null');
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();






            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};
