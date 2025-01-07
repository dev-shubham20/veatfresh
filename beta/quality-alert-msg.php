<?php
    // start session
    session_start();
    
    // set time for session timeout
    $currentTime = time() + 25200;
    $expired = 3600;
    
    // if session not set go to login page
    if (!isset($_SESSION['user'])) {
        header("location:index.php");
    }
    
    // if current time is more than session timeout back to login page
    if ($currentTime > $_SESSION['timeout']) {
        session_destroy();
        header("location:index.php");
    }
    
    // destroy previous session timeout and create new one
    unset($_SESSION['timeout']);
    $_SESSION['timeout'] = $currentTime + $expired;
    ?>
<?php include"header.php";?>
<html>
    <head>
        <title>Main Slider Images | <?=$settings['app_name']?> - Dashboard</title>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
            
            });
            function sendPushNotification(id) {
                var data = $('form#' + id).serialize();
                $('form#' + id).unbind('submit');
                $.ajax({
                    url: "send-message.php",
                    type: 'GET',
                    data: data,
                    beforeSend: function () {
            
                    },
                    success: function (data, textStatus, xhr) {
                        $('.txt_message').val("");
                    },
                    error: function (xhr, textStatus, errorThrown) {
            
                    }
                });
            
                return false;
            }
        </script>
        <style type="text/css">
            .container{
            width: 950px;
            margin: 0 auto;
            padding: 0;
            }
            h1{
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 24px;
            color: #777;
            }
            h1 .send_btn
            {
            background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#0096FF), to(#005DFF));
            background: -webkit-linear-gradient(0% 0%, 0% 100%, from(#0096FF), to(#005DFF));
            background: -moz-linear-gradient(center top, #0096FF, #005DFF);
            background: linear-gradient(#0096FF, #005DFF);
            text-shadow: 0 1px 0 rgba(0, 0, 0, 0.3);
            border-radius: 3px;
            color: #fff;
            padding: 3px;
            }
            div.clear{
            clear: both;
            }
            ul.devices{
            margin: 0;
            padding: 0;
            }
            ul.devices li{
            float: left;
            list-style: none;
            border: 1px solid #dedede;
            padding: 10px;
            margin: 0 15px 25px 0;
            border-radius: 3px;
            -webkit-box-shadow: 0 1px 5px rgba(0, 0, 0, 0.35);
            -moz-box-shadow: 0 1px 5px rgba(0, 0, 0, 0.35);
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.35);
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #555;
            width:100%;
            height:150px;
            background-color:#ffffff;
            }
            ul.devices li label, ul.devices li span{
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 12px;
            font-style: normal;
            font-variant: normal;
            font-weight: bold;
            color: #393939;
            display: block;
            float: left;
            }
            ul.devices li label{
            height: 25px;
            width: 50px;                
            }
            ul.devices li textarea{
            float: left;
            resize: none;
            }
            ul.devices li .send_btn{
            background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#0096FF), to(#005DFF));
            background: -webkit-linear-gradient(0% 0%, 0% 100%, from(#0096FF), to(#005DFF));
            background: -moz-linear-gradient(center top, #0096FF, #005DFF);
            background: linear-gradient(#0096FF, #005DFF);
            text-shadow: 0 1px 0 rgba(0, 0, 0, 0.3);
            border-radius: 7px;
            color: #fff;
            padding: 4px 24px;
            }
            a{text-decoration:none;color:rgb(245,134,52);}
        </style>
    </head>
    <body>
        <div class="content-wrapper">
        <section class="content-header">
            <h1>Quality and Alert message for home page</h1>
            <ol class="breadcrumb">
                <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
            </ol>
            <hr/>
        </section>
        <?php
            include_once('includes/functions.php');
            

            
          
            ?>
        <section class="content">
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add / Update Quality here</h3>
                        </div>
                        <form id="quality_form" method="post" action="api/quality-images.php" enctype="multipart/form-data">
                             <input type='hidden' name='add-image' id='add-image' value='1'/>
							 
							<div class="box-body">
                                <div class="form-group">
                                    <label for="image">Quality Image : <small> ( Recommended Size : 72 x 72 pixels )</small></label>
                                    <input type='file' name="image" id="image" /> 
                                </div>
								<div class="form-group">
                                    <label for="type">Quality Title :</label>
                                    <input type="text" class="form-control" name="quality_title" id="quality_title" required="">
                                </div>
								<div class="form-group">
                                    <label for="type">Quality Description :</label>
                                    <input type="text" class="form-control" name="quality_desc" id="quality_desc" required="">
                                </div>
                            </div>
                            <div class="box-footer">
                                <input type="submit" class="btn-primary btn" value="Upload"/>
                            </div>
							<input type="hidden" id="id_quality" name="id_quality" value="0"/>
                        </form>
                        <div id="result"></div>
                    </div>
                </div>
				<div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Quality Image List</h3>
                        </div>
                        <table id="notifications_table_quality" class="table table-hover" data-toggle="table" 
                            data-url="api/get-bootstrap-table-data.php?table=quality_data"
                            data-page-list="[5, 10, 20, 50, 100, 200]"
                            data-show-refresh="true" data-show-columns="true"
                            data-side-pagination="server" data-pagination="true"
                            data-search="true" data-trim-on-search="false"
                            data-sort-name="id_quality" data-sort-order="desc">
                            <thead>
                            <tr>
                                <th data-field="id" data-sortable="true">ID</th>
                                <th data-field="image">Image</th>
                                <th data-field="title">Title</th>
                                <th data-field="description">Description</th>
                                <th data-field="operate">Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
			
			<div class="row">
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add / Update Alert here</h3>
                        </div>
                        <form id="alert_form" method="post" action="api/quality-images.php" enctype="multipart/form-data">
                             <input type='hidden' name='add-image-alert' id='add-image-alert' value='1'/>
							 
							<div class="box-body">
                                <div class="form-group">
                                    <label for="image">Alert Image : <small> ( Recommended Size : 72 x 72 pixels )</small></label>
                                    <input type='file' name="alert_image" id="alert_image" /> 
                                </div>
								<div class="form-group">
                                    <label for="type">Alert image Link (If any) :</label>
                                    <input type="text" class="form-control" name="link" id="link" required="">
                                </div>
								<div class="form-group">
                                    <label for="type">Alert Message :</label>
                                    <input type="text" class="form-control" name="message" id="message" required="">
                                </div>
                            </div>
                            <div class="box-footer">
                                <input type="submit" class="btn-primary btn" value="Upload"/>
                            </div>
							<input type="hidden" id="id_alert" name="id_alert" value="0"/>
                        </form>
                        <div id="result_alert"></div>
                    </div>
                </div>
				<div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Alert List</h3>
                        </div>
                        <table id="notifications_table_alert" class="table table-hover" data-toggle="table" 
                            data-url="api/get-bootstrap-table-data.php?table=alert_data"
                            data-page-list="[5, 10, 20, 50, 100, 200]"
                            data-show-refresh="true" data-show-columns="true"
                            data-side-pagination="server" data-pagination="true"
                            data-search="true" data-trim-on-search="false"
                            data-sort-name="id_alert" data-sort-order="desc">
                            <thead>
                            <tr>
                                <th data-field="id" data-sortable="true">ID</th>
                                <th data-field="image">Image</th>
                                <th data-field="link">Link</th>
                                <th data-field="message">Message</th>
                                <th data-field="operate">Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
			
        </section>
    </div>
    <script>
		$('#quality_form').on('submit',function(e){
        e.preventDefault();
        var formData = new FormData(this);
            $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            dataType:'json',
            //beforeSend:{},
            cache:false,
            contentType: false,
            processData: false,
            success:function(result){
                $('#result').html(result.message);
                $('#result').show().delay(6000).fadeOut();
                //$('#add-image').val('');
                $( '#quality_form' ).each(function(){
                this.reset();
                });
                $('#id_quality').val('0');
                $('#notifications_table_quality').bootstrapTable('refresh');
            }
            });
        
		}); 
		$(document).on('click', '.edit-quality', function(){
			var title = $(this).data('title');
			var desc = $(this).data('desc');
			var id = $(this).data('id');
			
			$('#id_quality').val(id);
			$('#quality_title').val(title);
			$('#quality_desc').val(desc);
		});
		
		$(document).on('click','.delete-quality',function(){
        if(confirm('Are you sure?')){
            id = $(this).data("id");
            image = $(this).data("image");
            $.ajax({
                url : 'api/quality-images.php',
                type: "get",
                data: 'id='+id+'&image='+image+'&type=delete-quality',
                success: function(result){
                    if(result==1){
                        $('#notifications_table_quality').bootstrapTable('refresh');
                    }else
                        alert('Error! Notification could not be deleted');
                }
            });
        }
    });
	
	
	$('#alert_form').on('submit',function(e){
        e.preventDefault();
        var formData = new FormData(this);
            $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            dataType:'json',
            //beforeSend:{},
            cache:false,
            contentType: false,
            processData: false,
            success:function(result){
                $('#result_alert').html(result.message);
                $('#result_alert').show().delay(6000).fadeOut();
                //$('#add-image').val('');
                $( '#alert_form' ).each(function(){
                this.reset();
                });
                $('#id_alert').val('0');
                $('#notifications_table_alert').bootstrapTable('refresh');
            }
            });
        
		}); 
		$(document).on('click', '.edit-alert', function(){
			var link = $(this).data('link');
			var message = $(this).data('message');
			var id = $(this).data('id');
			
			$('#id_alert').val(id);
			$('#link').val(link);
			$('#message').val(message);
		});
		
		$(document).on('click','.delete-alert',function(){
        if(confirm('Are you sure?')){
            id = $(this).data("id");
            image = $(this).data("image");
            $.ajax({
                url : 'api/quality-images.php',
                type: "get",
                data: 'id='+id+'&image='+image+'&type=delete-alert',
                success: function(result){
                    if(result==1){
                        $('#notifications_table_alert').bootstrapTable('refresh');
                    }else
                        alert('Error! Notification could not be deleted');
                }
            });
        }
    });
		
    </script>
</body>
</html>
<?php include"footer.php"; ?>