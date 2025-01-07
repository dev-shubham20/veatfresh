<?php

namespace App\Controllers;

class Wishlist extends BaseController
{
    
    public function index()
    {
        $data = [
            'title' => 'Wishlist'
        ];
        return render_frontend('wishlist',$data);
    }
    
}