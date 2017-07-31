<!DOCTYPE html>
<html lang="en">
<body>
  
<?php
	include_once("../datafeed-db_config.php");
	global $con_datafeed_db;
	include_once('view_variables.php');
	
	$counter = true;
	if(isset($_GET['datafeed_id'])) {
		$datafeed_id = $_GET['datafeed_id'];
		$user_id = $_GET['user_id'];
		$counter = true;
	}else{
		$counter = false;
?> 
		<script>//window.location = "login.php";</script>
<?php
	}
	
	$stmtuser = $con_datafeed_db->prepare("SELECT * FROM warning_list WHERE id = ? AND user_id = ? ");
	$stmtuser->execute([$datafeed_id,  $user_id]);
	$rowCount = $stmtuser->rowCount();
	
	if($rowCount >= 1){
		while ($row = $stmtuser->fetch())
		{
			//FETCH DATA
			$id = $row['id'];
			$other_data = $row['other_data'];
			$project_id = $row['project_id'];
			$warning_field = $row['warning_field'];
			$warning_message = $row['warning_message'];
			$user_id = $row['user_id'];
			
		}	
	}	
?>


<head>
  <title>DMT WORK</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Architects+Daughter" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Istok+Web" rel="stylesheet">
  <!-- Datatables-->
  <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <link href="css/custom-edit-page.css" rel="stylesheet">

</head>

<nav class="navbar navbar-inverse" style="background-color:#2a363b !important;border-color:none !important">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <!--<a class="navbar-brand" href=<?php echo $home.'?username='.$username;?>  style="color:white !important">HOME |</a>-->
      <a class="navbar-brand" href=<?php echo $home?>  style="color:white !important">HOME |</a>
	</div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href= <?php echo $project.'?id='.$user_id;?> style="color:white !important" >Projects</a></li>
      </ul>
	  <ul class="nav navbar-nav">
        <li><a href= <?php echo $datafeed.'?id='.$user_id;?> style="color:white !important" >DataFeed</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href= <?php echo $login; ?> style="color:white !important" ><span></span>Logout</a></li>
      </ul>
    </div>
  </div>
</nav>



<center>
<div class="container" >    
	<div class="row" >
		
		<h3>Edit Data Feed</h3>

	<table class="table table-bordered">
  <thead>
    <tr>
      <th>Field</th>
      <th>Value</th>

    </tr>
  </thead>
  <tbody>
    <tr>
      <th>Product Type</th>
      <td>Mark</td>
    
    </tr>
    <tr>
      <th>Title</th>
      <td>Jacob</td>
    
    </tr>
    <tr>
      <th>Description</th>
      <td>Larry</td>    
    </tr>
        <tr>
      <th>Link</th>
      <td>Larry</td>    
    </tr>
        <tr>
      <th>Image Link</th>
      <td>Larry</td>    
    </tr>
        <tr>
      <th>ID</th>
      <td>Larry</td>    
    </tr>
        <tr>
      <th>Availability</th>
      <td>Larry</td>    
    </tr>
        <tr>
      <th>Item Condition</th>
      <td>Larry</td>    
    </tr>
        <tr>
      <th>Brand</th>
      <td>Larry</td>    
    </tr>
     <tr>
      <th>Product Category</th>
      <td>Larry</td>    
    </tr>
     <tr>
      <th>Gender</th>
      <td>Larry</td>    
    </tr>
     <tr>
      <th>Age Group</th>
      <td>Larry</td>    
    </tr>
     <tr>
      <th>MPN</th>
      <td>Larry</td>    
    </tr>
     <tr>
      <th>Color</th>
      <td>Larry</td>    
    </tr>
     <tr>
      <th>Item Group ID</th>
      <td>Larry</td>    
    </tr>
     <tr>
      <th>Style Number</th>
      <td>Larry</td>    
    </tr>
     <tr>
      <th>GTIN</th>
      <td>Larry</td>    
    </tr>
  </tbody>
</table>
		
	</div>
	 
		
</div>
</center>

</body>
</html>
