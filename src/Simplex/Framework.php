<?php

namespace Simplex;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;

class Framework {
	protected $matcher;
	protected $controllerResolver;
	protected $argumentResolver;

	public function __construct(UrlMatcherInterface $matcher, ControllerResolverInterface $controllerResolver, ArgumentResolverInterface $argumentResolver)
	{
		$this->matcher = $matcher;
		$this->controllerResolver = $controllerResolver;
		$this->argumentResolver = $argumentResolver;
//		$this->dispatcher = $dispatcher;
	}

	public function handle(Request $request) {
		try {
			$request->attributes->add($this->matcher->match($request->getPathInfo()));
			$controller = $this->controllerResolver->getController($request);
			$arguments = $this->argumentResolver->getArguments( $request, $controller);
			$response = call_user_func_array($controller, $arguments);
		}
		catch (RouteNotFoundException $e) {
			$response = new Response('Page not found', 404);
		}
		catch (Exception $e) {
			$response = new Response('An error occured', 500);
		}

//		$this->dispatcher->dispatch('response', new Event());

		return $response;
	}
}