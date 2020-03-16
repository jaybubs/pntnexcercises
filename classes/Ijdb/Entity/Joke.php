<?php

namespace Ijdb\Entity;

class Joke
{
	public $id;
	public $authorId;
	public $jokedate;
	public $joketext;
	private $authorsTable;
	private $author;
	private $jokeCategoriesTable;

	public function __construct(\Ninja\DbTable $authorsTable, \Ninja\DbTable $jokeCategoriesTable)
	{
	$this->authorsTable = $authorsTable;
	$this->jokeCategoriesTable = $jokeCategoriesTable;
	}
	
	public function getAuthor() {
		if (empty($this->author)) {
		$this->author = $this->authorsTable->findById($this->authorId);	
		}
		return $this->author;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 */
	public function addCategory($categoryId)
	{
		$jokeCat = ['jokeId' => $this->id,
			'categoryId' => $categoryId];

		$this->jokeCategoriesTable->save($jokeCat);
	}
	
	
}
