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

class LeapYearController
{
	function indexAction ($year)
	{
		if (is_leap_year($year)) {
			return new Response('Yep this is leap year');
		} else {
			return new Response('Nope its not leap year');
		}

	}
}



$routes = new RouteCollection();

$routes->add('leap_year', new Route('/is_leap_year/{year}', array(
	'year' => NULL,
	'_controller' => 'LeapYearController::indexAction'
)));
return $routes;