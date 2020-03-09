<?php

namespace Ijdb\Controllers;

class Login
{
	private $auth;

	public function __construct(\Ninja\Authentication $auth)
	{
        $this->auth = $auth;
	}
	
	public function loginForm()
	{
		return ['template' => 'login.html.php', 'title' => 'Log In'];
	}
	
	public function processLogin()
	{
		if ($this->auth->login($_POST['email'],$_POST['password'])) {
			header('location: /login/success');
		} else {
			return ['template'  => 'login.html.php',
				'title'     => 'Log In',
				'variables' => ['error' => 'Invalid username/password.']
			];
		}
	}

	public function success()
	{
		return ['template' => 'loginsuccess.html.php','title' => 'Login Successful'];
	}
	
	public function logout()
	{
		// unset($_SESSION); no longer working for 7.3 use session_unset() instead
		session_unset();
		return ['template' => 'logout.html.php', 'title' => 'You have been logged out'];
	}
	
	
	public function error()
	{
		return ['template' => 'loginerror.html.php', 'title' => 'You are not logged in'];
	}
	
}
