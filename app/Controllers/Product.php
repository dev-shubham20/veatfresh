<?php



namespace App\Controllers;



use App\Models\CrudModel;

use CodeIgniter\HTTP\RequestInterface;

use App\Libraries\MenuTree;



class Product extends BaseController

{

    private $session = null;

    // Admin Table

    

    private $category_tbl = 'category';

    private $product_tbl = 'products';

    private $product_variant_tbl = 'product_variant';

    private $slider_tbl = 'slider';



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

    

    public function product_detail(string $ProductID)

    {

        $product_id = decryptor($ProductID);



        $join_data = array(

            $this->product_variant_tbl.' as v' => array('p.id = v.product_id' => 'left' )

        );  

        $where = ['p.id' => $product_id];

        $db_data = array(

            "table" => $this->product_tbl." as p",

            "join" => $join_data,

            "where" => $where,

            "order_by" => array("column"=>"p.id", "order"=>"DESC")

        );

        $product_data = $this->CrudModel->getAnyItems($db_data);





        $where_category = ['p.category_id' => $product_data[0]->category_id];

        $db_data_category = array(

            "table" => $this->product_tbl." as p",

            "join" => $join_data,

            "where" => $where_category,

            "order_by" => array("column"=>"p.id", "order"=>"rand")

        );

        $product_data_category = $this->CrudModel->getAnyItems($db_data_category);



        $this->data['related_product_data'] = $product_data_category;

        $this->data['product_data'] = $product_data;

        $this->data['title'] = 'Product Detail';



        return render_frontend('product-detail', $this->data);

    }



    public function all_products()

    {

        $join_data = array(

            $this->product_variant_tbl.' as v' => array('p.id = v.product_id' => 'left' )

        ); 



        $db_data = array(

            "table" => $this->product_tbl." as p",

            "join" => $join_data,

            "order_by" => array("column"=>"p.id", "order"=>"DESC"),

            "group_by" => array("column"=>"p.id")

        );

        $product_data = $this->CrudModel->getAnyItems($db_data);



        $this->data['product_data'] = $product_data;

        $this->data['title'] = 'Shop';

        

        return render_frontend('shop',$this->data);

    }



    public function products_by_category(string $CategoryID)

    {

        $category_id = decryptor($CategoryID);

        $join_data = array(

            $this->product_variant_tbl.' as v' => array('p.id = v.product_id' => 'left' )

        );  

        $where = ['p.category_id' => $category_id]; 

        $db_data = array(

            "table" => $this->product_tbl." as p",

            "join" => $join_data,

            "where" => $where,

            "order_by" => array("column"=>"p.id", "order"=>"DESC"),

            "group_by" => array("column"=>"p.id")

        );

        $product_data = $this->CrudModel->getAnyItems($db_data);



        $this->data['product_data'] = $product_data;

        $this->data['title'] = category_name($category_id).' | Category';

        $this->data['selected_category'] = $category_id;

        $this->data['category_name'] = category_name($category_id);

        

        return render_frontend('category',$this->data);

    }

    

}