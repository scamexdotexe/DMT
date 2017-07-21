<?php
include_once("../datafeed-db_config.php");
global $con_datafeed_db;

if (isset($_GET['user_id'])) {
	$user_id = $_GET['user_id'];
}else{
	$user_id = $_POST['user_id'];
}
if (isset($_GET['project_id'])) {
	$project_id = $_GET['project_id'];
}else{
	$project_id = $_POST['project_id'];
}

 $file = $_FILES['data_feed']['tmp_name'];
 
 echo 'FILE: '.$file;
 $handle = fopen($file, "r");
 $counter = 0;
 while(($filesop = fgetcsv($handle, 1000, "\t")) !== false)
	{
		echo 'counter: '.$counter;
		if($counter != 0){
			//capturing all the columns and data and separate it into Variable
			$product_type = $filesop[0];
			$title = $filesop[1];
			$description = $filesop[2];
			$link = $filesop[3];
			$image_link = $filesop[4];
			$id = $filesop[5];
			$label = $filesop[6];
			$price = $filesop[7];
			$size = $filesop[8];
			$availability = $filesop[9];
			$condition = $filesop[10];
			$brand = $filesop[11];
			$google_product_category = $filesop[12];
			$gender = $filesop[13];
			$age_group = $filesop[14];
			$mpn = $filesop[15];
			$color = $filesop[16];
			$item_group_id = $filesop[17];
			$adwords_labels = $filesop[18];
			$style_number = $filesop[19];
			$GTIN = $filesop[20];

			//echo $counter. ' product_type: '.$product_type;
			echo '<br/>';echo '<br/>';
			echo $counter. ' title: '.$title;
			echo '<br/>';echo '<br/>';
			
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
			echo 'condition: '. $condition;
			if($condition == '' OR $condition == null){
				//failed
				$warning_field = 'condition';
				$warning_message = 'no data';
				$other_data = $condition;
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
			
		//-----------------------------------------adwords_labels Validation
			echo 'adwords_labels: '. $adwords_labels; 
			if($adwords_labels == '' OR $adwords_labels == null){
				//failed
				$warning_field = 'adwords_labels';
				$warning_message = 'no data';
				$other_data = $adwords_labels;
				insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
			}
			
		//-----------------------------------------style_number Validation
			echo 'style_number: '. $style_number;
			if($style_number == '' OR $style_number == null){
				//failed
				$warning_field = 'style_number';
				$warning_message = 'no data';
				$other_data = $style_number;
				insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
			}
		 
		//-----------------------------------------GTIN Validation
			echo 'GTIN: '. $GTIN;
			if($GTIN == '' OR $GTIN == null){
				//failed
				$warning_field = 'GTIN';
				$warning_message = 'no data';
				$other_data = $GTIN;
				insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
			}elseif(strlen($GTIN) > 50){
				//failed
				$warning_field = 'GTIN';
				$warning_message = 'Max 50 numeric characters ';
				$other_data = $GTIN;
				insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data);
			}
		}	 
		$counter++;
	}
	
function insertWarning($con_datafeed_db,$warning_field,$warning_message,$other_data){
	echo 'warning field: '.$warning_field;
	global $con_datafeed_db,$warning_field,$warning_message,$other_data,$user_id,$project_id;
	$stmtdatafeed = $con_datafeed_db->prepare("INSERT INTO warning_list (project_id,user_id,warning_field,warning_message,other_data) VALUES (?,?,?,?,?)");
	$stmtdatafeed->execute(array('1',$user_id,$warning_field,$warning_message,$other_data));
	//exit(header('Location: ' . $_SERVER['HTTP_REFERER']));
	redirect($user_id);
}

function redirect($user_id){
	?>
		<script>window.location = "../view/datafeed.php?id=<?php echo $user_id?>";</script>
	<?php
}
?>