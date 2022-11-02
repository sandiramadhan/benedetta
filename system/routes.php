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

		$this->group = null;
		$this->options = [];
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
		for($i = 0; $i < count($this->registered_routes); $i++) {
			$v = $this->registered_routes[$i];
			$_url = $v['group'] == '/' ? $v['url'] : $v['group'].($v['url'] == '/' ? '' : $v['url']);
			if ($_url == $this->main_uri) {
				$_arrctrl = explode('::', $v['ctrl']);
				if(isset($_arrctrl[0]) && isset($_arrctrl[1])) {
					$_ctrl = $_arrctrl[0];
					$_func = $_arrctrl[1];
					
					$filedir = __DIR__ . '/../controllers/'.$_ctrl.'.php';
					if (file_exists($filedir)) {
						require_once $filedir;
						$clsname = strtoupper(substr($_ctrl, 0,1)).substr($_ctrl, 1);
						$cls = new $clsname();
						$cls->$_func();
					} else {
						throw new Exception("Controller or method is not found!");
					}
				}
				break;
			}
		}
	}
}