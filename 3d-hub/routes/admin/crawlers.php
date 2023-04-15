<?php

Route::prefix('frames')->group(function () {
    $controller = 'General\CrawlerFrameController@';
    $route = 'crawlers.frames';

    admin_routes($controller, $route, true);
    $route = 'admin.'.$route.'.';

    /**
     * --------------------------------------------------------------------------------------------------------------------
     *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
     * --------------------------------------------------------------------------------------------------------------------
     */
            
    
});



Route::prefix('tasks')->group(function () {
    $controller = 'General\CrawlerTaskController@';
    $route = 'crawlers.tasks';

    admin_routes($controller, $route, true);
    $route = 'admin.'.$route.'.';

    /**
     * --------------------------------------------------------------------------------------------------------------------
     *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
     * --------------------------------------------------------------------------------------------------------------------
     */
    Route::post('tasks/run',                      $controller.'run'                               )->name($route.'run');
    Route::post('tasks/status',                   $controller.'changeStatus'                      )->name($route.'status');

    
});

Route::prefix('posts')->group(function () {
    $controller = 'General\CrawlerPostController@';
    $route = 'crawlers.posts';

    // admin_routes($controller, $route, true);
    $route = 'admin.'.$route.'.';

    /**
     * --------------------------------------------------------------------------------------------------------------------
     *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
     * --------------------------------------------------------------------------------------------------------------------
     */
    Route::get('crawl.html',                      $controller.'getFreeForm'              )->name($route.'crawl-form');
    Route::post('crawl',                          $controller.'crawl'                    )->name($route.'save-crawl');
    Route::get('category-options',                $controller.'getCategoryOptions'       )->name($route.'category-options');
    Route::post('handle',                         $controller.'handle'                   )->name($route.'handle');
    
});