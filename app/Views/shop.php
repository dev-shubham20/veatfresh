<main class="main">

        <!-- <div class="page-header mt-30 mb-50">

            <div class="container">

                <div class="archive-header">

                    <div class="row align-items-center">

                        <div class="col-xl-3">

                            <h1 class="mb-15">Shop</h1>

                            <div class="breadcrumb">

                                <a href="<?php echo base_url();?>" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>

                                <span></span> Shop

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div> -->

        <div class="container mb-30">

            <div class="row">

                <div class="col-12">

                    

                    <div class="row product-grid">

                        <?php if(!empty($product_data)) {

                            $count = 0;

                            foreach ($product_data as $key => $value) { ?>

                        <div class="col-lg-1-4 col-md-3 col-12 col-sm-6">

                            <div class="product-cart-wrap wow fadeIn animated mb-30">

                                <div class="product-img-action-wrap">

                                    <div class="product-img product-img-zoom">

                                        <a href="<?= base_url('product-detail/'.encryptor($value->product_id)); ?>">

                                            <img class="default-img" src="<?php echo IMAGE_URL.$value->image;?>" alt="">

                                            <img class="hover-img" src="<?php echo IMAGE_URL.$value->image;?>" alt="">

                                        </a>

                                    </div>                                    

                                </div>

                                <div class="product-content-wrap">

                                    <div class="product-category">

                                        <a href="<?= base_url('category/'.encryptor($value->category_id)); ?>"><?php echo category_name($value->category_id);?></a>

                                    </div>

                                    <h2><a href="<?= base_url('product-detail/'.encryptor($value->product_id)); ?>"><?php echo $value->name;?></a></h2>

                                    

                                    <div class="measurement">



                                                    <span class="font-small text-muted text-heading"> <strong>Gross Wt: </strong><?php echo $value->gross_weight." ".unit_name($value->measurement_unit_id);?></span> |



                                                    <span class="font-small text-muted text-heading"> <strong>Net Wt: </strong><?php echo $value->measurement." ".unit_name($value->measurement_unit_id);?></span>                                       



                                                </div>

                                    <div class="product-card-bottom">

                                        <div class="product-price">

                                            <?php if($value->discounted_price != 0){ ?>

                                                <span>₹<?php echo number_format((float)$value->discounted_price, 2, '.', '');;?> </span>

                                                <span class="old-price">₹<?php echo number_format((float)$value->price, 2, '.', '');?></span>   

                                            <?php } else {?>

                                                <span>₹<?php echo number_format((float)$value->price, 2, '.', '');?> </span>

                                            <?php } ?>

                                        </div>
                                        <?php if($value->serve_for == 'Available'){?>
                                        <div class="add-cart">
                                            <div class="plus-minus-input checkoutasd pl-mi" style="display:none;">
                                              <button type="button" class="decrease-btn dbtn" id="">-</button>
                                              <input type="text" class="quantity qty-val" id="">
                                              <button type="button" class="increase-btn ibtn" id="">+</button>
                                            </div>
                                            <a class="add btn_cart_data" href="#" id="<?php echo $value->product_id;?>">ADD TO CART</a>
                                            <input type="hidden" value="<?php echo $value->id; ?>" class="varient_id" />
                                            <input type="hidden" value="1" class="quantity_start" />
                                            <input type="hidden" value="<?php echo isset($_SESSION['user_login']) ?  $_SESSION['user_login']['UserID'] : ''; ?>" class="user_id" />
                                            <div class="loading" style="display:none;">
                                                <img src="<?= base_url('assets/imgs/spinner.gif'); ?>" alt="loader" />
                                            </div>
                                            
                                        </div>
                                        <?php } else{ ?>
                                            <div class="add-cart">                                                        
                                                <a class="add sod-outclass" href="#">Sold Out</a>
                                            </div>    
                                        <?php } ?>
                                    </div>
                                    <?php if($value->serve_for == 'Available'){?>
                                        <div class="more-varients-class" onclick="location.href='<?= base_url('product-detail/'.encryptor($value->product_id)); ?>'" style="cursor:pointer">
                                            <a href="<?= base_url('product-detail/'.encryptor($value->product_id)); ?>">More Varients</a>
                                        </div>
                                    <?php } ?>
                                </div>

                            </div>

                        </div>

                        <?php  } } ?>

                        <!--end product card-->                        

                    </div>

                    <!--product grid-->

                    <!-- <div class="pagination-area mt-20 mb-20">

                        <nav aria-label="Page navigation example">

                            <ul class="pagination justify-content-start">

                                <li class="page-item"><a class="page-link" href="#"><i class="fi-rs-arrow-small-left"></i></a></li>

                                <li class="page-item"><a class="page-link" href="#">1</a></li>

                                <li class="page-item active"><a class="page-link" href="#">2</a></li>

                                <li class="page-item"><a class="page-link" href="#">3</a></li>

                                <li class="page-item"><a class="page-link dot" href="#">...</a></li>

                                <li class="page-item"><a class="page-link" href="#">6</a></li>

                                <li class="page-item"><a class="page-link" href="#"><i class="fi-rs-arrow-small-right"></i></a></li>

                            </ul>

                        </nav>

                    </div> -->

                </div>

            </div>

        </div>

    </main>

