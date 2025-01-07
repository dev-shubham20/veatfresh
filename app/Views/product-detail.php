         <div class="page-header breadcrumb-wrap">

            <div class="container">

                <div class="breadcrumb">

                    <a href="#" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>

                    <span></span> <a href="<?php echo base_url();?>"><?php echo category_name($product_data[0]->category_id);?></a>

                    <span></span> <?php echo $product_data[0]->name;?>

                </div>

            </div>

        </div>

        <div class="container mb-30">

            <div class="row">

                <div class="col-xl-10 col-lg-12 m-auto">

                    <div class="product-detail accordion-detail">

                        <div class="row mb-50 mt-30">

                            <div class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">

                                <div class="detail-gallery">

                                    <span class="zoom-icon"><i class="fi-rs-search"></i></span>

                                    <!-- MAIN SLIDES -->

                                    <div class="product-image-slider">

                                        <figure class="border-radius-10">

                                            <img src="<?php echo IMAGE_URL.$product_data[0]->image;?>" alt="product image">

                                        </figure>

                                        <?php if(!empty($product_data[0]->other_images)){ ?>

                                        <figure class="border-radius-10">

                                            <img src="<?php echo base_url('assets/imgs/shop/two.png');?>" alt="product image">

                                        </figure>   

                                        <?php } ?>

                                    </div>

                                    <!-- THUMBNAILS -->

                                    <div class="slider-nav-thumbnails">

                                        <div><img src="<?php echo IMAGE_URL.$product_data[0]->image;?>" alt="product image"></div>

                                        <?php if(!empty($product_data[0]->other_images)){ ?>

                                        <div><img src="<?php echo base_url('assets/imgs/shop/two.png');?>" alt="product image"></div>    

                                        <?php } ?>                                        

                                    </div>

                                </div>

                                <!-- End Gallery -->

                            </div>

                            <div class="col-md-6 col-sm-12 col-xs-12">

                                <div class="detail-info pr-30 pl-30">                                    

                                    <h2 class="title-detail"><?php echo $product_data[0]->name;?></h2>

                                    

                                    <div class="clearfix product-price-cover">

                                        <div class="product-price primary-color float-left">                                            

                                            <?php if($product_data[0]->discounted_price != 0){ ?> 

                                                <span class="current-price text-brand">₹<?php echo number_format((float)$product_data[0]->discounted_price, 2, '.', '');?></span>

                                                <span>

                                                    <span class="save-price  font-md color3 ml-15"></span>

                                                    <span class="old-price font-md ml-15">₹<?php echo number_format((float)$product_data[0]->price, 2, '.', '');?></span>

                                                </span> 

                                            <?php } else {?>

                                                <span class="current-price text-brand">₹<?php echo number_format((float)$product_data[0]->price, 2, '.', '');?></span>

                                                <span>

                                                    <span class="save-price  font-md color3 ml-15"></span>

                                                    <span class="old-price font-md ml-15"></span>

                                                </span> 

                                            <?php } ?> 

                                        </div>

                                    </div>     

                                    <?php 

                                    // echo "<pre>";

                                    // print_r($product_data);

                                    // echo "</pre>";

                                    ?>  

                                    <?php if(!empty($product_data)){?>

                                    <div class="detail-extralink mb-50">

                                        <?php if($product_data[0]->serve_for == 'Available'){?>
                                        <table class="font-md">

                                            <tbody>                                                

                                                <tr class="weight-wo-wheels">

                                                    <th>No Of Pieces: </th>

                                                    <td>

                                                        <p><span class="noofpieces"><?php echo $product_data[0]->no_of_pieces != "" ? $product_data[0]->no_of_pieces : "N/A";?></span></p>

                                                    </td>

                                                </tr>

                                                <tr class="weight-wo-wheels">

                                                    <th>Serves:</th>

                                                    <td>

                                                        <p><span class="noofserves"><?php echo $product_data[0]->no_of_persons != "" ? $product_data[0]->no_of_persons : "N/A";?></span></p>

                                                    </td>

                                                </tr>

                                                <tr class="weight-wo-wheels">

                                                    <th>Gross Weight:</th>

                                                    <td>

                                                        <p><span class="gross"><?php echo $product_data[0]->gross_weight;?></span><?php echo " ".unit_name($product_data[0]->measurement_unit_id);?></p>

                                                    </td>

                                                </tr>

                                                <tr class="weight-wo-wheels">

                                                    <th>Net Weight:</th>

                                                    <td>

                                                        <p><span class="net"><?php echo $product_data[0]->measurement;?></span><?php echo " ".unit_name($product_data[0]->measurement_unit_id);?></p>

                                                    </td>

                                                </tr>

                                            </tbody>

                                        </table>

                                        
                                        <select class="form-control weightDropDown" name="weight" id="weight">

                                            <option>More Varients</option>

                                            <?php 

                                            $c = 1;

                                            foreach ($product_data as $value) { ?>

                                               <option value="<?php echo $value->id;?>" <?php if($c == 1){ echo "selected";}?>><?php echo $value->measurement." ".unit_name($value->measurement_unit_id);?></option>

                                            <?php $c++; } ?>                                            

                                        </select>

                                        <?php } ?>

                                        <input type="hidden" name="product_id" id="product_id" value="<?php echo $product_data[0]->product_id;?>" />

                                        <input type="hidden" name="user_id" id="user_id" value="<?php echo isset($_SESSION['user_login']) ? $_SESSION['user_login']['UserID'] : '';?>" />

                                    </div>

                                    <?php } ?>

                                  
                                    <?php if($product_data[0]->serve_for == 'Available'){?>
                                    <div class="detail-extralink mb-50 detail-extralink-input-wrapper">

                                        <div class="detail-qty border radius">

                                            <input type="number" name="quantity_start" class="quantity_start form-control" value="1" min="1">

                                            <!-- <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>

                                            <span class="qty-val" id="qty">1</span>

                                            <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a> -->

                                        </div>

                                        <div class="product-extra-link2">

                                            <button type="button" class="button btncart_data"><i class="fi-rs-shopping-cart"></i>Add to cart</button>

                                        </div>

                                    </div>

                                    <?php } else { ?>
                                    <div class="detail-extralink mb-50">

                                        <div class="product-extra-link2">

                                            <button type="button" class="button sod-outclass">Sold Out</button>

                                        </div>

                                    </div>   

                                    <?php } ?>

                                    <p class="without-loggedin"></p>

                                    <div class="product-info">

                                        <div class="tab-style3">                                            

                                            <div class="tab-content shop_info_tab entry-main-content">

                                                <div class="tab-pane fade show active" id="Description">

                                                    <div class="">

                                                        <p><?php echo $product_data[0]->description;?></p>                                            

                                                    </div>

                                                </div>

                                                                               

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <!-- Detail Info -->

                            </div>

                        </div>

                       

                        <div class="row mt-60">

                            <div class="col-12">

                                <h2 class="section-title style-1 mb-30">Related products</h2>

                            </div>

                            <div class="col-12">

                                <div class="row related-products">

                                    <?php

                                    if(!empty($related_product_data)) {

                                    $count = 0;

                                    foreach ($related_product_data as $key => $value) { 

                                    if($count < 4) { ?>

                                    

                                    <div class="col-lg-3 col-md-4 col-12 col-sm-6">

                                        <div class="product-cart-wrap hover-up">

                                            <div class="product-img-action-wrap">

                                                <div class="product-img product-img-zoom">

                                                    <a href="#" tabindex="0">

                                                        <img class="default-img" src="<?php echo IMAGE_URL.$value->image;?>" alt="">

                                                        <img class="hover-img" src="<?php echo IMAGE_URL.$value->image;?>" alt="">

                                                    </a>

                                                </div>                                                

                                            </div>

                                            <div class="product-content-wrap">

                                                <h2><a href="<?= base_url('product-detail/'.encryptor($value->product_id)); ?>"><?php echo $value->name;?></a></h2>                                                

                                                <div class="product-price">

                                                    <?php if($value->discounted_price != 0){ ?>

                                                        <span>₹<?php echo $value->discounted_price;?> </span>

                                                        <span class="old-price">₹<?php echo $value->price;?></span>   

                                                    <?php } else {?>

                                                        <span>₹<?php echo $value->price;?> </span>

                                                    <?php } ?>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <?php } $count++; } }?>                                 

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    