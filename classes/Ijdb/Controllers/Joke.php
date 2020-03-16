<?php
namespace Ijdb\Controllers;
use \Ninja\DbTable;
use \Ninja\Authentication;

class Joke {
	private $authorsTable;
	private $jokesTable;
	private $categoriesTable;
	private $auth;

	public function __construct(dbTable $jokesTable, dbTable $authorsTable, dbTable $categoriesTable, Authentication $auth) {
		$this->jokesTable = $jokesTable;
		$this->authorsTable = $authorsTable;
		$this->categoriesTable = $categoriesTable;
		$this->auth = $auth;
	}

	public function list() {
        if (isset($_GET['category'])) {
            $category = $this->categoriesTable->findById($_GET['category']);
            $jokes = $category->getJokes();
        } else {
            $jokes = $this->jokesTable->findAll();
        }

		$title = 'Joke list';
		$totJ = $this->jokesTable->total();
		$author = $this->auth->getUser();
		return ['template' => 'jokes.html.php',
			'title' => $title,
			'variables' => [
				'totJ' => $totJ,
				'jokes' => $jokes,
				'userId' => $author->id ?? null,
				'categories' => $this->categoriesTable->findAll()
			]
		];
	}

	public function home() {
		$title='IJDB';

		return ['template' => 'home.html.php', 'title' => $title];
	}

	public function fuck() {
		$author = $this->auth->getUser();

		$joke = $this->jokesTable->findById($_POST['id']);

		if ($joke->authorId != $author->id) {
			return;
		}

		$this->jokesTable->fuck($_POST['id']);

		header('location: /joke/list');
	}

	public function saveEdit() {
		$author = $this->auth->getUser();

		$joke = $_POST['joke'];
		$joke['jokedate'] = new \DateTime();

		$jokeEntity = $author->addJoke($joke);

		foreach ($_POST['category'] as $categoryId) {
			$jokeEntity->addCategory($categoryId);
		}

		header('location: /joke/list');
	}

	public function edit() {
		$author = $this->auth->getUser();
		$categories = $this->categoriesTable->findAll();

		if (isset($_GET['id'])) {
			$joke = $this->jokesTable->findById($_GET['id']);
		}

		$title = 'Edit joke';

		return ['template' => 'editjoke.html.php',
			'title' => $title,
			'variables' => [
				'joke' => $joke ?? null,
				'userId' => $author->id ?? null,
				'categories' => $categories
			]
		];
		}

}
