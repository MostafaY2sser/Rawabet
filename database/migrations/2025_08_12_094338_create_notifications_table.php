<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    public function up()
{
    Schema::create('notifications', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('description')->nullable();
        $table->string('url')->nullable();
        $table->boolean('seen')->default(false);
        $table->text("icon");
        $table->string('class'); 

        $table->string('resever_type'); // Type of the resever (e.g., App\Models\Provider)
        $table->unsignedBigInteger('resever_id'); 
        $table->timestamps();
    });
}


    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
