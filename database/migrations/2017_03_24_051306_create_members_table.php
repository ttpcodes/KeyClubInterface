<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
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
            $table->integer('user_id');
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
