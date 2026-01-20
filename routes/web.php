<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DisplayController;
use App\Http\Controllers\ArnesApiController;

Route::get('/', [DisplayController::class, 'index'])->name('player');
Route::get('/jalan-rasa/{outlet_id?}', [DisplayController::class, 'jalanRasa'])->name('player.jalan-rasa');
Route::get('/arnes/{outlet_id?}', [DisplayController::class, 'arnes'])->name('player.arnes');

Route::post('/select-outlet', [DisplayController::class, 'selectOutlet'])->name('select-outlet');
Route::get('/api/playlist/{id}', [DisplayController::class, 'getPlaylist']);

// Arnes Schedule API Proxy
Route::get('/api/arnes/schedule/{kode_outlet}', [ArnesApiController::class, 'getSchedule']);
// Heartbeat/Ping
Route::post('/api/ping/{id}', [DisplayController::class, 'ping']);
