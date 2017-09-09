<?php


namespace Simplex;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ResponseEvent extends Event {
	protected $response;
	protected $request;

	public function __construct(Response $response, Request $request)
	{
		$this->request = $request;
		$this->response = $response;
	}

	public function getResponse() {
		return $this->response;
	}

	public function getRequest() {
		return $this->request;
	}
}