<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultantsTable extends Migration
{
    public function up()
    {
       Schema::create('consultants', function (Blueprint $table) {
    $table->id();
    $table->string('fullname');
    $table->string('avatar')->nullable();
    $table->foreignId('specialty_id')
          ->nullable()
          ->constrained('specialities')
          ->onDelete('set null');
    $table->string('identity_number')->unique();
    $table->integer('experience_years');
    $table->text('certificates')->nullable();
    $table->string('email')->unique();
    $table->string('phone_number')->unique();
    $table->timestamps();
});
    }
    public function down()
    {
        Schema::dropIfExists('consultants');
    }
}
