<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/callback', function (Request $request) {
    $auth_token = $request->query('code'); // extract token from URL
    return view('callback', compact('auth_token'));
});
