<?php

namespace NChat;
use Data\DataManager;
use NChat\BaseObject;

/**
 * Controller
 *
 * class handles POST requests and redirects
 * the client after processing
 * - demo of singleton pattern
 */
class Controller
	extends BaseObject {
	// static strings used in views

	const ACTION = 'action';
	const ACTION_LOGIN = 'login';
	const ACTION_LOGOUT = 'logout';

	const USER_NAME = 'username';
	const USER_EMAIL = 'email';
	const USER_PASSWORD = 'password';
	const USER_PASSWORD_CONFIRMATION ='password-confirmation';
	
	const PAGE = 'page';
	const REGISTER = 'register';
	
	private static $instance = false;

	//Singleton - getInstance
	public static function getInstance() : Controller {

		if ( ! self::$instance) {
			self::$instance = new Controller();
		}

		return self::$instance;
	}

	private function __construct() {
		//no members to initialize
	}

	public function invokeAction(): bool {
		$action = $_REQUEST[ self::ACTION ];

		switch ($action) {

			case self::ACTION_LOGIN :
				if (!AuthenticationManager::authenticate($_REQUEST[self::USER_NAME], $_REQUEST[self::USER_PASSWORD])) {
					self::forwardRequest(['Invalid user credentials.']);
				}
				Util::redirect();
				break;

			case self::ACTION_LOGOUT :
				AuthenticationManager::signOut();
				Util::redirect("index.php");
				break;
			
			case self::REGISTER : 
				if(self::validateRegisterUserInput($_REQUEST)){
					AuthenticationManager::register($_REQUEST[self::USER_NAME],$_REQUEST[self::USER_EMAIL], $_REQUEST[self::USER_PASSWORD], $_REQUEST[self::USER_PASSWORD_CONFIRMATION]);
				}			
				Util::redirect("index.php?view=login");
				break;

			default :
				throw new \Exception('Unknown controller action: ' . $action);
				break;
		}
	}

	protected function validateRegisterUserInput(array $arr): bool{
		if(strlen($arr[self::USER_PASSWORD]) < 5){
			self::forwardRequest(['Passwort zu kurz!']);
			return false;
		}

		if($arr[self::USER_PASSWORD] != $arr[self::USER_PASSWORD_CONFIRMATION]){
			self::forwardRequest(['Passwörter stimmen nicht überein!']);
			return false;
		}

		if(strlen($arr[self::USER_NAME]) < 4){
			self::forwardRequest(['Benutzername zu kurz, verwenden Sie bitte mindestens 4 Zeichen']);
		}
		return true;
	}

	protected function forwardRequest(array $errors = null, $target = null) {
		if ($target == null) {
			if (isset($_REQUEST[self::PAGE])) {
				$target = $_REQUEST[self::PAGE];
			}
			else {
				$target = $_SERVER['REQUEST_URI'];
			}
		}
		if (count($errors) > 0) {
			$target .= '&errors=' . urlencode(serialize($errors));
			header('Location:' . $target);
			exit();
		}
	}
}