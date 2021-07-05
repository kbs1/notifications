<?php

namespace App\Templates;

use App\Clients\Client;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
	protected $table = 'templates';
	public $timestamps = true;
	protected $dates = ['created_at', 'updated_at'];
	protected $guarded = [];

	// relationships
	public function client()
	{
		return $this->belongsTo(Client::class);
	}
}
