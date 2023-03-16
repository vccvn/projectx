<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Category Routes
|--------------------------------------------------------------------------
|
| định nghĩa các route cho danh mục sản phẩm
|
*/
Route::prefix('categories')->group(function () {
    $controller = 'General\ProjectCategoryController@';
    $route = 'projects.categories';

    admin_routes($controller, $route, true);
    $route = 'admin.'.$route.'.';

    /**
     * --------------------------------------------------------------------------------------------------------------------
     *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
     * --------------------------------------------------------------------------------------------------------------------
     */
    Route::get('/options',                       $controller.'getCategoryOptions'        )->name($route.'options');
});



/*
|--------------------------------------------------------------------------
| Project Routes
|--------------------------------------------------------------------------
|
| định nghĩa các route sản phẩm
|
*/


$controller = 'General\ProjectController@';
$route = 'projects';

admin_routes($controller, $route, true);
$route = 'admin.'.$route.'.';

/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */
Route::post('/check-slug',                    $controller.'checkSlug'                 )->name($route.'check-slug');
Route::get('/get-slug',                       $controller.'getSlug'                   )->name($route.'get-slug');

Route::get('/project-options',                $controller.'getProjectSelectOptions'   )->name($route.'select-options');
Route::get('/project-tagss',                  $controller.'getProjectTagData'         )->name($route.'tag-data');