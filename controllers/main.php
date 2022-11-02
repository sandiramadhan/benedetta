<?php

class Main 
{
	public function __construct()
	{
		
	}

	public function index()
	{
		print_r('Main index called');
	}

	public function contact($id)
	{
		print_r('Main contact called with id: '. $id . ' and ');
	}
}