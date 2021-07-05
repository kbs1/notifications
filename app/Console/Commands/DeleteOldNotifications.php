<?php

namespace App\Console\Commands;

use App\Clients\Client;
use Illuminate\Console\Command;

class DeleteOldNotifications extends Command
{
	protected $signature = 'notifications:delete-old';
	protected $description = 'Delete sent notifications outside of rentention period.';

	public function handle()
	{
		$this->info('DeleteOldNotifications starting');

		foreach (Client::all() as $client) {
			$deleted = $client->notifications()->sent()->where('sent_at', '<=', now()->subDays($client->notifications_retention_days))->delete();

			if ($deleted)
				$this->line("Client ID {$client->id}: deleted $deleted sent notifications");
		}

		$this->info('DeleteOldNotifications completed successfully');
		return 0;
	}
}
