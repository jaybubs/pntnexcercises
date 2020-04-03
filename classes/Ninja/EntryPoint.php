<?php
namespace Ninja;

class entryPoint {
	private $route;
	private $method;
	private $routes;

	public function __construct(string $route,string $method,\Ninja\Routes $routes) {
		$this->route  = $route;
		$this->routes = $routes;
		$this->method = $method;
		$this->checkUrl();
	}

	private function checkUrl() {
		if ($this->route !== strtolower($this->route)) {
			http_response_code(301);
			header('location: '.strtolower($this->route));
		}
	}
	
	private function loadTemplate($templateFileName, $variables =[]) {
		extract($variables);

		ob_start();
		include __DIR__ . '/../../templates/' . $templateFileName;

		return ob_get_clean();
	}

	public function run() {

		$routes = $this->routes->getRoutes();
		$auth = $this->routes->getAuth();

		if (isset($routes[$this->route]['login']) && !$auth->isLoggedIn()){
			header('location: /login/error');
        } elseif (isset($routes[$this->route]['permissions']) && !$this->routes->checkPermission($routes[$this->route]['permissions'])) {
            header('location: /login/error');
        } else {
		$controller = $routes[$this->route][$this->method]['controller'];
		$action = $routes[$this->route][$this->method]['action'];

		$page = $controller->$action();

		$title = $page['title'];

		if (isset($page['variables'])) {
			$output = $this->loadTemplate($page['template'], $page['variables']);
		}
		else {
			$output = $this->loadTemplate($page['template']);
		}
		echo $this->loadTemplate('layout.html.php', ['loggedIn' => $auth->isLoggedIn(), 'output' => $output, 'title' => $title]);
		}
	}
}
