<?php

namespace App\Notifications;

use App\Clients\Client;
use App\Services\Service;
use App\Templates\Template;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
	protected $table = 'notifications';
	public $timestamps = true;
	protected $dates = ['created_at', 'updated_at'];
	protected $guarded = [];

	protected $casts = [
		'data' => 'array',
		'attachments' => 'array',
	];

	// relationships
	public function client()
	{
		return $this->belongsTo(Client::class);
	}

	public function service()
	{
		return $this->belongsTo(Service::class);
	}

	public function template()
	{
		return $this->belongsTo(Template::class);
	}

	// scopes
	public function scopeSent($q)
	{
		return $q->whereNotNull('sent_at');
	}
}
