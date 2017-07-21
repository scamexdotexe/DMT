<!DOCTYPE html>
<html lang="en">
<head>
  <title>DMT WORK</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Architects+Daughter" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Istok+Web" rel="stylesheet">
  <link href="css/custom-login.css" rel="stylesheet">
</head>

<body>

<?php 
if(session_id() != '') {
    session_unset();
	session_destroy();
}
?>

<center>
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Reset Password</h4>
        </div>
        <div class="modal-body">
		<form class="email" method="post">
          <p>Enter your Email for verification:</p>
		  <input type="text" name="email" required>
		  <button type="button" id="ajax" class="green big"><span>Reset</span></button> <br/>
			 <input type="text" name="success" id="success" class="alert alert-success">
		</form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div> 
    </div>
  </div>
</center>

<script>

$("#success").hide();
		$("#ajax").click(function(){
		$("#success").hide();
		$.ajax({
		  method: "POST",
		  url: "../controller/ResetController.php",
		  data: $('form.email').serialize(),
		})
		  .done(function( msg ) {
			if(msg == 'failed'){
				alert('Sorry, your email is not allowed to enter.');
				return false;
			}else{
				$("#success").show();
				$("#success").val(msg);
			}
		  })
		});
		
</script>

<div class="container">    
	<div class="row">
	<form action="../controller/UserController.php" method="POST">
	<h2 id="login_header">User Login</h2>
	<center>
	<hr id="separator"/>
	  <p>
	   <label> <span class="glyphicon glyphicon-user"></span>Username</label>
			<input id="username" value="" name="username" type="text" required="required" /><br>
	  </p>
	  <p>
	   <label><span class="glyphicon glyphicon-lock"></span>Password</label>
			<input id="password" name="password" type="password" required="required" />
	  </p>
	  <p>
		<input type="checkbox" name="remember_me" value="1" > Remember Me?<br>
	  </p>
	  <p>
		<button type="submit" class="btn" name="submit"><span><b>Login</b></span></button> 
		<button type="button" class="btn" data-toggle="modal" data-target="#myModal"><b>Reset</b></button>
	  </p>
	 </form>
	</center>
	</div>
</div>
<br>

</body>
</html>