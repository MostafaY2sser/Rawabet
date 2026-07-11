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
        Schema::create('customers', function (Blueprint $table) {
            // step one
            $table->id();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone_number');
            $table->string('national_id');
            $table->timestamp('email_verified_at')->nullable();

            $table->integer('step')->default(1);
            // step two
            $table->tinyInteger('account_verfication')->default(0);

            // step three

            $table->string('personal_image')->nullable();
            $table->string('address')->nullable();

            // Foreign key to cities table
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');

            // Foreign key to regions table
            $table->unsignedBigInteger('region_id')->nullable();
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('set null');

            $table->string('payment_method')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
