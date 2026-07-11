<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('offer_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->foreignId('offer_id')->constrained('offers')->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->decimal('amount_percentage', 5, 2)->nullable();
            $table->integer('total_days')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offer_items');
    }
};
