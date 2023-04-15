<?php

/*
|--------------------------------------------------------------------------
| Category Routes
|--------------------------------------------------------------------------
|
| định nghĩa các route cho danh mục sản phẩm
|
*/

use Illuminate\Support\Facades\Route;


Route::prefix('api')->group(function () {

    $r = 'admin.3d.api.';
    Route::get('/', function () {
        return response(['message' => 'Hello World']);
    })->name($r . 'base');

    Route::prefix('items')->group(function ($router) use ($r) {
        $c = 'Crazy3D\Api\ModelItemController@';
        // Route::get('detail/{id}',                      $c.'detail'                               );
        Route::get('/category',                        $c . 'getItemCategories');
        Route::get('/list',                            $c . 'getData');
        // Route::middleware(['auth.jwt'])->group(function () use($r, $c) {
            Route::put('update/{id}',                  $c . 'update3D');
            Route::put('thumbnail/{id}',               $c . 'updateThumbnail');
    
            Route::put('/{id}',                        $c . 'update3D');
        // });
    });
    Route::prefix('categories')->group(function ($router) use ($r) {
        $c = 'Crazy3D\Api\ModelItemController@';
        Route::get('/list',                       $c . 'getItemCategories');
    });

    Route::prefix('templates')->group(function ($router) use ($r) {
        $c = 'Crazy3D\Api\TemplateController@';
        Route::get('/list',                        $c . 'getTemplateCategories');
        Route::get('/categories',                        $c . 'getTemplateCategories');
        Route::put('update/{id}',                  $c . 'update3D');
        Route::put('thumbnail/{id}',               $c . 'updateThumbnail');
        Route::put('/{id}',                        $c . 'update3D');

    });
    
    Route::prefix('projects')->group(function ($router) use ($r) {
        $c = 'Crazy3D\Api\ProjectController@';
        Route::get('/list',                        $c . 'getProjectCategories');
        Route::put('update/{id}',                  $c . 'update3D');
        Route::put('thumbnail/{id}',               $c . 'updateThumbnail');
        Route::put('/{id}',                        $c . 'update3D');

    });
});




Route::prefix('categories')->group(function ($router = null) {
    $controller = 'Crazy3D\CategoryController@';
    $route = '3d.categories';

    admin_routes($controller, $route, true);
    $route = 'admin.' . $route . '.';

    /**
     * --------------------------------------------------------------------------------------------------------------------
     *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
     * --------------------------------------------------------------------------------------------------------------------
     */
    Route::get('/options',                       $controller . 'getCategoryOptions')->name($route . 'options');
});

Route::prefix('models')->group(function () {

    $controller = 'Crazy3D\Model3DController@';
    $route = '3d.models';
    admin_routes($controller, $route, true);
    $route = 'admin.' . $route . '.';
    /**
     * --------------------------------------------------------------------------------------------------------------------
     *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
     * --------------------------------------------------------------------------------------------------------------------
     */
    // Route::get('/parent-options',                 $controller.'getParentSelectOptions'   )->name($route.'parent-option');
    // Route::get('/user-tag-data',                  $controller.'getUserTagData'           )->name($route.'tag-data');

    Route::get('upload',                          $controller . 'getUploadForm')->name($route . 'upload');
    Route::post('upload',                         $controller . 'doUpload');
    Route::post('first-update',                   $controller . 'FirstUpdate')->name($route . 'first-update');
    Route::get('preview/{secret_id?}',                         $controller . 'preview')->name($route . 'preview');
});
Route::prefix('items')->group(function () {

    $controller = 'Angular\Model3DController@';
    $route = '3d.items';
    // admin_routes($controller, $route, true);
    $route = 'admin.' . $route . '.';
    /**
     * --------------------------------------------------------------------------------------------------------------------
     *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
     * --------------------------------------------------------------------------------------------------------------------
     */
    // Route::get('/parent-options',                 $controller.'getParentSelectOptions'   )->name($route.'parent-option');
    // Route::get('/user-tag-data',                  $controller.'getUserTagData'           )->name($route.'tag-data');
    Route::get('/',                               $controller . 'nothing')->name($route . 'root');
    Route::get('/category',                       $controller . 'getItemCategories')->name($route . 'category');
    Route::get('/{secret_id}/edit',               $controller . 'getAngularEditemPage')->name($route . 'edit');
    // Route::get('/{secret_id}/edit',               $controller . 'getAngularEditemPage')->name($route . 'create');
});

Route::prefix('templates')->group(function () {

    $controller = 'Crazy3D\TemplateController@';
    $route = '3d.templates';
    admin_routes($controller, $route, true);
    $route = 'admin.' . $route . '.';
    /**
     * --------------------------------------------------------------------------------------------------------------------
     *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
     * --------------------------------------------------------------------------------------------------------------------
     */
    // Route::post('upload',                         $controller . 'doUpload'               );
    // Route::get('/',                               $controller.'nothing'                     )->name($route.'root');
    Route::post('create-default',                 $controller . 'createDefault')->name($route . 'create-default');
    Route::get('preview/{secret_id?}',            $controller . 'preview')->name($route . 'preview');
    Route::get('/{secret_id}/create',               $controller . 'getAngularEditTemplatePage')->name($route . 'create-new');
    Route::get('/{secret_id}/edit',               $controller . 'getAngularEditTemplatePage')->name($route . 'edit');
});
Route::prefix('projects')->group(function () {

    $controller = 'Crazy3D\ProjectController@';
    $route = '3d.projects';
    admin_routes($controller, $route, true);
    $route = 'admin.' . $route . '.';
    /**
     * --------------------------------------------------------------------------------------------------------------------
     *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
     * --------------------------------------------------------------------------------------------------------------------
     */
    Route::post('create-default',                 $controller . 'createDefault')->name($route . 'create-default');
    Route::get('preview/{secret_id?}',            $controller . 'preview')->name($route . 'preview');
    Route::get('/{secret_id}/edit',               $controller . 'getAngularEditProjectPage')->name($route . 'edit');
    Route::get('/{secret_id}/create',             $controller . 'getAngularCreateProjectPage')->name($route . 'create-new');
});
