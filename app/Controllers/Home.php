<?php

namespace App\Controllers;

use App\Models\CrudModel;
use CodeIgniter\HTTP\RequestInterface;
use App\Libraries\MenuTree;

class Home extends BaseController
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
    private $cities_tbl = 'city';
    private $areas_tbl = 'area';
    private $orders_tbl = 'orders';
    private $order_items_tbl = 'order_items';
    private $faq_tbl = 'faq';
    private $setting_tbl = 'settings';

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
    public function index()
    {   
        $where_section = ["id" => 2];
        $db_data_sections = array(
            "table" => $this->sections_tbl,
            "where" => $where_section
        );

        $section_data = $this->CrudModel->getAnyItems($db_data_sections);

        $product_ids = explode(",",$section_data[0]->product_ids);

        foreach ($product_ids as $value) {
            $where_product = ["p.id" => $value];
            $join_data = array(
                $this->product_variant_tbl.' as v' => array('p.id = v.product_id' => 'left' )
            );  
            $db_data = array(
                "table" => $this->product_tbl." as p",
                "join" => $join_data,
                "where" => $where_product,
                "order_by" => array("column"=>"p.id", "order"=>"ASC")
            );
            $product_data[] = $this->CrudModel->getAnyItems($db_data);
        }
        
        
        $where_section_meat = ["id" => 3];
        $meat_db_data_sections = array(
            "table" => $this->sections_tbl,
            "where" => $where_section_meat
        );


        $meat_section_data = $this->CrudModel->getAnyItems($meat_db_data_sections);
        $meat_product_ids = explode(",", $meat_section_data[0]->product_ids);
        
        foreach ($meat_product_ids as $value) {
            $where_meat_product = ["p.id" => $value];
            $join_data = array(
                $this->product_variant_tbl . ' as v' => array('p.id = v.product_id' => 'left')
            );
            $db_data = array(
                "table" => $this->product_tbl . " as p",
                "join" => $join_data,
                "where" => $where_meat_product,
                "order_by" => array("column" => "p.id", "order" => "ASC")
            );
            
            $meat_product_data[] = $this->CrudModel->getAnyItems($db_data);
        }
        
        
        $db_data_slider = array(
            "table" => $this->slider_tbl
        );
            
        $sliders = $this->CrudModel->getAnyItems($db_data_slider);

        $db_data_offers = array(
            "table" => $this->offers_tbl
        );

        $offers_data = $this->CrudModel->getAnyItems($db_data_offers);


        $this->data['offers_data'] = $offers_data;
        
        $this->data['sliders_data'] = $sliders;
        $this->data['product_data'] = $product_data;
        $this->data['meat_product_data'] = $meat_product_data;
        $this->data['title'] = 'Home';
        
        return render_frontend('home',$this->data);
    }

    public function terms()
    {
        $where_section = ["variable" => "terms_conditions"];
        $db_data_sections = array(
            "table" => $this->setting_tbl,
            "where" => $where_section
        );

        $section_data = $this->CrudModel->getAnyItems($db_data_sections);
        $this->data['terms'] = $section_data;
        $this->data['title'] = 'Terms & Conditions';
        return render_frontend('terms',$this->data);
    }

    public function privacy()
    {
        $where_section = ["variable" => "privacy_policy"];
        $db_data_sections = array(
            "table" => $this->setting_tbl,
            "where" => $where_section
        );

        $section_data = $this->CrudModel->getAnyItems($db_data_sections);
        $this->data['privacy'] = $section_data;
        $this->data['title'] = 'Privacy Policy';
        return render_frontend('privacy-policy',$this->data);
    }

    public function contactus()
    {
        $where_section = ["variable" => "contact_us"];
        $db_data_sections = array(
            "table" => $this->setting_tbl,
            "where" => $where_section
        );

        $section_data = $this->CrudModel->getAnyItems($db_data_sections);
        $this->data['contact'] = $section_data;
        $this->data['title'] = 'Contact Us';
        return render_frontend('contact-us',$this->data);
    }

    public function about()
    {
        $where_section = ["variable" => "about_us"];
        $db_data_sections = array(
            "table" => $this->setting_tbl,
            "where" => $where_section
        );

        $section_data = $this->CrudModel->getAnyItems($db_data_sections);
        $this->data['about'] = $section_data;
        $this->data['title'] = 'About Us';
        return render_frontend('about',$this->data);
    }

    public function faq()
    {
        $db_data_faqs = array(
            "table" => $this->faq_tbl
        );

        $faqs_data = $this->CrudModel->getAnyItems($db_data_faqs);
        $this->data['faqs'] = $faqs_data;
        $this->data['title'] = 'FAQs';
        return render_frontend('faq',$this->data);
    }

    public function refer_and_earn()
    {
        if($this->session->has('user_login')){ 
            $user_id = $_SESSION['user_login']['UserID'];  
        
            $where = ["id" => $user_id];
            $db_data = array(
                "table" => $this->users_tbl,
                "where" => $where
            );
            $user_data = $this->CrudModel->getAnyItems($db_data); 

            $this->data['user'] = $user_data;
            $this->data['title'] = 'Refer & Earn';
            return view('refer-and-earn',$this->data);
        }else{
            return redirect()->to('login');
        }
    }

    public function login()
    {
        if($this->session->has('user_login')){    
            $this->data['title'] = 'My Account';
            return redirect()->to('account');
        }else{
            $this->data['title'] = 'Login';
            return view('login',$this->data);
        }        
    }

    public function do_login()
    {
        $input = $this->validate([
            'phonenumber' => 'required',
            'password' => 'required'
        ]);
        if ($input) {
            $mobile = $this->request->getPost('phonenumber');
            $password = md5($this->request->getPost('password'));
            
            $where_data = ['mobile' => $mobile, 'password' => $password, 'status' => 1];
            $db_data = array(
                "table" => $this->users_tbl,
                "where" => $where_data,
                "output" => 'row_object'
            );

            $admin_data = $this->CrudModel->getAnyItems($db_data);
            if(!empty($admin_data)){
                $user_ip = getClientIpAddress();

                $where_data_c = ['user_ip' => $user_ip, 'user_id' => NULL, 'status' => 1];
                $db_data_c = array(
                    "table" => $this->cart_tbl,
                    "where" => $where_data_c,
                    "output" => 'row_object'
                );

                $admin = $this->CrudModel->getAnyItems($db_data_c);
                
                /*Delete old data*/
                $where_user = ['user_id' => $admin_data->id, 'status' => 1];           
                $c_data = $this->CrudModel->deleteItems($this->cart_tbl,$where_user);

                if(!empty($admin)){
                    //print_r($admin_data);
                    $update_data = array(
                        'user_id' => $admin_data->id,
                        'user_ip' => NULL,
                        'updated_on' => date('Y-m-d h:i:s')
                    );
                    $this->CrudModel->updateItem($this->cart_tbl, $where_data_c, $update_data);                    
                    
               }

                // if(isset($_SESSION['user_cart_data'])){

                //     foreach ($_SESSION['user_cart_data'] as $value){ 

                //         $where_data = ['product_varient' => $value['varient_id'], 'product_id' =>$value['product_id'], 'user_id' => $value['user_id']];
                //         $db_cartdata = array(
                //             "table" => $this->cart_tbl,
                //             "where" => $where_data,
                //             "output" => 'row_object'
                //         );

                //         $cart_data = $this->CrudModel->getAnyItems($db_cartdata);
                     
                //         if(!empty($cart_data)){
                //             $update_data = array(
                //                 'quantity' => $value['quantity'],
                //                 'updated_on' => date('Y-m-d h:i:s'),
                //                 'status' => '1'
                //             );
                //             $is_update_cart = $this->CrudModel->updateItem($this->cart_tbl, $where_data, $update_data);
                //             if($is_update_cart){
                //                 $this->session->setFlashdata('success', 'Cart Updated');
                //             }else{
                //                 $this->session->setFlashdata('error', 'Invalid Cart Data');
                //             }
                            
                //         }else{
                //             $update_data = array(
                //                 'user_id' => $value['user_id'],
                //                 'product_id' => $value['product_id'],
                //                 'product_varient ' => $value['varient_id'],
                //                 'quantity' => $value['quantity'],
                //                 'added_on' => date('Y-m-d h:i:s'),
                //                 'updated_on' => date('Y-m-d h:i:s'),
                //                 'status' => '1'
                //             );
                //             $is_add_cart = $this->CrudModel->insertItem($this->cart_tbl, $update_data);
                //             if($is_add_cart){
                //                 $this->session->setFlashdata('success', 'Cart Updated');
                //             }else{
                //                 $this->session->setFlashdata('error', 'Invalid Cart Data');
                //             }
                //         }
                //     }
                // }

                $adminData['user_login'] = [
                    'UserID'  => $admin_data->id,
                    'Name'  => $admin_data->name,
                    'EmailID'  => $admin_data->email,
                    'MobileNo'  => $admin_data->mobile
                ];
        
                $this->session->set($adminData);
                return redirect()->to('/');

                
                
            }else{
                $this->session->setFlashdata('error', 'Invalid Credentials');
                return redirect()->to('login');
            }
        } else {
            $this->session->setFlashdata('error', $this->validation->listErrors());
            return redirect()->to('login');
        }
        
    }

    public function register()
    {
        if($this->session->has('user_login')){    
            $this->data['title'] = 'My Account';
            return redirect()->to('account');
        }else{
            $this->data['title'] = 'Register';
            return view('register',$this->data);
        }  
    }



    public function do_register()
    {
        $input = $this->validate([
            'name' => 'required',
            'phoneNumber' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            'address' => 'required',
            'password' => 'required'        
        ]);
                                    
        if ($input) {
            $name = $this->request->getPost('name');
            $email = $this->request->getPost('email');
            $phoneNumber = $this->request->getPost('phoneNumber');
            $city = $this->request->getPost('city');
            $pincode = $this->request->getPost('pincode');
            $address = $this->request->getPost('address');
            $cpassword = $this->request->getPost('cpassword');
            $password = $this->request->getPost('password');
            $referal_code = $this->request->getPost('referal_code');
            $fcm_id = $this->request->getPost('register_token');
            $latitude = $this->request->getPost('latitude');
            $longitude = $this->request->getPost('longitude');

            $countrycode = substr($phoneNumber, 0, 3);

            $phoneNumber = str_replace("+91", "", $phoneNumber);

            if(isset($phoneNumber) && !empty($phoneNumber)){

                $where_data = ['mobile' => $phoneNumber, 'status' => 1];
                $db_data = array(
                    "table" => $this->users_tbl,
                    "where" => $where_data,
                    "output" => 'row_object'
                );

                $admin_data = $this->CrudModel->getAnyItems($db_data);
                //print_r($admin_data);
                if(!empty($admin_data)){
                    $this->session->setFlashdata('error', 'This mobile number is already registered! Please use another mobile number for registration!');
                    return redirect()->to('register');
                }else{
                    $update_data = array(
                        'name' => $name,
                        'email' => $email,
                        'mobile' => $phoneNumber,
                        'country_code' => $countrycode,
                        'password' => md5($password),
                        'city' => $city,
                        'street' => $address,
                        'pincode'=> $pincode,
                        'fcm_id' => $fcm_id,                    
                        'latitude'=> $latitude,
                        'longitude'=> $longitude,
                        'status' => '1'
                    );
                    $is_creator_registered = $this->CrudModel->insertItem($this->users_tbl, $update_data);

                    if ($is_creator_registered) { 
                        $this->session->setFlashdata('success', 'You are now registered successfully with VeatFresh! Please login to your account for enjoyng great meal with us!');               
                        return redirect()->to('login');
                    }else {
                        //$data = $email->printDebugger(['headers']);                         
                        $this->session->setFlashdata('error', 'Something Got wrong!');
                        return redirect()->to('register');
                    }
                }
            }else {
                $this->session->setFlashdata('error', $this->validation->listErrors());
                return redirect()->to('register');
            }       
        }else {
            $this->session->setFlashdata('error', $this->validation->listErrors());
            return redirect()->to('register');
        }
    }

    public function forgot_password()
    {
        if($this->session->has('user_login')){    
            $this->data['title'] = 'My Account';
            return redirect()->to('account');
        }else{
            $this->data['title'] = 'Forgot Password';
            return view('forgot-password',$this->data);
        }  
    }

    public function do_reset_password()
    {
        $input = $this->validate([
            'phoneNumber' => 'required',
            'password' => 'required',
            'cpassword' => 'required'     
        ]);
                                    
        if ($input) {
            $phoneNumber = $this->request->getPost('phoneNumber');
            $password = $this->request->getPost('password');            
            $cpassword = $this->request->getPost('cpassword');

            $phoneNumber = str_replace("+91", "", $phoneNumber);
            
            $where_data = ['mobile' => $phoneNumber];
            $db_data = array(
                "table" => $this->users_tbl,
                "where" => $where_data,
                "output" => 'row_object'
            );

            $admin_data = $this->CrudModel->getAnyItems($db_data);
            
            if(empty($admin_data)){
                $this->session->setFlashdata('error', 'You have entered wrong mobile number.Please enter right password.');
                return redirect()->to('forgot-password');
            }else{
                if($password == $cpassword){
                    $update_data = array(
                        'password' => md5($password)
                    );
                    $is_creator_registered = $this->CrudModel->updateItem($this->users_tbl, $where_data, $update_data);

                    if ($is_creator_registered) { 
                        $this->session->setFlashdata('success', 'Password reset successfully!');               
                        return redirect()->to('login');
                    }else {                    
                        $this->session->setFlashdata('error', 'Something Got wrong!');
                        return redirect()->to('forgot-password');
                    }
                }else{
                    $this->session->setFlashdata('error', 'New Password & Confirm Password must be matched!');
                    return redirect()->to('forgot-password');                    
                }
            }
                
        }else {
            $this->session->setFlashdata('error', $this->validation->listErrors());
            return redirect()->to('forgot-password');
        }
    }

    public function my_account()
    {
        if($this->session->has('user_login')){  
            $db_cities = array(
                "table" => $this->cities_tbl
            );
            $cities = $this->CrudModel->getAnyItems($db_cities);

            $db_areas = array(
                "table" => $this->areas_tbl
            );
            $areas = $this->CrudModel->getAnyItems($db_areas);

            $this->data['cities'] = $cities;
            $this->data['areas'] = $areas;
            $this->data['title'] = 'Profile';
            return view('account',$this->data);
        }else{
            return redirect()->to('login');
        }
    }

    public function change_password()
    {
        if($this->session->has('user_login')){             
            $this->data['title'] = 'Change Password';
            return view('change-password',$this->data);
        }else{
            return redirect()->to('login');
        }
    }

    public function track_order()
    {
        if($this->session->has('user_login')){ 
            $user_id = $_SESSION['user_login']['UserID'];  
            /* all orders */ 
            $all_orders_data = [];
            $where_product = ["or.user_id" => $user_id];
            $db_data = array(
                "table" => $this->orders_tbl." as or",
                "where" => $where_product,
                "order_by" => array("column"=>"or.id", "order"=>"DESC")
            );
            $product_data = $this->CrudModel->getAnyItems($db_data); 
            if(!empty($product_data)){
                foreach($product_data as $order){
                    $array['order'] = array(
                        "order_id" => $order->id,
                        "payment_option" => $order->payment_method,
                        "active_status" => $order->active_status,
                        "date_added" => $order->date_added,
                        "user_id" => $user_id
                    );
                    
                    $where = ["user_id" => $user_id, "order_id" => $order->id];
                    $data = array(
                        "table" => $this->order_items_tbl,
                        "where" => $where,
                        "order_by" => array("column"=>"id", "order"=>"DESC")
                    );
                    $order_items = $this->CrudModel->getAnyItems($data);
                    $array['order']['order_item'] = $order_items;
                    array_push($all_orders_data, $array);
                }
            }
            $this->data['all_orders_data'] = $all_orders_data;

            /* In Process orders */ 
            $process_orders_data = [];
            $where_inprocess = ["or.user_id" => $user_id, "or.active_status" => "processed"];
            $db_inprocess = array(
                "table" => $this->orders_tbl." as or",
                "where" => $where_inprocess,
                "order_by" => array("column"=>"or.id", "order"=>"DESC")
            );
            $inprocess_data = $this->CrudModel->getAnyItems($db_inprocess); 

            //print_r($inprocess_data);
            if(!empty($inprocess_data)){
                foreach($inprocess_data as $order){
                    $array['order'] = array(
                        "order_id" => $order->id,
                        "payment_option" => $order->payment_method,
                        "active_status" => $order->active_status,
                        "date_added" => $order->date_added,
                        "user_id" => $user_id
                    );
                    
                    $where = ["user_id" => $user_id, "order_id" => $order->id];
                    $data = array(
                        "table" => $this->order_items_tbl,
                        "where" => $where,
                        "order_by" => array("column"=>"id", "order"=>"DESC")
                    );
                    $order_items = $this->CrudModel->getAnyItems($data);
                    $array['order']['order_item'] = $order_items;
                    array_push($process_orders_data, $array);
                }
            }
            $this->data['inprocess_orders_data'] = $process_orders_data; 

            /* Shipped orders */ 
            $shipped_orders_data = [];
            $where_shipped = ["or.user_id" => $user_id, "or.active_status" => "shipped"];
            $db_shipped = array(
                "table" => $this->orders_tbl." as or",
                "where" => $where_shipped,
                "order_by" => array("column"=>"or.id", "order"=>"DESC")
            );
            $shipped_data = $this->CrudModel->getAnyItems($db_shipped); 
            if(!empty($shipped_data)){
                foreach($shipped_data as $order){
                    $array['order'] = array(
                        "order_id" => $order->id,
                        "payment_option" => $order->payment_method,
                        "active_status" => $order->active_status,
                        "date_added" => $order->date_added,
                        "user_id" => $user_id
                    );
                    
                    $where = ["user_id" => $user_id, "order_id" => $order->id];
                    $data = array(
                        "table" => $this->order_items_tbl,
                        "where" => $where,
                        "order_by" => array("column"=>"id", "order"=>"DESC")
                    );
                    $order_items = $this->CrudModel->getAnyItems($data);
                    $array['order']['order_item'] = $order_items;

                    array_push($shipped_orders_data, $array);
                }
            }
            $this->data['shipped_orders_data'] = $shipped_orders_data; 

            /* Delivered orders */ 
            $delivered_orders_data = [];
            $where_delivered = ["or.user_id" => $user_id, "or.active_status" => "delivered"];
            $db_delivered = array(
                "table" => $this->orders_tbl." as or",
                "where" => $where_delivered,
                "order_by" => array("column"=>"or.id", "order"=>"DESC")
            );
            $delivered_data = $this->CrudModel->getAnyItems($db_delivered); 
            if(!empty($delivered_data)){
                foreach($delivered_data as $order){
                    $array['order'] = array(
                        "order_id" => $order->id,
                        "payment_option" => $order->payment_method,
                        "active_status" => $order->active_status,
                        "date_added" => $order->date_added,
                        "user_id" => $user_id
                    );
                    
                    $where = ["user_id" => $user_id, "order_id" => $order->id];
                    $data = array(
                        "table" => $this->order_items_tbl,
                        "where" => $where,
                        "order_by" => array("column"=>"id", "order"=>"DESC")
                    );
                    $order_items = $this->CrudModel->getAnyItems($data);
                    $array['order']['order_item'] = $order_items;
                    
                    array_push($delivered_orders_data, $array);
                }
            }
            $this->data['delivered_orders_data'] = $delivered_orders_data; 

            /* Cancelled orders */ 
            $cancelled_orders_data = [];
            $where_cancelled = ["or.user_id" => $user_id, "or.active_status" => "cancelled"];
            $db_cancelled = array(
                "table" => $this->orders_tbl." as or",
                "where" => $where_cancelled,
                "order_by" => array("column"=>"or.id", "order"=>"DESC")
            );
            $cancelled_data = $this->CrudModel->getAnyItems($db_cancelled); 
            if(!empty($cancelled_data)){
                foreach($cancelled_data as $order){
                    $array['order'] = array(
                        "order_id" => $order->id,
                        "payment_option" => $order->payment_method,
                        "active_status" => $order->active_status,
                        "date_added" => $order->date_added,
                        "user_id" => $user_id
                    );
                    
                    $where = ["user_id" => $user_id, "order_id" => $order->id];
                    $data = array(
                        "table" => $this->order_items_tbl,
                        "where" => $where,
                        "order_by" => array("column"=>"id", "order"=>"DESC")
                    );
                    $order_items = $this->CrudModel->getAnyItems($data);
                    $array['order']['order_item'] = $order_items;
                    
                    array_push($cancelled_orders_data, $array);
                }
            }
            $this->data['cancelled_orders_data'] = $cancelled_orders_data;

            /* Returned orders */ 
            $returned_orders_data = [];
            $where_returned = ["or.user_id" => $user_id, "or.active_status" => "returned"];
            $db_returned = array(
                "table" => $this->orders_tbl." as or",
                "where" => $where_returned,
                "order_by" => array("column"=>"or.id", "order"=>"DESC")
            );
            $returned_data = $this->CrudModel->getAnyItems($db_returned); 
            if(!empty($returned_data)){
                foreach($returned_data as $order){
                    $array['order'] = array(
                        "order_id" => $order->id,
                        "payment_option" => $order->payment_method,
                        "active_status" => $order->active_status,
                        "date_added" => $order->date_added,
                        "user_id" => $user_id
                    );
                    
                    $where = ["user_id" => $user_id, "order_id" => $order->id];
                    $data = array(
                        "table" => $this->order_items_tbl,
                        "where" => $where,
                        "order_by" => array("column"=>"id", "order"=>"DESC")
                    );
                    $order_items = $this->CrudModel->getAnyItems($data);
                    $array['order']['order_item'] = $order_items;
                    
                    array_push($returned_orders_data, $array);
                }
            }
            $this->data['returned_orders_data'] = $returned_orders_data;

            $this->data['title'] = 'Track Order';
            return view('track-order',$this->data);
        }else{
            return redirect()->to('login');
        }
    }

    public function order_detail(string $OrderID)
    {
        if($this->session->has('user_login')){ 
            $user_id = $_SESSION['user_login']['UserID'];  

            if(isset($_GET['action']) && $_GET['action'] == 'cancelorder'){
                $status[] = array( 'cancelled',date("d-m-Y h:i:sa") );
                $active_status = 'cancelled';

                $array = array(
                    "active_status" => $active_status,
                    "status" => json_encode($status)                       
                );
                    
                $where = ["id" => $OrderID];                
                $this->CrudModel->updateItem($this->orders_tbl, $where, $array);

                $where2 = ["order_id" => $OrderID]; 
                $this->CrudModel->updateItem($this->order_items_tbl, $where2, $array);

                return redirect()->to('/track-order');
            }
            /* all orders */ 
            $all_orders_data = [];
            $where_product = ["or.user_id" => $user_id, "or.id" => $OrderID];
            $db_data = array(
                "table" => $this->orders_tbl." as or",
                "where" => $where_product,
                "order_by" => array("column"=>"or.id", "order"=>"ASC")
            );
            $product_data = $this->CrudModel->getAnyItems($db_data); 
            if(!empty($product_data)){
                //foreach($product_data as $order){
                    $array['order'] = $product_data;
                    
                    $where = ["user_id" => $user_id, "order_id" => $OrderID];
                    $data = array(
                        "table" => $this->order_items_tbl,
                        "where" => $where,
                        "order_by" => array("column"=>"id", "order"=>"ASC")
                    );
                    $order_items = $this->CrudModel->getAnyItems($data);
                    $array['order']['order_item'] = $order_items;
                    array_push($all_orders_data, $array);
                //}
            }
            $this->data['all_orders_data'] = $all_orders_data;


            $this->data['title'] = 'Order Details';
            return view('order-details',$this->data);
        }else{
            return redirect()->to('login');
        }
    }

    public function update_profile()
    {
        $input = $this->validate([
            'name' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            'street' => 'required'        
        ]);
                                    
        if ($input) {
            $name = $this->request->getPost('name');
            $email = $this->request->getPost('email');            
            $city = $this->request->getPost('city');
            $area = $this->request->getPost('area');
            $pincode = $this->request->getPost('pincode');
            $street = $this->request->getPost('street');
            $user_id = $this->request->getPost('user_id');
            $status = isset($_GET['status']) ? $_GET['status'] : '';
            
                $where_data = ['id' => $user_id];
                $db_data = array(
                    "table" => $this->users_tbl,
                    "where" => $where_data,
                    "output" => 'row_object'
                );

                $admin_data = $this->CrudModel->getAnyItems($db_data);
                // print_r($admin_data);
                // exit;
                if(empty($admin_data)){
                    $this->session->setFlashdata('error', 'You are not registered. Please Register.');
                    return redirect()->to('logout');
                }else{
                    $update_data = array(
                        'name' => $name,
                        'email' => $email,
                        'street' => $street,
                        'city' => $city,
                        'area' => $area,
                        'pincode'=> $pincode
                    );
                    $is_creator_registered = $this->CrudModel->updateItem($this->users_tbl, $where_data, $update_data);

                    if ($is_creator_registered) { 
                        $this->session->setFlashdata('success', 'Profile updated successfully!');
                        if($status != "" && $status == 'checkout'){
                            return redirect()->to('checkout');
                        }  else{
                            return redirect()->to('account');
                        }  
                    }else {                    
                        $this->session->setFlashdata('error', 'Something Got wrong!');
                        return redirect()->to('account');
                    }
                }
                
        }else {
            $this->session->setFlashdata('error', $this->validation->listErrors());
            return redirect()->to('account');
        }
    }

    public function update_password()
    {
        $input = $this->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required'     
        ]);
                                    
        if ($input) {
            $old_password = $this->request->getPost('old_password');
            $new_password = $this->request->getPost('new_password');            
            $confirm_password = $this->request->getPost('confirm_password');
            $user_id = $this->request->getPost('user_id');
            
            $where_data = ['id' => $user_id, 'password' => md5($old_password)];
            $db_data = array(
                "table" => $this->users_tbl,
                "where" => $where_data,
                "output" => 'row_object'
            );

            $admin_data = $this->CrudModel->getAnyItems($db_data);
                
            if(empty($admin_data)){
                $this->session->setFlashdata('error', 'You have entered wrong old password.Please enter right password.');
                return redirect()->to('logout');
            }else{
                if($new_password == $confirm_password){
                    $update_data = array(
                        'password' => md5($new_password)
                    );
                    $is_creator_registered = $this->CrudModel->updateItem($this->users_tbl, $where_data, $update_data);

                    if ($is_creator_registered) { 
                        $this->session->setFlashdata('success', 'Password updated successfully!');               
                        return redirect()->to('changepassword');
                    }else {                    
                        $this->session->setFlashdata('error', 'Something Got wrong!');
                        return redirect()->to('changepassword');
                    }
                }else{
                    $this->session->setFlashdata('error', 'New Password & Confirm Password must be matched!');
                    return redirect()->to('changepassword');                    
                }
            }
                
        }else {
            $this->session->setFlashdata('error', $this->validation->listErrors());
            return redirect()->to('changepassword');
        }
    }
    public function search_result(){
            if(isset($_GET['keyword']) && $_GET['keyword'] != ""){
                $keyword = $_GET['keyword'];
                $where = 'p.name LIKE "%'.$keyword.'%" OR p.description LIKE "%'.$keyword.'%"';
            }else{
                $where = 'p.status = 1';
            }
            $db = \Config\Database::connect();

            $query = $db->query("SELECT p.*,v.* FROM $this->product_tbl as p LEFT JOIN $this->product_variant_tbl as v ON p.id = v.product_id WHERE ".$where." GROUP BY p.id ORDER BY p.id DESC");

            $product_data = $query->getResult();
            // print_r($product_data);
            // exit;
            // $join_data = array(
            //     $this->product_variant_tbl.' as v' => array('p.id = v.product_id' => 'left' )
            // ); 

            // $db_data = array(
            //     "table" => $this->product_tbl." as p",
            //     "join" => $join_data,
            //     "where" => $where,
            //     "order_by" => array("column"=>"p.id", "order"=>"DESC"),
            //     "group_by" => array("column"=>"p.id")
            // );

           //$product_data = $this->CrudModel->getAnyItems($db_data);

            $this->data['product_data'] = $product_data;

            $this->data['title'] = 'Search Results';
            return render_frontend('search',$this->data);
        
    }
    //Logout mgmt control================================================================================================================================================================
    public function logout()
    {
        
        $this->session->destroy();
        return redirect()->to('/');
        
    }
}
