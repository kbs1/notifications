<?php

namespace App\Services;

class Factory
{
	public static function make(string $type): Handler
	{
		switch ($type) {
			case 'smtp':
				return new Smtp;
			case 'twilio_sms':
				return new TwilioSms;
			case 'one_signal':
				return new OneSignal;
		}

		throw new \InvalidArgumentException("Service type '$type' not defined.");
	}
}
