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
        Schema::create('inspection_reports_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('report_id');
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('file_path')->nullable(); 
            $table->timestamps();

            $table->foreign('report_id')->references('id')->on('inspection_reports')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_reports_attachments');
    }
};
