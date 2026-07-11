<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_id')->constrained('providers')->onDelete('cascade');
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->decimal('total_amount', 15, 2);
            $table->enum('status', ['pending', 'approved', 'accepted', 'declined','completed'])->default('pending');
            $table->date('expected_end_date')->nullable();
            $table->integer('total_days')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
