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

                    Profile

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
                        <?php if(isset($_GET['status']) && $_GET['status'] == 'checkout'){?>              
                        <?= form_open('home/update_profile?status=checkout', ['class' => 'needs-validation profile_form', 'novalidate' => '', 'autocomplete' => 'off']); ?>
                        <?php } else { ?>
                        <?= form_open('home/update_profile', ['class' => 'needs-validation profile_form', 'novalidate' => '', 'autocomplete' => 'off']); ?>
                        <?php } ?>
                            <?php $user = get_user($_SESSION['user_login']['UserID']); ?> 
                            <input class="form-control" name="user_id" type="hidden" value="<?php echo $user->id;?>" />
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Name</label>
                                    <input class="form-control" name="name" type="text" value="<?php echo $user->name;?>" required />
                                </div>  
                                <div class="form-group col-md-12">
                                    <label>Email</label>
                                    <input class="form-control" name="email" type="email" value="<?php echo $user->email;?>" />
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Mobile</label>
                                    <input class="form-control" name="mobile" type="text" value="<?php echo $user->country_code.'-'.$user->mobile;?>" required disabled/>
                                </div>  
                                <div class="form-group col-md-12">
                                    <label>Select City</label>
                                    <select class="form-control" name="city">
                                        <?php if(!empty($cities)){ 
                                                foreach ($cities as $city) { ?>
                                                    <option value="<?php echo $city->id;?>" <?php echo isset($user->city) && $user->city == $city->id ? "selected" : "";?>><?php echo $city->name;?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Select Area</label>
                                    <select class="form-control" name="area">
                                        <?php if(!empty($areas)){ 
                                                foreach ($areas as $area) { ?>
                                                    <option value="<?php echo $area->id;?>" <?php echo isset($user->area) && $user->area == $area->id ? "selected" : "";?>><?php echo $area->name;?></option>
                                        <?php } } ?>
                                    </select>
                                </div>    
                                <div class="form-group col-md-12">
                                    <label>Address</label>
                                    <input class="form-control" name="street" id="street" type="text" value="<?php echo $user->street;?>" required />
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Pincode</label>
                                    <input class="form-control" name="pincode" id="pincode" type="text" value="<?php echo $user->pincode;?>" required />
                                </div> 

                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-fill-out submit font-weight-bold" name="submit" value="Submit">Update</button>
                                </div>

                                <div class="change_password_div">
                                    <a href="<?php echo base_url('changepassword');?>">Change Password?</a>
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