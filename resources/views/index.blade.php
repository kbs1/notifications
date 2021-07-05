@extends('layout')

@section('content')
	<h1>Sync attachments</h1>
	<form action="{{ route('api.v1.attachments.sync') }}" method="post" enctype="multipart/form-data">
		<p><input type="text" name="api_key" placeholder="API key"></p>
		<p><input type="file" name="attachments[]" multiple></p>
		<p><input type="submit" value="Sync"></p>
	</form>

	<h1>Sync service</h1>
	<form action="{{ route('api.v1.services.sync') }}" method="post">
		<p><input type="text" name="api_key" placeholder="API key"></p>
		<p><input type="text" name="name" placeholder="Service name"></p>
		<p>
			<select name="type">
				<option value="">Type</option>
				<option value="smtp">SMTP</option>
				<option value="twilio_sms">Twilio SMS</option>
				<option value="one_signal">One Signal</option>
			</select>
		</p>
		<p><input type="text" name="host" placeholder="SMTP host"></p>
		<p><input type="text" name="port" placeholder="SMTP port"></p>
		<p>
			<select name="encryption">
				<option value="select">Encryption</option>
				<option value="">None</option>
				<option value="ssl">SSL</option>
				<option value="tls">TLS</option>
			</select>
		</p>
		<p><input type="text" name="username" placeholder="SMTP username"></p>
		<p><input type="password" name="password" placeholder="SMTP password"></p>
		<p><input type="text" name="from_address" placeholder="From address"></p>
		<p><input type="text" name="from_name" placeholder="From name"></p>
		<p><input type="submit" value="Sync"></p>
	</form>

	<h1>Sync template</h1>
	<form action="{{ route('api.v1.templates.sync') }}" method="post">
		<p><input type="text" name="api_key" placeholder="API key"></p>
		<p><input type="text" name="name" placeholder="Template name"></p>
		<p><input type="text" name="title" placeholder="Title"></p>
		<p><textarea name="body" rows="10" placeholder="Body"></textarea></p>
		<p><input type="submit" value="Sync"></p>
	</form>

	<h1>Send notification</h1>
	<form action="{{ route('api.v1.notifications.send') }}" method="post">
		<p><input type="text" name="api_key" placeholder="API key"></p>
		<p><input type="text" name="service" placeholder="Service name"></p>
		<p><input type="text" name="template" placeholder="Template name"></p>
		<p><input type="text" name="to[]" placeholder="To (recipient)"></p>
		<p><input type="text" name="replacements[{NAME}]" placeholder="{NAME} replacement"></p>
		<p><input type="text" name="replacements[{SURNAME}]" placeholder="{SURNAME} replacement"></p>
		<p><input type="text" name="attachments[]" placeholder="Attachment ID 1"></p>
		<p><input type="text" name="attachments[]" placeholder="Attachment ID 2"></p>
		<p><input type="text" name="webhook_success_url" placeholder="Webhook success URL"></p>
		<p><input type="text" name="webhook_failure_url" placeholder="Webhook failure URL"></p>
		<p><input type="submit" value="Send"></p>
	</form>
@endsection
