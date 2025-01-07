<?php session_start();
include '../includes/crud.php';
include_once('../includes/variables.php');
$db = new Database();
$db->connect();
$response = array();

if ((isset($_POST['add-image'])) && ($_POST['add-image'] == 1)) {
    $id_quality = $_POST['id_quality'];
	$quality_title = $_POST['quality_title'];
	$quality_desc = $_POST['quality_desc'];

	if($id_quality==0){
		$sql = "INSERT INTO `quality`(`title`, `description`) VALUES ('".$quality_title."','".$quality_desc."')";
		$db->sql($sql);
		$sql="SELECT id_quality FROM `quality` ORDER BY id_quality DESC";
		$db->sql($sql);
		$res = $db->getResult();
		$response["id"] = $id_quality = $res[0]['id_quality'];
	}else{
		$sql = "UPDATE `quality` SET `title`='".$quality_title."',`description`='".$quality_desc."' WHERE `id_quality`='".$id_quality."'";
		$db->sql($sql);
		$response["id"] = $id_quality;
	}
	
	
	
	
	
	$image = $_FILES['image']['name'];
	$image_error = $_FILES['image']['error'];
	$image_type = $_FILES['image']['type'];
	
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
		$upload = move_uploaded_file($_FILES['image']['tmp_name'], '../upload/quality/'.$image);
		
		// insert new data to menu table
		$upload_image = 'upload/quality/'.$image;
		$sql = "UPDATE `quality` SET `image`='".$upload_image."' WHERE `id_quality`='".$id_quality."'";
		$db->sql($sql);
		$response["message"] = "<span class='label label-success'>Image Uploaded Successfully!</span>";
	}else{
		$response["message"] = "<span class='label label-daner'>Image could not be Uploaded!Try Again!</span>";
	}
	
	echo json_encode($response);
}

if(isset($_GET['type']) && $_GET['type'] != '' && $_GET['type'] == 'delete-quality') {
    
    // print_r($_GET);
    $id		= $_GET['id'];
    $image 	= $_GET['image'];
	
	if(!empty($image))
		unlink('../'.$image);
	
	$sql = 'DELETE FROM `quality` WHERE `id_quality`='.$id;
	if($db->sql($sql)){
		echo 1;
	}else{
		echo 0;
	}
}


if ((isset($_POST['add-image-alert'])) && ($_POST['add-image-alert'] == 1)) {
    $id_alert = $_POST['id_alert'];
	$link = $_POST['link'];
	$message = $_POST['message'];

	if($id_alert==0){
		$sql = "INSERT INTO `alert`(`link`, `message`) VALUES ('".$link."','".$message."')";
		$db->sql($sql);
		$sql="SELECT id_alert FROM `alert` ORDER BY id_alert DESC";
		$db->sql($sql);
		$res = $db->getResult();
		$response["id"] = $id_alert = $res[0]['id_alert'];
	}else{
		$sql = "UPDATE `alert` SET `link`='".$link."',`message`='".$message."' WHERE `id_alert`='".$id_alert."'";
		$db->sql($sql);
		$response["id"] = $id_alert;
	}
	
	
	
	
	$image = $_FILES['alert_image']['name'];
	$image_error = $_FILES['alert_image']['error'];
	$image_type = $_FILES['alert_image']['type'];
	
	// create array variable to handle error
	$error = array();
	// common image file extensions
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	
	// get image file extension
	error_reporting(E_ERROR | E_PARSE);
	$extension = end(explode(".", $_FILES["alert_image"]["name"]));
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
		$file = preg_replace("/\s+/", "_", $_FILES['alert_image']['name']);
		
		$image = $microtime.".".$extension;
		// upload new image
		$upload = move_uploaded_file($_FILES['alert_image']['tmp_name'], '../upload/alert/'.$image);
		
		// insert new data to menu table
		$upload_image = 'upload/alert/'.$image;
		$sql = "UPDATE `alert` SET `image`='".$upload_image."' WHERE `id_alert`='".$id_alert."'";
		$db->sql($sql);
		$response["message"] = "<span class='label label-success'>Image Uploaded Successfully!</span>";
	}else{
		$response["message"] = "<span class='label label-daner'>Image could not be Uploaded!Try Again!</span>";
	}
	
	echo json_encode($response);
}

if(isset($_GET['type']) && $_GET['type'] != '' && $_GET['type'] == 'delete-alert') {
    
    // print_r($_GET);
    $id		= $_GET['id'];
    $image 	= $_GET['image'];
	
	if(!empty($image))
		unlink('../'.$image);
	
	$sql = 'DELETE FROM `alert` WHERE `id_alert`='.$id;
	if($db->sql($sql)){
		echo 1;
	}else{
		echo 0;
	}
}
?>