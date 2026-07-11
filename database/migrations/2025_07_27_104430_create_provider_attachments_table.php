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
        Schema::create('provider_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id');
            $table->string('file_path'); // Path to the file in storage
            $table->string('file_name'); // Original name of the file
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('provider_id')
                ->references('id')
                ->on('providers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_attachments');
    }
};
