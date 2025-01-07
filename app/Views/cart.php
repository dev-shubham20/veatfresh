<!DOCTYPE html>

<html lang="en">



<!-- Header Start -->

<?php echo view('includes/header'); ?>

<!-- Header Start -->



<body>

    <!--End header-->

    <main class="main pages">

       

        <div class="page-content">

        <div class="page-header breadcrumb-wrap cart-b">

            <div class="container">

                <div class="breadcrumb"> 

                    Cart

                </div>

            </div>

        </div>

        <?php if(isset($Total_Items) && $Total_Items!=0){?>

        <div class="container mb-80 mt-20">

            <div class="row">

                <!-- <div class="col-lg-8 mb-40">

                    <h1 class="heading-2 mb-10">Your Cart</h1>

                    <div class="d-flex justify-content-between">

                        <h6 class="text-body" id="cart_total_no">There are <span class="text-brand"><?php //echo isset($Total_Items) ? $Total_Items : '0';?></span> products in your cart</h6>                        

                    </div>

                </div> -->
<!-- 
                <div class="col-lg-4 mb-40">

                    <h4 class="mb-10">Apply Coupon</h4>

                    <p class="mb-30"><span class="font-lg text-muted">Using A Promo Code?</p>

                    <form action="#" >

                        <div class="d-flex justify-content-between">

                            <?php //if(isset($_SESSION['promo_code'])){

                                //$promocode = $_SESSION['promo_code'][0]->promo_code;

                           // }?>

                            <input class="font-medium mr-15 coupon" name="Coupon" id="coupon" placeholder="Enter Your Coupon" value="<?php //echo isset($promocode) ? $promocode : '';?>">

                            <button class="btn" id="apply-promo"><i class="fi-rs-label mr-10"></i>Apply</button>

                        </div>

                    </form>

                </div> -->

            </div>

            <div class="row">

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"></div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <?php
                        if(!empty($Cart_Data)){
                            foreach ($Cart_Data as $value) { ?>
                            <div class="cart-box">
                                <div class="image-box-cart">
                                    <img src="<?= IMAGE_URL.get_product_image($value->product_id);?>" alt="<?= get_product_name($value->product_id);?>">
                                </div>
                                <div class="product-name-cart">
                                    <p class="trsh-icon-crt"><a href="#" class="text-body remove-from-cart" id="<?php echo $value->cart_id;?>"><i class="fi-rs-cross-circle"></i></a></p>
                                    <h6 class="mb-5"><a class="product-name mb-10 text-heading" href="<?= base_url('product-detail/'.encryptor($value->product_id)); ?>"><?= get_product_name($value->product_id);?></a></h6>
                                    <div class="product-rate-cover"> 
                                        <span class="font-small ml-5 text-muted"><?= get_product_varient_measurement($value->product_varient);?></span> &nbsp;<span class="text-body"><?php if(get_product_discounted_price($value->product_varient) !== "0"){ ?>₹<?= number_format((float)get_product_discounted_price($value->product_varient), 2, '.', '');?> <?php } else { ?> ₹<?= number_format((float)get_product_price($value->product_varient), 2, '.', '');?><?php } ?></span>
                                         <?php if(get_product_discounted_price($value->product_varient) !== "0"){ ?><span class="old-price">₹<?= number_format((float)get_product_price($value->product_varient), 2, '.', '');?>  </span><?php } ?>
                                    </div> 
                                    <!-- <div class="detail-extralink mr-15">

                                            <div class="detail-qty border radius">

                                                <input type="number" name="qty-val" class="qty-val form-control" id="<?php echo $value->cart_id;?>" value="<?php echo $value->quantity;?>" min="1">

                                            </div>

                                    </div> -->
                                    <div class="plus-minus-input checkoutasd">
                                      <button type="button" class="decrease-btn" id="<?php echo $value->cart_id;?>">-</button>
                                      <input type="text" class="quantity qty-val" id="<?php echo $value->cart_id;?>" value="<?php echo $value->quantity;?>">
                                      <button type="button" class="increase-btn" id="<?php echo $value->cart_id;?>">+</button>
                                    </div>

                                    <div class="final-price" id="final_price_<?php echo $value->cart_id;?>">
                                      <span class="text-body"><?php if(get_product_discounted_price($value->product_varient) !== "0"){ ?>
                                        ₹<?= number_format((float)get_product_discounted_price($value->product_varient)*$value->quantity, 2, '.', '');?> 
                                        <?php } else { ?>
                                        ₹<?= number_format((float)get_product_price($value->product_varient)*$value->quantity, 2, '.', '');?> 
                                        <?php } ?>
                                        </span> 
                                    </div>
                                </div>
                            </div>
                    <?php } } ?>
<!-- 
                    <div class="table-responsive shopping-summery">

                        <table class="table table-wishlist">

                            <thead>

                                <tr class="main-heading">
                                   
                                    <th scope="col" width="50%">Product</th>

                                    <th scope="col" width="10%">Unit Price</th>

                                    <th scope="col" width="20%">Quantity</th>

                                    <th scope="col" width="10%">Subtotal</th>

                                    <th scope="col" width="10%">Remove</th>

                                </tr>

                            </thead>

                            <tbody id="cart_table">

                                <?php
                                //if(!empty($Cart_Data)){
                                    //foreach ($Cart_Data as $value) { ?>

                                <tr class="pt-30" id="row_tr_<?php echo $value->cart_id;?>">                            

                                    <td class="image product-thumbnail pt-40 text-center" width="50%">
                                        <img src="<?= base_url()."/assets/".get_product_image($value->product_id);?>" alt="<?= get_product_name($value->product_id);?>">
                                        <h6 class="mb-5"><a class="product-name mb-10 text-heading" href="<?= base_url('product-detail/'.encryptor($value->product_id)); ?>"><?= get_product_name($value->product_id);?></a></h6>

                                        <!-- <div class="product-rate-cover">                                            

                                            <span class="font-small ml-5 text-muted">No Of Pieces: <?php echo get_product_varient_no_of_pieces($value->product_varient) !== "" ? get_product_varient_no_of_pieces($value->product_varient) : 'N/A';?></span><br/>

                                            <span class="font-small ml-5 text-muted">Serves: <?php echo get_product_varient_no_of_persons($value->product_varient) !== "" ? get_product_varient_no_of_persons($value->product_varient) : 'N/A';?></span><br/>

                                            <span class="font-small ml-5 text-muted">Net Weight: <?= get_product_varient_measurement($value->product_varient);?></span><br/>

                                            <span class="font-small ml-5 text-muted">Gross Weight: <?= get_product_varient_gross_weight($value->product_varient);?></span>

                                        </div> -->
                                    <!-- </td>

                                   
                                    <td class="price text-center" width="10%">

                                        <h4 class="text-body">₹<?= number_format((float)get_product_price($value->product_varient), 2, '.', '');?> </h4>

                                    </td>

                                    <td class="text-center detail-info" width="20%">

                                        <div class="detail-extralink mr-15">

                                            <div class="detail-qty border radius">

                                                <input type="number" name="qty-val" class="qty-val form-control" id="<?php echo $value->cart_id;?>" value="<?php echo $value->quantity;?>" min="1">

                                            </div>

                                        </div>

                                    </td>

                                    <td class="price text-center" width="10%">

                                        <h4 class="text-brand">₹<?php $price = get_product_price($value->product_varient);

                                        $total = $price * $value->quantity;

                                        echo number_format((float)$total, 2, '.', '');?>  </h4>

                                    </td>

                                    <td class="action text-center" width="10%"><a href="#" class="text-body remove-from-cart" id="<?php echo $value->cart_id;?>"><i class="fi-rs-trash"></i></a></td>

                                </tr>
 -->
                            <?php //}} ?>                       

                            <!-- </tbody>

                        </table>

                    </div>  -->

                    <div class="divider-2 mb-30"></div>

                    <!-- <div class="cart-action d-flex justify-content-between">                       

                        <a class="btn  mr-10 mb-sm-15 update_cart"><i class="fi-rs-refresh mr-10"></i>Update Cart</a>  

                    </div> -->

                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"></div>


                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"></div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">



                            

                    <div class="border p-md-4 cart-totals">

                        <div class="table-responsive">

                            <table class="table no-border">

                                <tbody>

                                    <tr>

                                        <td class="cart_total_label">

                                            <h6 class="text-muted">Subtotal</h6>

                                        </td>

                                        <?php 

                                        $final_subtotal = 0;

                                        $final_total = 0;

                                        if(!empty($Cart_Data)){

                                            foreach ($Cart_Data as $val) {

                                                //echo get_product_discounted_price($val->product_varient);

                                                $price = get_product_discounted_price($val->product_varient) !== "0" ? get_product_discounted_price($val->product_varient) : get_product_price($val->product_varient);

                                                $total = $price * $val->quantity; 

                                                $final_subtotal = $final_subtotal + $total;  

                                            }

                                        }

                                        //print_r($Settings);

                                        $tax = $Settings['tax'];

                                        $total_tax = $final_subtotal * $tax / 100;

                                        $tax_total = $final_subtotal + $total_tax;

                                        $delivery_charges = $Settings['delivery_charge'];

                                        $min_amount = $Settings['min_amount'];

                                        if($tax_total < $min_amount){

                                            $final_total = $final_total + $tax_total + $delivery_charges;

                                            $delivery = "₹".number_format((float)$delivery_charges, 2, '.', '');

                                        }else{

                                            $final_total = $final_total + $tax_total;

                                            $delivery = 'Free';

                                        }

                                        ?>

                                        <td class="cart_total_amount">

                                            <h4 class="text-brand text-end" id="subtotal">₹<?php echo number_format((float)$final_subtotal, 2, '.', '');?></h4>

                                        </td>

                                    </tr>
                                   
                                    <tr>

                                        <td class="cart_total_label">

                                            <h6 class="text-muted">Tax</h6>

                                        </td>

                                        <td class="cart_total_amount">

                                            <h5 class="text-heading text-end">₹<?php echo number_format((float)$total_tax, 2, '.', ''); ?></h4>

                                        </td> 

                                    </tr> 

                                    <tr>

                                        <td class="cart_total_label">

                                            <h6 class="text-muted">Delivery</h6>

                                        </td>

                                        <td class="cart_total_amount">

                                            <h5 class="text-heading text-end"><?php echo $delivery;?></h4>

                                        </td> 

                                    </tr> 

                                    <?php if(isset($_SESSION['promo_code']) && !empty($_SESSION['promo_code'])){ 

                                        //print_r($_SESSION['promo_code']);

                                        $promocode = $_SESSION['promo_code'][0]->promo_code;  

                                        if($_SESSION['promo_code'][0]->discount_type == "percentage"){

                                            $discount_am = $final_total * $_SESSION['promo_code'][0]->discount / 100;

                                        }else if($_SESSION['promo_code'][0]->discount_type == "amount"){

                                            $discount_am = $_SESSION['promo_code'][0]->discount;

                                        }

                                    ?>                                  

                                    <tr>

                                        <td class="cart_total_label">

                                            <h6 class="text-muted">Discount applied <br/>(Code: <?php echo $promocode;?>)</h6>

                                        </td>

                                        <td class="cart_total_amount">

                                            <h5 class="text-heading text-end text-discount-red">-₹<?php echo $discount_am;?></h4>

                                        </td> 

                                    </tr>

                                    <?php }?>

                                    <tr>

                                        <td scope="col" colspan="2">

                                            <div class="divider-2 mt-10 mb-10"></div>

                                        </td>

                                    </tr>

                                    <tr>

                                        <td class="cart_total_label">

                                            <h6 class="text-muted">Total</h6>

                                        </td>

                                        <td class="cart_total_amount">

                                            <h4 class="text-brand text-end" id="final_total">₹<?php echo isset($discount_am) ? number_format((float)($final_total-$discount_am), 2, '.', '') : number_format((float)$final_total, 2, '.', '');?></h4>

                                        </td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>

                        <a href="<?php echo base_url('/checkout');?>" class="btn mb-20 w-100">Proceed To CheckOut<i class="fi-rs-sign-out ml-15"></i></a>

                    </div>

                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"></div>

            </div>

        </div>

        <?php } else{?>

        <div class="container mb-80 mt-50 text-center">

            <div class="row">

                <div class="col-lg-12 mb-40">

                    <h1 class="heading-2 mb-10">Cart</h1>

                    <div class="justify-content-betweentext-center">

                        <h6 class="text-body">There are no products in your cart.</h6>                        

                    </div>

                </div>

                

            </div>

            <div class="row">

                <div class="col-lg-12">

                  

                    <div class="divider-2 mb-30"></div>                    

                    <div class="cart-action ustify-content-between">

                        <a class="btn" href="<?php echo base_url('shop');?>"><i class="fi-rs-arrow-left mr-10"></i>Continue Shopping</a>

                       

                    </div>

                </div>

                

            </div>

        </div>

        <?php } ?>
        </div>

    </main>

<?php //echo view('includes/footer'); ?>

    <!-- Scripts Start -->

<?php echo view('includes/scripts'); ?>
<script type="text/javascript">
    /*For total*/
    $(document).ready(function() {
      $(".checkout").on("input", ".quantity", function() {
        var price = +$(".price").data("price");
        var quantity = +$(this).val();
        $("#total").text("$" + price * quantity);
      })

      var $buttonPlus = $('.increase-btn');
      var $buttonMin = $('.decrease-btn');
      
      
      /*For plus and minus buttons*/
      $buttonPlus.click(function() {
        var $quantity = $(this).prev('.quantity').val();
        $(this).prev('.quantity').val(parseInt($quantity) + 1).trigger('input');
      });
      
      $buttonMin.click(function() {
        var $quantity = $(this).next('.quantity').val();
        $(this).next('.quantity').val(Math.max(parseInt($quantity) - 1, 0)).trigger('input');
      });
    })
</script>

    <!-- Scripts End -->        

</body>

</html>