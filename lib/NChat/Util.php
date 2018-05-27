<?php

use NChat\BaseObject;
namespace NChat;

class Util extends BaseObject {

	public static function escape(string $string) : string {
		return nl2br(htmlspecialchars($string));
	}

	public static function action(string $action, array $params = null) : string {
		$url = null;

		$url = 'index.php?' . Controller::ACTION . '=' . rawurlencode($action);

		if (is_array($params)) {
			foreach ($params AS $key => $value) {
				$url .= '&' . rawurlencode($key) . '=' . rawurlencode($value);
			}
		}

		$url .= '&' . Controller::PAGE . '=' . rawurlencode(
				isset($_REQUEST[Controller::PAGE]) ?
					$_REQUEST[Controller::PAGE] :
					$_SERVER['REQUEST_URI']
			);

		return $url;
	}

	public static function redirect(string $page = null) {
		if ($page == null) {
			$page = isset($_REQUEST[Controller::PAGE]) ?
				rawurldecode($_REQUEST[Controller::PAGE]) :
				$_SERVER['REQUEST_URI'];
		}
		var_dump($page);
		header("Location: $page");
		exit();
	}

}