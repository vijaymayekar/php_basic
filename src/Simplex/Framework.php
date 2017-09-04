<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;

class Framework {
	protected $matcher;
	protected $controllerResolver;
	protected $argumentResolver;

	public function __construct(UrlMatcher $matcher, ControllerResolver $controllerResolver, ArgumentResolver $argumentResolver)
	{
		$this->matcher = $matcher;
		$this->controllerResolver = $controllerResolver;
		$this->argumentResolver = $argumentResolver;
	}

	public function handle(Request $request) {
		try {
			$request->attributes->add($this->matcher->match($request->getPathInfo()));
			$controller = $this->controllerResolver->getController($request);
			$arguments = $this->argumentResolver->getArguments( $request, $controller);
			return call_user_func_array($controller, $arguments);
		}
		catch (RouteNotFoundException $e) {
			return new Response('Page not found', 404);
		}
		catch (Exception $e) {
			return new Response('An error occured', 500);
		}
	}
}