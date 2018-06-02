<?php

use NChat\Channel;
use NChat\Post;
use NChat\AuthenticationManager;

use Data\DataManager;
$posts = null;
$posts = DataManager::getPostsByChannelId($_REQUEST["channelid"]);
echo ($_REQUEST["channelid"]);
?>

<?php 
if ($posts != null){
  foreach($posts as $post){
?>    
    <div class="postContainer">
      <div class="titleContainer">
        <p> <?php echo $post->getTitle(); ?> </p>^
        <p> <?php echo $post->getUserName(); ?> </p>
      </div>
      <div class="textContainer">
        <hr>
        <p> <?php echo $post->getText(); ?> </p>
      </div>
    </div> 
<?php
  }
} 
?>
