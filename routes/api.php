<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:api', 'forceJsonResponse'])->prefix('v1')->namespace('Api\v1')->name('api.v1.')->group(function () {
	Route::prefix('attachments')->name('attachments.')->group(function () {
		Route::post('sync', 'AttachmentsController@sync')->name('sync');
	});

	Route::prefix('services')->name('services.')->group(function () {
		Route::post('sync', 'ServicesController@sync')->name('sync');
	});

	Route::prefix('templates')->name('templates.')->group(function () {
		Route::post('sync', 'TemplatesController@sync')->name('sync');
	});

	Route::prefix('notifications')->name('notifications.')->group(function () {
		Route::post('send', 'NotificationsController@send')->name('send');
	});
});
