

        <div class="page-header breadcrumb-wrap">

            <div class="container">

                <div class="breadcrumb">

                    <a href="<?php echo base_url();?>" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    
                    <span></span> FAQ

                </div>

            </div>

        </div>

        <div class="page-content pt-50">

            <div class="container">

                <div class="row">

                    <div class="col-xl-10 col-lg-12 m-auto">

                        <div class="row">

                            <div class="col-lg-12">

                                <div class="single-page pr-30 mb-lg-0 mb-sm-5">

                                    <div class="single-header  style-2">

                                        <h5>FAQs </h5>

                                    </div>

                                    <div class="single-content mb-50">

                                        <?php if(!empty($faqs)){
                                            foreach ($faqs as $faq) { ?>
                                           <div class="faq-div">
                                                <div class="faq-question">
                                                    <p><?php echo $faq->question;?></p>
                                                </div>
                                                <div class="faq-answer">
                                                    <p><?php echo $faq->answer;?></p>
                                                </div>
                                           </div>     
                                        <?php } }?>

                                    </div>

                                </div>

                            </div>

                            

                        </div>

                    </div>

                </div>

            </div>

        </div>