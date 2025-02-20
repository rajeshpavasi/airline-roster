<?php

use Illuminate\Http\Request;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RosterController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/events', [EventController::class, 'getEventsBetweenDates']);
Route::get('/flights-next-week', [EventController::class, 'getFlightsNextWeek']);
Route::get('/standby-next-week', [EventController::class, 'getStandbyNextWeek']);
Route::get('/flights-from-location', [EventController::class, 'getFlightsFromLocation']);

Route::post('/upload-roster', [RosterController::class, 'uploadRoster']);
