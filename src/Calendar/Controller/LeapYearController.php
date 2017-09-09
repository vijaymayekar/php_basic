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
			return new Response('Yep this is leap year');
		} else {
			return new Response('Nope its not leap year');
		}

	}
}
