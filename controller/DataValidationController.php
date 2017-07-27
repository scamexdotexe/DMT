<?php
error_reporting(0);

$basefeed 			= urldecode($argv[1]);
$productfeed 		= urldecode($argv[2]);
$pid 				= urldecode($argv[3]);
$uid 				= urldecode($argv[4]);

$productFeed 	= file_get_contents($productfeed);
$dataFeed		= file_get_contents($basefeed);

$productLine 	= explode("\n",$productFeed);
$productCols	= explode("\t",$productFeed); // array with all columns

echo "[+] Products Length: ".count($productCols)."\n";
echo "[+] Products Lines Length: ".count($productLine)."\n";

$dataFeedLines  = explode("\n",$dataFeed);
$dataFeedCols   = explode("\t",$productFeed);

$newDataFeed	= "product_type\ttitle\tdescription\tlink\timage_link\tid\tlabel\tprice\tsize\tavailability\tcondition\tbrand\tgoogle_product_category\tgender\tage_group\tmpn\tcolor\titem_group_id\tstyle_number\tGTIN\n";
$removedData	= "product_type\ttitle\tdescription\tlink\timage_link\tid\tlabel\tprice\tsize\tavailability\tcondition\tbrand\tgoogle_product_category\tgender\tage_group\tmpn\tcolor\titem_group_id\tstyle_number\tGTIN\n";

echo "[+] Data Length: ".count($dataFeedLines)."\n";

// if not in productfeed then remove from datafeed
// update status in datafeed with status from productfeed

$i = 0;
foreach ($dataFeedLines as $key => $value) {
	$i++;
	if ($i == 1){
		continue;
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

	/*
	if in datafeed but not ptoduct feed = remove

	if in product feed but not datafeed = add

	if in both files adjust in stock, price fields
	*/
	$key = array_search($id, $productCols); //Searches the array for a given value and returns the first corresponding key if successful
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

				//-----------------------------------------Product Type Validation
				//echo 'product_type: '. $product_type;
				if($product_type == '' OR $product_type == null){
					//failed 
					$warning_field = 'product_type';
					$warning_message = 'no data';
					$other_data = $product_type;
					insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
				}elseif (strlen($product_type) > 750){
					//failed 
					$warning_field = 'product_type';
					$warning_message = 'Max 750 alphanumeric characters';
					$other_data = $product_type;
					insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
				}else{
					//success
				}



			//-----------------------------------------Title Validation
				//echo 'title: '. $title;
				if($title == '' OR $title == null){
					//failed 
					$warning_field = 'title';
					$warning_message = 'no data';
					$other_data = $title;
					insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
				}elseif (strlen($title) > 150){
					//failed 
					$warning_field = 'title';
					$warning_message = 'Max 150 characters';
					$other_data = $title;
					insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
				}else{
					//success
				}
				
			//-----------------------------------------Description Validation
				//echo 'description: '. $description;
				if($description == '' OR $description == null){
					//failed 
					$warning_field = 'description';
					$warning_message = 'no data';
					$other_data = $description;
					insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
				}elseif (strlen($description) > 5000){
					//failed 
					$warning_field = 'description';
					$warning_message = 'Max 5000 characters';
					$other_data = $description;
					insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
				}else{
					//success
				}
				
			//-----------------------------------------Link Validation
				//echo 'link: '. $link;
				$https_link = substr($link, 0, 5);
				$http_link = substr($link, 0, 4);
				
					if($link == '' OR $link == null){
						//failed
						$warning_field = 'description';
						$warning_message = 'no data';
						$other_data = $description;
						insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
					}elseif (strlen($link) > 2000){
						//failed
						$warning_field = 'link';
						$warning_message = 'Max 2000 characters';
						$other_data = $link;
						insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
					}elseif (strpos($link, 'http://') !== false) {
						//success
					}elseif(strpos($link, 'https://') !== false)
					{
						//success
					}else{
						$warning_field = 'link';
						$warning_message = 'link is not http/https';
						$other_data = $link;
						insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
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
					//failed
					$warning_field = 'link';
					$warning_message = 'link is not http/https';
					$other_data = $link;
					insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
				}
				
				echo 'IMAGE LINK: >>>>>>' .$image_link;
				if(strpos($image_link, '.jpg') !== false){
					
				}elseif(strpos($image_link, '.jpg') !== false){
					
				}elseif(strpos($image_link, '.jpeg') !== false){
					
				}elseif(strpos($image_link, '.png') !== false){
					
				}elseif(strpos($image_link, '.bmp') !== false){
					
				}elseif(strpos($image_link, '.tif') !== false){
					
				}elseif(strpos($image_link, '.tiff') !== false){
					
				}else{
					//failed
					$warning_field = 'image_link';
					$warning_message = 'wrong format of image';
					$other_data = $image_link;
					insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
				}
				
				if($image_link == '' OR $image_link == null){
					//failed
				}elseif(strlen($image_link) > 2000){
					//failed
				}

		//-----------------------------------------ID Validation
			echo 'id: '. $id;
			if($id == '' OR $id == null){
				$warning_field = 'id';
				$warning_message = 'no data';
				$other_data = $id;
				insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
			}elseif(strlen($id) > 50){
				$warning_field = 'id';
				$warning_message = 'Max 50 characters';
				$other_data = $id;
				insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
			}else{
				//success
			}
			
		//-----------------------------------------LABEL Validation
			echo 'label: '. $label;
			if($label == '' OR $label == null){
				//failed
				$warning_field = 'label';
				$warning_message = 'no data';
				$other_data = $label;
				insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
			}
		
		//-----------------------------------------PRICE Validation
			echo 'price: '. $price;
			if($price == '' OR $price == null){
				//failed
				$warning_field = 'price';
				$warning_message = 'no data';
				$other_data = $price;
				insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
			}
			
		//-----------------------------------------SIZE Validation
			echo 'size: '. $size;
			if($size == '' OR $size == null){
				//failed
				$warning_field = 'size';
				$warning_message = 'no data';
				$other_data = $size;
				insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
			}elseif(strlen($size) > 100){
				//failed
				$warning_field = 'size';
				$warning_message = 'Max 100 characters';
				$other_data = $size;
				insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
			}
			
		//-----------------------------------------AVAILABILITY Validation
			echo 'availability: '. $availability;
			if($availability == '' OR $availability == null){
				//failed
				$warning_field = 'availability';
				$warning_message = 'no data';
				$other_data = $availability;
				insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
			}
		 
		//-----------------------------------------CONDITION Validation
			echo 'condition: '. $item_condition;
			if($item_condition == '' OR $item_condition == null){
				//failed
				$warning_field = 'condition';
				$warning_message = 'no data';
				$other_data = $item_condition;
				insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
			}
		 
		//-----------------------------------------BRAND Validation
			echo 'brand: '. $brand;
			if($brand == '' OR $brand == null){
				//failed
				$warning_field = 'brand';
				$warning_message = 'no data';
				$other_data = $brand;
				insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
			}elseif(strlen($brand) > 70){
				//failed
				$warning_field = 'brand';
				$warning_message = 'Max 70 characters';
				$other_data = $brand;
				insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
			}
		
		//-----------------------------------------GOOGLE PRODUCT CATEGORY Validation
			echo 'google_product_category: '. $google_product_category;
			if($google_product_category == '' OR $google_product_category == null){
				//failed
				$warning_field = 'google_product_category';
				$warning_message = 'no data';
				$other_data = $google_product_category;
				insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
			}
		 
		//-----------------------------------------GENDER Validation
			echo 'gender: '. $gender;
			if($gender == '' OR $gender == null){
				//failed
				$warning_field = 'gender';
				$warning_message = 'no data';
				$other_data = $gender;
				insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
			}if($gender == 'male' OR $gender == 'female' OR $gender == 'unisex'){
				//success
			}else{
				//failed
				$warning_field = 'gender';
				$warning_message = 'value is incorrect';
				$other_data = $gender;
				insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
			}
		 
		//-----------------------------------------GENDER Validation
			echo 'age_group: '. $age_group;
			if($age_group == '' OR $age_group == null){
				$warning_field = 'age_group';
				$warning_message = 'no data';
				$other_data = $age_group;
				insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
			}if($age_group == 'newborn' OR $age_group == 'infant' OR $age_group == 'toddler' OR $age_group == 'kids' OR $age_group == 'adult'){
				//success
			}else{
				//failed
				$warning_field = 'age_group';
				$warning_message = 'age_group is incorrect';
				$other_data = $age_group;
				insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
			}
		 
		//-----------------------------------------MPN Validation
			echo 'mpn: '. $mpn;
			if($mpn == '' OR $mpn == null){
				//failed
				$warning_field = 'mpn';
				$warning_message = 'no data';
				$other_data = $link;
				insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
			}elseif(strlen($mpn) > 70){
				//failed
				$warning_field = 'mpn';
				$warning_message = 'Max 70 alphanumeric characters';
				$other_data = $mpn;
				insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
			}
		 
		//-----------------------------------------COLOR Validation
			echo 'color: '. $color;
			if($color == '' OR $color == null){
				//failed
				$warning_field = 'color';
				$warning_message = 'no data';
				$other_data = $color;
				insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
			}elseif(strlen($color) > 100){
				//failed
				$warning_field = 'color';
				$warning_message = 'Max 100 alphanumeric characters';
				$other_data = $color;
				insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
			}
		 
			echo 'item_group_id: '. $item_group_id;
			if($item_group_id == '' OR $item_group_id == null){
				//failed
				$warning_field = 'item_group_id';
				$warning_message = 'no data';
				$other_data = $item_group_id;
				insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
			}elseif(strlen($item_group_id) > 50){
				//failed
				$warning_field = 'item_group_id';
				$warning_message = 'Max 50 alphanumeric characters';
				$other_data = $item_group_id;
				insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
			}
			
					
		//-----------------------------------------style_number Validation
			
			if($style_number == '' OR $style_number == null){
				//failed
				$warning_field = 'style_number';
				$warning_message = 'no data';
				$other_data = $style_number;
				insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
			}
		 
		//-----------------------------------------GTIN Validation
			
			if($gtin == '' OR $gtin == null){
				//failed
				$warning_field = 'GTIN';
				$warning_message = 'no data';
				$other_data = $gtin;
				insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
			}elseif(strlen($gtin) > 50){
				//failed
				$warning_field = 'GTIN';
				$warning_message = 'Max 50 numeric characters ';
				$other_data = $gtin;
				insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
			}



	echo ".";


}


foreach ($productLine as $key => $value) {
	$i++;
	if ($i == 1){
		continue;
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
	
	$key = array_search($id, $dataFeedCols);
	if ($key !== false) {
		// if in product feed but not datafeed = add
		$removedData .= "$product_type \t $title \t $description \t $link \t $image_link \t $id \t $label \t $price \t $size \t $availability \t $item_condition \t $brand \t $google_product_category \t $gender \t $age_group \t $mpn \t $color \t $item_group_id \t $style_number \t $gtin \n";
	}
}

// Write the contents back to the file
file_put_contents("new_datafeedversion4.txt", $newDataFeed);
file_put_contents("removedData.txt", $removedData);

echo "Done. Files created.";



function insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data){
	echo 'warning field: '.$warning_field;
	global $con_datafeed_db,$warning_field,$warning_message,$other_data,$user_id,$project_id;
	$stmtdatafeed = $con_datafeed_db->prepare("INSERT INTO warning_list (project_id,user_id,warning_field,warning_message,other_data) VALUES (?,?,?,?,?)");
	$stmtdatafeed->execute(array('1',$user_id,$warning_field,$warning_message,$other_data));
	//exit(header('Location: ' . $_SERVER['HTTP_REFERER']));
	// redirect($user_id);
}




?>