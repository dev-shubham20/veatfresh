<!DOCTYPE html>
<html lang="en">
<!-- Header Start -->
<?php echo view('includes/header'); ?>
<!-- Header Start -->

<style type="text/css">
    .payment-logo.d-flex {
        width: 125px;
    }

    .error-data-day p,
    .error-data-time p {
        color: red;
        font-weight: 600;
    }
</style>

<body>
    <main class="main pages">
        <div class="page-header breadcrumb-wrap cart-b">
            <div class="container">
                <div class="breadcrumb">
                    Checkout
                </div>
            </div>
        </div>

        <div class="container mb-80 mt-50">
            <div class="row">
                <div class="col-lg-12">
                    <div class="cart-box">
                        <h6 class="mb-5">Delivery Address <span class="edit-address"><a href="<?php echo base_url('account?status=checkout'); ?>"><i class="fi-rs-edit-alt"></i></a></span></h6>
                        <?php $user = get_user($_SESSION['user_login']['UserID']); ?>
                        <input type="hidden" required="" name="user_id" value="<?= $_SESSION['user_login']['UserID']; ?>" id="user_id" />
                        <div class="form-group col-lg-12">
                            <textarea name="address" id="address" required placeholder="Address *" disabled>
                                        <?php if ($user->street != "") {
                                            echo $user->street;
                                        }
                                        if ($user->area != "") {
                                            echo ", " . get_area_name($user->area);
                                        }
                                        if ($user->city != "") {
                                            echo ", " . get_city_name($user->city);
                                        }
                                        if ($user->pincode != "") {
                                            echo ", " . $user->pincode;
                                        } ?>                                            
                                    </textarea>
                            <input type="hidden" required="" name="latitude" id="latitude" />
                            <input type="hidden" required="" name="longitude" id="longitude" />
                            <input type="hidden" name="phone" placeholder="Phone *" value="<?php echo $_SESSION['user_login']['MobileNo']; ?>" id="phone">
                            <!-- <div id="map_canvas" style="width: 100%;height: 500px;margin: 20px 0px;"></div> -->
                        </div>
                    </div>

                    <div class="cart-box" style="height: auto;">
                        <div class="form-group">
                            <?php if (isset($_SESSION['instructions']) && !empty($_SESSION['instructions'])) {
                                $instructions = $_SESSION['instructions'];
                            } else {
                                $instructions = '';
                            } ?>
                            <input type="text" placeholder="Add Instructions" name="instructions" id="instructions" value="<?php echo $instructions; ?>" />
                        </div>
                    </div>

                    <div class="cart-box" style="height: auto;">
                        <div class="col-lg-12">
                            <p class="mb-10"><span class="font-lg">Have A Promo Code?</p>
                            <form action="#">
                                <div class="d-flex justify-content-between">
                                    <?php if (isset($_SESSION['promo_code']) && !empty($_SESSION['promo_code'])) {
                                        $promocode = $_SESSION['promo_code'][0]->promo_code;
                                    } ?>
                                    <input class="font-medium mr-15 coupon" name="Coupon" id="coupon" placeholder="Promo Code" value="<?php echo isset($promocode) ? $promocode : ''; ?>" style="width: 70%;">
                                    <button class="btn" id="apply-promo" style="width: 30%;">Apply</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="border cart-totals">
                        <div class="d-flex align-items-end justify-content-between mb-30">
                            <h6>Order Summary</h6>
                        </div>
                        <div class="table-responsive order_table checkout">
                            <table class="table no-border">
                                <tbody>
                                    <?php if (!empty($Cart_Data)) {
                                        foreach ($Cart_Data as $value) { ?>
                                            <tr>
                                                <td class="image product-thumbnail" width="50%">
                                                    <img src="<?= IMAGE_URL . get_product_image($value->product_id); ?>" alt="<?= get_product_name($value->product_id); ?>">
                                                    <h6 class="w-160 mb-5"><a href="<?= base_url('product-detail/' . encryptor($value->product_id)); ?>" class="text-heading"><?= get_product_name($value->product_id); ?></a></h6></span>
                                                </td>
                                                <td width="20%">
                                                    <h6 class="text-muted">x <?php echo $value->quantity; ?></h6>
                                                </td>
                                                <td width="30%">
                                                    <h4 class="text-brand">₹<?php $price = get_product_discounted_price($value->product_varient) !== "0" ? get_product_discounted_price($value->product_varient) : get_product_price($value->product_varient);
                                                                            $total = $price * $value->quantity;
                                                                            echo number_format((float)$total, 2, '.', ''); ?></h4>
                                                </td>
                                            </tr>
                                    <?php }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
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
                                        if (!empty($Cart_Data)) {
                                            foreach ($Cart_Data as $val) {
                                                $price = get_product_discounted_price($val->product_varient) !== "0" ? get_product_discounted_price($val->product_varient) : get_product_price($val->product_varient);
                                                $total = $price * $val->quantity;
                                                $final_subtotal = $final_subtotal + $total;
                                            }
                                        }

                                        $tax = $Settings['tax'];
                                        $total_tax = $final_subtotal * $tax / 100;
                                        $tax_total = $final_subtotal + $total_tax;
                                        $delivery_charges = $Settings['delivery_charge'];
                                        $min_amount = $Settings['min_amount'];
                                        if ($tax_total < $min_amount) {
                                            $final_total = $final_total + $tax_total + $delivery_charges;
                                            $delivery = "₹" . number_format((float)$delivery_charges, 2, '.', '');
                                            $delivery_c = $delivery_charges;
                                        } else {
                                            $final_total = $final_total + $tax_total;
                                            $delivery = 'Free';
                                            $delivery_c = 0;
                                        } ?>

                                        <td class="cart_total_amount">
                                            <h4 class="text-brand text-end">₹<?php echo number_format((float)$final_subtotal, 2, '.', ''); ?></h4>
                                            <input type="hidden" required="" id="final_subtotal" value="<?= $final_subtotal; ?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="cart_total_label">
                                            <h6 class="text-muted">Tax</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h5 class="text-heading text-end">₹<?php echo number_format((float)$total_tax, 2, '.', ''); ?></h4>
                                                <input type="hidden" required="" id="total_tax" value="<?= $total_tax; ?>" />
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="cart_total_label">
                                            <h6 class="text-muted">Delivery</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h5 class="text-heading text-end"><?php echo $delivery; ?></h4>
                                                <input type="hidden" required="" id="delivery_charge" value="<?= $delivery_c; ?>" />
                                        </td>
                                    </tr>

                                    <?php if (isset($_SESSION['promo_code']) && !empty($_SESSION['promo_code'])) {
                                        $dbs = db_connect();
                                        $querys = $dbs->query('SELECT * FROM orders WHERE user_id = "' . $_SESSION['user_login']['UserID'] . '" AND promo_code = "' . $_SESSION['promo_code'][0]->promo_code . '"');
                                        $result = $querys->getResultArray();
                                        $count_arr = count($result);
                                        if ($count_arr > 0 && $_SESSION['promo_code'][0]->repeat_usage == 0) {
                                            $discount_am = null;
                                        } else if ($count_arr > 0 && ($count_arr == 1) && ($_SESSION['promo_code'][0]->repeat_usage == 1)) {
                                            $discount_am = null;
                                        } else if ($count_arr == 0) {
                                            $promocode = $_SESSION['promo_code'][0]->promo_code;
                                            if ($_SESSION['promo_code'][0]->discount_type == "percentage" && $final_total > $_SESSION['promo_code'][0]->minimum_order_amount) {
                                                $discount_am = $final_total * $_SESSION['promo_code'][0]->discount / 100;
                                            } else if ($_SESSION['promo_code'][0]->discount_type == "amount" && $final_total > $_SESSION['promo_code'][0]->minimum_order_amount) {
                                                $discount_am = $_SESSION['promo_code'][0]->discount;
                                            } else {
                                                $discount_am = 0;
                                            }
                                        } ?>

                                        <tr>
                                            <?php
                                            if ($discount_am > 0) { ?>
                                                <td class="cart_total_label">
                                                    <h6 class="text-muted">Discount applied <br />(Code: <?php echo $promocode; ?>)</h6>
                                                    <input type="hidden" id="promocode" value="<?= $promocode; ?>" />
                                                </td>
                                                <td class="cart_total_amount">
                                                    <h5 class="text-heading text-end text-discount-red">-₹<?php echo $discount_am; ?></h4>
                                                        <input type="hidden" id="discount_am" value="<?= $discount_am; ?>" />
                                                </td>
                                            <?php } else if ($discount_am == null && $discount_am != 0) { ?>
                                                <td class="cart_total_label" colspan="2">
                                                    <h5 class="text-heading text-end text-discount-red">You can't apply Promo Code <?php echo $_SESSION['promo_code'][0]->promo_code; ?>. As its usage limit is over for you.</h4>
                                                        <input type="hidden" id="discount_am" value="0" />
                                                </td>
                                            <?php } else { ?>
                                                <td class="cart_total_label" colspan="2">
                                                    <h5 class="text-heading text-end text-discount-red">Discount can't be applied. Your subtotal should be minimum <?php echo $_SESSION['promo_code'][0]->minimum_order_amount; ?></h4>
                                                        <input type="hidden" id="discount_am" value="<?= $discount_am; ?>" />
                                                </td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
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
                                            <h4 class="text-brand text-end">₹<?php echo isset($discount_am) ? number_format((float)($final_total - $discount_am), 2, '.', '') : number_format((float)$final_total, 2, '.', ''); ?></h4>
                                            <input type="hidden" id="total" value="<?php echo isset($discount_am) ? number_format((float)($final_total - $discount_am), 2, '.', '') : number_format((float)$final_total, 2, '.', ''); ?>" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 mb-20 mt-20">

                    <div class="border cart-totals">

                        <div class="d-flex align-items-end justify-content-between mb-10 mt-30">

                            <h6>Select Delivery Day</h6>

                        </div>

                        <div class="table-responsive order_table checkout">
                            <div class="error-data-day"></div>
                            <div class="custome-radio">

                                <input class="form-check-input delivery_day" required type="radio" name="delivery_day" value="Today" id="today">

                                <label class="form-check-label" for="today" data-bs-toggle="collapse">Today</label>

                            </div>


                            <div class="custome-radio">

                                <input class="form-check-input delivery_day" required type="radio" name="delivery_day" value="Tomorrow" id="tomorrow">

                                <label class="form-check-label" for="tomorrow" data-bs-toggle="collapse">Tomorrow</label>

                            </div>

                        </div>

                        <div class="d-flex align-items-end justify-content-between mb-10 mt-30">

                            <h6>Delivery Time</h6>

                        </div>

                        <div class="table-responsive order_table checkout today_table" style="display: none;">
                            <div class="error-data-time"></div>
                            <?php
                            $db = db_connect();
                            $query = $db->query('SELECT * FROM time_slots WHERE status = 1 ORDER BY id ASC');
                            //you get result as an array in here but fetch your result however you feel to
                            $result = $query->getResultArray();
                            $t = time();
                            if ($result != "") {
                                foreach ($result as $time) { ?>
                                    <div class="custome-radio">

                                        <input class="form-check-input delivery_time" required="" type="radio" name="delivery_time" value="<?php echo $time['title']; ?>" id="today<?php echo $time['id']; ?>" <?php if (strtotime($time['from_time']) < $t) {
                                                                                                                                                                                                                    echo 'disabled';
                                                                                                                                                                                                                } ?>>

                                        <label class="form-check-label <?php if (strtotime($time['from_time']) < $t) {
                                                                            echo 'disabled';
                                                                        } ?>" for="today<?php echo $time['id']; ?>" data-bs-toggle="collapse"><?php echo $time['title']; ?></label>

                                    </div>
                            <?php }
                            }
                            ?>


                        </div>

                        <div class="table-responsive order_table checkout tomorrow_table" style="display: none;">
                            <div class="error-data-time"></div>
                            <?php
                            $db = db_connect();
                            $query = $db->query('SELECT * FROM time_slots WHERE status = 1 ORDER BY id ASC');
                            $result = $query->getResultArray();

                            if ($result != "") {
                                foreach ($result as $time) { ?>
                                    <div class="custome-radio">

                                        <input class="form-check-input delivery_time" required="" type="radio" name="delivery_time" value="<?php echo $time['title']; ?>" id="tomorrow<?php echo $time['id']; ?>">

                                        <label class="form-check-label" for="tomorrow<?php echo $time['id']; ?>" data-bs-toggle="collapse"><?php echo $time['title']; ?></label>

                                    </div>
                            <?php }
                            }
                            ?>


                        </div>

                        <div class="table-responsive order_table checkout every_table" style="display: block;">
                            <div class="error-data-time"></div>
                            <?php
                            $db = db_connect();
                            $query = $db->query('SELECT * FROM time_slots WHERE status = 1 ORDER BY id ASC');
                            $result = $query->getResultArray();

                            if ($result != "") {
                                foreach ($result as $time) { ?>
                                    <div class="custome-radio">

                                        <input class="form-check-input delivery_time" required="" type="radio" name="delivery_time" value="<?php echo $time['title']; ?>" id="every<?php echo $time['id']; ?>">

                                        <label class="form-check-label" for="every<?php echo $time['id']; ?>" data-bs-toggle="collapse"><?php echo $time['title']; ?></label>

                                    </div>
                            <?php }
                            }
                            ?>


                        </div>

                    </div>
                </div>

                <div class="col-lg-12 mb-20 mt-20">

                    <div class="border cart-totals">

                        <div class="d-flex align-items-end justify-content-between mb-30">

                            <h4 class="mb-30">Payment</h4>

                        </div>

                        <div class="payment_option">

                            <div class="custome-radio">

                                <input class="form-check-input payment_option" required="" type="radio" name="payment_option" value="cod" id="cash">

                                <label class="form-check-label" for="cash" data-bs-toggle="collapse" data-target="#checkPayment" aria-controls="checkPayment">Cash on delivery</label>

                            </div>

                            <div class="custome-radio">

                                <input class="form-check-input payment_option" required="" type="radio" name="payment_option" value="RazorPay" id="online">

                                <label class="form-check-label" for="online" data-bs-toggle="collapse" data-target="#RazorPay" aria-controls="RazorPay">Online Gateway(Razorpay)</label>

                            </div>

                        </div>

                        <div class="payment-logo d-flex">

                            <img class="mr-15" src="assets/imgs/theme/icons/razorpay.png" alt="">

                        </div>
                        <button type="submit" class="btn btn-fill-out btn-block mt-30 cashpay">Place an Order<i class="fi-rs-sign-out ml-15"></i></button>
                        <button type="submit" class="btn btn-fill-out btn-block mt-30 onlinepay" id="rzp-button1">Place an Order<i class="fi-rs-sign-out ml-15"></i></button>
                        <!--amount need to be in paisa-->


                        <!-- <a href="javascript:;" class="btn btn-fill-out btn-block mt-30 onlinepay razorpay-payment-button">Place an Order<i class="fi-rs-sign-out ml-15"></i></a> -->

                    </div>

                </div>
            </div>
        </div>

        </div>
    </main>

    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyARmvL9u4ku_1yV_GXhqbbK6TxRuLf9VV4"></script>-->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->
    <script type="text/javascript">
        // var map;
        // var marker;
        // var myLatlng = new google.maps.LatLng(<?php echo $user->latitude; ?>, <?php echo $user->longitude; ?>);
        // var geocoder = new google.maps.Geocoder();
        // var infowindow = new google.maps.InfoWindow();
        // function initialize() {
        //     var mapOptions = {
        //     zoom: 3,
        //     center: myLatlng,
        //     mapTypeId: google.maps.MapTypeId.ROADMAP
        //     };

        //     map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
        //     marker = new google.maps.Marker({
        //         map: map,
        //         position: myLatlng,
        //         draggable: true
        //     });

        //     google.maps.event.addListener(marker, 'dragend', function() {
        //         geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
        //             if (status == google.maps.GeocoderStatus.OK) {
        //                 if (results[0]) {
        //                     var address_components = results[0].address_components;
        //                     var components={};
        //                     jQuery.each(address_components, function(k,v1) {jQuery.each(v1.types, function(k2, v2){components[v2]=v1.long_name});});
        //                     $('#address').val(results[0].formatted_address);
        //                     if(components.postal_code) {
        //                         $('#pincode').val(components.postal_code);
        //                     }
        //                     $('#latitude').val(marker.getPosition().lat());
        //                     $('#longitude').val(marker.getPosition().lng());
        //                     infowindow.setContent(results[0].formatted_address);
        //                     infowindow.open(map, marker);
        //                 }
        //             }
        //         });
        //     });
        // }
        // google.maps.event.addDomListener(window, 'load', initialize);
    </script>

    <!-- Scripts Start -->
    <?php echo view('includes/scripts'); ?>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var isPaymentProcessing = false;
        var options = {
            "key": "rzp_live_sHnjBOB7LUtqZS",
            "amount": "<?php echo isset($discount_am) ? (float)($final_total - $discount_am) * 100 : (float)$final_total * 100; ?>",
            "currency": "INR",
            "description": "<?php echo "Final Amount"; ?>",
            "image": "<?php echo base_url('assets/imgs/theme/favicon.png'); ?>",
            config: {
                display: {
                    blocks: {
                        hdfc: {
                            name: "Pay using HDFC Bank",
                            instruments: [{
                                    method: "card",
                                    issuers: ["HDFC"]
                                },
                                {
                                    method: "netbanking",
                                    banks: ["HDFC"]
                                },
                            ]
                        },
                        other: {
                            name: "Other Payment modes",
                            instruments: [{
                                    method: "card"
                                },
                                {
                                    method: 'netbanking',
                                },
                                {
                                    method: "upi"
                                },
                                {
                                    method: "wallet"
                                }
                            ]
                        }
                    },
                    hide: [

                    ],
                    sequence: ["block.hdfc", "block.other"],
                    preferences: {
                        show_default_blocks: false // Should Checkout show its default blocks?
                    }
                }
            },
            "handler": function(response) {
                // CSRF Hash
                if (isPaymentProcessing) {
                    console.log("Payment already in progress or completed.");
                    return;
                }
                
                 isPaymentProcessing = true;
                $('#rzp-button1').prop('disabled', true); 
                
                var csrfName = $('.txt_csrfname').attr('name');
                var csrfHash = $('.txt_csrfname').val();
                var user_id = $('#user_id').val();
                var mobile = $('#phone').val();
                var total = $('#final_subtotal').val();
                var tax_charge = $('#total_tax').val();
                var delivery_charge = $('#delivery_charge').val();
                var discount_temp = 0;
                var discount = discount_temp ? discount_temp : 0;
                var final_total = $('#total').val();
                var payment_method = $('.payment_option:checked').val();
                var delivery_time = $('.delivery_day:checked').val() + ' - ' + $('.delivery_time:checked').val();
                var address = $('#address').val();
                var latitude = $('#latitude').val();
                var longitude = $('#longitude').val();
                var order_instructions = $('#instructions').val();
                var promo_code_temp = $('#promocode').val();
                var promo_code = $('#discount_am').val();


                $.ajax({
                    url: BASE_URL + '/AjaxController/do_place_order',
                    type: 'post',
                    data: {
                        payment_id: response.razorpay_payment_id,
                        user_id: user_id,
                        mobile: mobile,
                        total: total,
                        tax_charge: tax_charge,
                        delivery_charge: delivery_charge,
                        discount: discount,
                        final_total: final_total,
                        payment_method: payment_method,
                        address: address,
                        latitude: latitude,
                        longitude: longitude,
                        order_instructions: order_instructions,
                        promo_code_temp: promo_code_temp,
                        promo_code: promo_code,
                        delivery_time: delivery_time,
                        [csrfName]: csrfHash
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            $(".status-updated").text(result.message);
                            $(".alert2-success").show();
                            $('.loadingDiv').hide();
                            alert('Order placed successfully!');
                            window.location.href = '<?php echo base_url(); ?>';
                        } else {
                            $(".status-error").text(result.message);
                            $(".alert2-danger").show();
                            $('.loadingDiv').hide();
                            alert('Order placement failed. Please try again.');
                            $('#rzp-button1').prop('disabled', false);
                            isPaymentProcessing = false;
                        }

                        $('input[name="csrf_test_name"]').val(result.token);
                        $('.txt_csrfname').val(result.token);
                    },
                    error: function() {
                        alert('An error occurred. Please try again.');
                        $('#rzp-button1').prop('disabled', false);
                        isPaymentProcessing = false;
                }
                });

            },
            "modal": {
                "ondismiss": function() {
                    if (confirm("Are you sure, you want to close the form?")) {
                        txt = "You pressed OK!";
                        console.log("Checkout form closed by the user");
                    } else {
                        txt = "You pressed Cancel!";
                        console.log("Complete the Payment")
                    }
                }
            }
        };

        var rzp1 = new Razorpay(options);
        var iz_checked2 = false;
        var iz_checkedDelTime = false;
        $('#rzp-button1').on('click', function(e) {
            e.preventDefault();
            if (!iz_checkedDelTime) {
                $('.error-data-time').html('<p>Please select Time Slot for Delivery.</p>');
            }
            if (!iz_checked2) {
                $('.error-data-day').html('<p>Please select Day for Delivery.</p>');
            } else if (iz_checked2 && iz_checkedDelTime) {
                $('.error-data-time').html('');
                $('.error-data-day').html('');
                if (!isPaymentProcessing) {
                    rzp1.open();
                }
            }
        });
        $('.delivery_day').on('change', function() {
            if ($(this).is(':checked')) {
                iz_checked2 = true;
                $('.error-data-day').html('');
            }
        });
        $('.delivery_time').on('change', function() {
            if ($(this).is(':checked')) {
                iz_checkedDelTime = true;
                $('.error-data-time').html('');

            }
        });
    </script>

    <script type="text/javascript">
        $(document).on('click', '.cashpay', function(e) {
            e.preventDefault();
            //iz_checked2 = iz_checked2 && $('.delivery_day').is(':checked');
            if (!iz_checkedDelTime) {
                $('.error-data-time').html('<p>Please select Time Slot for Delivery.</p>');
            }
            if (!iz_checked2) {
                $('.error-data-day').html('<p>Please select Day for Delivery.</p>');
            } else if (iz_checked2 && iz_checkedDelTime) {
                $('.error-data-time').html('');
                $('.error-data-day').html('');
                var csrfName = $('.txt_csrfname').attr('name');
                var csrfHash = $('.txt_csrfname').val();
                var user_id = $('#user_id').val();
                var mobile = $('#phone').val();
                var total = $('#final_subtotal').val();
                var tax_charge = $('#total_tax').val();
                var delivery_charge = $('#delivery_charge').val();
                var discount_temp = 0;
                var discount = discount_temp ? discount_temp : 0;
                var final_total = $('#total').val();
                var payment_method = $('.payment_option:checked').val();
                var address = $('#address').val();
                var latitude = $('#latitude').val();
                var longitude = $('#longitude').val();
                var order_instructions = $('#instructions').val();
                var delivery_time = $('.delivery_day:checked').val() + ' - ' + $('.delivery_time:checked').val();
                var promo_code_temp = $('#promocode').val();
                var promo_code = $('#discount_am').val();

                $.ajax({
                    url: BASE_URL + '/AjaxController/do_place_order',
                    type: 'post',
                    data: {
                        user_id: user_id,
                        mobile: mobile,
                        total: total,
                        tax_charge: tax_charge,
                        delivery_charge: delivery_charge,
                        discount: discount,
                        final_total: final_total,
                        payment_method: payment_method,
                        address: address,
                        latitude: latitude,
                        longitude: longitude,
                        order_instructions: order_instructions,
                        promo_code_temp: promo_code_temp,
                        promo_code: promo_code,
                        delivery_time: delivery_time,
                        [csrfName]: csrfHash
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            $(".status-updated").text(result.message);
                            $(".alert2-success").show();
                            $('.loadingDiv').hide();
                            alert('Order placed!');
                            window.location.href = '<?php echo base_url(); ?>';
                        } else {
                            $(".status-error").text(result.message);
                            $(".alert2-danger").show();
                            $('.loadingDiv').hide();
                            alert('Order not placed!');
                        }

                        $('input[name="csrf_test_name"]').val(result.token);
                        $('.txt_csrfname').val(result.token);
                    }
                });
            }
        });

        $(document).on('change blur', '#instructions', function(e) {
            e.preventDefault();
            var instructions = $(this).val();
            var csrfName = $('.txt_csrfname').attr('name');
            var csrfHash = $('.txt_csrfname').val();
            $.ajax({
                url: BASE_URL + '/AjaxController/set_instructions_session',
                type: 'post',
                data: {
                    instructions: instructions,
                    [csrfName]: csrfHash
                },
                dataType: 'json',
                success: function(result) {
                    if (result.response == true) {
                        //$('.loadingDiv').hide();
                        //location.reload();           
                    } else {
                        // $('.loadingDiv').hide();
                        // $('.without-loggedin').text(result.message);  
                    }
                    $('input[name="csrf_test_name"]').val(result.token);
                    $('.txt_csrfname').val(result.token);
                }
            });
        });
    </script>
    <script type="text/javascript">
        $('body').on('change', '.delivery_day', function() {
            var dt = $('.delivery_day:checked').val();
            if (dt == "Today") {
                $('.today_table').show();
                $('.tomorrow_table').hide();
                $('.every_table').hide();
            } else if (dt == "Tomorrow") {
                $('.today_table').hide();
                $('.tomorrow_table').show();
                $('.every_table').hide();
            } else {
                $('.today_table').hide();
                $('.tomorrow_table').hide();
                $('.every_table').show();
            }
        });
    </script>
    <!-- Scripts End -->

</body>
</html>