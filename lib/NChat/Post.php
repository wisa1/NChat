<?php
namespace NChat;

use Data\DataManager;

class Post extends Entity {
  private $userid;
  private $userName;
  private $channelId;
  private $title;
	private $text;

	public function __construct(int $id, int $userId, int $channeldId, string $title, string $text) {
		parent::__construct($id);
		$this->userName = $userName;
    $this->userId = $userId;
    $this->userName = DataManager::getUserById($userId)->getUserName();
    $this->channelId = $channeldId;
    $this->title = $title;
    $this->text = $text;
	}

	public function getUserName() {
		return $this->userName;
	}

	public function getTitle() {
		return $this->title;
  }

  public function getText() {
		return $this->text;
	}
}