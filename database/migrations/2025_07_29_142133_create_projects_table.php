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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            // Project type (not a foreign key)
            $table->unsignedBigInteger('project_type')->nullable()->comment('Type of project');
            $table->foreign('project_type')->references('id')->on('project_types')->onDelete('set null');

            // Service details
            $table->unsignedBigInteger('service_type')->nullable()->comment('Type of service requested');
            $table->foreign('service_type')->references('id')->on('specialities')->onDelete('set null');

            $table->string('address')->nullable()->comment('Service location address');
            $table->decimal('latitude', 10, 7)->nullable()->comment('Latitude of service location');
            $table->decimal('longitude', 10, 7)->nullable()->comment('Longitude of service location');
            $table->unsignedBigInteger('building_type')->nullable()->comment('Type of building');
            $table->foreign('building_type')->references('id')->on('building_types')->onDelete('set null');

            $table->foreignId('consultant_id')->nullable()->constrained('consultants')->onDelete('set null');

            // Category of work (foreign key to categories)
            $table->unsignedBigInteger('category_id')->nullable()->comment('Category of work');
            $table->foreign('category_id')->references('id')->on('project_categories')->onDelete('set null');

            // Add other foreign keys if needed — e.g., region, city, provider
            $table->unsignedBigInteger('city_id')->nullable()->comment('Related city');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');

            $table->unsignedBigInteger('region_id')->nullable()->comment('Related region');
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('set null');

            $table->unsignedBigInteger('provider_id')->nullable()->comment('Assigned provider');
            $table->foreign('provider_id')->references('id')->on('providers')->onDelete('set null');

            $table->longText('work_description')->nullable()->comment('Detailed description of the work');

            // Budget & timeline
            $table->decimal('budget', 15, 2)->comment('Estimated budget')->nullable();
            $table->date('start_date')->comment('Expected project start date')->nullable();
            $table->integer('duration')->comment('Expected duration or timeframe in months')->nullable();

            $table->enum('status', ['require_complete', 'pending', 'completed', 'cancelled'])->default('require_complete');
            $table->integer('step')->default(1);
            $table->string('reference_number')->nullable();
            // Timestamps

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
