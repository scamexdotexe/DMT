<!DOCTYPE html>
<html lang="en">
<link href="css/custom-project.css" rel="stylesheet">

<body>
  
<?php
	session_start();
	include_once("../config.php");
	include_once('view_variables.php');
	include_once('../includes/functions.php');

	$counter = true;
	if(isset($_SESSION['user_id'])) {
		//$post_GET = $_GET['id'];
		$post_GET = $_SESSION['user_id'];
		$id = $post_GET;
		$counter = true;
	}else{
		$counter = false;
?> 
		<script>//window.location = "login.php";</script>
<?php
	}
	
	$stmtuser = $connection->prepare("SELECT * FROM tbl_user WHERE id = :id");
	$stmtuser->execute(['id' => $id]);
	$rowCount = $stmtuser->rowCount();
	
	if($rowCount >= 1){
		while ($row = $stmtuser->fetch())
		{
			//FETCH DATA
			$user_id = $row['id'];
			$username = $row['username'];
			$password = $row['password'];
			$email = $row['email'];
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
  
	
  <style>
    /* Remove the navbar's default rounded borders and increase the bottom margin */ 
    .navbar {
      margin-bottom: 50px;
      border-radius: 0;
    }
    
    /* Remove the jumbotron's default bottom margin */ 
     .jumbotron {
      margin-bottom: 0;
    }
   
    /* Add a gray background color and some padding to the footer */
    footer {
      background-color: #f2f2f2;
      padding: 5px;
	  margin-top: 135px;
	  display:none !important;
    }
	
	.jumbotron {
		padding: 0px !important;
	}
	
	body{
		font-family: 'Istok Web', sans-serif;
	}
  </style>

</head>

<nav class="navbar navbar-inverse" style="background-color:#2a363b !important;border-color:none !important">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href=<?php echo $home.'?username='.$username;?>  style="color:white !important">HOME |</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href= <?php echo $project; ?> style="color:white !important" >Projects</a></li>
      </ul>
	  <ul class="nav navbar-nav">
        <li><a href= <?php echo $datafeed; ?> style="color:white !important" >DataFeed</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href= <?php echo $login; ?> style="color:white !important" ><span></span>Logout</a></li>
      </ul>
    </div>
  </div>
</nav>



<!-- For Data Tables -->
    <script>
		$(document).ready(function(){
			$('#example').DataTable();
		});
	</script>
	
<!-- End of DataTables -->

<div class="container">    
	<div class="row">

	<div class="col-xs-2">
		<button style="margin-left: 15px;" type="submit" data-toggle="modal" data-target="#myModal" class="btn btn-success"><center>Create Project</center></button> 
	</div>
	<div class="col-xs-10">
		<div id="feedback">
			<span>* Before you can add product feed, add base feed first for your project.</span>
		</div>
	</div>

	</div>
	<br/>
    <?php
	
		$conn = mysqli_connect("localhost","root","","dmt");
		if (mysqli_connect_errno())
		  {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();

		  }else{
		  }
	
		$sql = "SELECT * FROM projects WHERE user_id = '$user_id' ";
		$result = $conn->query($sql);
	?>
		<table id="example" class="display" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>ID</th>
					<th>Project Name</th>
					<th>Project Type</th> 
					<th>Data Feed</th> 
					<th>Timestamp</th> 
					<th>Action</th> 
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>ID</th>
					<th>Project Name</th>
					<th>Project Type</th> 
					<th>Data Feed</th> 
					<th>Timestamp</th> 
					<th>Action</th> 
				</tr>
			</tfoot>
			<tbody>
				<?php



					if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						$project_id = $row["id"];
						echo "<tr>".
						"<td>".$row["id"]."</td>".
						"<td>".$row["project_na"]."</td>".
						"<td>".$row["project_type"]."</td>".
						"<td>".$row["data_feed"]."</td>".
						"<td>".$row["timestamp"]."</td>".
						"<td><a class ='btn btn-warning btn-sm btn-dmt-delete' href='../api/delete_projects.php?project_id=$project_id&user_id=$user_id'>"."Delete</a> ";

						if(isFeedExists($project_id)){

						}else{

						echo " <a  data-toggle='modal' data-target='#myModalBase' id='{$project_id}' data-id='{$project_id}'  class ='btn btn-success btn-sm' href='#'>"."Add Base Data</a></td>";
						}
						
						echo "</tr>";
					}
					} else {
						echo "0 results";
					}
					$conn->close();
				?>
			</tbody>
		</table>
		
</div><br>

<!-- modal spinner -->
 <div class="modal fade" id="spinner" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">          
          <h4 class="modal-title"><b>Please wait...</b></h4>
        </div>
        <div class="modal-body">
		<img style="margin: auto; display: block;" src="images/ajax-loader.gif" alt="">
        </div>
       
      </div> 
    </div>
  </div>
 <!-- Modal -->
  <div class="modal fade" id="myModalBase" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><b>Upload Basefeed</b></h4>
        </div>
        <div class="modal-body">
		<form id="basefeed" class="project" enctype="multipart/form-data" method="POST">
          <label for="project_na">Select a basefeed file.</label>
		  <input type="file" name="basefeed" required>
		 
		  <hr/>
		  <input type="hidden" name="user_id" value="<?php echo "$user_id" ?>" required>
		  <input type="hidden" id="project_idcontainer" name="project_id" required>
		  <center><button type="submit" id="ajax" class="btn btn-primary">Submit</button></center>
		</form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div> 
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><b>Create Project</b></h4>
        </div>
        <div class="modal-body">
		<form action="../controller/ProjectController.php" class="project" enctype="multipart/form-data" method="POST">
          <label for="project_na">Enter Project Name</label>
		  <input type="text" name="project_na" placeholder="Project Name" required>
		  <hr/>
		  <label for="project_type">Select Project Type</label>
		  
		  <select name="project_type">
		  <option value="Merchant Center" selected>Merchant Center</option>
		  <option value="Project Type 1">Project Type 1</option>
		  <option value="Project Type 2">Project Type 2</option>
		  <option value="Project Type 3">Project Type 3</option>
		  </select>
		  <hr/>
		  <input type="hidden" name="user_id" value="<?php echo "$user_id" ?>" required>
		  
		  <center><button type="submit" id="ajax" class="btn btn-primary">Submit</button></center>
		</form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div> 
    </div>
  </div>
  
<!-- Script -->
<script>

	$('#myModalBase').on('show.bs.modal',function(e){
        
        var invoker = $(e.relatedTarget).attr('id');
        
        $('#project_idcontainer').val(invoker);

        
    });

$(':file').change(function(){
    var file = this.files[0];
    name = file.name;
    size = file.size;
    type = file.type;

    size = size / 1000;
	if(size > 9000){
	    alert('The File is greater than allowed size.' + size);
		$('#ajax').attr('disabled','disabled');	
	}else{
		alert(size);
	}
	
    var ext = this.value.match(/\.(.+)$/)[1];
    switch (ext) {
        case 'txt':
        case 'csv':
            break;
        default:
            alert('This is not an allowed file type.');
            this.value = '';
			$('#ajax').attr('disabled','disabled');	
    }
});
	
</script>

<script>
		
		$('#basefeed').submit(function(e){

        e.preventDefault();

         		$('#spinner').modal('show');
          	   $('#myModalBase').modal('hide');

        var formData = new FormData($(this)[0]);

        var inputs = $("#upload_data input[type='file']");

        $.each(inputs, function (obj, v) {
        	var file = v.files[0];
        	 var name = $(v).attr("id");
        	 formData.append(name, file);
    	});

        $.ajax({
            url: '../controller/addbase.php',
            type: 'POST',
            data: formData,
            async: false,
            enctype: 'multipart/form-data',            
            success: function (data) {
                $('#feedback').empty();
                    $('#feedback').append('<div class="alert alert-success">' +
   data+
'</div>');
                    $('#spinner').modal('hide');
            },
            error: function(){
               $('#feedback').empty();
                    $('#feedback').append('<div class="alert alert-warning"><pre>' +
   JSON.stringify(data) +
'</pre></div>');
                    $('#spinner').modal('hide');
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });
	</script>

</body>
</html>
