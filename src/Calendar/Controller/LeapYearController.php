<?php

namespace Calendar\Controller;

use Calendar\Model\LeapYear;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LeapYearController
{
	function indexAction (Request $request, $year)
	{
		$leapyear = new LeapYear();
		if ($leapyear->isLeapYear($year)) {
			$response = new Response('Yep, this is a leap year!' . rand());
		} else {
			$response = new Response('Nope its not leap year');
		}
		$response->setTtl(10);
		return $response;
	}
}
