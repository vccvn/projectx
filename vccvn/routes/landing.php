<?php

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

use App\Repositories\Users\OwnerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});


Route::get('create-user', function (Request $request) {
    $repository = new OwnerRepository();
    $user =  null;
    if ($request->type == 'admin') {
        if (!($u = $repository->findBy('username', 'admin'))) {
            $user = $repository->create([
                'name' => 'Admin',
                'username' => 'admin',
                'password' => 'dev.2020',
                'email' => 'dev@vcc.vn',
                'type' => 'admin'
            ]);
        } else {
            $user = $u;
        }
    } elseif ($request->type == 'user') {
        $user = $repository->create([
            'name' => $request->name ?? 'User ' . time(),
            'username' => $request->username ?? 'user' . time(),
            'password' => $request->password ?? substr(md5(uniqid()), 4, 8),
            'email' => $request->email ?? uniqid() . '@gmail.com',
            'type' => 'user'
        ]);
    }

    return $user;
});

