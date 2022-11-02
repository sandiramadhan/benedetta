<?php

class Routes
{
	/*
		* routes args
		[
			path: (string)
			group: (string)
			middleware: (array)
			controllers: (string::string)
			params: (array)
		]
	*/
	protected $main_uri = '';
	protected $registered_routes = [];
	protected $group = null;
	protected $options = [];

	public function __construct() {
		$uri = $_SERVER['REQUEST_URI'];
		$arr_uri = explode('/', $uri);
		for($i=0; $i<count($arr_uri); $i++) 
			if($i>1) $this->main_uri .= '/'.$arr_uri[$i];
	}

	public function group(string $url, ...$params) {
		$callback = array_pop($params);
		$this->group = $url;
		$this->options = array_shift($params);

		if (is_callable($callback)) {
			$callback($this);
		}
	}

	public function get(string $url, ...$params) {
		$r = [
			'group' => $this->group,
			'options' => $this->options,
			'url' => $url,
			'ctrl' => isset($params[0]) ? $params[0] : ''
		];
		array_push($this->registered_routes, $r);
	}

	public function run()
	{
		echo "<pre>";
		print_r($this->registered_routes);
	}
}