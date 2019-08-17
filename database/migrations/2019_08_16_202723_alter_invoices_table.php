<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('event_id');
            $table->dropColumn('club_id');
            $table->integer('participation_id')->unsigned()->after('paid');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->integer('event_id')->unsigned()->after('paid');
            $table->integer('club_id')->unsigned()->after('paid');
            $table->dropColumn('participation_id');
        });
    }
}
