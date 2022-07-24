<?php

class Contact
{
	public function execute(): void
	{
		require_once $_SERVER['DOCUMENT_ROOT'] . '/views/contact.phtml';
	}
}
