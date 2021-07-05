<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\SyncAttachmentsRequest;

use App\Http\Controllers\Controller;

class AttachmentsController extends Controller
{
	public function sync(SyncAttachmentsRequest $request)
	{
		$client = $request->user();
		$attachments = collect();

		foreach ($request->file('attachments') as $file)
			$attachments->push($client->storeAttachment($file));

		return response()->json(['success' => true, 'attachments' => $attachments->map(fn($attachment) => $attachment->only('id', 'md5'))]);
	}
}
