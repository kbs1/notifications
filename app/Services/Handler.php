<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Notifications\Notification;
use App\Jobs\SendNotification;

abstract class Handler
{
	protected $model;

	public function __construct(Service $service = null)
	{
		$this->model = $service;
	}

	public function setModel(Service $service)
	{
		$this->model = $service;
	}

	public function model()
	{
		return $this->model;
	}

	public function client()
	{
		return $this->model()->client;
	}

	public function applyReplacements(string $subject, array $replacements): string
	{
		return strtr($subject, $replacements);
	}

	public function queueNotification(Request $request): Notification
	{
		$client = $this->client();
		$attachments = (array) $request->input('attachments');
		$template = $client->templates()->whereName($request->input('template'))->firstOrFail();

		$notification = $client->notifications()->create([
			'service_id' => $this->model()->id,
			'template_id' => $template->id,
			'title' => $this->applyReplacements($template->title, (array) $request->input('replacements')),
			'body' => $this->applyReplacements($template->body, (array) $request->input('replacements')),
			'data' => $request->validate($this->notificationValidationRules()),
			'attachments' => count($attachments) ? $client->attachments()->whereIn('id', $attachments)->pluck('id') : [],
			'scheduled_at' => $request->input('scheduled_at', now()),
			'webhook_success_url' => $request->input('webhook_success_url'),
			'webhook_failure_url' => $request->input('webhook_failure_url'),
		]);

		SendNotification::dispatch($notification->id)->delay($notification->scheduled_at);

		return $notification;
	}

	public function callNotificationWebhook(Notification $notification, string $type, \Throwable $ex = null): void
	{
		if ((string) $notification->{"webhook_{$type}_url"} === '')
			return;

		@file_get_contents($notification->{"webhook_{$type}_url"}, false, stream_context_create([
			'http' => [
				'timeout' => 5,
				'method' => 'POST',
				'header' => 'Content-Type: application/json',
				'content' => json_encode($ex ?? $notification->only('id')),
			],
		]));
	}

	abstract public function serviceValidationRules(): array;
	abstract public function notificationValidationRules(): array;

	abstract public function sendNotification(Notification $notification): void;
}
