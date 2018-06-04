<?php

use NChat\Channel;
use NChat\Post;
use NChat\AuthenticationManager;

use Data\DataManager;
$posts = null;
$posts = DataManager::getPostsByChannelId($_REQUEST["channelid"]);
$user = AuthenticationManager::getAuthenticatedUser();

$editable = DataManager::getEditablePostId($_REQUEST["channelid"], $user->getId());
echo $editable;
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
          
          <?php if($post->getId() == $editable) { ?>
          <button type="button" class="actionButton" data-toggle="modal" data-target="#myModal">
            <span class="glyphicon glyphicon-pencil"></span>
          </button>

          <button type="button" class="actionButton">
            <span class="glyphicon glyphicon-remove"></span>
          </button>

          
          <?php }?>
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

<form class="newPostForm" id="newPostForm">
  <p> Neuen Beitrag erstellen </p>
  <div class="input-group">
    <span class="input-group-addon">Titel</span>
    <input id="newTitle" type="text" class="form-control" name="<?php echo NChat\Controller::NEW_TITLE ?>" placeholder="Titel">
  </div>

  <div class="input-group">
    <span class="input-group-addon">Text</span>
    <textarea id="newTitle" type="text" class="form-control" name="<?php echo NChat\Controller::NEW_TEXT ?>" placeholder="Text"/>
  </div>

  <input type="submit" value="Erstellen"/>

  </div>
</form>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script>
  $("#newPostForm").submit(function(e) {
    var url = "index.php?view=chat&action=newPost"; // the script where you handle the form input.
    $.ajax({
          type: "POST",
          url: url,
          data: $("#newPostForm").serialize()
                +"&channelId="+<?php echo $_REQUEST["channelid"]; ?>+
                "&userId="+<?php echo $user->getId(); ?>, // serializes the form's elements.
          success: function(data)
          {
            var toload = "index.php?view=chatContent" + 
            "&channelid="+ <?php echo $_REQUEST["channelid"] ?>;
            $("#content").load(toload);
          }
        });
    e.preventDefault(); // avoid to execute the actual submit of the form.
  });

  $(".glyphicon-pencil").click(function(){
    alert("edit something");
  })  

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
</script>
