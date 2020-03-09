<?php
namespace Ijdb\Controllers;
use \Ninja\DbTable;
use \Ninja\Authentication;

class Joke {
	private $authorsTable;
	private $jokesTable;

	public function __construct(dbTable $jokesTable, dbTable $authorsTable, Authentication $auth) {
		$this->jokesTable = $jokesTable;
		$this->authorsTable = $authorsTable;
		$this->auth = $auth;
	}

	public function list() {
		$result = $this->jokesTable->findAll();
		$jokes =[];
		foreach ($result as $joke) {
			$author = $this->authorsTable->findById($joke['id']);
			$jokes[] = [
				'id'       => $joke['id'],
				'joketext' => $joke['joketext'],
				'jokedate' => $joke['jokedate'],
				'name'     => $author['name'],
				'email'    => $author['email'],
				'authorId' => $author['id']
			];
		}

		$title = 'Joke list';
		$totJ = $this->jokesTable->total();
		return ['template' => 'jokes.html.php',
			'title' => $title,
			'variables' => [
				'totJ' => $totJ,
				'jokes' => $jokes,
				'userId' => $author['id'] ?? null
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

		if ($joke['authorId'] != $author['id']) {
			return;
		}

		$this->jokesTable->fuck($_POST['id']);

		header('location: /joke/list');
	}

	public function saveEdit() {
		$author = $this->auth->getUser();
		if (isset($_GET['id'])) {
			$joke = $this->jokesTable->findById($_GET['id']);

			if ($joke['authorId'] != $author['id']) {
				return;
			}
		}

		$joke = $_POST['joke'];
		$joke['jokedate'] = new \DateTime();
		$joke['authorId'] = $author['id'];

		$this->jokesTable->save($joke);

		header('location: /joke/list');
	}

	public function edit() {
		$author = $this->auth->getUser();

		if (isset($_GET['id'])) {
			$joke = $this->jokesTable->findById($_GET['id']);
		}

		$title = 'Edit joke';
		return ['template' => 'editjoke.html.php',
			'title' => $title,
			'variables' => [
				'joke' => $joke ?? null,
				'userId' => $author['id'] ?? null
			]
		];
		}

}
