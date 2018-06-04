<?php
namespace NChat;

use Data\DataManager;

class Post extends Entity {
  private $userId;
  private $userName;
  private $channelId;
  private $title;
  private $text;
  private $important;

	public function __construct(int $id, int $userId, int $channeldId, string $title, string $text, ?int $important) {
		parent::__construct($id);
    $this->userId = $userId;
    $this->userName = DataManager::getUserById($userId)->getUserName();
    $this->channelId = $channeldId;
    $this->title = $title;
    $this->text = $text;
    $this->important = $important;
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
  
  public function getImportant(){
    return $this->important;
  }
}