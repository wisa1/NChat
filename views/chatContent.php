<?php

use NChat\Channel;
use NChat\Post;
use NChat\AuthenticationManager;

use Data\DataManager;
$posts = null;
$posts = DataManager::getPostsByChannelId($_REQUEST["channelid"]);
$user = AuthenticationManager::getAuthenticatedUser();
?>

<div class='container'>
  <?php
  if ($posts != null){
    foreach($posts as $post){
  ?>    
		 <div class="media comment-box">
        <div class="media comment-header">
          <p class="media-heading">Von: <?php echo $post->getUserName(); ?></p>
          <p class="media-heading">Titel: <?php echo $post->getTitle(); ?></p>
          <span class="glyphicon glyphicon-pencil"></span>
          <span class="glyphicon glyphicon-remove"></span>
        </div>
        
        <div class="media-body">
            <p><?php echo $post->getText(); ?></p>
        </div>
     </div>
<?php
  }
} 
?>
</div>

<form id="newPostForm">
  <div class="input-group">
    <span class="input-group-addon">Titel</span>
    <input id="newTitle" type="text" class="form-control" name="<?php echo NChat\Controller::NEW_TITLE ?>" placeholder="Titel">
  </div>

  <div class="input-group">
    <span class="input-group-addon">Text</span>
    <input id="newTitle" type="text" class="form-control" name="<?php echo NChat\Controller::NEW_TEXT ?>" placeholder="Text">
  </div>

  <input type="submit" value="Erstellen"/>

  </div>
</form>

<script>
  $("#newPostForm").submit(function(e) {
    var url = "index.php?view=chat&action=newPost"; // the script where you handle the form input.
    $.ajax({
          type: "POST",
          url: url,
          data: $("#newPostForm").serialize(), // serializes the form's elements.
          success: function(data)
          {
            var toload = "index.php?view=chatContent&channelid=1";
            $("#content").load(toload);
          }
        });
    e.preventDefault(); // avoid to execute the actual submit of the form.
  });
</script>
