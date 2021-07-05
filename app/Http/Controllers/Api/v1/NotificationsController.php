<?php

namespace App\Http\Controllers\Api\v1;

use App\Services\Factory as ServiceFactory;

use App\Http\Requests\SendNotificationRequest;
use App\Http\Controllers\Controller;

class NotificationsController extends Controller
{
	public function send(SendNotificationRequest $request)
	{
		$client = $request->user();
		$service = $client->services()->whereName($request->input('service'))->firstOrFail();
		$handler = $service->handler();

		$notification = $handler->queueNotification($request);

		return response()->json(['success' => true, 'notification' => $notification->only('id')]);
	}
}
