<?php

class AuthorController {
	private DatabaseTable $authorTable;

	public function __construct(DatabaseTable $authorTable)
	{
		$this->authorTable = $authorTable;
	}

	public function register()
	{
		
	}
}