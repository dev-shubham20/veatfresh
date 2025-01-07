<!DOCTYPE html>

<html lang="en">
<!-- Header Start -->

<?php echo view('includes/header'); ?>

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
                        <?php      
                        //print_r($all_orders_data);
                        $sub_total = 0;                     
                        if(!empty($all_orders_data)){
                            foreach ($all_orders_data as $order) {
                        ?>                       
                        <div class="card">
                            <div class="card-header">
                                <div class="header-left">
                                    <p class="order_id">Ordered Id: <?php echo $order['order'][0]->id;?></p>
                                    <p class="order_date">Order Date: <?php echo date("d-m-Y",strtotime($order['order'][0]->date_added));?></p>
                                </div>                                
                            </div>
                            <?php foreach ($order['order']['order_item'] as $item) { 
                                $product_id = get_product_id_from_varient($item->product_variant_id); 
                                $price_d = get_product_discounted_price($item->product_variant_id) !== "0" ? number_format((float)get_product_discounted_price($item->product_variant_id)*$item->quantity, 2, '.', '') : number_format((float)get_product_price($item->product_variant_id)*$item->quantity, 2, '.', '');
                                $sub_total = $sub_total + $price_d;?>
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
                                        <p>Via <?php echo strtoupper($order['order'][0]->payment_method);?>
                                    </div>
                                    <div class="order-status-track">
                                        <p><?php echo ucwords($item->active_status);?>
                                    </div>
                                </div>                            
                            </div>
                            <?php } ?>
                            <div class="card-footer">                               
                                <h6>Price Detail</h6>
                                <div class="product-name-cart">                                    
                                    <table border="0" width="50%" class="table-responsive order-detil">
                                        <tr>
                                            <td>Items Amount :</td>
                                            <td>₹<?= number_format((float)$sub_total, 1, '.', '');?></td>
                                        </tr>
                                        <tr>
                                            <td>Delivery Charges :</td>
                                            <td>+ ₹<?= $order['order'][0]->delivery_charge;?></td>
                                        </tr>
                                        <tr>
                                            <td>Tax(<?= $order['order'][0]->tax_percentage;?>%) :</td>
                                            <td>+ ₹<?= $order['order'][0]->tax_amount;?></td>
                                        </tr>
                                        <tr>
                                            <td>Discount :</td>
                                            <td>- ₹<?= $order['order'][0]->discount;?></td>
                                        </tr>
                                        <tr>
                                            <td>Total :</td>
                                            <td>₹<?= number_format((float)$order['order'][0]->final_total, 1, '.', '');?></td>
                                        </tr>
                                        <tr>
                                            <td>PromocodeDiscount :</td>
                                            <td>- ₹<?= $order['order'][0]->promo_discount;?></td>
                                        </tr>
                                        <tr>
                                            <td>Wallet Discount :</td>
                                            <td>- ₹<?= $order['order'][0]->wallet_balance;?></td>
                                        </tr>

                                        <tr>
                                            <td><strong>Final Total :</strong></td>
                                            <td><strong>₹<?= number_format((float)$order['order'][0]->final_total, 1, '.', '');?></strong></td>
                                        </tr>
                                    </table>
                                    
                                </div>                            
                            </div>
                            <div class="card-footer">
                                <h6>Other Details</h6>
                                <?php $user = get_user($order['order'][0]->user_id); //print_r($user);?>
                                <p>Name : <?php echo $user->name;?></p>   
                                <p>Mobile : <?php echo $order['order'][0]->mobile;?></p>
                                <p>Address : <?php echo $order['order'][0]->address;?></p>  

                                <hr/>
                                <h6>Order Status</h6>
                                <?php $user = get_user($order['order'][0]->user_id); //print_r($user);?>
                                <p>Order <?php echo ucwords($order['order'][0]->active_status);?> On : <?php echo date("d-m-Y h:iA",strtotime($order['order'][0]->date_added));?></p>                  
                            </div>

                            <!--<?php if($order['order'][0]->active_status == "received"){ ?>-->
                            <!--    <a class="btn btn-fill-out btn-block mt-30" href="<?php echo base_url('order-detail/'.$order['order'][0]->id."?action=cancelorder&user_id=".$order['order'][0]->user_id);?>" onClick="return confirm('Are you sure you want to cancel this order?');">Cancel Order</a>-->
                            <!--<?php } ?>-->
                            
                            <?php if ($order['order'][0]->active_status == "received") { ?>
                                <a class="btn btn-fill-out btn-block mt-30" href="javascript:void(0);"
                                    onclick="alert('Please call or WhatsApp our customer care number 9005316726 to cancel the order.');">
                                    Request Order Cancellation
                                </a>
                            <?php } ?>
                            
                        </div>
                        <?php } } else {?>
                        <div class="no-orders"><p>No orders to track.</p></div>
                        <?php } ?>          
              
        </div>
    
    </main>

<?php //echo view('includes/footer'); ?>

    <!-- Scripts Start -->


<?php echo view('includes/scripts'); ?>

</body>

</html>