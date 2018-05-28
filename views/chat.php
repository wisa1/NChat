<?php

use NChat\Channel;
use Data\DataManager;

use NChat\AuthenticationManager;
require_once('views/partials/header.php'); 

$user = AuthenticationManager::getAuthenticatedUser();
$channels = DataManager::getChannelsForUser($user->getId());

?>

<div class="container">
  <div class="column left">
    <nav id="sidebar">
      <div class="sidebar-header">
        <h3>Channels</h3>
      </div>

      <!-- Sidebar Links -->
      <ul class="list-unstyled components">
        <?php foreach($channels as $chan) { ?>
        <li><a class="navLink" id="<?php echo $chan->getId();?>" href="#"><?php echo '#'.$chan->getName();?></a></li>
        <?php } ?>
      </ul>
    </nav>  
  </div>        
  <div class="column right">
    <div id="content" class="container">
      
    </div>
  </div>
</div>

<script>
  $(".navLink").click(function(){
    $(".navLink").removeClass("active");
    $(this).addClass("active");
    $("#content").load("views/chatContent.php?channelid=1");

  })
</script>