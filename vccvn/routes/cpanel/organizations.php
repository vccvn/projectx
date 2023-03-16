<?php
$controller = 'OrganizationController@';
$route = 'organizations';

/**
 * --------------------------------------------------------------------------------------------------------------------
 * |                    URI                    |       Controller @ method       |             Route Name             |
 * --------------------------------------------------------------------------------------------------------------------
 */
manager_routes($controller, $route, true);
$route.='.';

// Route::get('/',                                 $controller.'index'               )->name('user');
// Route::get('/trash.html',                       $controller.'trash'               )->name($route.'trash');
// Route::get('/create.html',                      $controller.'create'              )->name($route.'create');
// Route::get('/update/{id}.html',                 $controller.'update'              )->name($route.'update');
// Route::post('/save',                            $controller.'save'                )->name($route.'save');
// Route::post('/move-to-trash',                   $controller.'moveToTrash'         )->name($route.'move-to-trash');
// Route::post('/delete',                          $controller.'delete'              )->name($route.'delete');
// Route::post('/restore',                         $controller.'restore'             )->name($route.'restore');