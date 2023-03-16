<?php
$c = "CommentController@";

$r = 'api.comments';
/*
|----------------------------------------------------------------------------------------------------------------------------
|                       URL                       |              CONTROLLER               |               NAME
|----------------------------------------------------------------------------------------------------------------------------
*/    
// url: /users                  
Route::get('/',                                    $c.'index'                             )->name($r); 
$r.='.'; // user.
// url: /users/list             
Route::get('/trash',                               $c.'trash'                             )->name($r.'trash');
// url: /users/{id}/info
Route::get('/{id}/detail',                         $c.'detail'                            )->name($r.'detail');
// url: /users/add
Route::post('/create',                             $c.'create'                            )->name($r.'create');
// url: /users/{id}/update
Route::post('/{id}/update',                        $c.'update'                            )->name($r.'update');
// url: /users/move-to-trash/{id}
Route::delete('/move-to-trash/{id}',               $c.'moveToTrash'                       )->name($r.'move-to-trash');
// url: /users/erase/{id}
Route::delete('/erase/{id}',                       $c.'erase'                             )->name($r.'erase');
// url: /users/restore/{id}
Route::put('/restore/{id}',                        $c.'restore'                           )->name($r.'restore');
