<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('services', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->foreignId('client_id')->constrained('clients');
			$table->string('name');
			$table->enum('type', ['smtp', 'twilio_sms', 'one_signal']);
			$table->json('data')->nullable();
			$table->timestamps();

			$table->unique(['client_id', 'name']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('services');
	}
}
