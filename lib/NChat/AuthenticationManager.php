<?php
namespace NChat;

use Data\DataManager;

class AuthenticationManager extends BaseObject {

	public static function authenticate(string $userName, string $password) : bool {
		$user = DataManager::getUserByUserName($userName);

		if ($user != null &&
		    $user->getPasswordHash() == hash('sha1', $userName . '#' . $password)
		) {
			$_SESSION['user'] = $user->getId();
			var_dump($_SESSION);
			return true;
			
		}
		self::signOut();
		return false;
	}

	public static function signOut() {
		unset($_SESSION['user']);
	}

	public static function isAuthenticated() : bool {
		return isset($_SESSION['user']);
	}

	public static function getAuthenticatedUser() {
		return self::isAuthenticated() ? DataManager::getUserById($_SESSION['user']) : null;
	}

	public static function register(string $userName, string $email, string $password){

	}
}