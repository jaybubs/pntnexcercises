<?php
class RegisterController {
	private $authorsTable;

	public function __construct(dbTable $authorsTable) {
		$this->authorsTable = $authorsTable;
	}
