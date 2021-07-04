<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplatesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('templates', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->foreignId('service_id')->constrained('services');
			$table->string('name');
			$table->longText('title');
			$table->longText('body');
			$table->json('replacements')->nullable();
			$table->text('webhook_success_url')->nullable();
			$table->text('webhook_failure_url')->nullable();
			$table->timestamps();

			$table->unique(['service_id', 'name']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('templates');
	}
}
