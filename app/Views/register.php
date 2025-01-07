<!DOCTYPE html>

<html lang="en">



<!-- Header Start -->

<?php echo view('includes/header'); ?>

<!-- Header Start -->



<body>

    <main class="main pages">

        <!-- <div class="page-header breadcrumb-wrap">

            <div class="container">

                <div class="breadcrumb">

                    <a href="<?php //echo base_url();?>" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>

                    <span></span> Register

                </div>

            </div>

        </div>
 -->
        <div class="page-content pt-150 pb-150">

            <div class="container">

                <div class="row">

                    <div class="col-xl-12 col-lg-10 col-md-12 m-auto">

                        <div class="row">

                            <div class="col-lg-12 pr-30 d-lg-block text-center">

                                <a href="<?= base_url(); ?>"><img src="<?php echo base_url('assets/imgs/theme/logo.png'); ?>" alt="veatfresh" width="150"></a>

                                <!-- <img class="border-radius-15" src="<?php echo base_url('assets/imgs/page/login-1.png');?>" alt=""> -->

                            </div>

                            <div class="col-lg-12 col-md-12">

                                <div class="login_wrap widget-taber-content background-white">

                                    <div class="padding_eight_all bg-white text-center">

                                        <div class="heading_s1">

                                            <h4 class="mb-5">Create an Account</h4>

                                            <p class="mb-30">Already have an account? <a href="<?php echo base_url('login');?>">Login</a></p>

                                        </div>

                                        <?php if($session->has('success')){ ?>
                                            <div class="alert alert-success alert-dismissible show">
                                                <div class="alert-body">                                                    
                                                    <?= $session->getFlashdata('success'); ?>
                                                </div>
                                            </div>
                                        <?php }elseif ($session->has('error')) { ?>
                                            <div class="alert alert-danger alert-dismissible show">
                                                <div class="alert-body">                                                
                                                    <?= $session->getFlashdata('error'); ?>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <div class="firebase-phone-number-div" style="display: <?php if(!isset($_SESSION['register_number']) && !isset($_SESSION['register_code'])){ echo "block";} else {echo "none";} ?>">

                                            <div class="form-group">

                                                <input type="tel" required="" name="phoneNumber" id="phoneNumber" placeholder="Mobile Number" />
                                                <span class="error" id="errorPN"></span>

                                            </div>

                                            <div class="form-group">

                                                <div id="recaptcha-container"></div>

                                            </div>

                                            <div class="mb-30">

                                                <button type="button" class="btn btn-fill-out btn-block hover-up font-weight-bold" name="submit" onclick="submitPhoneNumberAuth()">Submit</button>

                                            </div>
                                            
                                        </div>


                                        <div class="firebase-code-div" style="display: <?php if(isset($_SESSION['register_number']) && !isset($_SESSION['register_code'])){ echo "block";} else {echo "none";} ?>">

                                            <div class="form-group">
                                                <label>Enter OTP(Verification Code)</label>
                                                <input type="text" required="" name="verification-code" id="vcode" placeholder="Verification Code">

                                            </div>

                                            <div class="mb-30">

                                                <button type="button" class="btn btn-fill-out btn-block hover-up font-weight-bold" name="submit" onclick="submitPhoneNumberAuthCode()">Submit</button>

                                            </div>
                                            
                                        </div>
                                        <?php //print_r($_SESSION); ?>
                                        <div class="full-registration" style="display: <?php if(isset($_SESSION['register_number']) && isset($_SESSION['register_code'])){ echo "block";} else {echo "none";} ?>">

                                            <?= form_open('home/do_register', ['class' => 'needs-validation', 'novalidate' => '', 'autocomplete' => 'off']); ?>

                                                <div class="form-group">

                                                    <input type="text" required="" name="name" placeholder="Name">

                                                </div>

                                                <div class="form-group">

                                                    <input type="email" name="email" placeholder="Email">

                                                </div>

                                                <div class="form-group">

                                                    <input type="tel" required="" name="phoneNumber" placeholder="Mobile Number" value="<?php if(isset($_SESSION['register_number'])){ echo $_SESSION['register_number'];} else {echo "";} ?>" readonly />

                                                </div>

                                                <div class="form-group">
                                                    
                                                     <select name="city" required>

                                                        <option>Select Your City</option>

                                                        <?php if(!empty($cities)){

                                                            $cnt = 1;

                                                            foreach ($cities as $key => $value) { ?> 

                                                                <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>

                                                        <?php }} ?>                                            

                                                    </select>

                                                </div>                                                

                                                <div class="form-group">

                                                    <input type="text" required="" name="address" id="address" placeholder="Address" />
                                                    <input type="hidden" required="" name="latitude" id="latitude" />
                                                    <input type="hidden" required="" name="longitude" id="longitude" />

                                                    <div id="map_canvas" style="width: 100%;height: 500px;margin: 20px 0px;"></div>

                                                </div>

                                                <div class="form-group">

                                                    <input type="text" required="" name="pincode" id="pincode" placeholder="Pincode">

                                                </div>

                                                <div class="form-group">

                                                    <input required="" type="password" name="password" placeholder="Password">

                                                </div>

                                                <div class="form-group">

                                                    <input required="" type="password" name="cpassword" placeholder="Confirm password">

                                                </div>  

                                                <div class="form-group">

                                                    <input type="text" name="referal_code" placeholder="Referral Code">
                                                    <input type="hidden" name="register_token" value="<?php if(isset($_SESSION['register_token'])){ echo $_SESSION['register_token'];} else {echo "";} ?>">

                                                </div>                                          

                                                <div class="login_footer form-group mb-50">

                                                    <div class="chek-form">

                                                        <div class="custome-checkbox">

                                                            <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox12" value="">

                                                            <label class="form-check-label" for="exampleCheckbox12"><span>I have read and agree to the terms &amp; Conditions.</span></label>

                                                        </div>

                                                    </div>

                                                    <a href="<?php echo base_url('terms-and-conditions');?>"><i class="fi-rs-book-alt mr-5 text-muted"></i>Lean more</a>

                                                </div>

                                                <div class="mb-30">
                                                    <?= form_submit('do_submit', 'Submit & Register', ['class' => 'btn btn-fill-out btn-block hover-up font-weight-bold', 'tabindex' => '6']); ?>
                                                </div>
                                            
                                            <?= form_close(); ?>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </main>


<?php //echo view('includes/footer'); ?>

    <!-- Scripts Start -->

<?php echo view('includes/scripts'); ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyARmvL9u4ku_1yV_GXhqbbK6TxRuLf9VV4"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript">
    var map;
    var marker;
    var myLatlng = new google.maps.LatLng(26.8467, 80.9462);
    var geocoder = new google.maps.Geocoder();
    var infowindow = new google.maps.InfoWindow();
    function initialize() {
        var mapOptions = {
        zoom: 3,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        
        map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
        marker = new google.maps.Marker({
            map: map,
            position: myLatlng,
            draggable: true
        });

        google.maps.event.addListener(marker, 'dragend', function() {
            geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        var address_components = results[0].address_components;
                        var components={};
                        jQuery.each(address_components, function(k,v1) {jQuery.each(v1.types, function(k2, v2){components[v2]=v1.long_name});});
                        
                        $('#address').val(results[0].formatted_address);
                        if(components.postal_code) {
                            $('#pincode').val(components.postal_code);
                        }
                        $('#latitude').val(marker.getPosition().lat());
                        $('#longitude').val(marker.getPosition().lng());
                        infowindow.setContent(results[0].formatted_address);
                        infowindow.open(map, marker);
                    }
                }
            });
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>
    <!-- Scripts End -->        

</body>

</html>