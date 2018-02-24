<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;

use App\user;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('make:admin', function (Request $request) {
    $user = User::where('username', 'admin')->first();

    if ($user) {
    	$this->error('User admin already exist!');
    	return;
    }
    //$password = $this->secret('Password:');
    $password = $this->ask('Password:');
    while (strlen($password) < 6) {
        $this->error('Password too short. Enter minimum 6 charecter pls...');
        $password = $this->ask('Password:');
    }

    User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@courier.test',
            'password' => Hash::make($password),
        ]);
    $this->comment('User admin created successfully!');
    return; 

})->describe('Make an admin user');
