<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUserIdFromMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * The philosophy of this application has changed so that the main purpose is
     * member tracking and not necessarily users having access to members by
     * default. Therefore, members have users instead of the relationship being
     * reversed. This is part 1/2 for the database changes.
     * Finalized: August 29, 2017
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropForeign('members_user_id_foreign');
            $table->dropColumn('user_id');
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
            $table->unsignedInteger('user_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
