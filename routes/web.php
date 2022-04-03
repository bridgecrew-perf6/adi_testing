<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Redis;

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
    $arr = [
        'satu',
        'baba',
        '(+62) 81334090986',
        'wawa'
    ];

    $test = Redis::connection();
    Redis::pipeline(function ($pipe) use ($arr) {
        //dd($arr);
        for ($i = 0; $i < count($arr); $i++) {
            $pipe->set('key:' . $i, $arr[$i]);
        }
    });
    $phone = $test->command('get', ['key:2']);

    //POSTGRESS_TEST
    $data = User::all();
    $nama = $data->first()->name;
    $email = $data->first()->email;

    //$redis = app()->make('redis');
    //$redis->set("key1", 'testValue');

    return view('welcome', compact('nama', 'email', 'phone'));
});
