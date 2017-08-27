<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * These migrations create the members table, which defines information for club members
     * as well as the relationship between a user account and a member instance.
     *
     * Finalized: August 24, 2017
     * Edited on August 26, 2017 due to breaking issues with signed integer user_id
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->unsignedInteger('id')->unique();
            $table->string('first');
            $table->string('last');
            $table->string('nickname')->nullable();
            $table->string('suffix')->nullable();
            $table->string('email');
            $table->string('address1');
            $table->string('address2')->nullable();
            $table->string('city');
            $table->string('country');
            $table->string('state');
            $table->string('postal');
            $table->string('graduation');
            $table->string('phone');
            $table->date('birth');
            $table->string('gender');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('members');
        Schema::enableForeignKeyConstraints();
    }
}
