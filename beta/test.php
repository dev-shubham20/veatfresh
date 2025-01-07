<?php
include_once ('api-firebase/send-email.php');
include_once ('api-firebase/send-sms.php');
include_once ('includes/crud.php');
include_once ('includes/functions.php');
include_once ('includes/custom-functions.php');
include_once ('includes/variables.php');

include_once ('api-firebase/verify-token.php');
require 'mailer/PHPMailerAutoload.php';

$db = new Database();
$db->connect();
$db->sql("SET NAMES utf8");
$function = new custom_functions();
$settings = $function->get_settings('system_timezone', true);
$app_name = $settings['app_name'];
$config = $function->get_configurations();

$settings_inv = $function->get_configurations();
$currency = $function->get_settings('currency');
$id = 4684;
$sql_outer="SELECT oi.*,u.*,p.*,v.*,o.*,u.name as uname,d.name as delivery_boy,o.status as order_status,oi.active_status as order_item_status,p.name as pname,(SELECT short_code FROM unit un where un.id=v.measurement_unit_id)as mesurement_unit_name FROM `order_items` oi JOIN users u ON u.id=oi.user_id JOIN product_variant v ON oi.product_variant_id=v.id JOIN products p ON p.id=v.product_id JOIN orders o ON o.id=oi.order_id LEFT JOIN delivery_boys d ON o.delivery_boy_id=d.id WHERE o.id=".$id;
                // Execute query
                $db->sql($sql_outer);
                // store result 
                $res_outer=$db->getResult();
                //print_r($res_outer);
                $items=[];
                foreach($res_outer as $row){
                        $data=array($row['product_id'],$row['pname'],$row['quantity'],$row['measurement'],$row['mesurement_unit_name'],$row['discounted_price']*$row['quantity'],$row['discount'],$row['sub_total'],$row['order_item_status']);
                        array_push($items, $data);
                }
                     // print_r($items);
                    $encoded_items=$db->escapeString(json_encode($items));
                $ids = $res_outer[0]['id'];
                $sql = "SELECT COUNT(id) as total FROM `invoice` where order_id=".$ids;
                $db->sql($sql);
                $res=$db->getResult();
                $total=$res[0]['total'];
                if ($total == 0) {

                    $invoicedate = date('Y-m-d');
                    $idx = $res_outer[0]['id'];
                    $name=$res_outer[0]['uname'];
                    $email=$res_outer[0]['email'];
                    $address = $res_outer[0]['address'];
                    $phone = $res_outer[0]['mobile'];
                    $orderdate = $res_outer[0]['date_added'];
                    $order_list = $encoded_items;
                    $discount = $res_outer[0]['discount'];
                    $final_total=$res_outer[0]['final_total'];
                    $total_payble = $res_outer[0]['price'];
                    $shipping_charge=$res_outer[0]['delivery_charge'];
                    $payment = $res_outer[0]['final_total'];
                    $method = $res_outer[0]['payment_method'];
                    $data = array(
                        'invoice_date' => $invoicedate,
                        'order_id' => $idx,
                        'name' => $name,
                        'address' => $address,
                        'order_date' => $orderdate,
                        'phone_number' => $phone,
                        'order_list' => $encoded_items,
                        'email' => $email,
                        'discount' => $discount,
                        'total_sale' => $total_payble,
                        'shipping_charge' => $shipping_charge,
                        'payment' => $payment,
                    );
                    // print_r($data);
                    $db->insert('invoice',$data);
                    $res=$db->getResult();
                }

                $sql_invoice = "SELECT id, invoice_date FROM invoice WHERE order_id =" . $ids;
                    // Execute query
                $db->sql($sql_invoice);
                    // store result 
                $res_invoice=$db->getResult();
                $order_list = $encoded_items;
                
                
            //     $updated_body = '
            // 	<html>
            // 	<body style="font-family: Open Sans, sans-serif;font-size:100%;font-weight:400;line-height:1.4;color:#000;">
            // 	<table style="width:100%;margin:50px auto 10px;padding:50px;">                   
            //         <thead>                      
            //             <tr>                            
            //                 <th style="text-align:left;">
            //                     <h4>
            //                         '.$settings_inv['app_name'].'<br/>
            //                         Mo. +91 '.$settings_inv['support_number'].'
            //                     </h4>                               
            //                 </th>
            //                 <th colspan="2" style="text-align:right;">
            //                     <h4>
            //                         <b>FSSAI: </b>12721066001560
            //                     </h4>
            //                 </th>                           
            //             </tr>
            //         </thead>
            //         <tbody>
            //             <tr>
            //                 <td colspan="2" style="text-align:center;">
            //                     <p><b style="color:#ff6d00;font-size:20px;">Dear '.$res_outer[0]['uname'].'</b> <br/> Thank you for ordering from VeatFresh.</p>
            //                 </td>
            //             </tr>
                        
            //             <tr>
            //                 <td colspan="2" style="text-align:center;">
            //                     <p style="margin-bottom:50px;margin-top:50px;"><b style="color:#ff6d00;font-size:20px;">Order #'.$res_outer[0]['id'].'</b></p>
            //                 </td>
            //             </tr>
            //             <tr>
            //                 <td style="text-align:left;">
            //                     <strong style="color:#009d00;font-size:18px;">From Address</strong>
            //                     <address>
            //                         <strong>'.$settings_inv['app_name'].'</strong><br>
            //                         Email: '.$settings_inv['support_email'].'<br>
            //                         Customer Care : +91 '.$settings_inv['support_number'].'<br>
            //                         Delivery By: &nbsp; '.$res_outer[0]['delivery_boy'].'
            //                     </address>
            //                 </td>
                      
            //                 <td style="text-align:right;">
            //                     <strong style="color:#009d00;font-size:18px;">Retail Invoice</strong><br>
            //                     <b>No : </b>#'.$res_invoice[0]['id'].'
            //                     <br>
            //                     <b>Date: </b>'.date('d-m-Y',strtotime($res_invoice[0]['invoice_date'])).'
            //                     <br>
            //                     <b>Date: </b>'.date('d-m-Y h:i A',strtotime($res_outer[0]['date_added'])).'
            //                     <br>
            //                     <b>Payment Mode : </b>'.$res_outer[0]['payment_method'].'
            //                     <br>                                
            //                 </td>
            //             </tr>
                        
            //             <tr>
            //                 <td colspan="2" style="text-align:left;">
            //                     <strong style="color:#009d00;font-size:18px;">Delevery Address</strong>
            //                     <address>
            //                          <strong>'.$res_outer[0]['uname'].'</strong><br>
            //                          '.$res_outer[0]['address'].'<br>
            //                          <strong>'.$res_outer[0]['mobile'].'</strong><br>
            //                          <strong>'.$res_outer[0]['email'].'</strong><br>
            //                     </address>
            //                 </td>
            //             </tr>
                        
            //             <tr style="margin-top:20px;text-align:left;border-bottom:1px solid #000;">
            //                 <td colspan="2">
            //                     <table style="width:100%;">
            //                             <thead style="text-align:left;">
            //                                 <tr>
            //                                     <th style="padding-top: 50px; padding-bottom: 10px;border-bottom: 3px ridge;">Sr No.</th>
            //                                     <th style="padding-top: 50px; padding-bottom: 10px;border-bottom: 3px ridge;">Product Code</th>
            //                                     <th style="padding-top: 50px; padding-bottom: 10px;border-bottom: 3px ridge;">Name</th>
            //                                     <th style="padding-top: 50px; padding-bottom: 10px;border-bottom: 3px ridge;">Unit</th>
            //                                     <th style="padding-top: 50px; padding-bottom: 10px;border-bottom: 3px ridge;">Qty</th>
            //                                     <th style="padding-top: 50px; padding-bottom: 10px;border-bottom: 3px ridge;">SubTotal ('.$currency.')</th>
            //                                 </tr>
            //                             </thead>
            //                             <tbody style="text-align:left;">';
            //                             $decoded_items=json_decode(stripSlashes($order_list));                                        
            //                             $qty = 0;
            //                             $i=1;
            //                             $total=0;
            //                             foreach ($decoded_items as $item) {
            //                                 if($item[8]!='cancelled' && $item[8]!='returned'){
                                                
            //                         $updated_body .= '<tr>
            //                                         <td style="padding-top: 10px; padding-bottom: 10px;border-bottom: 3px ridge;">&nbsp;&nbsp;&nbsp;&nbsp;'.$i.'<br></td>
            //                                         <td style="padding-top: 10px; padding-bottom: 10px;border-bottom: 3px ridge;">&nbsp;&nbsp;&nbsp;&nbsp;'.$item[0].'<br></td>
            //                                         <td style="padding-top: 10px; padding-bottom: 10px;border-bottom: 3px ridge;">'.$item[1].'<br></td>
            //                                         <td style="padding-top: 10px; padding-bottom: 10px;border-bottom: 3px ridge;">'.$item[3]." ".$item[4].'<br></td>
            //                                         <td style="padding-top: 10px; padding-bottom: 10px;border-bottom: 3px ridge;">&nbsp;&nbsp;&nbsp;&nbsp;'.$item[2].'<br></td>
            //                                         <td style="padding-top: 10px; padding-bottom: 10px;border-bottom: 3px ridge;">&nbsp;&nbsp;&nbsp;&nbsp;'.$item[7].'<br></td>
            //                                 </tr>';
            //                                 $qty = $qty+$item[2];
            //                                 $i++;
            //                                 $total+=$item[7];
            //                             } }
            //                             $sql_total = 'select total from orders where id='.$id;
            //                             $db->sql($sql_total);
            //                             $res_total = $db->getResult();
                                        
            //                         $updated_body .= '</tbody>
            //                                 <tr style="text-align:left;">
            //                                         <th></th>
            //                                         <th></th>
            //                                         <th></th>
            //                                     <th>Total</th>
            //                                   <td>&nbsp;&nbsp;&nbsp;&nbsp;'.$qty.'<br></td>
            //                                   <td>&nbsp;&nbsp;&nbsp;&nbsp;'.$res_total[0]['total'].'<br></td>
            //                                 </tr>
            //                     </table>
            //                 </td>
            //             </tr>';

            	$updated_body = '
            	<html>
            	<body style="font-family: Open Sans, sans-serif;font-size:100%;font-weight:400;line-height:1.4;color:#000;">
            	<table style="width:100%;margin:50px auto 10px;padding:20px;"> 
                    <tbody>
                        <tr>
                            <td style="text-align:center;">
                                <p><b style="color:#ff6d00;font-size:20px;">Dear '.$res_outer[0]['uname'].'</b> <br/> Thank you for ordering from VeatFresh.</p>
                            </td>
                        </tr>
                        
                        <tr>
                            <td style="text-align:center;">
                                <p style="margin-bottom:50px;margin-top:50px;"><b style="color:#ff6d00;font-size:20px;">Order ID : #'.$res_outer[0]['id'].'</b></p>
                            </td>
                        </tr>
                        
                        <tr>
                            <td style="text-align:left;border-bottom: 2px ridge;"">
                                <strong style="color:#009d00;font-size:18px;">Delivery Address</strong>
                                <address>
                                     <strong>'.$res_outer[0]['address'].'</strong><br>
                                     <strong>'.$res_outer[0]['mobile'].'</strong><br>
                                     <strong>'.$res_outer[0]['email'].'</strong><br>
                                </address>
                            </td>
                        </tr>
                        
                        <tr style="margin-top:20px;text-align:left;border-bottom:1px solid #000;">
                            <td>
                                <table style="width:100%;">
                                        <thead style="text-align:left;">
                                            <tr>
                                                <th style="padding-top: 50px; padding-bottom: 10px;border-bottom: 3px ridge;">Sr No.</th>
                                                <th style="padding-top: 50px; padding-bottom: 10px;border-bottom: 3px ridge;">Product Code</th>
                                                <th style="padding-top: 50px; padding-bottom: 10px;border-bottom: 3px ridge;">Name</th>
                                                <th style="padding-top: 50px; padding-bottom: 10px;border-bottom: 3px ridge;">Unit</th>
                                                <th style="padding-top: 50px; padding-bottom: 10px;border-bottom: 3px ridge;">Qty</th>
                                                <th style="padding-top: 50px; padding-bottom: 10px;border-bottom: 3px ridge;">SubTotal ('.$currency.')</th>
                                            </tr>
                                        </thead>
                                        <tbody style="text-align:left;">';
                                        $decoded_items=json_decode(stripSlashes($order_list));                                        
                                        $qty = 0;
                                        $i=1;
                                        $total=0;
                                        foreach ($decoded_items as $item) {
                                            if($item[8]!='cancelled' && $item[8]!='returned'){
                                                
                                    $updated_body .= '<tr>
                                                    <td style="padding-top: 10px; padding-bottom: 10px;border-bottom: 3px ridge;">&nbsp;&nbsp;&nbsp;&nbsp;'.$i.'<br></td>
                                                    <td style="padding-top: 10px; padding-bottom: 10px;border-bottom: 3px ridge;">&nbsp;&nbsp;&nbsp;&nbsp;'.$item[0].'<br></td>
                                                    <td style="padding-top: 10px; padding-bottom: 10px;border-bottom: 3px ridge;">'.$item[1].'<br></td>
                                                    <td style="padding-top: 10px; padding-bottom: 10px;border-bottom: 3px ridge;">'.$item[3]." ".$item[4].'<br></td>
                                                    <td style="padding-top: 10px; padding-bottom: 10px;border-bottom: 3px ridge;">&nbsp;&nbsp;&nbsp;&nbsp;'.$item[2].'<br></td>
                                                    <td style="padding-top: 10px; padding-bottom: 10px;border-bottom: 3px ridge;">&nbsp;&nbsp;&nbsp;&nbsp;'.$item[7].'<br></td>
                                            </tr>';
                                            $qty = $qty+$item[2];
                                            $i++;
                                            $total+=$item[7];
                                        } }
                                        $sql_total = 'select total from orders where id='.$id;
                                        $db->sql($sql_total);
                                        $res_total = $db->getResult();
                                        
                                    $updated_body .= '</tbody>
                                            <tr style="text-align:left;">
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                <th>Total</th>
                                               <td>&nbsp;&nbsp;&nbsp;&nbsp;'.$qty.'<br></td>
                                               <td>&nbsp;&nbsp;&nbsp;&nbsp;'.$res_total[0]['total'].'<br></td>
                                            </tr>
                                </table>
                            </td>
                        </tr>';

                        if($res_outer[0]['discount']>0){
                            $discounted_amount = $res_total[0]['total'] * $res_outer[0]['discount'] / 100; /*  */
                            $final_total = $res_total[0]['total'] - $discounted_amount;
                            $discount_in_rupees = $res_total[0]['total']-$final_total;
                            $discount_in_rupees = $discount_in_rupees;
                            // echo $discount_in_rupees;
                        } else {
                            $discount_in_rupees = 0;
                        }
                        $updated_body .= '
                        <tr>
                            <td> 
                                <table style="width:100%;text-align:right;">
                                    <th></th>
                                    <tr>
                                            <th style="text-align:right;padding-top: 50px; padding-bottom: 5px;">Total Order Price ('.$currency.')</th>
                                            <td style="text-align:right;padding-top: 50px; padding-bottom: 5px;">+'.$res_total[0]['total'].'</td>
                                    </tr>
                                    <tr>
                                            <th style="text-align:right;padding-top: 5px; padding-bottom: 5px;">Delivery Charge ('.$currency.')</th>
                                            
                                            <td style="text-align:right;padding-top: 5px; padding-bottom: 5px;">+'.$res_outer[0]['delivery_charge'].'</td>
                                    </tr>
                                    <tr>
                                            <th style="text-align:right;padding-top: 5px; padding-bottom: 5px;">Tax '.$currency.'(%)</th>
                                            <td style="text-align:right;padding-top: 5px; padding-bottom: 5px;">+ '.$res_outer[0]['tax_amount'].' ('.$res_outer[0]['tax_percentage'].'%)</td>
                                    </tr>
                                    <tr>
                                            <th style="text-align:right;padding-top: 5px; padding-bottom: 5px;">Discount <?=$currency;?>(%)</th>
                                            <td style="text-align:right;padding-top: 5px; padding-bottom: 5px;">- '.$discount_in_rupees.' ('.$res_outer[0]['discount'].'%)</td>
                                    </tr>
                                    <tr>
                                            <th style="text-align:right;padding-top: 5px; padding-bottom: 5px;">Promo ('.$res_outer[0]['promo_code'].') Discount ('.$currency.')</th>
                                            <td style="text-align:right;padding-top: 5px; padding-bottom: 5px;">- '.$res_outer[0]['promo_discount'].'</td>
                                    </tr>
                                    <tr>
                                            <th style="text-align:right;padding-top: 5px; padding-bottom: 5px;">Wallet Used ('.$currency.')</th>
                                            <td style="text-align:right;padding-top: 5px; padding-bottom: 5px;">- '.$res_outer[0]['wallet_balance'].'</td>
                                    </tr>
                                    <th style="text-align:right;padding-top: 5px; padding-bottom: 5px;">Final Total ('.$currency.')</th>';
                                        $total = $res_total[0]['total'];
                                        $delivery_charge = $res_outer[0]['delivery_charge'];
                                        $tax_amount = $res_outer[0]['tax_amount'];
                                        $promo_discount = $res_outer[0]['promo_discount'];
                                        $wallet = $res_outer[0]['wallet_balance'];
                                        $final_total = $total+$delivery_charge+$tax_amount-$discount_in_rupees-$promo_discount-$wallet;
                                      
                            $updated_body .= '<td style="text-align:right;padding-top: 5px; padding-bottom: 5px;">= '.ceil($final_total).'</td>
                                    </tr>
                                </table>
                            </td>
                        </tr> 
                    </tbody>
                </table>
                <table style="width:100%;">  
                    <tbody>
                        <tr style="width:100%;text-align:center">
                            <td style="width:100%;text-align:center;">
                                <p style="margin-bottom:10px;margin-top:50px;"><b style="color:#000;font-size:14px;">Have Questions?</b><br/>
                                Write us on <a href="mailto:'.$settings_inv['support_email'].'"><b style="color:#ff6d00;font-size:14px;">'.$settings_inv['support_email'].'</b></a> or Call <a href="tel:+91'.$settings_inv['support_number'].'"><b style="color:#ff6d00;font-size:14px;">@+91 '.$settings_inv['support_number'].'</b></a>
                                </p>
                            </td>
                        </tr>
                        <tr style="width:100%;text-align:center">
                            <td style="width:100%;text-align:center;background:#ff6d00;">
                                <p style="margin-bottom:10px;margin-top:20px;"><b style="color:#fff;font-size:14px;">Please share your experience with us</b></p>
                                <a href="https://play.google.com/store/apps/details?id=com.veatfresh&hl=en_IN&gl=US" target="_blank"><img src="https://admin.veatfresh.in/stars.png" style="width: 200px;height: 60px;"/></a>
                                <a href="https://play.google.com/store/apps/details?id=com.veatfresh&hl=en_IN&gl=US" target="_blank"><img src="https://admin.veatfresh.in/google-play.png" style="width: 200px;height: 60px;"/></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </body>
                </html>';
            	$mail = new PHPMailer; 
				$mail->Debugoutput = 'html'; 
				//$toemail = $to;
				$fname = "Your order has been delivered"; 
				$mail->setFrom('admin@veatfresh.in', $fname);
				$mail->addReplyTo('admin@veatfresh.in', $fname);
				//$mail->addAddress($toemail, $fname);
				$mail->addAddress('live.kronickeys@gmail.com', $fname);
				$mail->Subject = $fname; 
				$mail->Body = $updated_body;       
				$mail->IsHTML(true);
				$mail->CharSet = "UTF-8";     
				if (!$mail->send()) {
				    $return_value = false;
				    print_r('no');
					echo $mail->ErrorInfo;
				} else {
					$return_value = true;
                   // echo $updated_body;
			  }
			  $mail->ClearAddresses();
			  echo $updated_body;
    //         	$updated_body='<p>Hello</p>';
    //         	$mail = new PHPMailer; 
				// $mail->Debugoutput = 'html'; 
				// $toemail = $to;
				// $fname = "test"; 
				// $mail->setFrom('admin@veatfresh.in', $fname);
				// $mail->addReplyTo('admin@veatfresh.in', $fname);
				// //$mail->addAddress($toemail);
				// $mail->addAddress('live.kronickeys@gmail.com', $fname);
				// $mail->Subject = $fname; 
				// $mail->Body = $updated_body;       
				// $mail->IsHTML(true);
				// $mail->CharSet = "UTF-8";     
				// 	if (!$mail->send()) 
				// 	{
				// 		$return_value = false;
				// 		print_r('no');
				// 		echo $mail->ErrorInfo;
				// 	} 
				// 	else 
				// 	{
				// 		$return_value = true;
				// 		print_r('yes');
				// 	}
			 //   	$mail->ClearAddresses();