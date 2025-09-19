<?php

use App\Controller\PageController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes): void {
    $routes->add('about_route', '/about')
        ->controller([PageController::class, 'about']);
};
