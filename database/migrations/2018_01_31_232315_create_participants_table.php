<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateParticipantsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('participants', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('first_name');
			$table->string('last_name');
			$table->date('dob');
			$table->boolean('gender');
			$table->boolean('language');
			$table->boolean('diet');
			$table->boolean('acc_type');
			$table->boolean('acc_single_room');
			$table->boolean('acc_free_parent');
			$table->timestamps();
			$table->integer('group_id')->unsigned()->index('group_id_foreign_key');
			$table->date('arrival_date')->nullable();
			$table->text('arrival_meal')->nullable();
			$table->date('departure_date')->nullable();
			$table->text('departure_meal')->nullable();
			$table->text('full_stay');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('participants');
	}

}
