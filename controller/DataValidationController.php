<?php


// include_once("../datafeed-db_config.php");

include_once("../config.php");
global $connection;

error_reporting(0);
ini_set('max_execution_time', 3600);


$productfeeds		= urldecode($argv[1]);

$pid 				= urldecode($argv[2]);
$uid 				= urldecode($argv[3]);

$productFeed 	= file_get_contents($productfeeds);




$productLine 	= explode("\n",$productFeed);
$productCols	= explode("\t",$productFeed); // array with all columns


/*
$dataFeed		= file_get_contents($basefeed);
$dataFeedLines  = explode("\n",$dataFeed);
$dataFeedCols   = explode("\t",$productFeed); */

$newDataFeed	= "product_type\ttitle\tdescription\tlink\timage_link\tid\tlabel\tprice\tsize\tavailability\tcondition\tbrand\tgoogle_product_category\tgender\tage_group\tmpn\tcolor\titem_group_id\tstyle_number\tGTIN\n";

$removedData	= "product_type\ttitle\tdescription\tlink\timage_link\tid\tlabel\tprice\tsize\tavailability\tcondition\tbrand\tgoogle_product_category\tgender\tage_group\tmpn\tcolor\titem_group_id\tstyle_number\tGTIN\n";

    $query = $connection->prepare('SELECT * FROM basedatafeed b WHERE project_id = :project_id');
    $query->execute(['project_id' => $pid]);


	$query->setFetchMode( PDO::FETCH_OBJ ); 

		while( $row = $query->fetch() ) 
		{  
				$product_type 				=  $row->product_type;
				$title 						=  $row->title;
				$description 				=  $row->description;
				$link 						=  $row->link;
				$image_link 				=  $row->image_link;
				$id 						=  $row->id;
				$label 						=  $row->custom_label;
				$price 						=  $row->price;
				$size 						=  $row->size;
				$availability 				=  $row->availability;
				$item_condition 			=  $row->condition;
				$brand		    			=  $row->brand;
				$google_product_category 	=  $row->google_product_category;
				$gender 					=  $row->gender;
				$age_group 					=  $row->age_group;
				$mpn 						=  $row->mpn;
				$color 						=  $row->color;
				$item_group_id				=  $row->item_group_id;
				$style_number 				=  $row->style_number;
				$gtin		 				=  $row->gtin; 

				///data validation

				$error = 0;
				$warning_message = '';
				$warning_field = '';
//-----------------------------------------Product Type Validation
				//echo 'product_type: '. $product_type;
				if($product_type == '' OR $product_type == null){
					$error++;
					//failed 
					$warning_field .= '[product_type]';
					$warning_message .= '[Product type no data]';
					$other_data = $product_type;					
					
				}elseif (strlen($product_type) > 750){
					$error++;
					//failed 
					$warning_field .= '[product_type]';
					$warning_message .= '[Max 750 alphanumeric characters]';
					$other_data = $product_type;
					
				}else{
					//success
				}



			//-----------------------------------------Title Validation
				//echo 'title: '. $title;
				if($title == '' OR $title == null){
					$error++;
					//failed 
					$warning_field .= '[title]';
					$warning_message .= '[Title no data]';
					$other_data = $title;
					
				}elseif (strlen($title) > 150){
					$error++;
					//failed 
					$warning_field .= '[title]';
					$warning_message .= '[Title Max 150 characters]';
					$other_data = $title;
					
				}else{
					//success
				}
				
			//-----------------------------------------Description Validation
				//echo 'description: '. $description;
				if($description == '' OR $description == null){
					$error++;
					//failed 
					$warning_field .= '[description]';
					$warning_message .= '[Description no data]';
					$other_data = $description;
					
				}elseif (strlen($description) > 5000){
					$error++;
					//failed 
					$warning_field .= '[description]';
					$warning_message = '[Description Max 5000 characters]';
					$other_data = $description;
					
				}else{
					//success
				}
				
			//-----------------------------------------Link Validation
				//echo 'link: '. $link;
				$https_link = substr($link, 0, 5);
				$http_link = substr($link, 0, 4);
				
					if($link == '' OR $link == null){
						$error++;
						//failed
						$warning_field .= '[description]';
						$warning_message .= '[Link no data]';
						$other_data = $description;
						
					}elseif (strlen($link) > 2000){
						$error++;
						//failed
						$warning_field .= '[link]';
						$warning_message .= '[Link Max 2000 characters]';
						$other_data = $link;
						
					}elseif (strpos($link, 'http://') !== false) {
						//success
					}elseif(strpos($link, 'https://') !== false)
					{
						//success
					}else{
						$error++;
						$warning_field .= '[link]';
						$warning_message .= 'link is not http/https';
						$other_data = $link;
						
					}
			
				//-----------------------------------------Image Link Validation
				
				/*
				$https_image = substr($link, 0, 5);
				$http_image = substr($link, 0, 4);
				$image_format = substr($image_link, -4);
				$image_format_five = substr($image_link, -5);
				*/

				if (strpos($image_link, 'http://') !== false) {
					//success
				}elseif(strpos($image_link, 'https://') !== false){
					//success
				}else{
					$error++;
					//failed
					$warning_field .='[link]';
					$warning_message .= '[image link is not http/https]';
					$other_data = $link;					
				}
				
				
				if(strpos($image_link, '.jpg') !== false){
					
				}elseif(strpos($image_link, '.jpg') !== false){
					
				}elseif(strpos($image_link, '.jpeg') !== false){
					
				}elseif(strpos($image_link, '.png') !== false){
					
				}elseif(strpos($image_link, '.bmp') !== false){
					
				}elseif(strpos($image_link, '.tif') !== false){
					
				}elseif(strpos($image_link, '.tiff') !== false){
					
				}else{
					$error++;
					//failed
					$warning_field .= '[image_link]';
					$warning_message .= '[Image link wrong format of image]';
					$other_data = $image_link;
					
				}
				
				if($image_link == '' OR $image_link == null){
					//failed
					$error++;
				}elseif(strlen($image_link) > 2000){
					//failed
					$error++;
				}

		//-----------------------------------------ID Validation
			
			if($id == '' OR $id == null){
				$error++;
				$warning_field .= '[id]';
				$warning_message .= '[id no data]';
				$other_data = $id;
				
			}elseif(strlen($id) > 50){
				$error++;
				$warning_field = 'id';
				$warning_message .= '[Max 50 characters]';
				$other_data = $id;
				
			}else{
				//success
			}
			
		//-----------------------------------------LABEL Validation
			
			if($label == '' OR $label == null){
				$error++;
				//failed				
				$warning_field .= '[label]';
				$warning_message .= '[Label no data]';
				$other_data = $label;
				
			}
		
		//-----------------------------------------PRICE Validation
			
			if($price == '' OR $price == null){
				$error++;
				//failed
				$warning_field .= '[price]';
				$warning_message .= '[Price no data]';
				$other_data = $price;
				
			}
			
		//-----------------------------------------SIZE Validation
			
			if($size == '' OR $size == null){
				$error++;
				//failed
				$warning_field .= '[size]';
				$warning_message .= '[Size no data]';
				$other_data = $size;
				
			}elseif(strlen($size) > 100){
				$error++;
				//failed
				$warning_field .= '[size]';
				$warning_message .= '[Size Max 100 characters]';
				$other_data = $size;
				
			}
			
		//-----------------------------------------AVAILABILITY Validation
			
			if($availability == '' OR $availability == null){
				$error++;
				//failed
				$warning_field .= '[availability]';
				$warning_message .= '[Availability no data]';
				$other_data = $availability;
				
			}
		 
		//-----------------------------------------CONDITION Validation
			
			if($item_condition == '' OR $item_condition == null){
				$error++;
				//failed
				$warning_field .= '[condition]';
				$warning_message .= '[Condition no data]';
				$other_data = $item_condition;
				
			}
		 
		//-----------------------------------------BRAND Validation
			
			if($brand == '' OR $brand == null){
				$error++;
				//failed
				$warning_field .= '[brand]';
				$warning_message .= '[Brand no data]';
				$other_data = $brand;
				
			}elseif(strlen($brand) > 70){
				$error++;
				//failed
				$warning_field .= '[brand]';
				$warning_message .= '[Brand Max 70 characters]';
				$other_data = $brand;
				
			}
		
		//-----------------------------------------GOOGLE PRODUCT CATEGORY Validation
			
			if($google_product_category == '' OR $google_product_category == null){
				//failed
				$error++;
				$warning_field .= '[google_product_category]';
				$warning_message .= '[Product category no data]';
				$other_data = $google_product_category;
				
			}
		 
		//-----------------------------------------GENDER Validation
			
			if($gender == '' OR $gender == null){
				$error++;
				//failed
				$warning_field .= '[gender]';
				$warning_message .= '[Gender no data]';
				$other_data = $gender;
				
			}if(strcasecmp($gender,'male') == 0 OR strcasecmp($gender, 'female') == 0 OR strcasecmp($gender, 'unisex')){
				//success
			}else{
				$error++;
				//failed
				$warning_field .= '[gender]';
				$warning_message .= '[Gender value is incorrect]';
				$other_data = $gender;
				
			}
		 
		//-----------------------------------------GENDER Validation
			
			if($age_group == '' OR $age_group == null){
				$error++;
				$warning_field .= '[age_group]';
				$warning_message .= '[Age group no data]';
				$other_data = $age_group;
				
			}if($age_group == 'newborn' OR $age_group == 'infant' OR $age_group == 'toddler' OR $age_group == 'kids' OR $age_group == 'adult'){
				//success
			}else{
				$error++;
				//failed
				$warning_field .= '[age_group]';
				$warning_message .= '[age_group is incorrect]';
				$other_data = $age_group;
				
			}
		 
		//-----------------------------------------MPN Validation
			
			if($mpn == '' OR $mpn == null){
				$error++;
				//failed
				$warning_field .= '[mpn]';
				$warning_message .= '[MPN no data]';
				$other_data = $link;
				
			}elseif(strlen($mpn) > 70){
				$error++;
				//failed
				$warning_field .= '[mpn]';
				$warning_message .= '[MPN Max 70 alphanumeric characters]';
				$other_data = $mpn;
				
			}
		 
		//-----------------------------------------COLOR Validation
			
			if($color == '' OR $color == null){
				$error++;
				//failed
				$warning_field .= '[color]';
				$warning_message .= '[Color no data]';
				$other_data = $color;
				
			}elseif(strlen($color) > 100){
				$error++;
				//failed
				$warning_field .= '[color]';
				$warning_message .= '[Color Max 100 alphanumeric characters]';
				$other_data = $color;
				
			}
		 
			
			if($item_group_id == '' OR $item_group_id == null){
				$error++;
				//failed
				$warning_field .= '[item_group_id]';
				$warning_message .= '[Item group id no data]';
				$other_data = $item_group_id;
				
			}elseif(strlen($item_group_id) > 50){
				$error++;
				//failed
				$warning_field .= '[item_group_id]';
				$warning_message .= '[Item group id Max 50 alphanumeric characters]';
				$other_data = $item_group_id;
				
			}
			
					
		//-----------------------------------------style_number Validation
			
			if($style_number == '' OR $style_number == null){
				$error++;
				//failed
				$warning_field .= '[style_number]';
				$warning_message .= '[Style number no data]';
				$other_data = $style_number;
				
			}
		 
		//-----------------------------------------GTIN Validation
			
			if($gtin == '' OR $gtin == null){
				$error++;
				//failed
				$warning_field .= '[GTIN]';
				$warning_message .= '[GTIN no data]';
				$other_data = $gtin;
				
			}elseif(strlen($gtin) > 50){
				$error++;
				//failed
				$warning_field .= '[GTIN]';
				$warning_message .= '[ GTIN Max 50 numeric characters ]';
				$other_data = $gtin;
				
			}

				//data validation

				if($error == 0){
				//Update availability
				$key = array_search($id, $productCols); 
				//Searches the array for a given value and returns the first corresponding key if successful
				if ($key !== false) {
					$newStatus = $productCols[$key+4];
					if ($newStatus == "Y"){
						$newAvailability = "in stock";
					}elseif ($newStatus == "N"){
						$newAvailability = "out of stock";
					}else{
						$newAvailability = "";
					}
				}


				if ((in_array($link,$productCols)) AND (in_array($id,$productCols))){
					// if in datafeed and in productfeed ==> adjust in stock, price fields
					$newDataFeed .= "$product_type \t $title \t $description \t $link \t $image_link \t $id \t $label \t $price \t $size \t $newAvailability \t $item_condition \t $brand \t $google_product_category \t $gender \t $age_group \t $mpn \t $color \t $item_group_id \t $style_number \t $gtin \n";

				}else{
					// if in datafeed but not in productfeed ==> remove
					$removedData .= "$product_type \t $title \t $description \t $link \t $image_link \t $id \t $label \t $price \t $size \t $availability \t $item_condition \t $brand \t $google_product_category \t $gender \t $age_group \t $mpn \t $color \t $item_group_id \t $style_number \t $gtin \n";
				}  
				// end if for errors      
			}else{



				insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data, $id);
			}
		}


	$result = $query->fetchAll();


//compare product lines to data feed.
foreach ($productLine as $key => $value) {
	$i++;
	if ($i == 1){
		continue;
	}

	//testing purposes only
	if($i == 10){
		// break;
	}
	
	//product_type	title	description	link	image_link	id	label	price	size	availability	condition	brand	google_product_category	gender	age_group	mpn	color	item_group_id	style_number	GTIN
	//each lines again splitted to objects by comma
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
	
	$key = array_search($id, $result);
	if ($key !== false) {
		// if in product feed but not datafeed = add
		$removedData .= "$product_type \t $title \t $description \t $link \t $image_link \t $id \t $label \t $price \t $size \t $availability \t $item_condition \t $brand \t $google_product_category \t $gender \t $age_group \t $mpn \t $color \t $item_group_id \t $style_number \t $gtin \n";
	}
}

// Write the contents back to the file


$ndf = file_put_contents("../public/new_datafeedversion4.txt", $newDataFeed);
$rd  = file_put_contents("../public/removedData.txt", $removedData);

if($ndf and $rd){
	echo "Done. Files created.";	
}else{
	echo "There were errors while writing the file.";
}


function insertWarning($connection,$warning_field,$warning_message,$other_data, $feed_id){
	// echo 'warning field: '.$warning_field . $warning_message;
	try {
	global $connection,$warning_field,$warning_message,$other_data,$uid,$pid;
	
	// global $connection;


	$stmtdatafeed = $connection->prepare("INSERT INTO warning_list (project_id,user_id,warning_field,warning_message,other_data, feed_id) VALUES (?,?,?,?,?,?)");
	$stmtdatafeed->execute(array($pid,$uid,$warning_field,$warning_message,$other_data,$feed_id));
	

	}catch(Exception $e) {
    	var_dump($e);
	}
	//exit(header('Location: ' . $_SERVER['HTTP_REFERER']));
	// redirect($user_id);
}


?>