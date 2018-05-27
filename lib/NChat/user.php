<?php
namespace NChat;

class User extends Entity {
	private $userName;
	private $passwordHash;

	public function __construct(int $id, string $userName, string $passwordHash) {
		parent::__construct($id);
		$this->userName = $userName;
		$this->passwordHash = $passwordHash;
	}

	public function getUserName() {
		return $this->userName;
	}

	public function getPasswordHash() {
		return $this->passwordHash;
	}
}