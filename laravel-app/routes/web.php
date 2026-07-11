<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', function () {
    return view('customer.auth.register.step_one');
});

Route::post('/register', 'CustomerController@register');