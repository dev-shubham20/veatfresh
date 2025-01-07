<script>

    var BASE_URL = '<?= base_url('/'); ?>';

</script>

<input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">


<div class="loadingDiv" style="display:none;">
    <img src="<?= base_url('assets/imgs/loading.gif'); ?>" alt="loader" />
</div>

<!-- Preloader Start -->
<!-- 
    <div id="preloader-active">

        <div class="preloader d-flex align-items-center justify-content-center">

            <div class="preloader-inner position-relative">

                <div class="text-center">

                    <img src="<?= base_url('assets/imgs/theme/loading.gif'); ?>" alt="">

                </div>

            </div>

        </div>

    </div> -->

    <!-- Vendor JS-->

    <script src="<?= base_url('assets/js/vendor/modernizr-3.6.0.min.js'); ?>"></script>

    <script src="<?= base_url('assets/js/vendor/jquery-3.6.0.min.js'); ?>"></script>

    <script src="<?= base_url('assets/js/vendor/jquery-migrate-3.3.0.min.js'); ?>"></script>

    <script src="<?= base_url('assets/js/vendor/bootstrap.bundle.min.js'); ?>"></script>

    <script src="<?= base_url('assets/js/plugins/slick.js'); ?>"></script>

    <script src="<?= base_url('assets/js/plugins/jquery.syotimer.min.js'); ?>"></script>

    <script src="<?= base_url('assets/css/plugins/owl-carousel/owl.carousel.js'); ?>"></script>

    <script src="<?= base_url('assets/js/plugins/wow.js'); ?>"></script>

    <script src="<?= base_url('assets/js/plugins/jquery-ui.js'); ?>"></script>

    <script src="<?= base_url('assets/js/plugins/perfect-scrollbar.js'); ?>"></script>

    <script src="<?= base_url('assets/js/plugins/magnific-popup.js'); ?>"></script>

    <script src="<?= base_url('assets/js/plugins/select2.min.js'); ?>"></script>

    <script src="<?= base_url('assets/js/plugins/waypoints.js'); ?>"></script>

    <script src="<?= base_url('assets/js/plugins/counterup.js'); ?>"></script>

    <script src="<?= base_url('assets/js/plugins/jquery.countdown.min.js'); ?>"></script>

    <script src="<?= base_url('assets/js/plugins/images-loaded.js'); ?>"></script>

    <script src="<?= base_url('assets/js/plugins/isotope.js'); ?>"></script>

    <script src="<?= base_url('assets/js/plugins/scrollup.js'); ?>"></script>

    <script src="<?= base_url('assets/js/plugins/jquery.vticker-min.js'); ?>"></script>

    <script src="<?= base_url('assets/js/plugins/jquery.theia.sticky.js'); ?>"></script>

    <script src="<?= base_url('assets/js/plugins/jquery.elevatezoom.js'); ?>"></script>

    <!-- Template  JS -->

    <script src="<?= base_url('assets/js/main.js'); ?>"></script>
    <script src="<?= base_url('assets/js/shop.js'); ?>"></script>

    <script src="https://www.gstatic.com/firebasejs/6.3.3/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/6.3.3/firebase-auth.js"></script>   
    <script type="text/javascript">
    var url = window.location.href; 
    //alert(url);
    var firebaseConfig = {
                    apiKey: "AIzaSyARmvL9u4ku_1yV_GXhqbbK6TxRuLf9VV4",
                    authDomain: "veatfresh.firebaseapp.com",
                    databaseURL: "https://veatfresh.firebaseio.com",
                    projectId: "veatfresh",
                    storageBucket: "veatfresh.appspot.com",
                    messagingSenderId: "916684734406",
                    appId: "1:916684734406:web:d462fc6907fcdf5a2e7cc7",
                    measurementId: "G-15XYF3DH3E"
      };
              
      firebase.initializeApp(firebaseConfig);
      window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier(
        "recaptcha-container",
        {
          size: "invisible",
          callback: function(response) {
            if(url == "https://veatfresh.in/forgot-password"){
              submitPhoneNumberAuthForgot();
            }else{
              submitPhoneNumberAuth();
            }            
          }
        }
      );

      // window.recaptchaVerifiers = new firebase.auth.RecaptchaVerifier(
      //   "recaptcha-containers",
      //   {
      //     size: "invisible",
      //     callback: function(response) {
      //       submitPhoneNumberAuthForgot();
      //     }
      //   }
      // );
              
    function submitPhoneNumberAuth() {
                var phoneNumber = document.getElementById("phoneNumber").value;
                var phoneno = /^\d{10}$/;
                if(phoneNumber == ""){            
                    $('#errorPN').text('Please enter phone number.');
                    $('#phoneNumber').addClass('error-control');
                    return false;
                }

                if(!phoneNumber.match(phoneno)){            
                    $('#errorPN').text('Please enter valid phone number.');
                    $('#phoneNumber').addClass('error-control');
                    return false;
                }
                var csrfName = $('.txt_csrfname').attr('name');
                var csrfHash = $('.txt_csrfname').val();
                $('#errorPN').text('');
                $('#phoneNumber').removeClass('error-control');

                $.ajax({  
                  url: BASE_URL + '/AjaxController/check_phone_is_available',  
                  type: 'post',
                  async: false,
                  data: {phoneNumber: phoneNumber, [csrfName]: csrfHash },
                  dataType: 'json',
                    success:function(result){  
                      $('input[name="csrf_test_name"]').val(result.token);
                      $('.txt_csrfname').val(result.token);  
                      if (result.response == true) {
                        $('#errorPN').text('');
                        $('#phoneNumber').removeClass('error-control');
                        submitPhoneNumberAndCheck(phoneNumber);
                      } else {
                        $('#errorPN').text(result.message);
                        $('#phoneNumber').addClass('error-control');                        
                      }                                             
                    }  
                });  
               
                
              
  }

  function submitPhoneNumberAuthForgot() {
                var phoneNumber = document.getElementById("phoneNumber").value;
                var phoneno = /^\d{10}$/;
                if(phoneNumber == ""){            
                    $('#errorPN').text('Please enter phone number.');
                    $('#phoneNumber').addClass('error-control');
                    return false;
                }

                if(!phoneNumber.match(phoneno)){            
                    $('#errorPN').text('Please enter valid phone number.');
                    $('#phoneNumber').addClass('error-control');
                    return false;
                }
                var csrfName = $('.txt_csrfname').attr('name');
                var csrfHash = $('.txt_csrfname').val();
                $('#errorPN').text('');
                $('#phoneNumber').removeClass('error-control');

                $.ajax({  
                  url: BASE_URL + '/AjaxController/check_phone_is_available_forgot',  
                  type: 'post',
                  async: false,
                  data: {phoneNumber: phoneNumber, [csrfName]: csrfHash },
                  dataType: 'json',
                    success:function(result){  
                      $('input[name="csrf_test_name"]').val(result.token);
                      $('.txt_csrfname').val(result.token);  
                      if (result.response == true) {
                       // $('#errorPN').text('');
                        $('#phoneNumber').removeClass('error-control');
                        submitPhoneNumberAndCheck(phoneNumber);
                      } else {
                        $('#errorPN').text(result.message);
                        $('#phoneNumber').addClass('error-control');                        
                      }                                             
                    }  
                });  
               
                
              
  }

  function submitPhoneNumberAndCheck(phoneNumber) {
    var csrfName = $('.txt_csrfname').attr('name');
    var csrfHash = $('.txt_csrfname').val();
    var appVerifier = window.recaptchaVerifier;
      firebase
      .auth()
      .signInWithPhoneNumber("+91"+phoneNumber, appVerifier)
      .then(function(confirmationResult) {
        window.confirmationResult = confirmationResult;
        console.log(confirmationResult);                                
        $.ajax({  
          url: BASE_URL + '/AjaxController/set_phone_session',  
          type: 'post',
          data: {phoneNumber: "+91"+phoneNumber, [csrfName]: csrfHash },
          dataType: 'json',
          success:function(result){  
            if (result.response == true) {
              $('.loadingDiv').hide();
              $('.firebase-phone-number-div').hide();
              $('.firebase-code-div').show();
            } else {
              $('.loadingDiv').hide();
            }
            $('input[name="csrf_test_name"]').val(result.token);
            $('.txt_csrfname').val(result.token);                          
          }  
        });  
      })
      .catch(function(error) {
        console.log(error);
      });   
  }

            
  function submitPhoneNumberAuthCode() {
                var code = document.getElementById("vcode").value;
                confirmationResult
                  .confirm(code)
                  .then(function(result) {
                    var user = result.user;
                    console.log(user);
                    if(user){     
                        var csrfName = $('.txt_csrfname').attr('name');
                        var csrfHash = $('.txt_csrfname').val();
                        var phoneNumber = user.phoneNumber;
                        user.getIdToken().then(function(idToken) {                          
                          $.ajax({  
                            url: BASE_URL + '/AjaxController/set_phone_code',  
                            type: 'post',
                            data: {code: code, token: idToken, phoneNumber: phoneNumber, [csrfName]: csrfHash },
                            dataType: 'json',
                            success:function(result){  
                              if (result.response == true) {
                                $('.loadingDiv').hide();
                                window.location.reload();
                              } else {
                                $('.loadingDiv').hide();
                              }
                              $('input[name="csrf_test_name"]').val(result.token);
                              $('.txt_csrfname').val(result.token);                          
                            }  
                          }); 
                        });                   
                         
                    }
                  })
                  .catch(function(error) {
                    console.log(error);
                  });
  }

    </script>

<script type="text/javascript">
    $(document).on('change', '#weight', function(){  
        alert('fbf')
      var varient_id = $(this).val();
      $('.loadingDiv').show();

      // CSRF Hash
      var csrfName = $('.txt_csrfname').attr('name');
      var csrfHash = $('.txt_csrfname').val();
      $.ajax({  
        url: BASE_URL + '/AjaxController/get_product_varient_data',  
        type: 'post',
        data: {varient_id: varient_id, [csrfName]: csrfHash },
        dataType: 'json',
        success:function(result){  
          if (result.response == true) {
            $('.loadingDiv').hide();
            if(result.data.no_of_pieces == ""){
                $('.noofpieces').text("N/A");
            }else{
                $('.noofpieces').text(result.data.no_of_pieces);
            }
            if(result.data.no_of_persons == ""){
                $('.noofserves').text("N/A");
            }else{
                $('.noofserves').text(result.data.no_of_persons);
            }
            
            $('.gross').text(result.data.gross_weight);
            $('.net').text(result.data.measurement);
            if(result.data.discounted_price != "0"){
                $('.current-price').text("₹"+result.data.discounted_price);
                $('.old-price').text("₹"+result.data.price);
            }else{
                $('.current-price').text("₹"+result.data.price);
            }
            
            // console.log(result.data)
          } else {
            $('.loadingDiv').hide();
          }
          $('input[name="csrf_test_name"]').val(result.token);
          $('.txt_csrfname').val(result.token);                          
        }  
      });  
            
  });  
  
$(document).on('click', '.button-add-to-cart', function(){  
      var product_id = $('#product_id').val();
      var varient_id = $('#weight').find(":selected").val();
    //   var varient_id = $('#weight_1').find(":selected").val();
      var quantity = $('#qty').text();
      var user_id = $('#user_id').val();
      $('.loadingDiv').show();
      if(user_id == ""){
        $('.loadingDiv').hide();
        $('.without-loggedin').text('Please login first to buy this item.');
        setTimeout(() => {
            window.location.href = BASE_URL + '/login';
        }, 3000);
      }else{
          // CSRF Hash
          var csrfName = $('.txt_csrfname').attr('name');
          var csrfHash = $('.txt_csrfname').val();
          $.ajax({  
            url: BASE_URL + '/AjaxController/add_to_cart',  
            type: 'post',
            data: {varient_id: varient_id, user_id: user_id, product_id: product_id, quantity: quantity,[csrfName]: csrfHash },
            dataType: 'json',
            success:function(result){  
              if (result.response == true) {
                $('.loadingDiv').hide();
                $('.without-loggedin').text('Added to cart.');                
              } else {
                $('.loadingDiv').hide();
                $('.without-loggedin').text(result.message);                
              }
              $('input[name="csrf_test_name"]').val(result.token);
              $('.txt_csrfname').val(result.token);                          
            }  
          });  
      }     
});

$(document).on('click', '.remove-from-cart', function(e){
    e.preventDefault();  
    var cart_id = $(this).attr('id');
    $('.loadingDiv').show();
    var cart_total_no = $('#cart_total_no span').text();

        
    var csrfName = $('.txt_csrfname').attr('name');
    var csrfHash = $('.txt_csrfname').val();
    $.ajax({  
        url: BASE_URL + '/AjaxController/remove_from_cart',  
        type: 'post',
        data: {cart_id: cart_id, [csrfName]: csrfHash },
        dataType: 'json',
        success:function(result){  
              if (result.response == true) {
                $('#cart_total_no span').text(cart_total_no-1);
                $('#row_tr_'+cart_id).remove();;
                $('.loadingDiv').hide();
                location.reload();           
              } else {
                $('.loadingDiv').hide();
                $('.without-loggedin').text(result.message);                
              }
              $('input[name="csrf_test_name"]').val(result.token);
              $('.txt_csrfname').val(result.token);                          
        }  
    });  
         
});  

$(document).on('click', '.update_cart', function(e){
    e.preventDefault();  
    var arr = [];
    $(".qty-val").map(function() {
        arr.push({
            cart_id: $(this).attr('id'), 
            quantity:  $(this).val()
        });
    });

    $('.loadingDiv').show();
        
    var csrfName = $('.txt_csrfname').attr('name');
    var csrfHash = $('.txt_csrfname').val();
    $.ajax({  
        url: BASE_URL + '/AjaxController/update_cart',  
        type: 'post',
        data: {carts: arr, [csrfName]: csrfHash },
        dataType: 'json',
        success:function(result){  
              if (result.response == true) {
                $('.loadingDiv').hide();
                //location.reload();           
              } else {
                $('.loadingDiv').hide();
                $('.without-loggedin').text(result.message);                
              }
              $('input[name="csrf_test_name"]').val(result.token);
              $('.txt_csrfname').val(result.token);                          
        }  
    });  
         
});  


$(document).on('click', '.decrease-btn', function(e){
    e.preventDefault();  
    // var arr = [];
    // $(".qty-val").map(function() {
    //     arr.push({
    //         cart_id: $(this).attr('id'), 
    //         quantity:  $(this).val()
    //     });
    // });
    var cart_id = $(this).attr('id');
    var quantity = $(this).next('.qty-val').val();
    var cart_total_no = $('#cart_total_no span').text();
    $('.loadingDiv').show();
        
    var csrfName = $('.txt_csrfname').attr('name');
    var csrfHash = $('.txt_csrfname').val();

    if(quantity == 0){
      $.ajax({  
        url: BASE_URL + '/AjaxController/remove_from_cart',  
        type: 'post',
        data: {cart_id: cart_id, [csrfName]: csrfHash },
        dataType: 'json',
        success:function(result){  
              if (result.response == true) {
                $('#cart_total_no span').text(cart_total_no-1);
                $('#row_tr_'+cart_id).remove();
                $('.loadingDiv').hide();
                location.reload();           
              } else {
                $('.loadingDiv').hide();
                $('.without-loggedin').text(result.message);                
              }
              $('input[name="csrf_test_name"]').val(result.token);
              $('.txt_csrfname').val(result.token);                          
        }  
      });
    }else{
      $.ajax({  
          url: BASE_URL + '/AjaxController/update_cart_decrease',  
          type: 'post',
          data: {cart_id: cart_id, quantity: quantity, [csrfName]: csrfHash },
          dataType: 'json',
          success:function(result){  
                if (result.response == true) {
                  $('.loadingDiv').hide();
                  $('#final_price_'+cart_id+' span').text('₹'+result.final_price); 
                  $('#subtotal').text('₹'+result.final_subtotal);
                  $('#final_total').text('₹'+result.final_total); 
                  //location.reload();           
                } else {
                  $('.loadingDiv').hide();
                  $('.without-loggedin').text(result.message);                
                }
                $('input[name="csrf_test_name"]').val(result.token);
                $('.txt_csrfname').val(result.token);                          
          }  
      });  
    }
         
});  

$(document).on('click', '.increase-btn', function(e){
    e.preventDefault();  
    // var arr = [];
    // $(".qty-val").map(function() {
    //     arr.push({
    //         cart_id: $(this).attr('id'), 
    //         quantity:  $(this).val()
    //     });
    // });
    var cart_id = $(this).attr('id');
    var quantity = $(this).prev('.qty-val').val();
    $('.loadingDiv').show();
        
    var csrfName = $('.txt_csrfname').attr('name');
    var csrfHash = $('.txt_csrfname').val();
    $.ajax({  
        url: BASE_URL + '/AjaxController/update_cart_increase',  
        type: 'post',
        data: {cart_id: cart_id, quantity: quantity, [csrfName]: csrfHash },
        dataType: 'json',
        success:function(result){  
              if (result.response == true) {
                $('.loadingDiv').hide();
                $('#final_price_'+cart_id+' span').text('₹'+result.final_price);
                $('#subtotal').text('₹'+result.final_subtotal);
                $('#final_total').text('₹'+result.final_total); 
                //location.reload();           
              } else {
                $('.loadingDiv').hide();
                $('.without-loggedin').text(result.message);                
              }
              $('input[name="csrf_test_name"]').val(result.token);
              $('.txt_csrfname').val(result.token);                          
        }  
    });  
         
});  

$(document).on('click', '#apply-promo', function(e){
    e.preventDefault();  
    var coupon = $('#coupon').val();
    $('.loadingDiv').show();
        
    var csrfName = $('.txt_csrfname').attr('name');
    var csrfHash = $('.txt_csrfname').val();
    $.ajax({  
        url: BASE_URL + '/AjaxController/set_promocode_session',  
        type: 'post',
        data: {coupon: coupon, [csrfName]: csrfHash },
        dataType: 'json',
        success:function(result){  
              if (result.response == true) {
                $('.loadingDiv').hide();
                location.reload();           
              } else {
                $('.loadingDiv').hide();
                $('.without-loggedin').text(result.message);                
              }
              $('input[name="csrf_test_name"]').val(result.token);
              $('.txt_csrfname').val(result.token);                          
        }  
    });  
         
});  

$(document).on('click', '.btn_cart_data', function(e){
    e.preventDefault();  
    var btn = $(this);
    var product_id = $(this).attr('id');
    var varient_id = $(this).next(".varient_id").val();
    var quantity = $(this).next().next(".quantity_start").val(); 
    var user_id = $(this).next().next().next(".user_id").val();
    $(this).next().next().next().next(".loading").show();      
   // $('.loading').show();  
          // CSRF Hash
    var csrfName = $('.txt_csrfname').attr('name');
    var csrfHash = $('.txt_csrfname').val();
    $.ajax({  
            url: BASE_URL + '/AjaxController/add_to_cart',  
            type: 'post',
            data: {varient_id: varient_id, user_id: user_id, product_id: product_id, quantity: quantity,[csrfName]: csrfHash },
            dataType: 'json',
            success:function(result){ 
              if (result.response == true) {
                $('.loading').hide();
                $('.mini-cart-icon span').text(result.cart_products); 
                btn.prev().children('.decrease-btn').attr('id',result.cart_id);
                btn.prev().children('.quantity').val(result.cart_id_quantity);
                btn.prev().children('.quantity').attr('id',result.cart_id);
                btn.prev().children('.increase-btn').attr('id',result.cart_id);
                btn.prev('.pl-mi').show();
                btn.hide();
                btn.text('Added To Cart');
                btn.css({'pointer-events': 'none', 'cursor': 'default','text-decoration':'none'});             
              } else {
                $('.loading').hide();
                $('.without-loggedin').text(result.message);                
              }
              $('input[name="csrf_test_name"]').val(result.token);
              $('.txt_csrfname').val(result.token);                          
            }  
    }); 
});

$(document).on('click', '.btncart_data', function(e){
    e.preventDefault();  
    var btn = $(this);
    var product_id = $('#product_id').val();
    var varient_id = $('#weight').val();
    // var varient_id = $('#weight').val();
    var quantity = $(".quantity_start").val(); 
    var user_id = $("#user_id").val();
    $(this).next().next().next().next(".loading").show();      
   // $('.loading').show();  
          // CSRF Hash
    var csrfName = $('.txt_csrfname').attr('name');
    var csrfHash = $('.txt_csrfname').val();
    $.ajax({  
            url: BASE_URL + '/AjaxController/add_to_cart',  
            type: 'post',
            data: {varient_id: varient_id, user_id: user_id, product_id: product_id, quantity: quantity,[csrfName]: csrfHash },
            dataType: 'json',
            success:function(result){ 
              if (result.response == true) {
                $('.loading').hide();
                $('.mini-cart-icon span').text(result.cart_products);                 
                btn.text('Added To Cart');
                btn.css({'pointer-events': 'none', 'cursor': 'default','text-decoration':'none'});             
              } else {
                $('.loading').hide();
                $('.without-loggedin').text(result.message);                
              }
              $('input[name="csrf_test_name"]').val(result.token);
              $('.txt_csrfname').val(result.token);                          
            }  
    }); 
});

$(document).on('change', '.payment_option', function(e){

    var mode = $('input[name="payment_option"]:checked').val();
    
    
    $('.cashpay').show();
    $('.onlinepay').hide();

    if(mode == "cash"){
        $('.cashpay').show();
        $('.onlinepay').hide();
    }else if(mode == "RazorPay"){
        $('.cashpay').hide();
        $('.onlinepay').show();
    }


    // CSRF Hash
    // var csrfName = $('.txt_csrfname').attr('name');
    // var csrfHash = $('.txt_csrfname').val();
    // $.ajax({  
    //         url: BASE_URL + '/AjaxController/add_to_cart',  
    //         type: 'post',
    //         data: {varient_id: varient_id, user_id: user_id, product_id: product_id, quantity: quantity,[csrfName]: csrfHash },
    //         dataType: 'json',
    //         success:function(result){  
    //             console.log(result);
    //           if (result.response == true) {
    //             $('.loadingDiv').hide();
    //             $('.mini-cart-icon span').text(result.cart_products);                
    //           } else {
    //             $('.loadingDiv').hide();
    //             $('.without-loggedin').text(result.message);                
    //           }
    //           $('input[name="csrf_test_name"]').val(result.token);
    //           $('.txt_csrfname').val(result.token);                          
    //         }  
    // }); 
});
</script>
<script type="text/javascript">
    /*For total*/
    $(document).ready(function() {  
      var buttonPlus = $('.ibtn');
      var buttonMin = $('.dbtn');     
      
      /*For plus and minus buttons*/
      buttonPlus.click(function() {
        var quantity = $(this).prev('.qty-val').val();
        $(this).prev('.qty-val').val(parseInt(quantity) + 1).trigger('input');
      });
      
      buttonMin.click(function() {
        var quantity = $(this).next('.qty-val').val();
        $(this).next('.qty-val').val(Math.max(parseInt(quantity) - 1, 0)).trigger('input');
      });
    })
</script>