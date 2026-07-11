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
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();

            // Related contract (optional, based on your previous migrations)
            $table->foreignId('contract_id')->nullable()->constrained('contracts')->onDelete('cascade');

            // Polymorphic sender (formerly "payer")
            $table->string('sender_type');
            $table->unsignedBigInteger('sender_id');
            $table->index(['sender_type', 'sender_id']);

            // Polymorphic beneficiary (receiver)
            $table->string('beneficiary_type');
            $table->unsignedBigInteger('beneficiary_id');
            $table->index(['beneficiary_type', 'beneficiary_id']);

            // Transaction details
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'completed', 'failed','hold']);
            $table->string('method')->nullable(); // e.g., card, bank, wallet
            $table->string('transaction_reference')->unique();
            $table->text('response')->nullable(); // gateway or internal response

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
