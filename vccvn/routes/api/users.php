<?php

// controller

use Illuminate\Support\Facades\Route;

$c = 'UserController@';
$r = 'api.users';
/*
|----------------------------------------------------------------------------------------------------------------------------
|                       URL                       |              CONTROLLER               |               NAME
|----------------------------------------------------------------------------------------------------------------------------
*/    
// url: /users                  
Route::get('/',                                    $c.'index'                             )->name($r); 
$r.='.'; // user.
// url: /users/role/{user_roie}             
Route::get('/role/{user_roie}',                    $c.'getByRole'                         )->name($r.'role');
// url: /users/list             
Route::get('/trash',                               $c.'trash'                             )->name($r.'trash');
// url: /users/{id}/info
Route::get('/{id}/detail',                         $c.'detail'                            )->name($r.'detail');
// url: /users/add
Route::post('/create',                             $c.'create'                            )->name($r.'create');
// url: /users/{id}/update
Route::post('/{id}/update',                        $c.'update'                            )->name($r.'update');
// url: /users/{id}/update
Route::post('/{id}/status',                        $c.'update'                            )->name($r.'status');
// url: /users/{id}/set-role
Route::post('/{id}/set-role',                      $c.'setRole'                           )->name($r.'set-role');
// url: /users/move-to-trash/{id}
Route::delete('/move-to-trash/{id}',               $c.'moveToTrash'                       )->name($r.'move-to-trash');
// url: /users/erase/{id}
Route::delete('/erase/{id}',                       $c.'erase'                             )->name($r.'erase');
// url: /users/restore/{id}
Route::put('/restore/{id}',                        $c.'restore'                           )->name($r.'restore');
// url: /users/{id}/find
Route::get('/find',                                $c.'finduser'                          )->name($r.'find');
