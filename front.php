<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__ . '/vendor/autoload.php';

$request = Request::createFromGlobals();

$routes = array(
	'/bye' => 'bye',
	'/hello' => 'hello'
);
$current_path = $request->getPathInfo();
if (array_key_exists($current_path, $routes)) {
	ob_start();
	extract($request->query->all(), EXTR_SKIP);
	include sprintf(__DIR__ . '/src/pages/%s.php', $routes[$current_path]);
	$response = new Response(ob_get_clean());
}
else {
	$response = new Response('Page not found', 404);
}

$response->send();