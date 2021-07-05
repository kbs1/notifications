<?php

namespace App\Http\Controllers\Api\v1;

use App\Services\Factory as ServiceFactory;

use App\Http\Requests\SyncServiceRequest;
use App\Http\Controllers\Controller;

class ServicesController extends Controller
{
	public function sync(SyncServiceRequest $request)
	{
		$attributes = $request->validated();

		$service = ServiceFactory::make($request->input('type'));
		$attributes['data'] = $request->validate($service->serviceValidationRules());

		$client = $request->user();

		if ($service = $client->services()->whereName($request->input('name'))->first()) {
			$service->fill($attributes);
			$service->save();
		} else {
			$service = $client->services()->create($attributes);
		}

		return response()->json(['success' => true, 'service' => $service->only('id', 'name')]);
	}
}
