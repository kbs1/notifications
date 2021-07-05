<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Notifications\Notification;

class SendNotification implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected $tries = 5;
	protected $timeout = 30;
	public $failOnTimeout = true;

	protected $notification_id;

	public function __construct(int $notification_id)
	{
		$this->notification_id = $notification_id;
	}

	public function handle()
	{
		$notification = Notification::findOrFail($this->notification_id);
		$handler = $notification->service->handler();

		$handler->sendNotification($notification);
		$handler->callNotificationWebhook($notification, 'success');
	}

	public function failed(\Throwable $exception)
	{
		$notification = Notification::find($this->notification_id);

		if (!$notification)
			return;

		$notification->service->handler()->callNotificationWebhook($notification, 'failure', $ex);
	}
}
