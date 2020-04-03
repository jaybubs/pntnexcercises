<?php
namespace Ijdb;

class IjdbRoutes implements \Ninja\Routes {

	private $authorsTable;
	private $jokesTable;
	private $categoriesTable;
	private $auth;
	private $jokeCategoriesTable;

	public function __construct() {

		include __DIR__.'/../../includes/dbconxn.php';

		$this->jokesTable = new \Ninja\DbTable($pdo,'joke','id', '\Ijdb\Entity\Joke',[&$this->authorsTable,&$this->jokeCategoriesTable]);
		$this->authorsTable = new \Ninja\DbTable($pdo, 'author', 'id','\Ijdb\Entity\Author', [&$this->jokesTable]);
		$this->auth = new \Ninja\Authentication($this->authorsTable, 'email', 'password');
		$this->categoriesTable = new \Ninja\DbTable($pdo, 'category', 'id', '\Ijdb\Entity\Category',[&$this->jokesTable, &$this->jokeCategoriesTable]);
		$this->jokeCategoriesTable = new \Ninja\DbTable($pdo, 'joke_category', 'categoryId');
	}
	

	public function getAuth(): \Ninja\Authentication {
		return $this->auth;
	}
	
    public function checkPermission($permission): bool
    {
        $user = $this->auth->getUser();

        if ($user && $user->hasPermission($permission)) {
            return true;
        } else {
            return false;
        }
    }

	public function getRoutes(): array {

		$jokeController = new \Ijdb\Controllers\Joke($this->jokesTable, $this->authorsTable, $this->categoriesTable, $this->auth);
		$authorController = new \Ijdb\Controllers\Register($this->authorsTable);
		$loginController = new \Ijdb\Controllers\Login($this->auth);
		$categoryController = new \Ijdb\Controllers\Category($this->categoriesTable);

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
			],
			'category/edit' => [
				'POST' => [
					'controller' => $categoryController,
					'action' => 'saveEdit'
				],
				'GET' => [
					'controller' => $categoryController,
					'action' => 'edit'
				],
                'login' => true,
                'permissions' => \Ijdb\Entity\Author::CATEGORIES_EDIT
			],
			'category/list' => [
				'GET' => [
					'controller' => $categoryController,
					'action' => 'list'
				],
				'login' => true,
                'permissions' => \Ijdb\Entity\Author::CATEGORIES_LIST
			],
			'category/fuck' => [
				'POST' => [
					'controller' => $categoryController,
					'action' => 'fuck'
				],
				'login' => true,
                'permissions' => \Ijdb\Entity\Author::CATEGORIES_REMOVE
			],
			'author/permissions' => [
				'GET' => [
					'controller' => $authorController,
					'action' => 'permissions'
				],
				'POST' => [
					'controller' => $authorController,
					'action' => 'savePermissions'
				],
                'login' => true,
                'permissions' => \Ijdb\Entity\Author::EDIT_USER_ACCESS
            ],
			'author/list' => [
				'GET' => [
					'controller' => $authorController,
					'action' => 'list'
				],
                'login' => true,
                'permissions' => \Ijdb\Entity\Author::EDIT_USER_ACCESS
            ]
		];

		return $routes;

	}
}
