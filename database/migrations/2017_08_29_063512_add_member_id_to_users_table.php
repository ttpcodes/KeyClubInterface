<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMemberIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * The philosophy of this application has changed so that the main purpose is
     * member tracking and not necessarily users having access to members by
     * default. Therefore, members have users instead of the relationship being
     * reversed. This is part 2/2 for the database changes.
     * Finalized: August 29, 2017
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('member_id');

            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_member_id_foreign');
            $table->dropColumn('member_id');
        });
    }
}
