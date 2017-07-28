<?php
include_once("../config.php");

global $connection;

error_reporting(0);
ini_set('max_execution_time', 3600);


if (isset($_POST['project_id']) AND isset($_FILES['basefeed'])){

	$basefeed 		= $_FILES['basefeed']['tmp_name'];
	$project_id		= $_POST['project_id'];

	$dataFeed		= file_get_contents($basefeed);

	$dataFeedLines  = explode("\n",$dataFeed);

	$i = 0;
	
	foreach ($dataFeedLines as $key => $value) {

	$i++;
	if ($i == 1){
		continue;
	}

	$each_line 					= explode("\t", $value);

	$product_type 				= str_replace('\"','',$each_line[0]);
	$title 						= str_replace('\"','',$each_line[1]);
	$description 				= str_replace('\"','',$each_line[2]);
	$link 						= str_replace('\"','',$each_line[3]);
	$image_link 				= str_replace('\"','',$each_line[4]);
	$id 						= str_replace('\"','',$each_line[5]);
	$label 						= str_replace('\"','',$each_line[6]);
	$price 						= str_replace('\"','',$each_line[7]);
	$size 						= str_replace('\"','',$each_line[8]);
	$availability 				= str_replace('\"','',$each_line[9]);
	$item_condition 			= str_replace('\"','',$each_line[10]);
	$brand		    			= str_replace('\"','',$each_line[11]);
	$google_product_category 	= str_replace('\"','',$each_line[12]);
	$gender 					= str_replace('\"','',$each_line[13]);
	$age_group 					= str_replace('\"','',$each_line[14]);
	$mpn 						= str_replace('\"','',$each_line[15]);
	$color 						= str_replace('\"','',$each_line[16]);
	$item_group_id				= str_replace('\"','',$each_line[17]);
	$style_number 				= str_replace('\"','',$each_line[18]);
	$gtin		 				= preg_replace('/\s+/', '', $each_line[19]);

		insertFeed($project_id, $product_type, $title, $description, $link, $image_link, $id, $label, $price, $size, $availability, $item_condition, $brand, $google_product_category, $gender, $age_group, $mpn, $color, $item_group_id, $style_number, $gtin);

	}

	echo 'Done. Base data feed updated.';



}else{

	echo 'No post data.';

	var_dump($_FILES);
}

function insertFeed($project_id, $product_type, $title, $description, $link, $image_link, $id, $label, $price, $size, $availability, $item_condition, $brand, $google_product_category, $gender, $age_group, $mpn, $color, $item_group_id, $style_number, $gtin){
	// echo 'warning field: '.$warning_field . $warning_message;
	try {
	global $connection;
	
	$sql = "INSERT INTO basedatafeed(project_id, product_type, title, description, link, image_link, id, custom_label, price, size, availability, `condition`, brand, google_product_category, gender, age_group, mpn, color, item_group_id, style_number, gtin)
	 VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";



	$stmtdatafeed = $connection->prepare($sql);
	$values = array($project_id, $product_type, $title, $description, $link, $image_link, $id, $label, $price, $size, $availability, $item_condition, $brand, $google_product_category, $gender, $age_group, $mpn, $color, $item_group_id, $style_number, $gtin);
	$stmtdatafeed->execute($values);
	

	}catch(Exception $e) {
    echo 'Exception -> ';
    echo $sql;
    // var_dump($e->getMessage());
    die($e);
	}
	
}




?>