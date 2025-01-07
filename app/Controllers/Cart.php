<?php

namespace App\Controllers;

use App\Models\CrudModel;
use CodeIgniter\HTTP\RequestInterface;
use App\Libraries\MenuTree;

class Cart extends BaseController

{
    private $category_tbl = 'category';
    private $product_tbl = 'products';
    private $product_variant_tbl = 'product_variant';
    private $slider_tbl = 'slider';
    private $sections_tbl = 'sections';
    private $offers_tbl = 'offers';
    private $users_tbl = 'users';
    private $cart_tbl = 'cart';
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
        // $this->check_session();
        if($this->session->has('admin_login')){
            $menus = new MenuTree();
            $this->list = $menus->get_menus();
            $this->data['menu_data'] = $menus->create_list($this->list);
        }
        $menus = new MenuTree();        
        $this->data['categories'] = $menus->get_categories();
        $this->data['cities'] = $menus->get_cities(); 
    }
    

    public function index(){
       if($this->session->has('user_login')){    
            $this->data['title'] = 'Cart';
            $user_id = $_SESSION['user_login']['UserID'];
            $where_data = ['user_id' => $user_id, 'status' => 1];
            //$where_data = ['status' => 1];
            $db_data = array(
                "table" => $this->cart_tbl,
                "where" => $where_data
            );

            $admin_data = $this->CrudModel->getAnyItems($db_data);
            //print_r($admin_data);
            $total_rows = count($admin_data);

            $where_settings = ['variable' => 'system_timezone'];
            $db_settings = array(
                "table" => $this->settings_tbl,
                "where" => $where_settings
            );

            $settings = $this->CrudModel->getAnyItems($db_settings);
            //print_r($settings);
            //exit;
            if(!empty($settings)){
                foreach ($settings as $row){
                    $id = $row->id;                                
                    $data = json_decode($row->value, true);
                }
                
            }

            $this->data['Cart_Data'] = $admin_data;
            $this->data['Settings'] = $data;
            $this->data['Total_Items'] = $total_rows;

            return view('cart',$this->data);
        }else {
            $user_ip = getClientIpAddress();
            $this->data['title'] = 'Cart';
            //$user_id = $_SESSION['user_login']['UserID'];
            $where_data = ['user_ip' => $user_ip, 'status' => 1];
            $db_data = array(
                "table" => $this->cart_tbl,
                "where" => $where_data
            );

            $admin_data = $this->CrudModel->getAnyItems($db_data);
            $total_rows = count($admin_data);

            $where_settings = ['variable' => 'system_timezone'];
            $db_settings = array(
                "table" => $this->settings_tbl,
                "where" => $where_settings
            );

            $settings = $this->CrudModel->getAnyItems($db_settings);
       
            if(!empty($settings)){
                foreach ($settings as $row){
                    $id = $row->id;                                
                    $data = json_decode($row->value, true);
                }
                
            }

            $this->data['Cart_Data'] = $admin_data;
            $this->data['Settings'] = $data;
            $this->data['Total_Items'] = $total_rows;

            return view('cart',$this->data);
        }
    }

    

}