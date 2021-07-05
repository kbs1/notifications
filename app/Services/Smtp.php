<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Notifications\Notification;

class Smtp extends Handler
{
	public function serviceValidationRules(): array
	{
		return [
			'host' => 'required',
			'port' => 'required|integer|min:1|max:65535',
			'encryption' => 'nullable|in:ssl,tls',
			'username' => 'required',
			'password' => 'required',
			'from_address' => 'required|email',
			'from_name' => 'nullable',
		];
	}

	public function notificationValidationRules(): array
	{
		return [
			'to.*' => 'required|email',
			'cc.*' => 'nullable|email',
			'bcc.*' => 'nullable|email',
			'reply_to' => 'nullable|email',
		];
	}

	public function sendNotification(Notification $notification): void
	{
		$service = $this->model();
		$service_data = $service['data'];
		$data = $notification['data'];

		$transport = new \Swift_SmtpTransport($service_data['host'], $service_data['port'], $service_data['encryption']);
		$transport->setUsername($service_data['username']);
		$transport->setPassword($service_data['password']);

		$mailer = new \Swift_Mailer($transport);
		$message = (new \Swift_Message($notification->title));

		if (($service_data['from_name'] ?? null) !== null)
			$message->setFrom([$service_data['from_address'] => $service_data['from_name']]);
		else
			$message->setFrom($service_data['from_address']);

		$message->setTo($data['to']);

		if ($data['cc'] ?? [])
			$message->setCc($data['cc']);

		if ($data['bcc'] ?? [])
			$message->setBcc($data['bcc']);

		$message->setBody($notification->body);

		if (count($notification->attachments)) {
			foreach ($notification->attachments as $id) {
				if ($attachment = $service->client->attachments()->find($id)) {
					$message->attach(\Swift_Attachment::fromPath(storage_path('app/attachments/' . $attachment->md5))->setFilename($attachment->filename));
				}
			}
		}

		if (($data['reply_to'] ?? null) !== null)
			$message->setReplyTo($data['reply_to']);

		$mailer->send($message, $failures);

		if (count($failures))
			throw new \RuntimeException("Unable to send notification, failures: " . implode(', ', $failures));

		$notification->sent_at = now();
		$notification->save();
	}
}
