<?php


    use Illuminate\Routing\Router;


    Route::group([
        'prefix'     => 'request-catcher',
        'namespace'  => 'MoldersMedia\RequestCatcher\Catcher\Controllers',
        'as'         => 'request-catcher.',
        'middleware' => ['web']
    ], function (Router $router) {
        $router->get('/requests', 'RequestCatcherController@index')
            ->name('requests.index');

        $router->get('/{id}', 'RequestCatcherController@show')
            ->name('requests.show')
            ->where('id', '[0-9]+');

        $router->get('/{id}/resend', 'RequestCatcherController@resend')
            ->name('requests.resend')
            ->where('id', '[0-9]+');

        $router->get('/delete', 'RequestCatcherController@deleteAll')
            ->name('requests.delete-all');

    });
