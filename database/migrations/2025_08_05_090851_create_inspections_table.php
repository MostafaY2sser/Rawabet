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
    Schema::create('inspections', function (Blueprint $table) {
        $table->id();

        // Relations
        $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('set null');

        // Current confirmed schedule
        $table->date('date');
        $table->time('time');

        // Requested changes by customer
        $table->date('requested_date')->nullable();
        $table->time('requested_time')->nullable();

        $table->enum('status', ['pending', 'approved', 'declined'])->default('pending');

        // Type of inspection
        $table->enum('type', ['first_inspection', 'item_inspection']);

        $table->timestamps();
    });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
