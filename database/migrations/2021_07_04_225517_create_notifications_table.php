<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notifications', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->foreignId('client_id')->constrained('clients');
			$table->foreignId('service_id')->constrained('services');
			$table->foreignId('template_id')->constrained('templates');
			$table->longText('title');
			$table->longText('body');
			$table->json('data');
			$table->json('attachments')->nullable();
			$table->timestamp('scheduled_at')->useCurrent();
			$table->timestamp('sent_at')->nullable();
			$table->text('webhook_success_url')->nullable();
			$table->text('webhook_failure_url')->nullable();
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
		Schema::dropIfExists('notifications');
	}
}
