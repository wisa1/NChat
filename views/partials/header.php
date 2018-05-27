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
      <a class="navbar-brand" href="/NChat">NChat</a>
    </div>

    <div class="navbar-collapse collapse" id="bs-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li <?php
		if (!isset($_GET['view'])) print ' class="active"';
    ?>><a href="index.php">Home</a></li>
    <!--
        <li <?php
		if (isset($_GET['view']) && $_GET['view'] == 'list') print ' class="active"';
		?>><a href="index.php?view=list">List</a></li>
        <li <?php
		if (isset($_GET['view']) && $_GET['view'] == 'search') print ' class="active"';
		?>><a href="index.php?view=search">Search</a></li>
    

    <li <?php
		if (isset($_GET['view']) && $_GET['view'] == 'checkout') print ' class="active"';
    ?>><a href="index.php?view=checkout">Checkout</a></li>
    -->
      </ul>
      <ul class="nav navbar-nav navbar-right">
        
        <li>
          <?php if ($user == null): ?>
            <a href="index.php?view=register">Registrieren</a>
          <?php else: ?>
            <p> Eingeloggt als <?php  echo ($user->getUserName()) ?> </p>
        </li>
        
        <?php endif; ?>
        <li>
          <?php if ($user == null): ?>
            <div class="loginDiv"> 
              <img src="/NChat/assets/img/redcircle.png" class="img-circle"></img>
              <a href="index.php?view=login">Einloggen</a>
            </div>
          <?php else: ?>
            <div class="loginDiv"> 
              <img src="/NChat/assets/img/greencircle.png" class="img-circle"></img>
              <form method="post" action="<?php echo Util::action(NChat\Controller::ACTION_LOGOUT); ?>" style="display:inline">
                  <input class="btn btn-xs" role="button" type="submit" value="Logout" />
              </form>
            </div>
          <?php endif; ?>
        </li>
      </ul> <!-- /. login -->
    </div><!--/.nav-collapse -->
  </div>
</div>

<div class="container">

