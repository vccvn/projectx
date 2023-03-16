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
    $controller = 'Ecommerce\ProductCategoryController@';
    $route = 'products.categories';

    admin_routes($controller, $route, true);
    $route = 'admin.' . $route . '.';

    /**
     * --------------------------------------------------------------------------------------------------------------------
     *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
     * --------------------------------------------------------------------------------------------------------------------
     */
    Route::get('/options',                       $controller . 'getCategoryOptions')->name($route . 'options');
});


/*
|--------------------------------------------------------------------------
| Attribute Routes
|--------------------------------------------------------------------------
|
| định nghĩa các route Thuộc tính sản phẩm
|
*/

Route::prefix('attributes')->group(function () {
    $controller = 'Ecommerce\ProductAttributeController@';
    $route = 'products.attributes';

    admin_routes($controller, $route, true);
    $route = 'admin.' . $route . '.';

    /**
     * --------------------------------------------------------------------------------------------------------------------
     *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
     * --------------------------------------------------------------------------------------------------------------------
     */

    Route::get('/detail',                        $controller . 'getAttributeDetail')->name($route . 'detail-values');


    // các route cho gia tri thuộc tính
    Route::prefix('values')->group(function () {
        $controller = 'Ecommerce\ProductAttributeValueController@';
        $route = 'admin.products.attributes.values';

        /**
         * ----------------------------------------------------------------------------------------------------------------
         *    Method | URI                       | Controller @ Nethod                   | Route Name                     |
         * ----------------------------------------------------------------------------------------------------------------
         */
        Route::get('/',                          $controller . 'index')->name($route);
        $route .= '.';
        Route::get('/list',                      $controller . 'index')->name($route . 'list');
        Route::get('/detail/{id?}',              $controller . 'detail')->name($route . 'detail');
        Route::post('/create',                   $controller . 'create')->name($route . 'create');
        Route::post('/store',                    $controller . 'store')->name($route . 'store');
        Route::put('/update/{id?}',              $controller . 'update')->name($route . 'update');
        Route::post('/save',                     $controller . 'save')->name($route . 'save');
        Route::delete('/delete',                 $controller . 'delete')->name($route . 'delete');
    });
});


Route::prefix('reviews')->group(function () {
    $controller = 'Ecommerce\ProductReviewController@';
    $route = 'products.reviews';

    admin_routes($controller, $route, true);
    $route = 'admin.' . $route . '.';

    /**
     * --------------------------------------------------------------------------------------------------------------------
     *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
     * --------------------------------------------------------------------------------------------------------------------
     */
    // Route::get('/options',                       $controller.'getCategoryOptions'        )->name($route.'options');
});


Route::prefix('warehouse')->group(function () {
    $controller = 'Ecommerce\WarehouseController@';
    $route = 'products.warehouse';


    $listRoute = ['index', 'list', 'create', 'update', 'save', 'move-to-trash', 'delete'];

    add_web_module_routes($controller, $listRoute, $route, 'admin');
    $route = 'admin.' . $route . '.';

    /**
     * --------------------------------------------------------------------------------------------------------------------
     *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
     * --------------------------------------------------------------------------------------------------------------------
     */
    // Route::get('/options',                       $controller.'getCategoryOptions'        )->name($route.'options');
});


Route::prefix('variants')->group(function () {
    $controller = 'Ecommerce\VariantController@';
    $route = 'products.variants';


    $listRoute = ['index', 'list', 'create', 'update', 'save', 'move-to-trash', 'delete'];

    add_web_module_routes($controller, $listRoute, $route, 'admin');
    $route = 'admin.' . $route . '.';

    /**
     * --------------------------------------------------------------------------------------------------------------------
     *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
     * --------------------------------------------------------------------------------------------------------------------
     */
    Route::get('/get-attribute-inputs',           $controller . 'getAttributeByProduct')->name($route . 'attribute-inputs');
});



/*
|--------------------------------------------------------------------------
| Product Routes
|--------------------------------------------------------------------------
|
| định nghĩa các route sản phẩm
|
*/


$controller = 'Ecommerce\ProductController@';
$route = 'products';

admin_routes($controller, $route, true);
$route = 'admin.' . $route . '.';

/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */
Route::get('/config.html',                    $controller . 'getPostConfigForm')->name($route . 'config');
Route::get('/form-layout.html',               $controller . 'getFormLayoutSetting')->name($route . 'form-layout');
Route::post('/check-slug',                    $controller . 'checkSlug')->name($route . 'check-slug');
Route::get('/get-slug',                       $controller . 'getSlug')->name($route . 'get-slug');
Route::get('/get-attribute-inputs',           $controller . 'getAttributeByCategory')->name($route . 'attribute-inputs');

Route::get('/product-options',                $controller . 'getProductSelectOptions')->name($route . 'select-options');
Route::get('/product-tagss',                  $controller . 'getProductTagData')->name($route . 'tag-data');




Route::prefix('crawls')->group(function () {

    Route::prefix('frames')->group(function () {
        $controller = 'Ecommerce\CrawlerFrameController@';
        $route = 'products.crawlers.frames';

        admin_routes($controller, $route, true);
        $route = 'admin.' . $route . '.';

        /**
         * --------------------------------------------------------------------------------------------------------------------
         *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
         * --------------------------------------------------------------------------------------------------------------------
         */
    });



    Route::prefix('tasks')->group(function () {
        $controller = 'Ecommerce\CrawlerTaskController@';
        $route = 'products.crawlers.tasks';

        admin_routes($controller, $route, true);
        $route = 'admin.' . $route . '.';

        /**
         * --------------------------------------------------------------------------------------------------------------------
         *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
         * --------------------------------------------------------------------------------------------------------------------
         */
        Route::post('tasks/run',                      $controller . 'run')->name($route . 'run');
        Route::post('tasks/status',                   $controller . 'changeStatus')->name($route . 'status');
    });

    $controller = 'Ecommerce\CrawlerProductController@';
    $route = 'admin.products.crawlers.';

    /**
     * --------------------------------------------------------------------------------------------------------------------
     *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
     * --------------------------------------------------------------------------------------------------------------------
     */
    Route::get('crawl.html',                      $controller . 'getFreeForm')->name($route . 'crawl-form');
    Route::post('crawl',                          $controller . 'crawl')->name($route . 'save-crawl');
    Route::post('handle',                         $controller . 'handle')->name($route . 'handle');
});
