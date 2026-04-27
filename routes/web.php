<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/delete/account', function () {
    return view('Deleteaccount');  // This is the name of your Blade file without the '.blade.php'
});
Route::get('privacy/policy', function () {
    return view('PrivacyPolicyMyAdvertisement');  // This is the name of your Blade file without the '.blade.php'
});

Route::get('/run-seeder', function () {
    Artisan::call('db:seed');
    return 'seeder run successfully!';
});

Route::get('/run-migrate', function () {
    Artisan::call('migrate');
    return 'migrate run successfully!';
});

Route::get('/run-migrate-fresh', function () {
    Artisan::call('migrate:fresh');
    return 'migrate fresh run successfully!';
});