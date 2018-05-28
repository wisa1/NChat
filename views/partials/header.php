<?php

use NChat\Util;
use NChat\AuthenticationManager;
$user = AuthenticationManager::getAuthenticatedUser();

if (isset($_GET["errors"])) {
	$errors = unserialize(urldecode($_GET["errors"]));
}
?>

<?php require_once('views/partials/htmlHead.php'); ?>
<body>
<div class="navbar navbar-fixed-top nchatNavBar">
  <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/NChat">NChat</a>
    </div>

    <div class="navbar-collapse collapse" id="bs-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li <?php
		if (!isset($_GET['view'])) print ' class="active"';
    ?>><a href="index.php?view=chat">Chat</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        
        <li class="nav-item">
          <?php if ($user == null): ?>
            <a class="nav-link" href="index.php?view=register">Registrieren</a>
          <?php else: ?>
            <p class="navbar-text"> Eingeloggt als <i><?php  echo ($user->getUserName()) ?></i> </p>
        </li>
        
        <?php endif; ?>
        <li class="nav-item">
          <?php if ($user == null): ?>

              <!--<img src="/NChat/assets/img/redcircle.png" class="img-circle"></img> -->
              <a class="nav-link" href="index.php?view=login">Einloggen</a>
          <?php else: ?> 
              <!--<img src="/NChat/assets/img/greencircle.png" class="img-circle"></img>-->
              <a class="nav-link" href="index.php?view=welcome&action=logout">Ausloggen</a>
          <?php endif; ?>
        </li>
      </ul> <!-- /. login -->
    </div><!--/.nav-collapse -->
  </div>
</div>

<div class="container">

