<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameEventablesTableByParticipants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('eventables', 'participants');
        Schema::table('participants', function (Blueprint $table) {
            $table->json('snapshot')->nullable()->after('eventable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->dropColumn('snapshot');
        });
        Schema::rename('participants', 'eventables');
    }
}
