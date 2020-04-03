<?php

namespace Ijdb\Entity;

class Author {

    const JOKES_EDIT = 1;
    const JOKES_DELETE = 2;
    const CATEGORIES_LIST = 4;
    const CATEGORIES_EDIT = 8;
    const CATEGORIES_REMOVE = 16;
    const EDIT_USER_ACCESS = 32;

	public $id;
	public $name;
	public $email;
	public $password;
	private $jokesTable;

	public function __construct(\Ninja\DbTable $jokesTable)
	{
        $this->jokesTable = $jokesTable;
	}

	public function getJokes()
	{
		return $this->jokesTable->find('authorId', $this->id);
	}

	public function addJoke($joke)
	{
		$joke['authorId'] = $this->id;
			
		return $this->jokesTable->save($joke);
	}
	
    public function hasPermission($permission)
    {
        return $this->permissions & $permission;
    }
    
	
}
