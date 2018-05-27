<?php

use NChat\AuthenticationManager;
use NChat\Util;

if (AuthenticationManager::isAuthenticated()) {
		var_dump($_REQUEST);
    Util::redirect("index.php");
}

$userName = isset($_REQUEST['username']) ? $_REQUEST['username'] : null;
?>

<?php require_once('views/partials/header.php'); ?>

	<div class="login">
		<h4>NChat - Login</h4>
			<hr>
        	<form class="login-inner" method="post" action="<?php echo Util::action(NChat\Controller::ACTION_LOGIN, array('view' => $view)); ?>">

    			<input type="text" class="form-control email" id="text-input" placeholder="Benutzername" name="<?php echo NChat\Controller::USER_NAME?>">
    			<input type="password" class="form-control password" id="password-input" placeholder="Passwort" name="<?php echo NChat\Controller::USER_PASSWORD?>">
				
					<input class="btn btn-block btn-lg btn-success submit" type="submit" value="Login">
                    <p>Bereits Mitglied? Logge dich mit Benutzername und Passwort ein</p>
                    <p>Neu? Kein Problem, erstelle einfach dein Konto durch Eingabe von Benutzername und Passwort</p>
				</form>
	</div>
</div>