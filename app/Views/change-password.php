<!DOCTYPE html>

<html lang="en">



<!-- Header Start -->

<?php echo view('includes/header'); ?>

<!-- Header Start -->



<body>

    <!--End header-->

    <main class="main pages">
        <div class="page-header breadcrumb-wrap cart-b">

            <div class="container">

                <div class="breadcrumb">

                    Change Password

                </div>

            </div>

        </div>
       
        <div class="page-content pt-30 pb-150">            
            <div class="container">             
                <div class="row">
                    <div class="col-lg-12 m-auto">  
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
                        <?= form_open('home/update_password', ['class' => 'needs-validation profile_form', 'novalidate' => '', 'autocomplete' => 'off']); ?>
                            <?php $user = get_user($_SESSION['user_login']['UserID']); ?> 
                            <input class="form-control" name="user_id" type="hidden" value="<?php echo $user->id;?>" />
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Old Password</label>
                                    <input class="form-control" name="old_password" type="password" value="" required />
                                </div>  
                                <div class="form-group col-md-12">
                                    <label>New Password</label>
                                    <input class="form-control" name="new_password" type="password" value="" required />
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Confirm Password</label>
                                    <input class="form-control" name="confirm_password" type="password" value="" required />
                                </div>  
                                
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-fill-out submit font-weight-bold" name="submit" value="Submit">Update Password</button>
                                </div>
                            </div>
                        <?= form_close(); ?>                      
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