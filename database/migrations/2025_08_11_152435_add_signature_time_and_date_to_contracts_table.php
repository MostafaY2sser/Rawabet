<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSignatureTimeAndDateToContractsTable extends Migration
{
    public function up()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->date('signature_date')->nullable()->after('updated_at');
            $table->time('signature_time')->nullable()->after('signature_date');
            $table->string("reference");
        });
    }

    public function down()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn('signature_date');
            $table->dropColumn('signature_time');
            $table->dropColumn('refrence');

        });
    }
}
