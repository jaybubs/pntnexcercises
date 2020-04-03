<?php

namespace Ijdb\Controllers;

use \Ninja\DbTable;

class Register
{
	private $authorsTable;

	public function __construct(dbTable $authorsTable) {
		$this->authorsTable = $authorsTable;
	}

	public function registrationForm() {
		return ['template' => 'register.html.php',
			'title' => 'Register an account'];
	}

	public function success() {
		return ['template' => 'registersuccess.html.php',
			'title' => 'Registration Successful'];
	}

    public function list()
    {
        $authors = $this->authorsTable->findAll();

        return ['template' => 'authorlist.html.php',
            'title' => 'Author List',
            'variables' => [
                'authors' => $authors
            ]
        ];
    }
    
    /**
     * undocumented function
     *
     * @return void
     */
    public function permissions()
    {
        $author = $this->authorsTable->findById($_GET['id']);

        $reflected = new \ReflectionClass('\Ijdb\Entity\Author');
        $constants = $reflected->getConstants();

        return ['template' => 'permissions.html.php',
            'title' => 'Edit Permissions',
            'variables' => [
                'author' => $author,
                'permissions' => $constants
            ]
        ];
    }
    
    public function savePermissions()
    {
        $author = [
            'id' => $_GET['id'],
            'permissions' => array_sum($_POST['permissions'] ?? [])
        ];

        $this->authorsTable->save($author);
        header('location: /author/list');
    }
    

	public function registerUser() {
		$author = $_POST['author'];

		//assume data is valid to begin with
		$valid = true;
		$errors = [];

		//but if any of the fields have been left blank
		//set $valid to false

		if (empty($author['name'])) {
			$valid = false;
			$errors[] = 'Name cannot be blank';
		}

		if (empty($author['email'])) {
			$valid = false;
			$errors[] = 'Email cannot be blank';
		} else if (filter_var($author['email'], FILTER_VALIDATE_EMAIL) == false) {
			$valid = false;
			$errors[] = 'Invalid email address';
		} else { //if the mail is valid, convert to lowercase
			$author['email'] = strtolower($author['email']);

		if (count($this->authorsTable->find('email',$author['email'])) > 0) {
			$valid = false;
			$errors[] = 'That email address is already registered';
		}
		}

		if (empty($author['password'])) {
			$valid = false;
			$errors[] = 'Password cannot be blank';
		}

		//if all is ok, the email remains lowercase and all is sent to the db

		if ($valid) {
			//hash the password first
			$author['password'] = password_hash($author['password'],PASSWORD_DEFAULT);

			$this->authorsTable->save($author);
			header('Location: /author/success');
			
		} else {
			//if something is not valid, return the form again with the deets prefilled
			return ['template' => 'register.html.php',
				'title' => 'Register an account',
				'variables' => [
					'errors' => $errors,
					'author' => $author
				]
			];
		}

	}
	
	
}
