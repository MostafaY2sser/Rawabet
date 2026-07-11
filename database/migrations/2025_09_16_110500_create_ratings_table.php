<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
   public function up()
{
    Schema::create('ratings', function (Blueprint $table) {
        $table->id();

        // Who is rating (customer or provider)
        $table->unsignedBigInteger('rater_id');
        $table->string('rater_type');

        // The project or context (optional)
        $table->unsignedBigInteger('project_id')->nullable();

        // When rating a provider (contractor)
        $table->tinyInteger('contractor_rating')->nullable()->comment('تقييم المقاول');
        $table->text('contractor_comment')->nullable()->comment('ملاحظات عن المقاول');

        // When rating a customer
        $table->tinyInteger('customer_rating')->nullable()->comment('تقييم العميل');
        $table->text('customer_comment')->nullable()->comment('ملاحظات عن العميل');

        // Additional rating categories — all nullable integers from 1 to 5
        $table->tinyInteger('quality_rating')->nullable()->comment('جودة العمل');
        $table->text('quality_comment')->nullable()->comment('ملاحظات عن جودة العمل');

        $table->tinyInteger('punctuality_rating')->nullable()->comment('الالتزام بالمواعيد');
        $table->text('punctuality_comment')->nullable()->comment('ملاحظات عن الالتزام بالمواعيد');

        $table->tinyInteger('communication_rating')->nullable()->comment('التواصل والاحترافية');
        $table->text('communication_comment')->nullable()->comment('ملاحظات عن التواصل والاحترافية');

        $table->tinyInteger('platform_rating')->nullable()->comment('تقييم المنصة والخدمة');
        $table->text('platform_comment')->nullable()->comment('ملاحظات عن تقييم المنصة والخدمة');

        // Optional general notes about the rating
        $table->text('general_notes')->nullable()->comment('ملاحظات عامة');

        $table->timestamps();

        // Indexes to optimize polymorphic queries
        $table->index(['rater_id', 'rater_type']);
    });
}


    public function down()
    {
        Schema::dropIfExists('ratings');
    }
}
