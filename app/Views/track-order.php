<!DOCTYPE html>

<html lang="en">



<!-- Header Start -->

<?php echo view('includes/header'); ?>

<!-- Header Start -->
<style type="text/css">
    .page-header.breadcrumb-wrap {
    padding: 20px;
    background-color: #fff;
    border-bottom: 0px solid #ececec;
    font-family: "Lato", sans-serif;
}
.tabs {
  max-width: 100%;
}
.tabs-nav {
    display: -webkit-box;
    overflow: auto;
    width: 100%;
}
.tabs-nav li {
  float: left;
  width: 25%;
}

.tabs-nav a {
  background: #ff6d00;
    border: 1px solid #ff6d00;
    color: #ffffff8c;
    display: block;
    font-weight: 600;
    padding: 10px 0;
    text-align: center;
    text-decoration: none;
}

.tab-active a {
  background: #ff6d00;
  border-bottom-color: transparent;
  color: #FFF!important;
  cursor: default;
}
.tabs-stage {
  border-radius: 0 0 6px 6px;
  border-top: 0;
  clear: both;
  padding: 24px 5px;
  position: relative;
  top: -1px;
}

</style>


<body>

    <!--End header-->

    <main class="main pages">
        <div class="page-header breadcrumb-wrap cart-b">

            <div class="container">

                <div class="breadcrumb">

                    Track Order

                </div>

            </div>

        </div>
       
        <div class="page-content pb-150 orders-track">                 
            <div class="tabs">
                <ul class="tabs-nav">
                    <li><a href="#tab-1">All</a></li>
                    <li><a href="#tab-2">In-Process</a></li>
                    <li><a href="#tab-3">Shipped</a></li>
                    <li><a href="#tab-4">Delivered</a></li>
                    <li><a href="#tab-5">Cancelled</a></li>
                    <li><a href="#tab-6">Returned</a></li>
                </ul>
                <div class="tabs-stage">
                    <div id="tab-1" class="tabs">
                        <?php                           
                        if(!empty($all_orders_data)){
                            foreach ($all_orders_data as $order) {
                        ?>                       
                        <div class="card">
                            <div class="card-header">
                                <div class="header-left">
                                    <p class="order_id">Ordered Id: <?php echo $order['order']['order_id'];?></p>
                                    <p class="order_date">Order Date: <?php echo date("d-m-Y",strtotime($order['order']['date_added']));?></p>
                                </div>
                                <div class="header-right">
                                    <a href="<?= base_url('order-detail/'.$order['order']['order_id']); ?>">View Details</a>
                                </div>
                            </div>
                            <?php foreach ($order['order']['order_item'] as $item) { 
                                $product_id = get_product_id_from_varient($item->product_variant_id); ?>
                            <div class="card-body">                               
                                <div class="image-box-cart">
                                    <img src="<?php echo IMAGE_URL.get_product_image($product_id);?>" alt="<?= get_product_name($product_id);?>">
                                </div>
                                <div class="product-name-cart">                                    
                                    <h4><a class="product-name text-heading" href="<?= base_url('product-detail/'.encryptor($product_id)); ?>"><?= get_product_name($product_id);?></a></h4>
                                    <div class="product-rate-cover"> 
                                        <span class="font-small text-muted">Qty: <?php echo $item->quantity;?></span> &nbsp;<span class="text-body"></span> <span class="old-price"> </span>
                                    </div>
                                    <div class="final-price" id="final_price_">
                                      <span class="text-body">₹<?php echo get_product_discounted_price($item->product_variant_id) !== "0" ? number_format((float)get_product_discounted_price($item->product_variant_id)*$item->quantity, 2, '.', '') : number_format((float)get_product_price($item->product_variant_id)*$item->quantity, 2, '.', '');?></span> 
                                    </div>
                                    <div class="payment-option-track">
                                        <p>Via <?php echo strtoupper($order['order']['payment_option']);?>
                                    </div>
                                    <div class="order-status-track">
                                        <p><?php echo ucwords($item->active_status);?>
                                    </div>
                                </div>                            
                            </div>
                            <?php } ?>
                        </div>
                        <?php } } else {?>
                        <div class="no-orders"><p>No orders to track.</p></div>
                        <?php } ?>
                    </div>
                    <div id="tab-2" class="tabs">
                        <?php                           
                        if(!empty($inprocess_orders_data)){
                            foreach ($inprocess_orders_data as $order) {
                        ?>                       
                        <div class="card">
                            <div class="card-header">
                                <div class="header-left">
                                    <p class="order_id">Ordered Id: <?php echo $order['order']['order_id'];?></p>
                                    <p class="order_date">Order Date: <?php echo date("d-m-Y",strtotime($order['order']['date_added']));?></p>
                                </div>
                                <div class="header-right">
                                    <a href="<?= base_url('order-detail/'.$order['order']['order_id']); ?>">View Details</a>
                                </div>
                            </div>
                            <?php foreach ($order['order']['order_item'] as $item) { 
                                $product_id = get_product_id_from_varient($item->product_variant_id); ?>
                            <div class="card-body">                               
                                <div class="image-box-cart">
                                    <img src="<?php echo IMAGE_URL.get_product_image($product_id);?>" alt="<?= get_product_name($product_id);?>">
                                </div>
                                <div class="product-name-cart">                                    
                                    <h4><a class="product-name text-heading" href="<?= base_url('product-detail/'.encryptor($product_id)); ?>"><?= get_product_name($product_id);?></a></h4>
                                    <div class="product-rate-cover"> 
                                        <span class="font-small text-muted">Qty: <?php echo $item->quantity;?></span> &nbsp;<span class="text-body"></span> <span class="old-price"> </span>
                                    </div>
                                    <div class="final-price" id="final_price_">
                                      <span class="text-body">₹<?php echo get_product_discounted_price($item->product_variant_id) !== "0" ? number_format((float)get_product_discounted_price($item->product_variant_id)*$item->quantity, 2, '.', '') : number_format((float)get_product_price($item->product_variant_id)*$item->quantity, 2, '.', '');?></span> 
                                    </div>
                                    <div class="payment-option-track">
                                        <p>Via <?php echo strtoupper($order['order']['payment_option']);?>
                                    </div>
                                    <div class="order-status-track">
                                        <p><?php echo ucwords($item->active_status);?>
                                    </div>
                                </div>                            
                            </div>
                            <?php } ?>
                        </div>
                        <?php } } else {?>
                        <div class="no-orders"><p>No orders to track.</p></div>
                        <?php } ?>
                    </div>
                    <div id="tab-3" class="tabs">
                        <?php                           
                        if(!empty($shipped_orders_data)){
                            foreach ($shipped_orders_data as $order) {
                        ?>                       
                        <div class="card">
                            <div class="card-header">
                                <div class="header-left">
                                    <p class="order_id">Ordered Id: <?php echo $order['order']['order_id'];?></p>
                                    <p class="order_date">Order Date: <?php echo date("d-m-Y",strtotime($order['order']['date_added']));?></p>
                                </div>
                                <div class="header-right">
                                    <a href="<?= base_url('order-detail/'.$order['order']['order_id']); ?>">View Details</a>
                                </div>
                            </div>
                            <?php foreach ($order['order']['order_item'] as $item) { 
                                $product_id = get_product_id_from_varient($item->product_variant_id); ?>
                            <div class="card-body">                               
                                <div class="image-box-cart">
                                    <img src="<?php echo IMAGE_URL.get_product_image($product_id);?>" alt="<?= get_product_name($product_id);?>">
                                </div>
                                <div class="product-name-cart">                                    
                                    <h4><a class="product-name text-heading" href="<?= base_url('product-detail/'.encryptor($product_id)); ?>"><?= get_product_name($product_id);?></a></h4>
                                    <div class="product-rate-cover"> 
                                        <span class="font-small text-muted">Qty: <?php echo $item->quantity;?></span> &nbsp;<span class="text-body"></span> <span class="old-price"> </span>
                                    </div>
                                    <div class="final-price" id="final_price_">
                                      <span class="text-body">₹<?php echo get_product_discounted_price($item->product_variant_id) !== "0" ? number_format((float)get_product_discounted_price($item->product_variant_id)*$item->quantity, 2, '.', '') : number_format((float)get_product_price($item->product_variant_id)*$item->quantity, 2, '.', '');?></span> 
                                    </div>
                                    <div class="payment-option-track">
                                        <p>Via <?php echo strtoupper($order['order']['payment_option']);?>
                                    </div>
                                    <div class="order-status-track">
                                        <p><?php echo ucwords($item->active_status);?>
                                    </div>
                                </div>                            
                            </div>
                            <?php } ?>
                        </div>
                        <?php } } else {?>
                        <div class="no-orders"><p>No orders to track.</p></div>
                        <?php } ?>
                    </div>
                    <div id="tab-4" class="tabs">
                        <?php                           
                        if(!empty($delivered_orders_data)){
                            foreach ($delivered_orders_data as $order) {
                        ?>                       
                        <div class="card">
                            <div class="card-header">
                                <div class="header-left">
                                    <p class="order_id">Ordered Id: <?php echo $order['order']['order_id'];?></p>
                                    <p class="order_date">Order Date: <?php echo date("d-m-Y",strtotime($order['order']['date_added']));?></p>
                                </div>
                                <div class="header-right">
                                    <a href="<?= base_url('order-detail/'.$order['order']['order_id']); ?>">View Details</a>
                                </div>
                            </div>
                            <?php foreach ($order['order']['order_item'] as $item) { 
                                $product_id = get_product_id_from_varient($item->product_variant_id); ?>
                            <div class="card-body">                               
                                <div class="image-box-cart">
                                    <img src="<?php echo IMAGE_URL.get_product_image($product_id);?>" alt="<?= get_product_name($product_id);?>">
                                </div>
                                <div class="product-name-cart">                                    
                                    <h4><a class="product-name text-heading" href="<?= base_url('product-detail/'.encryptor($product_id)); ?>"><?= get_product_name($product_id);?></a></h4>
                                    <div class="product-rate-cover"> 
                                        <span class="font-small text-muted">Qty: <?php echo $item->quantity;?></span> &nbsp;<span class="text-body"></span> <span class="old-price"> </span>
                                    </div>
                                    <div class="final-price" id="final_price_">
                                      <span class="text-body">₹<?php echo get_product_discounted_price($item->product_variant_id) !== "0" ? number_format((float)get_product_discounted_price($item->product_variant_id)*$item->quantity, 2, '.', '') : number_format((float)get_product_price($item->product_variant_id)*$item->quantity, 2, '.', '');?></span> 
                                    </div>
                                    <div class="payment-option-track">
                                        <p>Via <?php echo strtoupper($order['order']['payment_option']);?>
                                    </div>
                                    <div class="order-status-track">
                                        <p><?php echo ucwords($item->active_status);?>
                                    </div>
                                </div>                            
                            </div>
                            <?php } ?>
                        </div>
                        <?php } } else {?>
                        <div class="no-orders"><p>No orders to track.</p></div>
                        <?php } ?>
                    </div>
                    <div id="tab-5" class="tabs">
                        <?php                           
                        if(!empty($cancelled_orders_data)){
                            foreach ($cancelled_orders_data as $order) {
                        ?>                       
                        <div class="card">
                            <div class="card-header">
                                <div class="header-left">
                                    <p class="order_id">Ordered Id: <?php echo $order['order']['order_id'];?></p>
                                    <p class="order_date">Order Date: <?php echo date("d-m-Y",strtotime($order['order']['date_added']));?></p>
                                </div>
                                <div class="header-right">
                                    <a href="<?= base_url('order-detail/'.$order['order']['order_id']); ?>">View Details</a>
                                </div>
                            </div>
                            <?php foreach ($order['order']['order_item'] as $item) { 
                                $product_id = get_product_id_from_varient($item->product_variant_id); ?>
                            <div class="card-body">                               
                                <div class="image-box-cart">
                                    <img src="<?php echo IMAGE_URL.get_product_image($product_id);?>" alt="<?= get_product_name($product_id);?>">
                                </div>
                                <div class="product-name-cart">                                    
                                    <h4><a class="product-name text-heading" href="<?= base_url('product-detail/'.encryptor($product_id)); ?>"><?= get_product_name($product_id);?></a></h4>
                                    <div class="product-rate-cover"> 
                                        <span class="font-small text-muted">Qty: <?php echo $item->quantity;?></span> &nbsp;<span class="text-body"></span> <span class="old-price"> </span>
                                    </div>
                                    <div class="final-price" id="final_price_">
                                      <span class="text-body">₹<?php echo get_product_discounted_price($item->product_variant_id) !== "0" ? number_format((float)get_product_discounted_price($item->product_variant_id)*$item->quantity, 2, '.', '') : number_format((float)get_product_price($item->product_variant_id)*$item->quantity, 2, '.', '');?></span> 
                                    </div>
                                    <div class="payment-option-track">
                                        <p>Via <?php echo strtoupper($order['order']['payment_option']);?>
                                    </div>
                                    <div class="order-status-track">
                                        <p><?php echo ucwords($item->active_status);?>
                                    </div>
                                </div>                            
                            </div>
                            <?php } ?>
                        </div>
                        <?php } } else {?>
                        <div class="no-orders"><p>No orders to track.</p></div>
                        <?php } ?>
                    </div>
                    <div id="tab-6" class="tabs">
                        <?php                           
                        if(!empty($returned_orders_data)){
                            foreach ($returned_orders_data as $order) {
                        ?>                       
                        <div class="card">
                            <div class="card-header">
                                <div class="header-left">
                                    <p class="order_id">Ordered Id: <?php echo $order['order']['order_id'];?></p>
                                    <p class="order_date">Order Date: <?php echo date("d-m-Y",strtotime($order['order']['date_added']));?></p>
                                </div>
                                <div class="header-right">
                                    <a href="<?= base_url('order-detail/'.$order['order']['order_id']); ?>">View Details</a>
                                </div>
                            </div>
                            <?php foreach ($order['order']['order_item'] as $item) { 
                                $product_id = get_product_id_from_varient($item->product_variant_id); ?>
                            <div class="card-body">                               
                                <div class="image-box-cart">
                                    <img src="<?php echo IMAGE_URL.get_product_image($product_id);?>" alt="<?= get_product_name($product_id);?>">
                                </div>
                                <div class="product-name-cart">                                    
                                    <h4><a class="product-name text-heading" href="<?= base_url('product-detail/'.encryptor($product_id)); ?>"><?= get_product_name($product_id);?></a></h4>
                                    <div class="product-rate-cover"> 
                                        <span class="font-small text-muted">Qty: <?php echo $item->quantity;?></span> &nbsp;<span class="text-body"></span> <span class="old-price"> </span>
                                    </div>
                                    <div class="final-price" id="final_price_">
                                      <span class="text-body">₹<?php echo get_product_discounted_price($item->product_variant_id) !== "0" ? number_format((float)get_product_discounted_price($item->product_variant_id)*$item->quantity, 2, '.', '') : number_format((float)get_product_price($item->product_variant_id)*$item->quantity, 2, '.', '');?></span> 
                                    </div>
                                    <div class="payment-option-track">
                                        <p>Via <?php echo strtoupper($order['order']['payment_option']);?>
                                    </div>
                                    <div class="order-status-track">
                                        <p><?php echo ucwords($item->active_status);?>
                                    </div>
                                </div>                            
                            </div>
                            <?php } ?>
                        </div>
                        <?php } } else {?>
                        <div class="no-orders"><p>No orders to track.</p></div>
                        <?php } ?>
                    </div>
                </div>
            </div>  
        </div>
    
    </main>

<?php //echo view('includes/footer'); ?>

    <!-- Scripts Start -->

<?php echo view('includes/scripts'); ?>
<script type="text/javascript">
    // Show the first tab by default
$('.tabs-stage div.tabs').hide();
$('.tabs-stage div.tabs:first').show();
$('.tabs-nav li:first').addClass('tab-active');

// Change tab class and display content
$('.tabs-nav a').on('click', function(event){
  event.preventDefault();
  $('.tabs-nav li').removeClass('tab-active');
  $(this).parent().addClass('tab-active');
  $('.tabs-stage div.tabs').hide();
  $($(this).attr('href')).show();
});
</script>

</body>

</html>