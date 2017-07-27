<!DOCTYPE html>
<html lang="en">
<style>
.modal-dialog{
    position: relative;
    display: table; //This is important 
    overflow-y: auto;    
    overflow-x: auto;
    width: 400px !important;
    min-width: 400px !important;   
}

	
	@media (min-width: 1200px)
	bootstrap.min.css:11
	.container {
		width: 1450px !important;
	}
	
	.dataTables_wrapper{
		border-width: 1px !important;
		border-style:solid !important;
		border-color: #A1A1A1 !important;
		padding: 5px !important;
	}
	
</style>
<body>

<?php
	session_start();
	include_once("../datafeed-db_config.php");
	include_once("../config.php");
	include_once('view_variables.php');
	$counter = true;
	if(isset($_SESSION['user_id'])) {
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
  <link href="css/custom-datafeed.css" rel="stylesheet">

</head>

<nav class="navbar navbar-inverse" style="background-color:#8b9dc3 !important;border-color:none !important">
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


  
<?php
	$stmtuser = $con_datafeed_db->prepare("SELECT * FROM warning_list");
	$rowCount = $stmtuser->rowCount();
?>

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
		<button style="margin-left: 15px;" type="submit" data-toggle="modal" data-target="#myModal" class="btn btn-success"><center>Create Datafeed</center></button> 
	</div>
	<div class="col-xs-10">
		<div id="feedback">
	
		</div>
		</div>
	</div>
	<br/>
    <?php
	
		$conn = mysqli_connect("localhost","root","","datafeed_db");
		if (mysqli_connect_errno())
		  {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();

		  }else{
		  }
	
		$sql = "SELECT * FROM warning_list WHERE user_id = '$user_id' ";
		$result = $conn->query($sql);
	?>
		<table id="example" class="display" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>ID</th>
					<th>Other Data</th>
					<th>Project id</th> 
					<th>Timestamp</th> 
					<th>User ID</th> 
					<th>Warning Field</th> 
					<th>Warning Message</th> 
					<th>Action</th> 
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>ID</th>
					<th>Other Data</th>
					<th>Project id</th> 
					<th>Timestamp</th> 
					<th>User ID</th> 
					<th>Warning Field</th> 
					<th>Warning Message</th> 
					<th>Action</th> 
				</tr>
			</tfoot>
			<tbody>
				<?php
					if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						$datafeed_id = $row["id"];
						echo "<tr>".
						"<td>".$row["id"]."</td>".
						"<td>".$row["other_data"]."</td>".
						"<td>".$row["project_id"]."</td>".
						"<td>".$row["timestamp"]."</td>".
						"<td>".$row["user_id"]."</td>".
						"<td>".$row["warning_field"]."</td>".
						"<td>".$row["warning_message"]."</td>".
						"<td>
						<a class ='btn btn-primary btn-sm' href='edit-page_datafeed.php?datafeed_id=$datafeed_id&user_id=$user_id'>"."Edit</a>
						</td>".
						"</tr>";
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
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><b>Create Datafeed</b></h4>
        </div>
        <div class="modal-body">
		<form id="upload_data" class="project" enctype="multipart/form-data" method="POST">
		  <label for="project_id">Select Project</label>
		  
			<?php
		  
			$stmtuser = $connection->prepare("SELECT * FROM projects WHERE user_id = :user_id");
			$stmtuser->execute(['user_id' => $user_id]);
			$rowCount = $stmtuser->rowCount();
			
			if($rowCount >= 1){
			?>
			<select id="project_id" name="project_id">
			<?php
				while ($row = $stmtuser->fetch())
				{
					//FETCH DATA
					$project_id = $row['id'];
					$project_na = $row['project_na'];
					$password = $row['password'];
					$email = $row['email'];
				?>
			<option value="<?php echo $project_id?>"><?php echo $project_na?></option>	
				<?php
				}	
			?>
			</select>
			<?php
			}
			?>	
		  <hr/>
		  <label>Current Product List<input  type="file" id="data_feed" name="data_feed" /></label>
		  <hr/>		 
		  <label>Product Feed<input  type="file" id="product_feed" name="data_feed" /></label>
		  <hr/>
		  <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>" required>

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

$(':file').change(function(){
    var file = this.files[0];
    name = file.name;
    size = file.size;
    type = file.type;
	if(size > 5000){
	    //alert('The File is greater than 5MB');
		//$('#ajax').attr('disabled','disabled');	
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
      /*  $('#upload_data').submit(function (e) {

        	e.preventDefault();

        	$('#spinner').modal('show');
        	$('#myModal').modal('hide');

            var form = $('form');
            var formData = new FormData();
            $.each($(':input', form), function (i, fileds) {
                formData.append($(fileds).attr('name'), $(fileds).val());
            });
            $.each($('input[type=file]', form)[0].files, function (i, file) {
                formData.append(file.name, file);
            });
            $.ajax({
                url: '../controller/runscript.php',
                method: 'POST',
                enctype: 'multipart/form-data',
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    // alert(data);
                    $('#feedback').empty();
                    $('#feedback').append('<div class="alert alert-success">' +
   data+
'</div>');
                    $('#spinner').modal('hide');
                },
                error: function (data) {
                	$('#feedback').empty();
                    $('#feedback').append('<div class="alert alert-warning"><pre>' +
   JSON.stringify(data) +
'</pre></div>');
                    $('#spinner').modal('hide');
                }
            });
        }); */
	</script>

	<script>
		
		$('#upload_data').submit(function(e){
        e.preventDefault();

         		$('#spinner').modal('show');
          	   $('#myModal').modal('hide');

        var formData = new FormData($(this)[0]);

        var inputs = $("#upload_data input[type='file']");

        $.each(inputs, function (obj, v) {
        	var file = v.files[0];
        	 var name = $(v).attr("id");
        	 formData.append(name, file);
    	});

        $.ajax({
            url: '../controller/runscript.php',
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
