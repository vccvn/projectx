<?php
use Illuminate\Support\Facades\Route;

$controller = 'General\CommentController@';

$route = 'comments';

$listRoute = ['index', 'create', 'update', 'save', 'delete', 'list'];

add_web_module_routes($controller, $listRoute, $route, 'admin');

$route = 'admin.'.$route.'.';
Route::post('change-approve',                 $controller.'changeApprove'              )->name($route.'change-approve');

