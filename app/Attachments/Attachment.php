<?php

namespace App\Attachments;

use App\Clients\Client;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
	protected $table = 'attachments';
	public $timestamps = true;
	protected $dates = ['created_at', 'updated_at'];
	protected $guarded = [];

	// relationships
	public function client()
	{
		return $this->belongsTo(Client::class);
	}
}
