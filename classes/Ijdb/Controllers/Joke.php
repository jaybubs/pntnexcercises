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
        $page = $_GET['page'] ?? 1;
        $offset = ($page-1)*2;

        if (isset($_GET['category'])) {
            $category = $this->categoriesTable->findById($_GET['category']);
            $jokes = $category->getJokes(2, $offset);
        } else {
            $jokes = $this->jokesTable->findAll('jokedate DESC', 2, $offset);
            $totJ = $this->jokesTable->total();
        }

		$title = 'Joke list';
		$totJ = $this->jokesTable->total();
		$author = $this->auth->getUser();
		return ['template' => 'jokes.html.php',
			'title' => $title,
			'variables' => [
				'totJ' => $totJ,
				'jokes' => $jokes,
                'user' => $author,
                'categories' => $this->categoriesTable->findAll(),
                'currentPage' => $page,
                'category' => $_GET['category'] ?? null
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
		if ($joke->authorId != $author->id && !$author->hasPermission(\Ijdb\Entity\Author::JOKES_DELETE)) {
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
        $jokeEntity->clearCategories();

        if (is_array($_POST['category'])) { //while not in the tutorial, foreach gives an exception when its fed an null/empty value, this way if the supplied value is null/empty array it will sipp adding categories and the joke will stay categoryless

		foreach ($_POST['category'] as $categoryId) {
			$jokeEntity->addCategory($categoryId);
		}
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
                'user' => $author,
				// 'userId' => $author->id ?? null,
				'categories' => $categories
			]
		];
		}

}
