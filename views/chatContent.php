<?php

use NChat\Channel;
use NChat\Post;
use NChat\AuthenticationManager;

use Data\DataManager;
$posts = null;

$user = AuthenticationManager::getAuthenticatedUser();

$lastChecked = DataManager::getLastChecked($_REQUEST["channelid"], $user->getId());
$posts = DataManager::getPostsByChannelId($_REQUEST["channelid"], $user->getId());
$editable = DataManager::getEditablePostId($_REQUEST["channelid"], $user->getId());

?>

<div class='container'>
  <?php
  if ($posts != null){
    foreach($posts as $post){
  ?>    
		 <div id="<?php echo $post->getId(); ?>" class="media comment-box  <?php if($post->getTimestamp() > $lastChecked) {echo("unread"); }  ?>">
        <div class="media comment-header">
          <p class="media-heading">Von: <?php echo $post->getUserName(); ?></p>
          <p class="media-heading">Titel: <?php echo $post->getTitle(); ?></p>
          
          <?php if($post->getId() == $editable) { ?>
            <button type="button" class="editButton floatRight" data-toggle="modal" data-target="#editModal">
              <span class="glyphicon glyphicon-pencil"></span>
            </button>

            <button type="button" class="actionButton floatRight">
              <span class="glyphicon glyphicon-remove"></span>
            </button>
          <?php }?>

          <button type="button" class="actionButton floatRight">
            <?php if($post->getImportant() == 1){ ?>
              <span class="glyphicon glyphicon-star"></span>
            <?php }  else { ?>
              <span class="glyphicon glyphicon-star-empty"></span>
            <?php } ?>
          </button>
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

<!-- New Post - Form -->
<form class="newPostForm" id="newPostForm">
  <p> Neuen Beitrag erstellen </p>
  <div class="input-group">
    <span class="input-group-addon">Titel</span>
    <input id="newTitle" type="text" class="form-control" name="<?php echo NChat\Controller::NEW_TITLE ?>" placeholder="Titel">
  </div>

  <div class="input-group">
    <span class="input-group-addon">Text</span>
    <textarea id="newText" type="text" class="form-control" name="<?php echo NChat\Controller::NEW_TEXT ?>" placeholder="Text"/>
  </div>

  <input type="submit" value="Erstellen"/>

  </div>
</form>

<!-- Edit - Modal Form -->
<div id="editModal" class="modal fade" role="dialog">
  <?php
    $editablePost = DataManager::getPostByPostId($editable, $user->getId());
  ?>
  <?php if($editable != null){ ?>
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $editablePost->getTitle(); ?></h4>
      </div>
      <div class="modal-body">
        <textarea id="editedText"><?php echo $editablePost->getText(); ?> </textarea>
      </div>
      <div class="modal-footer">
        <button id="editConfirm" type="button" class="btn btn-default" data-dismiss="modal">Speichern</button>
        <button id="editAbort" type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
      </div>
    </div>
  </div>
  <?php } ?>
</div>

<script>
  function htmlEntities(str) {
      return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
  } 

  $("#newPostForm").submit(function(e) {
    var url = "index.php?view=chat";
    $.ajax({
          type: "POST",
          url: url,
          data: $("#newPostForm").serialize()
                +"&channelId="+<?php echo $_REQUEST["channelid"]; ?>+
                "&userId="+<?php echo $user->getId(); ?> +
                "&action=newPost", 
          success: function(data)
          {
            var toload = "index.php?view=chatContent" + 
            "&channelid="+ <?php echo $_REQUEST["channelid"] ?>;
            $("#content").load(toload);
          }
        });
    e.preventDefault(); // avoid to execute the actual submit of the form.
  });

  $(".glyphicon-remove").click(function(){
    var url = "index.php?view=chat";
    $.ajax({
          type: "POST",
          url: url,
          data: "action=deletePost&postId=" + <?php echo $editable ?>,
          success: function(data){
            var toload = "index.php?view=chatContent" + 
            "&channelid="+ <?php echo $_REQUEST["channelid"] ?>;
            $("#content").load(toload);
          }
    })
  })

  $('#editConfirm').click(function(){
    var url = "index.php?view=chat";
    $.ajax({
      type: "POST",
      url: url,
      data: encodeURI("action=editPost&postId=" + <?php echo $editable ?> + "&newText=" + htmlEntities($('#editedText').val())),
        success: function(data){
          var toload = "index.php?view=chatContent" + 
          "&channelid="+ <?php echo $_REQUEST["channelid"] ?>;
          $("#content").load(toload);
        }
    })
  })

  $('.actionButton').click(function(){
    var url = "index.php?view=chat";
    $.ajax({
      type: "POST",
      url: url,
      data: encodeURI("action=toggleImportant&postId=" + $(this).parent().parent().attr('id') + "&userId=" + "<?php echo $user->getId();?>"),
        success: function(data){
          var toload = "index.php?view=chatContent" + 
          "&channelid="+ <?php echo $_REQUEST["channelid"] ?>;
          $("#content").load(toload);
        }
    })
  })
</script>
