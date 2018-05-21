<?php

use NChat\AuthenticationManager;
use NChat\Util;

if (AuthenticationManager::isAuthenticated()) {
    Util::redirect("main.php");
}

var_dump($_REQUEST);
$userName = isset($_REQUEST['username']) ? $_REQUEST['username'] : null;

?>

<?php require_once('views/partials/htmlHead.php'); ?>
<div class="container">
	<div class="login">
		<h4>NChat - Login</h4>
			<hr>
        		<form class="login-inner" methos="post" action="<?php echo Util::action(NChat\Controller::ACTION_LOGIN, array('view' => $view)); ?>">

    				<input type="text" class="form-control email" id="text-input" placeholder="Benutzername" name="username">
    				<input type="password" class="form-control password" id="password-input" placeholder="Passwort" name="password">
				
					<input class="btn btn-block btn-lg btn-success submit" type="submit" value="Login">
                    <p>Bereits Mitglied? Logge dich mit Benutzername und Passwort ein</p>
                    <p>Neu? Kein Problem, erstelle einfach dein Konto durch Eingabe von Benutzername und Passwort</p>
				</form>
	</div>
</div>