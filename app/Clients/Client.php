<?php

namespace App\Clients;

use App\Attachments\Attachment;
use App\Services\Service;
use App\Templates\Template;
use App\Notifications\Notification;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class Client extends Model
{
	use HasFactory;

	protected $table = 'clients';
	public $timestamps = true;
	protected $dates = ['created_at', 'updated_at'];
	protected $guarded = [];

	// relationships
	public function attachments()
	{
		return $this->hasMany(Attachment::class);
	}

	public function services()
	{
		return $this->hasMany(Service::class);
	}

	public function templates()
	{
		return $this->hasMany(Template::class);
	}

	public function notifications()
	{
		return $this->hasMany(Notification::class);
	}

	// methods
	public function storeAttachment(UploadedFile $file): Attachment
	{
		$md5 = md5_file($file->path());
		$filename = $file->getClientOriginalName();

		$existing = $this->attachments()->whereMd5($md5)->first();

		if ($existing) {
			if ($existing->filename === $filename) {
				$existing->touch();
				return $existing;
			}
		} else {
			$file->storeAs('attachments', $md5);
		}

		return $this->attachments()->create([
			'md5' => $md5,
			'mime' => $file->getMimeType(),
			'filename' => $filename,
		]);
	}
}
