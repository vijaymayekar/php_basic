<?php

namespace Simplex\Tests;

use Simplex\Framework;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;

class FrameworkTest extends \PHPUnit\Framework\TestCase
{
	public function testNotFoundHandling()
	{
		$framework = $this->getFrameworkForException(new RouteNotFoundException());

		$response = $framework->handle(new Request());

		$this->assertEquals(404, $response->getStatusCode());
	}

	protected function getFrameworkForException($exception)
	{
		$matcher = $this->createMock('Symfony\Component\Routing\Matcher\UrlMatcherInterface');
		$matcher
			->expects($this->once())
			->method('match')
			->will($this->throwException($exception))
		;
		$resolver = $this->createMock('Symfony\Component\HttpKernel\Controller\ControllerResolverInterface');
		$argumentResolver = new ArgumentResolver();

		return new Framework($matcher, $resolver, $argumentResolver);
	}

//	public function testErrorHandling()
//	{
//		$framework = $this->getFrameworkForException(new \RuntimeException(500));
//		$response = $framework->handle(new Request());
//		$this->assertEquals(500, $response->getStatusCode());
//	}

	public function testControllerResponse()
	{
		$matcher = $this->createMock('Symfony\Component\Routing\Matcher\UrlMatcherInterface');
		$matcher
			->expects($this->once())
			->method('match')
			->will($this->returnValue(array(
				'_route' => 'foo',
				'name' => 'Fabien',
				'_controller' => function ($name) {
					return new Response('Hello '.$name);
				}
			)))
		;
		$controllerResolver = new ControllerResolver();
		$argumentResolver = new ArgumentResolver();


		$framework = new Framework($matcher, $controllerResolver, $argumentResolver);

		$response = $framework->handle(new Request());

		$this->assertEquals(200, $response->getStatusCode());
		$this->assertContains('Hello Fabien', $response->getContent());
	}

	public function testYearControllerResponse()
	{
		$matcher = $this->createMock('Symfony\Component\Routing\Matcher\UrlMatcherInterface');
		$matcher
			->expects($this->once())
			->method('match')
			->will($this->returnValue(array(
				'_route' => '/is_leap_year/{year}',
				'year' => 400,
				'_controller' => 'Calendar\\Controller\\LeapYearController::indexAction'
			)))
		;
		$controllerResolver = new ControllerResolver();
		$argumentResolver = new ArgumentResolver();


		$framework = new Framework($matcher, $controllerResolver, $argumentResolver);

		$response = $framework->handle(new Request());

		$this->assertEquals(200, $response->getStatusCode());
		$this->assertContains('Yep this is leap year', $response->getContent());
	}
}