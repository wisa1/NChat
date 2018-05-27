<?php
namespace NChat;

interface IData {
	public function getId();
}

class Entity extends BaseObject implements IData {

	private $id;

	public function getId() {
		return $this->id;
	}

	public function __construct($id) {
		$this->id = $id;
	}
}