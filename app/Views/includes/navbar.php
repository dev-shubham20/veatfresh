    <header class="header-area header-style-1 header-height-2">

        <!-- <div class="mobile-promotion"><span>Grand opening, <strong>up to 15%</strong> off all items. Only <strong>3 days</strong> left</span></div> -->

        <div class="header-middle header-middle-ptb-1 d-none d-lg-block">

            <div class="container">

                <div class="header-wrap">

                    <div class="logo logo-width-1">

                        <a href="<?= base_url(); ?>"><img src="<?php echo base_url('assets/imgs/theme/logo.png'); ?>" alt="veatfresh"></a>

                    </div>

                    <div class="header-right">

                        <div class="search-location">

                            <!-- <form action="#">

                                <select class="select-active">

                                    <option>Your Location</option>

                                    <?php //if(!empty($cities)){

                                        //$cnt = 1;

                                        //foreach ($cities as $key => $value) { ?> 

                                            <option value="<?php //echo $value->id; ?>"><?php //echo $value->name; ?></option>

                                    <?php // }} ?>                                            

                                </select>

                            </form> -->

                            

                        </div>



                        <div class="header-action-right">

                            <div class="header-action-2">

                                <div class="search-style-2" id="header-search-desktop">

                                    <form action="<?php echo base_url('search');?>" method="get">                                

                                        <input type="text" name="keyword" placeholder="Search for items..." value="<?php if(isset($_GET['keyword'])){ echo $_GET['keyword'];} ?>">

                                    </form>

                                </div>

                                <div class="header-action-icon-2">

                                    <?php if(isset($_SESSION['user_login'])){?>
                                        <a href="<?php echo base_url('account');?>">

                                            <img class="svgInject" alt="User" src="<?= base_url('assets/imgs/theme/icons/icon-user.svg'); ?>">

                                        </a>
                                    <?php } else{ ?>
                                        <a href="<?php echo base_url('login');?>">

                                            <img class="svgInject" alt="User" src="<?= base_url('assets/imgs/theme/icons/icon-user.svg'); ?>">

                                        </a>
                                    <?php } ?>
                                    <?php //print_r($_SESSION['user_login']);?>
                                    <?php if(isset($_SESSION['user_login'])){
                                        $words = explode(" ", $_SESSION['user_login']['Name']);
                                        ?>
                                        <span class="lable ml-0"><?php echo $words[0];?></span>
                                         <div class="cart-dropdown-wrap cart-dropdown-hm2 account-dropdown">
                                            <ul>
                                                <li>
                                                    <a href="<?php echo base_url('account');?>"><i class="fi fi-rs-user mr-10"></i>My Account</a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo base_url('track-order');?>"><i class="fi fi-rs-location-alt mr-10"></i>Track Order</a>
                                                </li>                                                
                                                <li>
                                                    <a href="<?= base_url('/logout');?>"><i class="fi fi-rs-sign-out mr-10"></i>Sign out</a>
                                                </li>
                                            </ul>
                                        </div>
                                    <?php } else{?>
                                        <span class="lable ml-0">Account</span>
                                    <?php } ?>

                                </div>                       

                                <div class="header-action-icon-2">

                                    <a class="mini-cart-icon" href="<?= base_url('cart'); ?>">

                                        <img alt="Nest" src="<?= base_url('assets/imgs/theme/icons/icon-cart.svg'); ?>">

                                        <span class="pro-count blue">
                                        <?php if(isset($_SESSION['user_login'])){?>
                                            <?php echo get_total_carts($_SESSION['user_login']['UserID'], NULL);?>
                                        <?php } else{?>
                                            <?php echo get_total_carts(NULL, getClientIpAddress());?>
                                        <?php } ?>
                                        </span>
                                        
                                    </a>                                
                                    <span class="lable">Cart</span>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div> 



        <div class="header-action-icon-2 d-block d-lg-none" style="margin:20px;">

            <div class="burger-icon burger-icon-white">

                <span class="burger-icon-top"></span>

                <span class="burger-icon-mid"></span>

                <span class="burger-icon-bottom"></span>

            </div>

        </div>  

        <div class="header-action-icon-2 d-block d-lg-none header-action-right right-head">
            <div class="header-action-icon-2">
                <a href="<?php echo base_url('login');?>">
                    <img class="svgInject" alt="User" src="<?= base_url('assets/imgs/theme/icons/icon-user.svg'); ?>">
                </a>    
            </div>                       

            <div class="header-action-icon-2">
                <a class="mini-cart-icon" href="<?= base_url('cart'); ?>">
                    <img alt="Nest" src="<?= base_url('assets/imgs/theme/icons/icon-cart.svg'); ?>">
                    <span class="pro-count blue">
                        <?php if(isset($_SESSION['user_login'])){?>
                            <?php echo get_total_carts($_SESSION['user_login']['UserID'], NULL);?>
                        <?php } else{?>
                            <?php echo get_total_carts(NULL, getClientIpAddress());?>
                        <?php } ?>
                    </span>                                        
                </a> 
            </div>
        </div>

        <div class="logo logo-width-1 mobile-logo">

            <a href="<?= base_url(); ?>"><img src="<?php echo base_url('assets/imgs/theme/logo.png'); ?>" alt="veatfresh"></a>

        </div>  

        <div class="mobile-search search-style-3 mobile-header-border" id="header-search-mobile">

            <form action="<?php echo base_url('search');?>" method="get">

                <input type="text" name="keyword" placeholder="Search for items…" value="<?php if(isset($_GET['keyword'])){ echo $_GET['keyword'];} ?>">

                <button type="submit"><i class="fi-rs-search"></i></button>

            </form>

        </div>

    </header>

    <div class="mobile-header-active mobile-header-wrapper-style">

        <div class="mobile-header-wrapper-inner">

            <div class="mobile-header-top">

                <div class="mobile-header-logo">

                    <a href="#"><img src="<?= base_url('assets/imgs/theme/logo.png'); ?>" alt="logo"></a>

                </div>

                <!-- <div class="mobile-search search-style-3 mobile-header-border">

                    <form action="#">

                        <input type="text" placeholder="Search for items…">

                        <button type="submit"><i class="fi-rs-search"></i></button>

                    </form>

                </div> -->

                <div class="mobile-menu-close close-style-wrap close-style-position-inherit">

                    <button class="close-style search-close">

                        <i class="icon-top"></i>

                        <i class="icon-bottom"></i>

                    </button>

                </div>

            </div>

            <div class="mobile-header-content-area">

                <!-- <div class="mobile-search search-style-3 mobile-header-border">

                    <form action="#">

                        <input type="text" placeholder="Search for items…">

                        <button type="submit"><i class="fi-rs-search"></i></button>

                    </form>

                </div> -->

                <div class="mobile-menu-wrap mobile-header-border">

                    <!-- mobile menu start -->

                    <nav>
                        <div class="row">
                            <div class="account-name">
                                <?php if(isset($_SESSION['user_login'])) { ?>
                                    <h3><?= $_SESSION['user_login']['Name']; ?></h3>
                                    <p><?= $_SESSION['user_login']['MobileNo']; ?></p>
                                <?php } ?>
                            </div>
                            <hr/>
                        </div>

                        <ul class="mobile-menu font-heading">

                            <li class="menu-item-has-children"><a href="<?= base_url('/');?>">Home</a></li>

                            <?php if(isset($_SESSION['user_login'])){?>

                            <li class="menu-item-has-children"><a href="<?php echo base_url('track-order');?>">Track Order</a></li>

                            <li class="menu-item-has-children"><a href="<?php echo base_url('refer-and-earn');?>">Refer & Earn</a></li>

                            <?php } ?>


                            <li class="menu-item-has-children"><a href="<?php echo base_url('contact');?>">Contact Us</a></li>

                            <li class="menu-item-has-children"><a href="<?php echo base_url('about');?>">About Us</a></li>

                            <li class="menu-item-has-children"><a href="<?php echo base_url('terms-and-conditions');?>">Terms & Conditions</a></li>

                            <li class="menu-item-has-children"><a href="<?php echo base_url('privacy-policy');?>">Privacy Policy</a></li>

                            <li class="menu-item-has-children"><a href="<?php echo base_url('faq');?>">FAQ</a></li>

                            <?php if(isset($_SESSION['user_login'])){?>

                            <li class="menu-item-has-children"><a href="<?= base_url('/logout');?>">Logout</a></li>

                            <?php } ?>

                        </ul>

                    </nav>

                    <!-- mobile menu end -->

                </div>

                <div class="site-copyright"> Copyright 2022 © Veat Fresh. All rights reserved.</div>

            </div>

        </div>

    </div>

    <!--End header-->

        <section class="header-cat-section">

            <div class="container wow fadeIn animated category-section">

                

                <div class="position-relative">

                    <div class="row" id="">

                    <div class="carausel-8-columns-cover position-relative">

                            <div class="carausel-8-columns" id="carausel-8-columns">

                            <?php 

                                if(!empty($categories)){

                                    $cnt = 1;

                                    foreach ($categories as $key => $value) {    

                                               

                            ?>

                                <div class="category-card <?php if(isset($selected_category) && $selected_category == $value->id){ echo "current-category";} ?>">

                                    <figure class="img-hover-scale overflow-hidden ">

                                        <a href="<?= base_url('category/'.encryptor($value->id)); ?>"><img src="<?php echo IMAGE_URL.$value->icon;?>" alt=""></a>

                                    </figure>

                                    <h6><a href="<?= base_url('category/'.encryptor($value->id)); ?>"><?= $value->name; ?></a></h6>

                                </div>



                            <?php } } ?>

                            </div>

                        </div>             

                    </div>

                </div>

            </div>

        </section>



    <!-- <section class="popular-categories">

            <div class="container wow fadeIn animated">

                

               

                        <div class="cards-cat">

                            <figure class=" img-hover-scale overflow-hidden">

                                <a href="#"><img src="<?php echo base_url('assets/imgs/theme/fish.jpg');?>" alt=""></a>

                            </figure>

                            <h6><a href="#">Fish</a></h6>

                        </div>

                        <div class="cards-cat">

                            <figure class=" img-hover-scale overflow-hidden">

                                <a href="#"><img src="<?php echo base_url('assets/imgs/theme/mutton.jpg');?>" alt=""></a>

                            </figure>

                            <h6><a href="#">Mutton</a></h6>

                        </div>

                        <div class="cards-cat">

                            <figure class=" img-hover-scale overflow-hidden">

                                <a href="#"><img src="<?php echo base_url('assets/imgs/theme/chicken.jpg');?>" alt=""></a>

                            </figure>

                            <h6><a href="#">Chicken</a></h6>

                        </div>

                        <div class="cards-cat">

                            <figure class=" img-hover-scale overflow-hidden">

                                <a href="#"><img src="<?php echo base_url('assets/imgs/theme/prawns.png');?>" alt=""></a>

                            </figure>

                            <h6><a href="#">Prawns</a></h6>

                        </div>

                        <div class="cards-cat">

                            <figure class=" img-hover-scale overflow-hidden">

                                <a href="#"><img src="<?php echo base_url('assets/imgs/theme/egg.png');?>" alt=""></a>

                            </figure>

                            <h6><a href="#">Eggs</a></h6>

                        </div>

                        <div class="cards-cat">

                            <figure class=" img-hover-scale overflow-hidden">

                                <a href="#"><img src="<?php echo base_url('assets/imgs/theme/icons/category-8.svg');?>" alt=""></a>

                            </figure>

                            <h6><a href="#">Addon Products</a></h6>

                        </div>                        

                    </div>

                </div>

            </div>

        </section> -->