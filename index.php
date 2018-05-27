<?php require_once('inc/bootstrap.php');

$default_view = 'welcome';

$view = isset($_REQUEST['view']) ? $_REQUEST['view'] : $default_view;

$postAction = isset($_REQUEST[\NChat\Controller::ACTION]) ? $_REQUEST[\NChat\Controller::ACTION] : null;
if ($postAction != null) {
	NChat\Controller::getInstance()->invokePostAction();
}

if (file_exists(__DIR__ . '/views/' . $view . '.php')) {
  require_once('views/' . $view . '.php');
}
else {
	require_once('views/' . $default_view . '.php');
}