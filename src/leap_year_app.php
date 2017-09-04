<?php

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

function is_leap_year($year = null) {
	if (null === $year) {
		$year = date('Y');
	}

	return 0 == $year % 400 || (0 == $year % 4 && 0 != $year % 100);
}


$routes = new RouteCollection();

$routes->add('leap_year', new Route('/is_leap_year/{year}', array(
	'year' => NULL,
	'_controller' => function ($request) {
		if (is_leap_year($request->attributes->get('year'))) {
			return new Response('Yep this is leap year');
		}
		else {
			return new Response('Nope its not leap year');
		}

	}
)));
return $routes;