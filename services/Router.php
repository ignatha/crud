<?php

/**
 * 
 */

class Router
{
	private array $handlers;
	private const METHOD_POST = 'POST';
	private const METHOD_GET = 'GET';
	private $notFoundHandler;

	function get(string $path, $handler): void
	{
		$this->addHandler(self::METHOD_GET, $path,$handler);
	}

	function post(string $path, $handler): void
	{
		$this->addHandler(self::METHOD_POST, $path,$handler);
	}

	private function addHandler(string $method, string $path, $handler): void
	{
		$this->handlers[$method . $path] = [
			'path'		=> $path,
			'method' 	=> $method,
			'handler'	=> $handler,
		];
	}

	public function addNotFoundHandler($handler): void
	{
		$this->notFoundHandler = $handler;
	}

	function run()
	{
		$requestUri = parse_url($_SERVER['REQUEST_URI']);
		$reqestPath = $requestUri['path'];
		$method = $_SERVER['REQUEST_METHOD'];

		$callback = null;
		foreach ($this->handlers as $handler) {
			if ($handler['path'] === $reqestPath && $method === $handler['method']) {
				$callback = $handler['handler'];
			}
		}

		if (is_string($callback)) {
			$parts = explode('::', $callback);
				if (is_array($parts)) {
					$className = array_shift($parts);
					$handler = new $className;

					$method = array_shift($parts);
					$callback = [$handler,$method];
				}
			}		

		if (!$callback) {
			header(header: "HTTP/1.0 404 Not Found");
			if (!empty($this->notFoundHandler)) {
				$callback = $this->notFoundHandler;
			}
		}

		call_user_func_array($callback, [
			array_merge($_GET, $_POST)
		]);
	}
}