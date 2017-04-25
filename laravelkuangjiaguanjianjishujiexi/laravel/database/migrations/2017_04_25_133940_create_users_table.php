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
        //
		Schema::create('users',function(Blueprint $table){
			$table->increments('id');
			$table->string('username',32);
			$table->string('account',32);
			$table->string('password',60);
			$table->rememberToken();
			$table->unsignedInteger('addtime');
			$table->tinyInteger('state')->unsigned()->default(1);
		});

		Schema::create('tb_category',function(Blueprint $table){
			$table->increments('id');
			$table->string('name',32);
			$table->unsignedInteger('count')->default(0);
			$table->integer('uid');
			$table->tinyInteger('state')->unsigned()->default(1);
		});

		Schema::create('tb_records',function(Blueprint $table){
			$table->increments('id');
			$table->string('title',64);
			$table->text('content')->nullable();
			$table->integer('cid');
			$table->integer('uid');
			$table->unsignedInteger('addtime')->default(0);
			$table->tinyInteger('state')->default(1)->unsigned();
		});



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
		Schema::drop('tb_category');
		Schema::drop('tb_records');
		Schema::drop('users');
    }
}
