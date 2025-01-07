<section class="home-slider position-relative mb-30">

            <div class="container">

                <div class="home-slide-cover mt-30">

                    <div class="hero-slider-1 style-4 dot-style-1 dot-style-1-position-1">

                        <?php 

                        if(!empty($sliders_data)){

                            $cnt = 1;

                            foreach ($sliders_data as $key => $value) {

                        ?>

                        <div class="single-hero-slider single-animation-wrap" style="background-image: url(<?php echo IMAGE_URL.$value->image;?>);">

                            <div class="slider-content">                                

                                

                            </div>

                        </div>

                        <?php } } ?>

                        <!-- <div class="single-hero-slider single-animation-wrap" style="background-image: url(assets/imgs/slider/1615112118726.jpg);">

                            <div class="slider-content">

                                

                            </div>

                        </div>

                        <div class="single-hero-slider single-animation-wrap" style="background-image: url(assets/imgs/slider/1615112148992.jpg);">

                            <div class="slider-content">                                

                                

                            </div>

                        </div> -->

                    </div>

                    <div class="slider-arrow hero-slider-1-arrow"></div>

                </div>

            </div>

        </section>
<!--End hero slider-->        

<section class="position-relative mb-30 offer-slider">

            <div class="container">

                            <!-- Slider 1 -->
                <div class="slider" id="slider1">                    
                    <!-- The Arrows -->
                    <?php if(!empty($offers_data)){
                        $cnt = 1;
                        foreach ($offers_data as $key => $value) {
                        ?>
                        <div style="background-image: url(<?php echo IMAGE_URL.$value->image;?>);"></div> 
                    <?php } } ?>
                    <i class="left" class="arrows" style="z-index:2; position:absolute;"><svg viewBox="0 0 100 100">
                            <path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z"></path>
                        </svg></i>
                    <i class="right" class="arrows" style="z-index:2; position:absolute;"><svg viewBox="0 0 100 100">
                            <path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z" transform="translate(100, 100) rotate(180) "></path>
                        </svg></i>
                </div>

            </div>

        </section>

<section class="section-padding pb-5">
    <div class="container">
                <div class="section-title">
                    <h3 class="">Top Fish Products
                        <span class="view-all-class"><a href="<?php echo base_url('shop');?>">View All</a></span>
                    </h3>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="tab-content wow fadeIn animated" id="myTabContent-1">
                            <div class="tab-pane fade show active" id="tab-one-1" role="tabpanel" aria-labelledby="tab-one-1">
                                <div class="carausel-4-columns-cover arrow-center position-relative">
                                    <div class="slider-arrow slider-arrow-2" id="carausel-4-columns-arrows"></div>

                                    <div class="carausel-4-columns" id="carausel-4-columns">
                                        <?php 
                                        if(!empty($product_data)) {
                                            $count = 0;
                                            foreach ($product_data as $key => $value) {                                                
                                                if($count < 5) {
                                                    ?>
                                        <div class="product-cart-wrap wow fadeIn animated mb-30">
                                            <div class="product-img-action-wrap">
                                                <div class="product-img product-img-zoom">
                                                    <a href="<?= base_url('product-detail/'.encryptor($value[0]->product_id)); ?>">
                                                        <img class="default-img" src="<?php echo IMAGE_URL.$value[0]->image;?>" alt="">
                                                        <img class="hover-img" src="<?php echo IMAGE_URL.$value[0]->image;?>" alt="">
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="product-content-wrap">
                                                <!-- <div class="product-category">
                                                    <a href="<?php //echo base_url('category/'.encryptor($value[0]->category_id)); ?>"><?php //echo category_name($value[0]->category_id);?></a>
                                                </div> -->
                                                <h2><a href="<?= base_url('product-detail/'.encryptor($value[0]->product_id)); ?>"><?php echo $value[0]->name;?></a></h2>
                                                <div class="measurement">
                                                    <span class="font-small text-muted text-heading"> <strong>Gross Wt: </strong><?php echo $value[0]->gross_weight." ".unit_name($value[0]->measurement_unit_id);?></span> |

                                                    <span class="font-small text-muted text-heading"> <strong>Net Wt: </strong><?php echo $value[0]->measurement." ".unit_name($value[0]->measurement_unit_id);?></span>                                       

                                                </div>
                                                <div class="product-card-bottom">
                                                    <div class="product-price">
                                                        <?php if($value[0]->discounted_price != 0){ ?>
                                                            <span>MRP: ₹<?php echo number_format((float)$value[0]->discounted_price, 2, '.', '');?> </span>
                                                            <span class="old-price">₹<?php echo number_format((float)$value[0]->price, 2, '.', '');?></span>
                                                        <?php } else {?>
                                                            <span>MRP: ₹<?php echo number_format((float)$value[0]->price, 2, '.', '');?> </span>
                                                        <?php } ?>
                                                    </div>

                                                    <?php if($value[0]->serve_for == 'Available'){?>
                                                    <div class="add-cart">
                                                        <!-- <a class="add btn_cart_data" href="<?php //echo base_url('product-detail/'.encryptor($value[0]->product_id)); ?>" id="<?php //echo $value[0]->product_id;?>">ADD TO CART</a> -->
                                                        <div class="plus-minus-input checkoutasd pl-mi" style="display:none;">
                                                          <button type="button" class="decrease-btn dbtn" id="">-</button>
                                                          <input type="text" class="quantity qty-val" id="">
                                                          <button type="button" class="increase-btn ibtn" id="">+</button>
                                                        </div>
                                                        <a class="add btn_cart_data" href="#" id="<?php echo $value[0]->product_id;?>">ADD TO CART</a>
                                                        <input type="hidden" value="<?php echo $value[0]->id; ?>" class="varient_id" />
                                                        <input type="hidden" value="1" class="quantity_start" />
                                                        <input type="hidden" value="<?php echo isset($_SESSION['user_login']) ?  $_SESSION['user_login']['UserID'] : ''; ?>" class="user_id" />
                                                        <div class="loading" style="display:none;">
                                                            <img src="<?= base_url('assets/imgs/spinner.gif'); ?>" alt="loader" />
                                                        </div>
                                                    </div>
                                                    <?php } else{ ?>
                                                    <div class="add-cart">                                                        
                                                        <a class="add" href="javascript;">Sold Out</a>
                                                    </div>    
                                                    <?php } ?>
                                                </div>
                                                <!--<div class="more-varients-class" onclick="location.href='<?= base_url('product-detail/'.encryptor($value[0]->product_id)); ?>'" style="cursor:pointer">-->
                                                <!--    <a href="<?= base_url('product-detail/'.encryptor($value[0]->product_id)); ?>">More Varients</a>-->
                                                <!--</div>-->
                                                
                                                <select class="form-control weightDropDown" name="weight" id="weight_1">
                                                    <option>More Variants</option>
                                                    <?php 
                                                    $c = 1;
                                                    foreach ($value as $variant) {  ?>
                                                        <option value="<?php echo $variant->id;?>" <?php if($c == 1){ echo "selected"; } ?>>
                                                            <?php echo $variant->measurement . " " . unit_name($variant->measurement_unit_id); ?>
                                                        </option>
                                                    <?php $c++; } ?>
                                                </select>
                                                
                                                <!--<input type="hidden" name="product_id" id="product_id" value="<?php echo $value[0]->product_id;?>" />-->
                                                <!--<input type="hidden" name="user_id" id="user_id" value="<?php echo isset($_SESSION['user_login']) ? $_SESSION['user_login']['UserID'] : '';?>" />-->
                                        
                                        
                                        
                                        
                                            </div>
                                        </div>
                                        <?php } $count++; } }?>
                                        <!--End product Wrap-->                               
                                    </div>
                                </div>
                            </div>
                            <!--End tab-pane-->
                        <!--End tab-content-->
                    </div>
                    <!--End Col-lg-12-->
                </div>
            </div>
            </div>
</section>
<!--End Best Sales-->

<section class="section-padding pb-5">

        <div class="container">

            <div class="section-title">

                <h3 class="">Top Meat Products
                    <span class="view-all-class"><a href="<?php echo base_url('shop'); ?>">View All</a></span>
                </h3>

            </div>

            <div class="row">

                <div class="col-lg-12 col-md-12">

                    <div class="tab-content wow fadeIn animated" id="myTabContent-1">

                        <div class="tab-pane fade show active" id="tab-one-1" role="tabpanel" aria-labelledby="tab-one-1">

                            <div class="carausel-5-columns-cover arrow-center position-relative">

                                <div class="slider-arrow slider-arrow-2" id="carausel-5-columns-arrows"></div>

                                <div class="carausel-5-columns" id="carausel-5-columns">

                                    <?php

                                    if (!empty($meat_product_data)) {

                                        $count = 0;

                                        foreach ($meat_product_data as $key => $value) {
                                            if ($count < 5) {
                                    ?>

                                                <div class="product-cart-wrap wow fadeIn animated mb-30">

                                                    <div class="product-img-action-wrap">

                                                        <div class="product-img product-img-zoom">

                                                            <a href="<?= base_url('product-detail/' . encryptor($value[0]->product_id)); ?>">

                                                                <img class="default-img" src="<?php echo IMAGE_URL . $value[0]->image; ?>" alt="">

                                                                <img class="hover-img" src="<?php echo IMAGE_URL . $value[0]->image; ?>" alt="">

                                                            </a>

                                                        </div>

                                                    </div>

                                                    <div class="product-content-wrap">
                                                        <h2><a href="<?= base_url('product-detail/' . encryptor($value[0]->product_id)); ?>"><?php echo $value[0]->name; ?></a></h2>
                                                        <div class="measurement">

                                                            <span class="font-small text-muted text-heading"> <strong>Gross Wt: </strong><?php echo $value[0]->gross_weight . " " . unit_name($value[0]->measurement_unit_id); ?></span> |

                                                            <span class="font-small text-muted text-heading"> <strong>Net Wt: </strong><?php echo $value[0]->measurement . " " . unit_name($value[0]->measurement_unit_id); ?></span>

                                                        </div>

                                                        <div class="product-card-bottom">

                                                            <div class="product-price">

                                                                <?php if ($value[0]->discounted_price != 0) { ?>

                                                                    <span>MRP: ₹<?php echo number_format((float)$value[0]->discounted_price, 2, '.', ''); ?> </span>

                                                                    <span class="old-price">₹<?php echo number_format((float)$value[0]->price, 2, '.', ''); ?></span>

                                                                <?php } else { ?>

                                                                    <span>MRP: ₹<?php echo number_format((float)$value[0]->price, 2, '.', ''); ?> </span>

                                                                <?php } ?>

                                                            </div>

                                                            <?php if ($value[0]->serve_for == 'Available') { ?>
                                                                <div class="add-cart">
                                                                    <!-- <a class="add btn_cart_data" href="<?php //echo base_url('product-detail/'.encryptor($value[0]->product_id)); 
                                                                                                            ?>" id="<?php //echo $value[0]->product_id;
                                                                                                                    ?>">ADD TO CART</a> -->
                                                                    <div class="plus-minus-input checkoutasd pl-mi" style="display:none;">
                                                                        <button type="button" class="decrease-btn dbtn" id="">-</button>
                                                                        <input type="text" class="quantity qty-val" id="">
                                                                        <button type="button" class="increase-btn ibtn" id="">+</button>
                                                                    </div>
                                                                    <a class="add btn_cart_data" href="#" id="<?php echo $value[0]->product_id; ?>">ADD TO CART</a>
                                                                    <input type="hidden" value="<?php echo $value[0]->id; ?>" class="varient_id" />
                                                                    <input type="hidden" value="1" class="quantity_start" />
                                                                    <input type="hidden" value="<?php echo isset($_SESSION['user_login']) ?  $_SESSION['user_login']['UserID'] : ''; ?>" class="user_id" />
                                                                    <div class="loading" style="display:none;">
                                                                        <img src="<?= base_url('assets/imgs/spinner.gif'); ?>" alt="loader" />
                                                                    </div>
                                                                </div>
                                                            <?php } else { ?>
                                                                <div class="add-cart">
                                                                    <a class="add" href="javascript;">Sold Out</a>
                                                                </div>
                                                            <?php } ?>

                                                        </div>

                                                        <!--<div class="more-varients-class" onclick="location.href='<?= base_url('product-detail/' . encryptor($value[0]->product_id)); ?>'" style="cursor:pointer">-->
                                                        <!--    <a href="<?= base_url('product-detail/' . encryptor($value[0]->product_id)); ?>">More Varients</a>-->
                                                        <!--</div>-->
                                                        
                                                        <select class="form-control weightDropDown" name="weight" id="weight">
                                                            <option>More Variants</option>
                                                            <?php 
                                                            $c = 1;
                                                            foreach ($value as $variant) {  ?>
                                                                <option value="<?php echo $variant->id;?>" <?php if($c == 1){ echo "selected"; } ?>>
                                                                    <?php echo $variant->measurement . " " . unit_name($variant->measurement_unit_id); ?>
                                                                </option>
                                                            <?php $c++; } ?>
                                                        </select>

                                                    </div>

                                                </div>

                                    <?php }
                                            $count++;
                                        }
                                    } ?>

                                    <!--End product Wrap-->

                                </div>

                            </div>

                        </div>

                        <!--End tab-pane-->



                        <!--End tab-content-->

                    </div>

                    <!--End Col-lg-12-->

                </div>

            </div>
        </div>
    </section>




<section class="popular-categories section-padding">

            <div class="container wow fadeIn animated">

                <div class="section-title">

                    <h3 class="">Shop By Categories</h3>                    

                </div>

                <div class="row">

                    <?php 

                        if(!empty($categories)){

                            $cnt = 1;

                            foreach ($categories as $key => $value) {

                        ?>

                        <div class="col-4">

                            <div class="card">

                                <figure class=" img-hover-scale overflow-hidden">

                                    <a href="<?= base_url('category/'.encryptor($value->id)); ?>"><img src="<?php echo IMAGE_URL.$value->image;?>" alt="<?= $value->name; ?>"></a>

                                </figure>

                                <h6><a href="<?= base_url('category/'.encryptor($value->id)); ?>"><?= $value->name; ?></a></h6>

                            </div>

                        </div>                                   

                    <?php } } ?>

                </div>

            </div>

        </section>
<!--End category slider-->