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
        Schema::create('provider_specializations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id');
            $table->unsignedBigInteger('specialization_id');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('provider_id')
                ->references('id')
                ->on('providers')
                ->onDelete('cascade');

            $table->foreign('specialization_id')
                ->references('id')
                ->on('specialities')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_specializations');
    }
};
