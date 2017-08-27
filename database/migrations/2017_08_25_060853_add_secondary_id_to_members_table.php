<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSecondaryIdToMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * This migration makes various fixes to IDs defined in the members schema.
     * user_id is now nullable (not all members have accounts) and is tracked using
     * an unsigned integer.
     * secondary_id is added for clubs that optionally need a second ID
     * for tracking. For example, Key Club maintains a student ID and an organizational
     * ID.
     * Various fields have appropriately been converted to nullable for other organizational
     * uses.
     * Finalized: August 27, 2017
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable()->change();
            $table->unsignedInteger('secondary_id')->nullable();
            $table->unsignedInteger('postal')->nullable()->change();
            $table->string('address1')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('country')->nullable()->change();
            $table->string('state')->nullable()->change();
            $table->date('birth')->nullable()->change();
            $table->string('gender')->nullable()->change();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropForeign('members_user_id_foreign');
            $table->integer('postal')->change();
            $table->dropColumn('secondary_id');
        });
    }
}
