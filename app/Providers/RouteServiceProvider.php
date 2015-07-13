<?php

namespace Dodona\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Dodona\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        //

        parent::boot($router);
        
        $router->model('client',  'Dodona\Models\Client');
        $router->model('service', 'Dodona\Models\Service');
        $router->model('site',    'Dodona\Models\Site');
        $router->model('server',  'Dodona\Models\Server');
        
        $router->model('ticket',              'Dodona\Models\Ticketing\Ticket');
        $router->model('server_check_result', 'Dodona\Models\ServerCheckResult');
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require app_path('Http/routes.php');
        });
    }
}
