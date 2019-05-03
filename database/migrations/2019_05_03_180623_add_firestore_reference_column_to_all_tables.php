<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFirestoreReferenceColumnToAllTables extends Migration
{

    protected $tables = ['zones', 'clubs','activities', 'events', 'fields', 'members', 'positions', 'profiles','units'];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tables as $table){
            Schema::table($table, function (Blueprint $table) {
                $table->string('firestore_reference')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->tables as $table){
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('firestore_reference');
            });
        }
    }
}
