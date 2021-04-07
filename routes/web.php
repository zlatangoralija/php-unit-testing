<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    Mail::raw('Test email', function ($message){
        $message->to('foo@bar.com');
        $message->from('bar@foo.com');
    });

    return 'Email sent';
});

Route::get('/feedback', function () {
    return view('feedback');
});
