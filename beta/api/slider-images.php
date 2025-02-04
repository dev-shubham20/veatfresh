<?php session_start();
include '../includes/crud.php';
include_once('../includes/variables.php');
$db = new Database();
$db->connect();
include 'send-email.php';
$response = array();
// print_r($_GET['accesskey']);

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

if ((isset($_POST['add-image'])) && ($_POST['add-image'] == 1)) {
    // print_r($_POST);
	$image = $_FILES['image']['name'];
	$image_error = $_FILES['image']['error'];
	$image_type = $_FILES['image']['type'];
	$type = $db->escapeString($_POST['type']);
	$id = ($type != 'default')?$_POST[$type]:"0";
// 	echo $id;
	
	// create array variable to handle error
	$error = array();
	// common image file extensions
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	
	// get image file extension
	error_reporting(E_ERROR | E_PARSE);
	$extension = end(explode(".", $_FILES["image"]["name"]));
	if($image_error > 0){
		$error['image'] = " <span class='label label-danger'>Not uploaded!</span>";
	}else if(!(($image_type == "image/gif") || 
		($image_type == "image/jpeg") || 
		($image_type == "image/jpg") || 
		($image_type == "image/x-png") ||
		($image_type == "image/png") || 
		($image_type == "image/pjpeg")) &&
		!(in_array($extension, $allowedExts))){
			$error['image'] = " <span class='label label-danger'>Image type must jpg, jpeg, gif, or png!</span>";
	}
	if( empty($error['image']) ){
		// create random image file name
		$mt = explode(' ', microtime());
		$microtime = ((int)$mt[1]) * 1000 + ((int)round($mt[0] * 1000));
		$file = preg_replace("/\s+/", "_", $_FILES['image']['name']);
		
		$image = $microtime.".".$extension;
		// upload new image
		$upload = move_uploaded_file($_FILES['image']['tmp_name'], '../upload/slider/'.$image);
		
		// insert new data to menu table
		$upload_image = 'upload/slider/'.$image;
		$sql = "INSERT INTO `slider`(`image`,`type`, `type_id`) VALUES ('$upload_image','".$type."','".$id."')";
// 		echo $sql;
		// echo "a";
		// echo $sql;
		$db->sql($sql);
		$res = $db->getResult();
		$sql="SELECT id FROM `slider` ORDER BY id DESC";
		$db->sql($sql);
		$res = $db->getResult();
		$response["message"] = "<span class='label label-success'>Image Uploaded Successfully!</span>";
		$response["id"] = $res[0]['id'];
	}else{
		$response["message"] = "<span class='label label-daner'>Image could not be Uploaded!Try Again!</span>";
	}
	echo json_encode($response);
}
if(isset($_GET['type']) && $_GET['type'] != '' && $_GET['type'] == 'delete-slider') {
    
    // print_r($_GET);
    $id		= $_GET['id'];
    $image 	= $_GET['image'];
	
	if(!empty($image))
		unlink('../'.$image);
	
	$sql = 'DELETE FROM `slider` WHERE `id`='.$id;
	if($db->sql($sql)){
		echo 1;
	}else{
		echo 0;
	}
}
if(isset($_POST['get-slider-images'])) {
	$sql = 'select * from slider order by id desc';
	$db->sql($sql);
	$result =$db->getResult();
	$response = $temp = $temp1 = array();
	if(!empty($result)){
    	$response['error'] = false;
    	foreach($result as $row){
    		$name = "";
    		if($row['type'] == 'category'){
    		    $sql = 'select `name` from category where id = '.$row['type_id'].' order by id desc';
    		    $db->sql($sql);
    		    $result1 = $db->getResult();
    		    $name = (!empty($result1[0]['name']))?$result1[0]['name']:"";
    		}
    		if($row['type'] == 'product'){
    		    $sql = 'select `name` from products where id = '.$row['type_id'].' order by id desc';
    		    $db->sql($sql);
    		    $result1 = $db->getResult();
    		    $name = (!empty($result1[0]['name']))?$result1[0]['name']:"";
    		}
    		
    		$temp['type'] = $row['type'];
    		$temp['type_id'] = $row['type_id'];
    		$temp['name'] = $name;
    		$temp['image'] = DOMAIN_URL.$row['image'];
    		$temp1[] = $temp;
    	}
    	$response['data'] = $temp1;
	}else{
	    $response['error'] = true;
	    $response['message'] = "No slider images uploaded yet!";
	}
	print_r(json_encode($response));
}
?>