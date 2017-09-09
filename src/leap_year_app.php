<?php

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

$routes->add('leap_year', new Route('/is_leap_year/{year}', array(
	'year' => NULL,
	'_controller' => 'Calendar\\Controller\\LeapYearController::indexAction'
)));
return $routes;