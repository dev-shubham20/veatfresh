<?php

namespace App\Libraries;

use App\Models\CrudModel;
use CodeIgniter\HTTP\RequestInterface;

class MenuTree
{
    private $admin_tbl = 'admin';
    private $admin_roles_tbl = 'admin_roles';
    private $modules_tbl = 'modules';
    private $category_tbl = 'category';
    private $city_tbl = 'city';
    private $cart_tbl = 'cart';

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->CrudModel = new CrudModel($this->db);

        // Init Session
        $this->session = \Config\Services::session();
        $this->session->start();
        $this->data['session'] = $this->session;
    }

    public function get_cities(){
        $db_data = array(
            "table" => $this->city_tbl
        );
            
        $cities = $this->CrudModel->getAnyItems($db_data);
        return $cities;
    }

    public function get_categories(){
        $db_data = array(
            "table" => $this->category_tbl
        );
            
        $categories = $this->CrudModel->getAnyItems($db_data);
        return $categories;
    }
    
    
}
