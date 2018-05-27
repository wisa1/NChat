<?php
use NChat\AuthenticationManager;
use NChat\Util;
?>

<?php require_once('views/partials/header.php'); ?>
<div class="container">
        <div class="row centered-form">
        <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
        	<div class="panel panel-default">
        		<div class="panel-heading">
			    		<h3 class="panel-title">Registrierung NChat</h3>
			 			</div>
			 			<div class="panel-body">
			    		<form role="form" method="post" action="<?php echo Util::action(NChat\Controller::REGISTER, array('view' => $view)); ?>">
                <div class="form-group">
			    				<input type="text" name="<?php echo NChat\Controller::USER_NAME?>" id="username" class="form-control input-sm" placeholder="Benutzername">
			    			</div>

			    			<div class="form-group">
			    				<input type="email" name="<?php echo NChat\Controller::USER_EMAIL?>" id="email" class="form-control input-sm" placeholder="Email Address">
			    			</div>

			    			<div class="row">
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			    						<input type="password" name="<?php echo NChat\Controller::USER_PASSWORD?>" id="password" class="form-control input-sm" placeholder="Password">
			    					</div>
			    				</div>
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			    						<input type="password" name="<?php echo NChat\Controller::USER_PASSWORD_CONFIRMATION?>" id="password_confirmation" class="form-control input-sm" placeholder="Confirm Password">
			    					</div>
			    				</div>
			    			</div>
			    			<input type="submit" value="Register" class="btn btn-info btn-block">
			    		</form>
			    	</div>
	    		</div>
    		</div>
    	</div>
    </div>