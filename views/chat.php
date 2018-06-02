<?php

use NChat\Channel;
use Data\DataManager;
use NChat\Post;

use NChat\AuthenticationManager;
require_once('views/partials/header.php'); 

$user = AuthenticationManager::getAuthenticatedUser();
$channels = null;
if($user != null) {
  $channels = DataManager::getChannelsForUser($user->getId());
}

?>

<div class="container">
  <div class="column left">
    <nav id="sidebar">
      <div class="sidebar-header">
        <h3>Channels</h3>
      </div>

      <!-- Sidebar Links -->
      <ul class="list-unstyled components">
        <?php
          if($channels != null){
          foreach($channels as $chan) { ?>
        <li><a class="navLink" id="<?php echo $chan->getId();?>" href="#"><?php echo '#'.$chan->getName();?></a></li>
        <?php } } //endif endforeach?>
      </ul>
    </nav>  
  </div>        
  <div class="column right">
    <div id="content" class="container">
      
    </div>
  </div>
</div>

<script>
  //Link - Event into ajax loading the partial for chat content
  $(".navLink").click(function(){
    $(".navLink").removeClass("active");
    $(this).addClass("active");

    var toload = "index.php?view=chatContent&channelid=" + $(this).attr('id');
    //alert(toload);
    $("#content").load(toload);

  })
</script>