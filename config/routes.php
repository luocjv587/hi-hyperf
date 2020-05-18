<?php

declare(strict_types=1);

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\HomeController@index');

Router::get('/hello-hyperf', function () {
    return 'Hello Hyperf.';
});


Router::addServer('innerHttp', function () {
    Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\HomeController@index');
});
