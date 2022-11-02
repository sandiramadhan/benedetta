<?php

require_once __DIR__ . './../configs/database.php';
require_once __DIR__ . './../configs/routes.php';

class Jcore {

	protected $registeredDb = [];
	public function __construct()
	{
		$this->registeredDb = new Database();
	}

}