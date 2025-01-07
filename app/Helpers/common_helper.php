<?php

if ( ! function_exists('get_roles'))

{    

    /**

     * get_roles

     *

     * @return void

     */

    function get_roles()

    {

        $role_arr = array(

            encryptor(1) => 'Super Admin',

            encryptor(2) => 'Admin'

        );

        return $role_arr;

    }

}



if ( ! function_exists('slugify')){

    /**

     * slugify

     *

     * @param  mixed $text

     * @return void

     */

    function slugify($text)

    {

        // replace non letter or digits by -

        $text = preg_replace('~[^\pL\d]+~u', '_', $text);

        // transliterate

        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters

        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim

        $text = trim($text, '-');

        // remove duplicate -

        $text = preg_replace('~-+~', '-', $text);

        // lowercase

        $text = strtolower($text);

        if (empty($text)) {

            return 'n-a';

        }

        return $text;

    }

}



if(!function_exists("getClientIpAddress")){

  

    function getClientIpAddress()

    {

        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //Checking IP From Shared Internet

        {

          $ip = $_SERVER['HTTP_CLIENT_IP'];

        }

        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //To Check IP is Pass From Proxy

        {

          $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

        }

        else

        {

          $ip = $_SERVER['REMOTE_ADDR'];

        }



        return $ip;

    }

}



if (! function_exists('category_name')) {

    function category_name($category_id) {

        $db = \Config\Database::connect();

        $builder = $db->table('category');

        $result = $builder->where(['id' => $category_id])->get()->getRow();

        return ($result) ? $result->name : "";

    }

}



if (! function_exists('convert_to_parent')) {

    function convert_to_parent($measurement,$measurement_unit_id){

        $db = \Config\Database::connect();

        $builder = $db->table('unit');

        $result = $builder->where(['id' => $measurement_unit_id])->get()->getRow();

        if(!empty($result->parent_id)){

            $stock = $measurement/$result->conversion;

        }else{

            $stock = ($measurement)*$result->conversion;

        }

        return ($stock) ? $stock : "";

    }

}



if (! function_exists('unit_name')) {

    function unit_name($measure_id) {

        $db = \Config\Database::connect();

        $builder = $db->table('unit');

        $result = $builder->where(['id' => $measure_id])->get()->getRow();

        return ($result) ? $result->short_code : "";

    }

}



if (! function_exists('get_user')) {

    function get_user($user_id) {

        $db = \Config\Database::connect();

        $builder = $db->table('users');

        $result = $builder->where(['id' => $user_id])->get()->getRow();

        return ($result) ? $result : "";

    }

}



if (! function_exists('get_total_carts')) {

    function get_total_carts($user_id, $user_ip) {

        $db = \Config\Database::connect();

        $builder = $db->table('cart');

        if($user_id != NULL){

            $result = $builder->where(['user_id' => $user_id])->countAllResults();

        }else if ($user_ip != NULL){

            $result = $builder->where(['user_ip' => $user_ip])->countAllResults();

        }        

        return ($result) ? $result : "0";

    }

}

if (! function_exists('get_product_id_from_varient')) {

    function get_product_id_from_varient($varient_id) {

        $db = \Config\Database::connect();

        $builder = $db->table('product_variant');

        $result = $builder->where(['id' => $varient_id])->get()->getRow();

        return ($result) ? $result->product_id : "";

    }

}


if (! function_exists('get_product_name')) {

    function get_product_name($product_id) {

        $db = \Config\Database::connect();

        $builder = $db->table('products');

        $result = $builder->where(['id' => $product_id])->get()->getRow();

        return ($result) ? $result->name : "";

    }

}





if (! function_exists('get_product_image')) {

    function get_product_image($product_id) {

        $db = \Config\Database::connect();

        $builder = $db->table('products');

        $result = $builder->where(['id' => $product_id])->get()->getRow();

        return ($result) ? $result->image : "";

    }

}



if (! function_exists('get_product_price')) {

    function get_product_price($product_varient) {

        $db = \Config\Database::connect();

        $builder = $db->table('product_variant');

        $result = $builder->where(['id' => $product_varient])->get()->getRow();

        return ($result) ? $result->price : "";

    }

}



if (! function_exists('get_product_discounted_price')) {

    function get_product_discounted_price($product_varient) {

        $db = \Config\Database::connect();

        $builder = $db->table('product_variant');

        $result = $builder->where(['id' => $product_varient])->get()->getRow();

        return ($result) ? $result->discounted_price : 0;

    }

}



if (! function_exists('get_product_varient_gross_weight')) {

    function get_product_varient_gross_weight($product_varient) {

        $db = \Config\Database::connect();

        $builder = $db->table('product_variant');

        $result = $builder->where(['id' => $product_varient ])->get()->getRow();

        return ($result) ? $result->gross_weight.' '.unit_name($result->measurement_unit_id) : "";

    }

}



if (! function_exists('get_product_varient_no_of_pieces')) {

    function get_product_varient_no_of_pieces($product_varient) {

        $db = \Config\Database::connect();

        $builder = $db->table('product_variant');

        $result = $builder->where(['id' => $product_varient ])->get()->getRow();

        return ($result) ? $result->no_of_pieces : "";

    }

}



if (! function_exists('get_product_varient_no_of_persons')) {

    function get_product_varient_no_of_persons($product_varient) {

        $db = \Config\Database::connect();

        $builder = $db->table('product_variant');

        $result = $builder->where(['id' => $product_varient ])->get()->getRow();

        return ($result) ? $result->no_of_persons : "";

    }

}



if (! function_exists('get_product_varient_measurement')) {

    function get_product_varient_measurement($product_varient) {

        $db = \Config\Database::connect();

        $builder = $db->table('product_variant');

        $result = $builder->where(['id' => $product_varient ])->get()->getRow();

        return ($result) ? $result->measurement.' '.unit_name($result->measurement_unit_id) : "";

    }

}

if (! function_exists('get_area_name')) {

    function get_area_name($area_id) {

        $db = \Config\Database::connect();

        $builder = $db->table('area');

        $result = $builder->where(['id' => $area_id])->get()->getRow();

        return ($result) ? $result->name : "";

    }

}

if (! function_exists('get_city_name')) {

    function get_city_name($city_id) {

        $db = \Config\Database::connect();

        $builder = $db->table('city');

        $result = $builder->where(['id' => $city_id])->get()->getRow();

        return ($result) ? $result->name : "";

    }

}