<?php 
namespace App\Controllers;

use App\Models\CrudModel;
use CodeIgniter\HTTP\RequestInterface;
use App\Libraries\MenuTree;
use Razorpay\Api\Api;

class AjaxController extends BaseController
{

	private $session = null;
    // Admin Table
    
    private $category_tbl = 'category';
    private $product_tbl = 'products';
    private $product_variant_tbl = 'product_variant';
    private $slider_tbl = 'slider';
    private $sections_tbl = 'sections';
    private $offers_tbl = 'offers';
    private $users_tbl = 'users';
    private $cart_tbl = 'cart';
    private $promo_tbl = 'promo_codes';
    private $order_items_tbl = 'order_items';
    private $orders_tbl = 'orders';
    private $settings_tbl = 'settings';

	function __construct()

    {
		helper(['form','security','common']);

        // DB Connection
        $this->db = \Config\Database::connect();
        $this->CrudModel = new CrudModel($this->db);
        
        // Init Session
        $this->session = \Config\Services::session();
        $this->session->start();
        $this->data['session'] = $this->session;

        // Init Form Validation
        $this->validation = \Config\Services::validation();
        $this->data['validation'] = $this->validation;
        $this->data['error'] = "";
        $this->data['roles_arr'] = get_roles();
        
        $menus = new MenuTree();        
        $this->data['categories'] = $menus->get_categories();
        $this->data['cities'] = $menus->get_cities();

    }

    public function set_phone_session(){
        $phoneNumber = $this->request->getPost('phoneNumber');
        $token = csrf_hash();        

        $adminData['register_number'] = $phoneNumber;        
        $this->session->set($adminData);

        $responseArr = array("token" => $token, "response" => true);
            
        echo json_encode($responseArr);
        die();
    }

    public function set_phone_code(){
        $code = $this->request->getPost('code');
        $r_token = $this->request->getPost('token');
        $phoneNumber = $this->request->getPost('phoneNumber');
        $token = csrf_hash();        

        $adminData['register_code'] = $code;
        $adminData['register_token'] = $r_token;
        $adminData['register_number'] = $phoneNumber;        
        $this->session->set($adminData);

        $responseArr = array("token" => $token, "response" => true);
            
        echo json_encode($responseArr);
        die();
    }

    public function check_phone_is_available(){
        $token = csrf_hash();         
        $phoneNumber = $this->request->getPost('phoneNumber');
        $phoneNumber = str_replace("+91", "", $phoneNumber);

        if(isset($phoneNumber) && !empty($phoneNumber)){
            $where_data = ['mobile' => $phoneNumber, 'status' => 1];
            $db_data = array(
                "table" => $this->users_tbl,
                "where" => $where_data,
                "output" => 'row_object'
            );

            $admin_data = $this->CrudModel->getAnyItems($db_data);
         
            if(!empty($admin_data)){
                $responseArr = array("token" => $token, "message" => "This mobile number is already registered! Please use another mobile number for registration!", "response" => false);
            }else{
                $responseArr = array("token" => $token, "response" => true);
            }
        }else{
            $responseArr = array("token" => $token, "message" => "Please enter mobile number!", "response" => false);
        }
        echo json_encode($responseArr);
        die();
    }

    public function check_phone_is_available_forgot(){
        $token = csrf_hash();         
        $phoneNumber = $this->request->getPost('phoneNumber');
        $phoneNumber = str_replace("+91", "", $phoneNumber);

        if(isset($phoneNumber) && !empty($phoneNumber)){
            $where_data = ['mobile' => $phoneNumber, 'status' => 1];
            $db_data = array(
                "table" => $this->users_tbl,
                "where" => $where_data,
                "output" => 'row_object'
            );

            $admin_data = $this->CrudModel->getAnyItems($db_data);
         
            if(!empty($admin_data)){
                $responseArr = array("token" => $token, "response" => true);
            }else{
                $responseArr = array("token" => $token, "response" => false, "message" => "This mobile number is not registered! Please use registred mobile number for forgot password!",);
            }
        }else{
            $responseArr = array("token" => $token, "message" => "Please enter mobile number!", "response" => false);
        }
        echo json_encode($responseArr);
        die();
    }

    public function get_product_varient_data(){
        $token = csrf_hash();         
        $varient_id = $this->request->getPost('varient_id');

        if(isset($varient_id) && !empty($varient_id)){
            $where_data = ['id' => $varient_id];
            $db_data = array(
                "table" => $this->product_variant_tbl,
                "where" => $where_data,
                "output" => 'row_object'
            );

            $admin_data = $this->CrudModel->getAnyItems($db_data);
         
            if(!empty($admin_data)){
                $responseArr = array("token" => $token, "data" => $admin_data, "message" => "Success", "response" => true);
            }else{
                $responseArr = array("token" => $token, "message" => "Please select another varient.", "response" => false);
            }
        }else{
            $responseArr = array("token" => $token, "message" => "Please select varient!", "response" => false);
        }
        echo json_encode($responseArr);
        die();
    }

    public function add_to_cart(){
        $token = csrf_hash();         
        $varient_id = $this->request->getPost('varient_id');
        $user_id = $this->request->getPost('user_id');
        $product_id = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity');
        $user_ip = getClientIpAddress();

        if($user_id == ''){
            if(isset($varient_id) && !empty($varient_id)){
                $where_data = ['product_varient' => $varient_id, 'product_id' => $product_id, 'user_ip' => $user_ip];
                $db_data = array(
                    "table" => $this->cart_tbl,
                    "where" => $where_data,
                    "output" => 'row_object'
                );

                $admin_data = $this->CrudModel->getAnyItems($db_data);
             
                if(!empty($admin_data)){
                    //print_r($admin_data);
                    $quantity = $quantity + $admin_data->quantity;
                    $update_data = array(
                        'quantity' => $quantity,
                        'updated_on' => date('Y-m-d h:i:s'),
                        'status' => '1'
                    );
                    $is_update_cart = $this->CrudModel->updateItem($this->cart_tbl, $where_data, $update_data);

                    $cart_data = $this->CrudModel->getAnyItems($db_data);
                    //print_r($cart_data);

                    $where_data_cart = ['user_ip' => $user_ip, 'status' => 1];
                    $total_cart = $this->CrudModel->countTotalRowsAll($this->cart_tbl, $where_data_cart);
                    if($is_update_cart){
                        $responseArr = array("token" => $token, "message" => "Success", "response" => true, "cart_products" => $total_cart, "cart_id" => $cart_data->cart_id, "cart_id_quantity" => $cart_data->quantity);
                    }else{
                        $responseArr = array("token" => $token, "message" => "Error in cart update.Please try again later.", "response" => false, "cart_products" => $total_cart);
                    }
                    
                }else{
                    $update_data = array(
                        'user_id' => NULL,
                        'user_ip' => $user_ip,
                        'product_id' => $product_id,
                        'product_varient' => $varient_id,
                        'quantity' => $quantity,
                        'added_on' => date('Y-m-d h:i:s'),
                        'updated_on' => date('Y-m-d h:i:s'),
                        'status' => '1'
                    );
                    $is_add_cart = $this->CrudModel->insertItem($this->cart_tbl, $update_data);

                    $cart_data = $this->CrudModel->getAnyItems($db_data);
                    //print_r($cart_data);

                    $where_data_cart = ['user_ip' => $user_ip, 'status' => 1];
                    $total_cart = $this->CrudModel->countTotalRowsAll($this->cart_tbl, $where_data_cart);
                    if($is_add_cart){
                        $responseArr = array("token" => $token, "message" => "Success", "response" => true, "cart_products" => $total_cart, "cart_id" => $cart_data->cart_id, "cart_id_quantity" => $cart_data->quantity);
                    }else{
                        $responseArr = array("token" => $token, "message" => "Error in adding to cart.Please try again later.", "response" => false, "cart_products" => $total_cart);
                    }
                }
            }else{
                $responseArr = array("token" => $token, "message" => "Please select varient!", "response" => false);
            } 

            //$responseArr = array("token" => $token, "response" => true, "cart_products" => count($_SESSION['user_cart_data']));
        }else{
            if(isset($varient_id) && !empty($varient_id)){
                $where_data = ['product_varient' => $varient_id, 'product_id' => $product_id, 'user_id' => $_SESSION['user_login']['UserID']];
                $db_data = array(
                    "table" => $this->cart_tbl,
                    "where" => $where_data,
                    "output" => 'row_object'
                );

                $admin_data = $this->CrudModel->getAnyItems($db_data);
             
                if(!empty($admin_data)){
                    $update_data = array(
                        'quantity' => $quantity,
                        'updated_on' => date('Y-m-d h:i:s'),
                        'status' => '1'
                    );
                    $is_update_cart = $this->CrudModel->updateItem($this->cart_tbl, $where_data, $update_data);
                    $cart_data = $this->CrudModel->getAnyItems($db_data);
                    //print_r($cart_data);
                    $where_data_cart = ['user_id' => $_SESSION['user_login']['UserID'], 'status' => 1];
                    $total_cart = $this->CrudModel->countTotalRowsAll($this->cart_tbl, $where_data_cart);
                    if($is_update_cart){
                        $responseArr = array("token" => $token, "message" => "Success", "response" => true, "cart_products" => $total_cart, "cart_id" => $cart_data->cart_id, "cart_id_quantity" => $cart_data->quantity);
                    }else{
                        $responseArr = array("token" => $token, "message" => "Error in cart update.Please try again later.", "response" => false, "cart_products" => $total_cart);
                    }
                    
                }else{
                    $update_data = array(
                        'user_id' => $user_id,
                        'product_id' => $product_id,
                        'product_varient' => $varient_id,
                        'quantity' => $quantity,
                        'added_on' => date('Y-m-d h:i:s'),
                        'updated_on' => date('Y-m-d h:i:s'),
                        'status' => '1'
                    );
                    $is_add_cart = $this->CrudModel->insertItem($this->cart_tbl, $update_data);

                    $cart_data = $this->CrudModel->getAnyItems($db_data);
                    //print_r($cart_data);
                    $where_data_cart = ['user_id' => $user_id, 'status' => 1];
                    $total_cart = $this->CrudModel->countTotalRowsAll($this->cart_tbl, $where_data_cart);
                    if($is_add_cart){
                        $responseArr = array("token" => $token, "message" => "Success", "response" => true, "cart_products" => $total_cart, "cart_id" => $cart_data->cart_id, "cart_id_quantity" => $cart_data->quantity);
                    }else{
                        $responseArr = array("token" => $token, "message" => "Error in adding to cart.Please try again later.", "response" => false, "cart_products" => $total_cart);
                    }
                }
            }else{
                $responseArr = array("token" => $token, "message" => "Please select varient!", "response" => false);
            } 
        }

        
        echo json_encode($responseArr);
         die();
    }

    public function remove_from_cart(){
        $token = csrf_hash();         
        $cart_id = $this->request->getPost('cart_id');

        if(isset($cart_id) && !empty($cart_id)){
            $where_data = ['cart_id' => $cart_id];
           
            $admin_data = $this->CrudModel->deleteItems($this->cart_tbl,$where_data);
         
            if(!empty($admin_data)){
                $responseArr = array("token" => $token, "message" => "Success", "response" => true);               
            }else{
                $responseArr = array("token" => $token, "message" => "Error.", "response" => false);                
            }
        }else{
            $responseArr = array("token" => $token, "message" => "Error.", "response" => false);
        }
        echo json_encode($responseArr);
        die();
    }

    public function update_cart(){
        $token = csrf_hash();         
        $carts = $this->request->getPost('carts');
        //print_r($carts);

        if(!empty($carts)){
            foreach ($carts as $value) {
                if($value['quantity'] != ''){
                    $where_data = ['cart_id' => $value['cart_id']]; 
                    $update_data = array(
                        'quantity' => $value['quantity'],
                        'updated_on' => date('Y-m-d h:i:s')
                    );
                    $this->CrudModel->updateItem($this->cart_tbl, $where_data, $update_data);
                }
            }
            $responseArr = array("token" => $token, "message" => "Success", "response" => true); 
        }else{
            $responseArr = array("token" => $token, "message" => "Please provide quantity!", "response" => false);
        }
        echo json_encode($responseArr);
        die();
    }

    public function set_promocode_session(){
        $coupon = $this->request->getPost('coupon');
        $token = csrf_hash(); 

        $user_id = $this->request->getPost('user_id');

        $where_data = ['promo_code' => $coupon, 'status' => 1];
        $db_data = array(
            "table" => $this->promo_tbl,
            "where" => $where_data
        );

        $admin_data = $this->CrudModel->getAnyItems($db_data);       
        //print_r($admin_data);
        $adminData['promo_code'] = $admin_data;        
        $this->session->set($adminData);

        $responseArr = array("token" => $token, "response" => true);
            
        echo json_encode($responseArr);
        die();
    }
    public function set_instructions_session(){
        $instructions = $this->request->getPost('instructions');
        $token = csrf_hash(); 
               
        //print_r($admin_data);
        $adminData['instructions'] = $instructions;        
        $this->session->set($adminData);

        $responseArr = array("token" => $token, "response" => true);
            
        echo json_encode($responseArr);
        die();
    }
    public function do_place_order()
    {           
        $token = csrf_hash(); 
        $user_id = $this->request->getPost('user_id');
        $mobile = $this->request->getPost('mobile');
        $wallet_balance = 0;
        $wallet_used = 'false';
        $total = $this->request->getPost('total');
        $tax_charge = $this->request->getPost('tax_charge');
        $delivery_charge = $this->request->getPost('delivery_charge');
        $discount_temp = $this->request->getPost('discount');
        $discount = isset($discount_temp) ? $discount_temp : 0;
        $final_total = $this->request->getPost('final_total');
        $payment_method = $this->request->getPost('payment_method');
        $address = $this->request->getPost('address');
        $delivery_time = $this->request->getPost('delivery_time');
        $latitude = $this->request->getPost('latitude');
        $longitude = $this->request->getPost('longitude');
        $order_instructions = $this->request->getPost('order_instructions');
        $promo_code_temp = $this->request->getPost('promo_code_temp');
        $promo_code = $this->request->getPost('promo_code');
        $status[] = array( 'received',date("d-m-Y h:i:sa") );
        //Input items of form
        $input = $this->request->getPost('payment_id');

        $order_insertdata = array(
            'user_id'=>$user_id,
            'mobile'=>$mobile,
            'delivery_charge'=>$delivery_charge,
            'wallet_balance' => $wallet_balance,
            'total' => $total,
            'final_total' => $final_total,
            'payment_method'=> $payment_method,
            'address'=> $address,
            'delivery_time'=> $delivery_time,
            'status' => json_encode($status),
            'latitude' => $latitude,
            'longitude' => $longitude,
            'tax_amount' => $tax_charge,
            'instructions' => $order_instructions,
            'promo_discount' => $promo_code !== null ? $promo_code : 0,
            'promo_code' => $promo_code_temp,
            'discount' => $discount,
            'active_status' => 'received'
        );
        
        if($payment_method == 'cod'){
            $is_booked = $this->CrudModel->insertItem($this->orders_tbl,$order_insertdata);
                $order_id = $is_booked;
                $where_data = ['user_id' => $user_id, 'status' => 1];
                $db_data = array(
                    "table" => $this->cart_tbl,
                    "where" => $where_data
                );

                $admin_data = $this->CrudModel->getAnyItems($db_data);
                // $total_amount=$total+$delivery_charge-$discount;
                // $item_details=json_decode(stripslashes(strip_tags($items)),1);
                foreach ($admin_data as $value) {
                    $item_details=$value->product_varient;
                    $quantity_arr=$value->quantity;
                    
                    // echo get_product_discounted_price($item_details) != "0" ? (get_product_discounted_price($item_details))*$quantity_arr : (get_product_price($item_details))*$quantity_arr;
                    
                    $item_data = array(
                        'user_id'=>$user_id,
                        'order_id'=>$order_id,
                        'product_variant_id'=>$item_details,
                        'quantity'=>$quantity_arr,
                        'price'=>get_product_price($item_details),
                        'discounted_price'=>get_product_discounted_price($item_details),
                        'discount'=>0,
                        'sub_total'=> get_product_discounted_price($item_details) != "0" ? get_product_discounted_price($item_details)*$quantity_arr : get_product_price($item_details)*$quantity_arr,
                        'status'=>json_encode($status),
                        'active_status' => 'received'
                    );

                    $is_itementered = $this->CrudModel->insertItem($this->order_items_tbl,$item_data);
                }

                $where_data2 = ['user_id' => $user_id];
                $delete_from_cart = $this->CrudModel->deleteItems($this->cart_tbl,$where_data2);
                    
                if ($is_booked && $is_itementered) { 
                    $this->session->remove('promo_code');
                    $this->session->remove('instructions');
                    $responseArr = array("token" => $token, "message" => "Order is placed successfully!", "success" => true); 
                }else {
                    $responseArr = array("token" => $token, "message" => "Order is Not placed successfully! please try again!", "success" => false); 
                }

        }else if($payment_method == 'RazorPay'){
            if (!empty($input)) {
                try {
                    //get API Configuration
                    $api = new Api(env('razorKey'), env('razorSecret'));
                    $payment = $api->payment->fetch($input);
                    $response = $api->payment->fetch($payment['id'])->capture(array('amount' => $payment['amount'], 'currency' => 'INR'));
                    $success = true;
                } catch (\Exception $e) {
                    $success = false;
                    return $e->getMessage();
                    session()->setFlashdata("error", $e->getMessage());
                    return redirect()->back();
                }
            }

            if($success == true){
                $is_booked = $this->CrudModel->insertItem($this->orders_tbl,$order_insertdata);

                $order_id = $is_booked;
                $where_data = ['user_id' => $user_id, 'status' => 1];
                $db_data = array(
                    "table" => $this->cart_tbl,
                    "where" => $where_data
                );

                $admin_data = $this->CrudModel->getAnyItems($db_data);
               // $total_amount= $total + $delivery_charge - $discount;
                // $item_details=json_decode(stripslashes(strip_tags($items)),1);
                foreach ($admin_data as $value) {
                    $item_details=$value->product_varient;
                    $quantity_arr=$value->quantity;

                    $item_data = array(
                        'user_id'=>$user_id,
                        'order_id'=>$order_id,
                        'product_variant_id'=>$item_details,
                        'quantity'=>$quantity_arr,
                        'price'=>get_product_price($item_details),
                        'discounted_price'=>get_product_discounted_price($item_details),
                        'discount'=>0,
                        'sub_total'=> get_product_discounted_price($item_details) != "0" ? get_product_discounted_price($item_details)*$quantity_arr : get_product_price($item_details)*$quantity_arr,
                        'status'=>json_encode($status),
                        'active_status' => 'received'
                    );

                    $is_itementered = $this->CrudModel->insertItem($this->order_items_tbl,$item_data);
                }
                    
                $where_data2 = ['user_id' => $user_id];
           
                $delete_from_cart = $this->CrudModel->deleteItems($this->cart_tbl,$where_data2);
                if ($is_booked && $is_itementered) { 
                    $responseArr = array("token" => $token, "message" => "Order is placed successfully!", "success" => true); 
                }else {
                    $responseArr = array("token" => $token, "message" => "Order is Not placed successfully! please try again!", "success" => false); 
                }
            }else {
                $responseArr = array("token" => $token, "message" => "Payment is not done yet!", "success" => false); 
            }
            // $responseArr = array("token" => $token, "message" => "please try again!", "success" => false);
        }
        echo json_encode($responseArr);
        die(); 
    } 

    public function update_cart_decrease(){
        $token = csrf_hash();         
        $cart_id = $this->request->getPost('cart_id');
        $quantity = $this->request->getPost('quantity');
        //print_r($carts);

        if(!empty($cart_id)){
            //foreach ($carts as $value) {
            if($quantity != ''){
                $where_data = ['cart_id' => $cart_id]; 
                $update_data = array(
                    'quantity' => $quantity,
                    'updated_on' => date('Y-m-d h:i:s')
                );
                $this->CrudModel->updateItem($this->cart_tbl, $where_data, $update_data);
            }
            $where_cart = ['cart_id' => $cart_id];
            $db_cart = array(
                "table" => $this->cart_tbl,
                "where" => $where_cart
            );

            $cart_data = $this->CrudModel->getAnyItems($db_cart);
            //print_r($cart_data);

            if(!empty($cart_data)){
                $varient = $cart_data[0]->product_varient;
                $qty = $cart_data[0]->quantity;
                $final_price = get_product_discounted_price($varient) !== "" ? number_format((float)get_product_discounted_price($varient) * $qty, 2, '.', '') : number_format((float)get_product_price($varient) * $qty, 2, '.', '');
            }
            $where_settings = ['variable' => 'system_timezone'];
            $db_settings = array(
                "table" => $this->settings_tbl,
                "where" => $where_settings
            );

            $settings = $this->CrudModel->getAnyItems($db_settings);           
            if(!empty($settings)){
                foreach ($settings as $row){
                    $id = $row->id;                                
                    $data_settings = json_decode($row->value, true);
                }
                
            }
            if($this->session->has('user_login')){ 
                $user_id = $_SESSION['user_login']['UserID'];
                $where_data = ['user_id' => $user_id, 'status' => 1];
                $db_data = array(
                    "table" => $this->cart_tbl,
                    "where" => $where_data
                );

                $admin_data = $this->CrudModel->getAnyItems($db_data); 
            } else {
                $user_ip = getClientIpAddress();
                $where_data = ['user_ip' => $user_ip, 'status' => 1];
                $db_data = array(
                    "table" => $this->cart_tbl,
                    "where" => $where_data
                );

                $admin_data = $this->CrudModel->getAnyItems($db_data);
                $total_rows = count($admin_data); 
            }
            $final_subtotal = 0;
            $final_total = 0;
            if(!empty($admin_data)){
                foreach ($admin_data as $val) {
                    $price = get_product_discounted_price($val->product_varient) !== "" ? get_product_discounted_price($val->product_varient) : get_product_price($val->product_varient);
                    $total = $price * $val->quantity; 
                    $final_subtotal = $final_subtotal + $total;  
                }
            }
            $tax = $data_settings['tax'];
            $total_tax = $final_subtotal * $tax / 100;
            $tax_total = $final_subtotal + $total_tax;
            $delivery_charges = $data_settings['delivery_charge'];
            $min_amount = $data_settings['min_amount'];
            if($tax_total < $min_amount){
                $final_total = $final_total + $tax_total + $delivery_charges;
            }else{
                $final_total = $final_total + $tax_total;
            }

            $responseArr = array("token" => $token, "message" => "Success", "response" => true, "final_price" => $final_price, 'final_subtotal' => number_format((float)$final_subtotal, 2, '.', ''),'final_total' => number_format((float)$final_total, 2, '.', '')); 
        }else{
            $responseArr = array("token" => $token, "message" => "Please provide quantity!", "response" => false);
        }
        echo json_encode($responseArr);
        die();
    }

    public function update_cart_increase(){
        $token = csrf_hash();         
        $cart_id = $this->request->getPost('cart_id');
        $quantity = $this->request->getPost('quantity');
        //print_r($carts);

        if(!empty($cart_id)){
            if($quantity != ''){
                $where_data = ['cart_id' => $cart_id]; 
                $update_data = array(
                    'quantity' => $quantity,
                    'updated_on' => date('Y-m-d h:i:s')
                );
                $this->CrudModel->updateItem($this->cart_tbl, $where_data, $update_data);
            }
            $where_cart = ['cart_id' => $cart_id];
            $db_cart = array(
                "table" => $this->cart_tbl,
                "where" => $where_cart
            );

            $cart_data = $this->CrudModel->getAnyItems($db_cart);
            //print_r($cart_data);

            if(!empty($cart_data)){
                $varient = $cart_data[0]->product_varient;
                $qty = $cart_data[0]->quantity;
                $final_price = get_product_discounted_price($varient) !== "" ? number_format((float)get_product_discounted_price($varient) * $qty, 2, '.', '') : number_format((float)get_product_price($varient) * $qty, 2, '.', '');
            }

            $where_settings = ['variable' => 'system_timezone'];
            $db_settings = array(
                "table" => $this->settings_tbl,
                "where" => $where_settings
            );

            $settings = $this->CrudModel->getAnyItems($db_settings);           
            
            if(!empty($settings)){
                foreach ($settings as $row){
                    $id = $row->id;                                
                    $data_settings = json_decode($row->value, true);
                }
                
            }
            //print_r($data_settings);
            if($this->session->has('user_login')){ 
                $user_id = $_SESSION['user_login']['UserID'];
                $where_data = ['user_id' => $user_id, 'status' => 1];
                $db_data = array(
                    "table" => $this->cart_tbl,
                    "where" => $where_data
                );

                $admin_data = $this->CrudModel->getAnyItems($db_data); 
            } else {
                $user_ip = getClientIpAddress();
                $where_data = ['user_ip' => $user_ip, 'status' => 1];
                $db_data = array(
                    "table" => $this->cart_tbl,
                    "where" => $where_data
                );

                $admin_data = $this->CrudModel->getAnyItems($db_data);
                $total_rows = count($admin_data); 
            }
            $final_subtotal = 0;
            $final_total = 0;
            if(!empty($admin_data)){
                foreach ($admin_data as $val) {
                    $price = get_product_discounted_price($val->product_varient) !== "" ? get_product_discounted_price($val->product_varient) : get_product_price($val->product_varient);
                    $total = $price * $val->quantity; 
                    $final_subtotal = $final_subtotal + $total;  
                }
            }
            $tax = $data_settings['tax'];
            $total_tax = $final_subtotal * $tax / 100;
            $tax_total = $final_subtotal + $total_tax;
            $delivery_charges = $data_settings['delivery_charge'];
            $min_amount = $data_settings['min_amount'];
            if($tax_total < $min_amount){
                $final_total = $final_total + $tax_total + $delivery_charges;
            }else{
                $final_total = $final_total + $tax_total;
            }
            
            $responseArr = array("token" => $token, "message" => "Success", "response" => true, "final_price" => $final_price, 'final_subtotal' => number_format((float)$final_subtotal, 2, '.', ''),'final_total' => number_format((float)$final_total, 2, '.', '')); 
        }else{
            $responseArr = array("token" => $token, "message" => "Please provide quantity!", "response" => false);
        }
        echo json_encode($responseArr);
        die();
    }
}