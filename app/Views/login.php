<!DOCTYPE html>

<html lang="en">



<!-- Header Start -->

<?php echo view('includes/header'); ?>

<!-- Header Start -->



<body>

    <!--End header-->

    <main class="main pages">

        <!-- <div class="page-header breadcrumb-wrap">

            <div class="container">

                <div class="breadcrumb">

                    <a href="<?php echo base_url();?>" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>

                    <span></span> Login

                </div>

            </div>

        </div> -->

        <div class="page-content pt-150 pb-150">

            <div class="container">

                <div class="row">

                    <div class="col-xl-6 col-lg-10 col-md-12 m-auto">

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

                        <div class="row">

                            <div class="col-lg-12 pr-30 d-lg-block text-center">

                                <a href="<?= base_url(); ?>"><img src="<?php echo base_url('assets/imgs/theme/logo.png'); ?>" alt="veatfresh" width="150"></a>

                                <!-- <img class="border-radius-15" src="<?php echo base_url('assets/imgs/page/login-1.png');?>" alt=""> -->

                            </div>

                            <div class="col-lg-12 col-md-12">

                                <div class="login_wrap widget-taber-content background-white">

                                    <div class="padding_eight_all bg-white text-center">

                                        <div class="heading_s1">

                                            <h4 class="mb-5">Login</h4>

                                            <p class="mb-30">Don't have an account? <a href="<?php echo base_url('register');?>">Create here</a></p>

                                        </div>

                                        <?= form_open('home/do_login', ['class' => 'needs-validation', 'novalidate' => '', 'autocomplete' => 'off']); ?>

                                            <div class="form-group">

                                                <input type="tel" required="" name="phonenumber" id="phoneNumber" placeholder="Phone Number *"/>

                                            </div> 

                                            <div class="form-group">

                                                <input type="password" required="" name="password" placeholder="********" />

                                            </div>                                                                                        

                                            <div class="login_footer form-group mb-20 text-center">                                                

                                                <a class="text-muted" href="<?php echo base_url('forgot-password');?>">Forgot password?</a>

                                            </div>

                                            <div class="mb-30">

                                                <?= form_submit('do_submit', 'Login', ['class' => 'btn btn-fill-out btn-block hover-up font-weight-bold', 'tabindex' => '6']); ?>

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

    </main>

<?php //echo view('includes/footer'); ?>

    <!-- Scripts Start -->

<?php echo view('includes/scripts'); ?>

    <!-- Scripts End -->        

</body>

</html>