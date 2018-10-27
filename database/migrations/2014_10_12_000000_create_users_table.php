<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('xid');
            $table->string('id')->unique();
            $table->string('user_id');
            $table->integer('level')->default(0);
            $table->string('name');
            $table->string('phone');
            $table->string('password');
            $table->string('address_postcode');
            $table->string('address_roadAddress');
            $table->string('address_jibunAddress');
            $table->string('address_detail');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
