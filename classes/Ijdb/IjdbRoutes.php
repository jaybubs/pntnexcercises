<?php
namespace Ijdb;

class IjdbRoutes implements \Ninja\Routes {

	private $authorsTable;
	private $jokesTable;
	private $auth;

	public function __construct() {

		include __DIR__.'/../../includes/dbconxn.php';

		$this->jokesTable = new \Ninja\DbTable($pdo,'joke','id');
		$this->authorsTable = new \Ninja\DbTable($pdo, 'author', 'id');
		$this->auth = new \Ninja\Authentication($this->authorsTable, 'email', 'password');
	}
	

	public function getAuth(): \Ninja\Authentication {
		return $this->auth;
	}
	
	public function getRoutes(): array {

		$jokeController = new \Ijdb\Controllers\Joke($this->jokesTable, $this->authorsTable, $this->auth);
		$authorController = new \Ijdb\Controllers\Register($this->authorsTable);
		$loginController = new \Ijdb\Controllers\Login($this->auth);

		$routes = [
			'author/register' => [
				'GET' => [
					'controller' => $authorController,
					'action' => 'registrationForm'
				],
				'POST' => [
					'controller' => $authorController,
					'action' => 'registerUser'
				]
			],
			'author/success' => [
				'GET' => [
					'controller' => $authorController,
					'action' => 'success'
				]
			],
			'joke/edit' => [
				'POST' => [
					'controller' => $jokeController,
					'action' => 'saveEdit'
				],
				'GET' => [
					'controller' => $jokeController,
					'action' => 'edit'
				],
				'login' => true
			],

			'joke/fuck'=> [
				'POST' => [
					'controller' => $jokeController,
					'action' => 'fuck'
				]
			],
			'joke/list' => [
				'GET' => [
					'controller' => $jokeController,
					'action' => 'list'
				],
				'login' => true
			],
			'' => [
				'GET' => [
					'controller' => $jokeController,
					'action' => 'home'
				]
			],
			'login/error' => [
				'GET' => [
					'controller' => $loginController,
					'action' => 'error'
				]
			],
			'login' => [
				'GET' => [
					'controller' => $loginController,
					'action' => 'loginForm'
				],
				'POST' => [
					'controller' => $loginController,
					'action' => 'processLogin'
				]
			],
			'login/success' => [
				'GET' => [
					'controller' => $loginController,
					'action' => 'success'
				],
				'login' => true
			],
			'logout' => [
				'GET' => [
					'controller' => $loginController,
					'action' => 'logout'
				]
			]
		];

		return $routes;

	}
}
