<?php

namespace App\Services;

use App\Clients\Client;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
	protected $table = 'services';
	public $timestamps = true;
	protected $dates = ['created_at', 'updated_at'];
	protected $guarded = [];

	protected $casts = [
		'data' => 'array',
	];

	// relationships
	public function client()
	{
		return $this->belongsTo(Client::class);
	}

	// methods
	public function handler()
	{
		$handler = Factory::make($this->type);
		$handler->setModel($this);
		return $handler;
	}
}
