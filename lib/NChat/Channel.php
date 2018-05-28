<?php
namespace NChat;

class Channel extends Entity {
  private $name;
	private $description;
	private $lastActivity;

	public function __construct(int $id, string $name, string $description, int $lastActivity) {
		parent::__construct($id);
		$this->name = $name;
		$this->description = $description;
		$this->lastActivity = $lastActivity;
	}

	public function getName() {
		return $this->name;
	}

	public function getDescription() {
		return $this->description;
	}
}