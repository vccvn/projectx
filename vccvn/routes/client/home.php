<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('home');
Route::get('/index.html', 'HomeController@index')->name('client.home');
Route::get('/home', 'HomeController@index');

Route::get('/crawldata', 'HomeController@crawlData');

Route::get('profile', 'HomeController@home')->name('profile');

Route::get('/thong-bao.html', 'AlertController@message')->name('client.alert');

Route::get('csrf-token', 'HomeController@getCSRFToken')->name('client.token');


Route::get('test', 'HomeController@test')->name('test');

Route::get('/access-logs', 'HomeController@viewLogs')->name('client.access-logs');



// Route::get('create-user', function (Request $request) {
//     $repository = new OwnerRepository();
//     $user =  null;
//     if ($request->type == 'admin') {
//         if (!($u = $repository->findBy('username', 'admin'))) {
//             $user = $repository->create([
//                 'name' => 'Admin',
//                 'username' => 'admin',
//                 'password' => 'dev.2020',
//                 'email' => 'dev@vcc.vn',
//                 'type' => 'admin'
//             ]);
//         } else {
//             $user = $u;
//         }
//     } elseif ($request->type == 'user') {
//         $user = $repository->create([
//             'name' => $request->name ?? 'User ' . time(),
//             'username' => $request->username ?? 'user' . time(),
//             'password' => $request->password ?? substr(md5(uniqid()), 4, 8),
//             'email' => $request->email ?? uniqid() . '@gmail.com',
//             'type' => 'user'
//         ]);
//     }

//     return $user;
// });
