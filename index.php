<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

require_once __DIR__ . '/vendor/autoload.php';

$request = Request::createFromGlobals();
$response = new Response();
$routes = include __DIR__ . '/src/leap_year_app.php';

$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);
$controllerResolver = new ControllerResolver();
$argumentResolver = new ArgumentResolver();


$framework = new Simplex\Framework($matcher, $controllerResolver, $argumentResolver);
$response = $framework->handle($request);

$response->send();