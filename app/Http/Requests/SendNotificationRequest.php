<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendNotificationRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'service' => 'required|exists:services,name',
			'template' => 'required|exists:templates,name',
			'replacements.*' => 'nullable',
			'attachments.*' => 'nullable|exists:attachments,id',
			'scheduled_at' => 'nullable|date',
			'webhook_success_url' => 'nullable|url',
			'webhook_failure_url' => 'nullable|url',
		];
	}
}
