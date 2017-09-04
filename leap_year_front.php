<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

require_once __DIR__ . '/vendor/autoload.php';

$request = Request::createFromGlobals();

$routes = include __DIR__ . '/src/leap_year_app.php';

$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);
$controllerResolver = new ControllerResolver();
$argumentResolver = new ArgumentResolver();


function render_template($request) {
	extract($request->attributes->all(), EXTR_SKIP);
	ob_start();
	include sprintf(__DIR__ . '/src/pages/%s.php', $_route);
	return new Response(ob_get_clean());
}

try {
	$request->attributes->add($matcher->match($request->getPathInfo()));
	$controller = $controllerResolver->getController($request);
	$arguments = $argumentResolver->getArguments( $request, $controller);
	print_r($arguments);
	$response = call_user_func_array($controller, $arguments);
}
catch (RouteNotFoundException $e) {
	$response = new Response('Page not found', 404);
}
catch (Exception $e) {
	$response = new Response('An error occured', 500);
}

$response->send();