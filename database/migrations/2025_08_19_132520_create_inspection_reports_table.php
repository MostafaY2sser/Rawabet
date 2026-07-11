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
        Schema::create('inspection_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inspection_id'); 
            $table->integer('rate')->nullable(); 
            $table->string('result_summary')->nullable();
            $table->text('features')->nullable();
            $table->text('recommendations')->nullable();
            $table->longText('details')->nullable();
            $table->timestamps();

            $table->foreign('inspection_id')->references('id')->on('inspections')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_reports');
    }

};
