<?php session_start();
include '../includes/crud.php';
include '../includes/variables.php';
// include_once('../includes/variables.php'); 
// include_once('../includes/custom-functions.php');
$db = new Database();
$db->connect();
date_default_timezone_set('Asia/Kolkata');
include 'send-email.php';
$response = array();
/* accesskey:90336 */

if(!isset($_POST['accesskey'])){
    if(!isset($_GET['accesskey'])){
        $response['error'] = true;
    	$response['message'] = "Access key is invalid or not passed!";
    	print_r(json_encode($response));
    	return false;
    }
}

if(isset($_POST['accesskey'])){
    $accesskey = $_POST['accesskey'];
}else{
    $accesskey = $_GET['accesskey'];
}

if ($access_key != $accesskey) {
	$response['error'] = true;
	$response['message'] = "invalid accesskey!";
	print_r(json_encode($response));
	return false;
}

if ((isset($_POST['add-section'])) && ($_POST['add-section'] == 1)) {
	
	$title = $_POST['title'];
	$short_description = $_POST['short_description'];
	$style = $_POST['style'];
	$product_ids = $_POST['product_ids'];
	// print_r($product_ids);
	// $a=array($product_ids);
	$product_ids = implode(',',$product_ids);
	// print_r($product_ids);
	$sql = "INSERT INTO `sections` (`title`,`style`,`short_description`,`product_ids`) VALUES ('$title','$style','$short_description','$product_ids')";
	// echo $sql;
	$db->sql($sql);
	$res = $db->getResult();
	$response["message"] = "Section created Successfully";

	$sql = "SELECT id FROM sections ORDER BY id DESC";
	$db->sql($sql);
	$res = $db->getResult();
	$response["id"] = $res[0]['id'];
	
	echo json_encode($response);
}
if ((isset($_POST['edit-section'])) && ($_POST['edit-section'] == 1)) {
	
	$id = $_POST['section-id'];
	$style = $_POST['style'];
	$short_description = $_POST['short_description'];
	$title = $_POST['title'];
	$product_ids = $_POST['product_ids'];
	$product_ids = implode(',',$product_ids);
	
	$sql = "UPDATE `sections` SET `title`='$title', `short_description`='$short_description', `style`='$style', `product_ids` = '$product_ids' WHERE `sections`.`id` = ".$id;
	$db->sql($sql);
	$res = $db->getResult();
	$response["message"] = "Section updated Successfully";
	$response["id"] = $id;
	
	echo json_encode($response);
}
if(isset($_GET['type']) && $_GET['type'] != '' && $_GET['type'] == 'delete-section') {
    $id		= $db->escapeString($_GET['id']);
	
	$sql = 'DELETE FROM `sections` WHERE `id`='.$id;
	if($db->sql($sql)){
		echo 1;
	}else{
		echo 0;
	}
}

if(isset($_POST['get-all-sections'])) {
	$sql = 'select * from `sections` order by id desc';
	$db->sql($sql);
	$result =$db->getResult();
	$response = $product_ids = $section = $variations = $temp = array();
	foreach($result as $row){
		$product_ids = explode(',',$row['product_ids']);
		
		$section['id'] = $row['id'];
		$section['title'] = $row['title'];
		$section['short_description'] = $row['short_description'];
		$section['style'] = $row['style'];
		$section['product_ids'] = array_map('trim',$product_ids);
		$product_ids = $section['product_ids'];

		$product_ids = implode(',', $product_ids);
		
		// $sql = 'SELECT * FROM `products` where id in ('.$row['product_ids'].') ORDER BY FIELD(id, '.$row['product_ids'].')';
		$sql = 'SELECT * FROM `products` WHERE id IN ('.$product_ids.')';
		// echo $sql;
		$db->sql($sql);
		$result1 = $db->getResult();
		$product = array();
		$i=0;
		foreach($result1 as $row){
			$sql = "SELECT *,(SELECT short_code FROM unit u WHERE u.id=pv.measurement_unit_id) as measurement_unit_name,(SELECT short_code FROM unit u WHERE u.id=pv.stock_unit_id) as stock_unit_name FROM product_variant pv WHERE pv.product_id=".$row['id']."";
                // echo $sql;
                $db->sql($sql);
                
                $row['other_images'] = json_decode($row['other_images'],1);
        		$row['other_images'] = (empty($row['other_images']))?array():$row['other_images'];

        		for($j=0;$j<count($row['other_images']);$j++){
        		    $row['other_images'][$j] = DOMAIN_URL.$row['other_images'][$j];
        		}
        		
        		
        		$row['image'] = DOMAIN_URL.$row['image'];
                $product[$i] = $row;
                $product[$i]['variants'] = $db->getResult();
                $i++;
			
		}
		$section['products'] = $product;
		$temp[] = $section;
		unset($section['products']);
	}
	if(!empty($result)){
    	$response['error'] = false;
    	$response['sections'] = $temp;
	}else{
	    $response['error'] = true;
    	$response['message'] = "No section has been created yet";
	}
	print_r(json_encode($response));
}


function isJSON($string){
	return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
}

?>