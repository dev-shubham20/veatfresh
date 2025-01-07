<!DOCTYPE html>

<html lang="en">



<!-- Header Start -->

<?php echo view('includes/header'); ?>

<!-- Header Start -->



<body>

    <main class="main pages">

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

                                            <h4 class="mb-5">Forgot Password</h4>

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

                                                <button type="button" class="btn btn-fill-out btn-block hover-up font-weight-bold" name="submit" onclick="submitPhoneNumberAuthForgot()">Submit</button>

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

                                            <?= form_open('home/do_reset_password', ['class' => 'needs-validation', 'novalidate' => '', 'autocomplete' => 'off']); ?>
                                                <div class="form-group">

                                                    <input type="tel" required="" name="phoneNumber" placeholder="Mobile Number" value="<?php if(isset($_SESSION['register_number'])){ echo $_SESSION['register_number'];} else {echo "";} ?>" readonly />

                                                </div>

                                                <div class="form-group">

                                                    <input required="" type="password" name="password" placeholder="New Password">

                                                </div>

                                                <div class="form-group">

                                                    <input required="" type="password" name="cpassword" placeholder="Confirm password">

                                                </div>  

                                                <div class="mb-30">
                                                    <?= form_submit('do_submit', 'Reset Password', ['class' => 'btn btn-fill-out btn-block hover-up font-weight-bold', 'tabindex' => '6']); ?>
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


</body>

</html>