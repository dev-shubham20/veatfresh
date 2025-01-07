<?php
    include_once('includes/crud.php');
    $db = new Database();
    $db->connect();

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GCM
 *
 * @author Ravi Tamada
 */
 
class GCM {

    //put your code here
    // constructor
    function __construct() {
        
    }

    /**
     * Sending Push Notification
     */
    public function send_notification($registatoin_ids, $message) {
        // include config
        include_once 'includes/config.php';

        $gcm_text = $_POST['gcmText'];
$gcm_url = $_POST['gcmURL'];
$gcm_subText = $_POST['gcm_secondText'];

$sql = "select gcm_regid from gcm_users ORDER BY id DESC LIMIT 1001";
$db->sql($sql);
$res = $db->getResult();

foreach ($res as $row) {
    $gcm_array[]=$row['gcm_regid'];
    $counter++;
}

mysql_free_result($res);


    $body['allsearch'] = array(
            'gcmText' => $gcm_text,
            'gcm_secondText' => $gcm_subText,
            'gcmURL' => $gcm_url
            );

    // Set POST variables
  $url = 'https://android.googleapis.com/gcm/send';

  $fields = array(
 'registration_ids' => $registatoin_ids,
 'data' => $message,
 );

//echo GOOGLE_API_KEY;
 $headers = array(
 'Authorization: key='.GOOGLE_API_KEY,
  'Content-Type: application/json'
 );


print_r($headers);
// Open connection
$ch = curl_init();

// Set the url, number of POST vars, POST data
curl_setopt($ch, CURLOPT_URL, $url);

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Disabling SSL Certificate support temporarly
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

// Execute post
$result = curl_exec($ch);
if ($result === FALSE) {
    die('Curl failed: ' . curl_error($ch));
}

// Close connection
curl_close($ch);
echo $result;


    }

}

?>