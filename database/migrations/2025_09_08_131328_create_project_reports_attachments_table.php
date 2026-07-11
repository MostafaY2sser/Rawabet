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
        Schema::create('project_reports_attachments', function (Blueprint $table) {
             $table->id();
            $table->foreignId('report_id')->constrained('project_reports')->onDelete('cascade');
            $table->string('file_path'); // Path to the file in storage
            $table->string('file_name'); // Original name of the file
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_reports_attachments');
    }
};
