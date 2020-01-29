<?php
class JokeController {
	private $authorsTable;
	private $jokesTable;

	public function __construct(dbTable $jokesTable, dbTable $authorsTable) {
		$this->jokesTable = $jokesTable;
		$this->authorsTable = $authorsTable;
	}

	public function list() {
		$result = $this->jokesTable->findAll();
		$jokes =[];
		foreach ($result as $joke) {
			$author = $this->authorsTable->findById($joke['id']);
			$jokes[] = [
				'id' => $joke['id'],
				'joketext' => $joke['joketext'],
				'jokedate' => $joke['jokedate'],
				'name' => $author['name'],
				'email' => $author['email']
			];
		}

		$title = 'Joke list';
		$totJ = $this->jokesTable->total();
		return ['template' => 'jokes.html.php',
			'title' => $title,
			'variables' => [
				'totJ' => $totJ,
				'jokes' => $jokes
			]
		];
	}

	public function home() {
		$title='IJDB';

		return ['template' => 'home.html.php', 'title' => $title];
	}

	public function fuck() {
		$this->jokesTable->fuck($_POST['id']);

		header('location: /joke/list');
	}

	public function edit() {
		if (isset($_POST['joke'])) {
			$joke = $_POST['joke'];
			$joke['jokedate'] = new DateTime();
			$joke['authorid'] = 1;

			$this->jokesTable->save($joke);
			header('location: /joke/list');
		}
		else {
			if (isset($_GET['id'])) {
				$joke = $this->jokesTable->findById($_GET['id']);
			}

			$title = 'Edit joke';
			return ['template' => 'editjoke.html.php',
				'title' => $title,
				'variables' => ['joke' => $joke ?? null]
			];
		}
	}

}
