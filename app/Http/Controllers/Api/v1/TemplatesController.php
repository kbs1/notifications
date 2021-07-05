<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\SyncTemplateRequest;
use App\Http\Controllers\Controller;

class TemplatesController extends Controller
{
	public function sync(SyncTemplateRequest $request)
	{
		$client = $request->user();

		if ($template = $client->templates()->whereName($request->input('name'))->first()) {
			$template->fill($request->validated());
			$template->save();
		} else {
			$template = $client->templates()->create($request->validated());
		}

		return response()->json(['success' => true, 'template' => $template->only('id', 'name')]);
	}
}
