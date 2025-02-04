<?php
include_once('includes/functions.php');
include_once('includes/custom-functions.php');
$function = new custom_functions;
$settings = $fn->get_configurations();
$currency = $fn->get_settings('currency');
?>

<?php
if (isset($_GET['id'])) {
    $ID = $_GET['id'];
} else {?>
    <script>
        window.location.href="invoices.php";
    </script>
    <?php
}
$sql_outer="SELECT oi.*,u.*,p.*,v.*,o.*,u.name as uname,d.name as delivery_boy,o.status as order_status,oi.active_status as order_item_status,p.name as pname,(SELECT short_code FROM unit un where un.id=v.measurement_unit_id)as mesurement_unit_name FROM `order_items` oi JOIN users u ON u.id=oi.user_id JOIN product_variant v ON oi.product_variant_id=v.id JOIN products p ON p.id=v.product_id JOIN orders o ON o.id=oi.order_id LEFT JOIN delivery_boys d ON o.delivery_boy_id=d.id WHERE o.id=".$ID;
    // Execute query
    $db->sql($sql_outer);
    // store result 
    $res_outer=$db->getResult();
    // print_r($res_outer);
      $items=[];
    foreach($res_outer as $row){
            $data=array($row['product_id'],$row['pname'],$row['quantity'],$row['measurement'],$row['mesurement_unit_name'],$row['discounted_price']*$row['quantity'],$row['discount'],$row['sub_total'],$row['order_item_status']);
            array_push($items, $data);
        }
         // print_r($items);
        $encoded_items=$db->escapeString(json_encode($items));
$id = $res_outer[0]['id'];
$sql = "SELECT COUNT(id) as total FROM `invoice` where order_id=".$id;
$db->sql($sql);
$res=$db->getResult();
$total=$res[0]['total'];
if ($total == 0) {

    $invoicedate = date('Y-m-d');
    $id = $res_outer[0]['id'];
    $name=$res_outer[0]['uname'];
    $email=$res_outer[0]['email'];
    $address = $res_outer[0]['address'];
    $phone = $res_outer[0]['mobile'];
    $orderdate = $res_outer[0]['date_added'];
    $order_list = $encoded_items;
    $discount = $res_outer[0]['discount'];
    $final_total=$res_outer[0]['final_total'];
    $total_payble = $res_outer[0]['price'];
    $shipping_charge=$res_outer[0]['delivery_charge'];
    $payment = $res_outer[0]['final_total'];
    $data = array(
        'invoice_date' => $invoicedate,
        'order_id' => $id,
        'name' => $name,
        'address' => $address,
        'order_date' => $orderdate,
        'phone_number' => $phone,
        'order_list' => $encoded_items,
        'email' => $email,
        'discount' => $discount,
        'total_sale' => $total_payble,
        'shipping_charge' => $shipping_charge,
        'payment' => $payment,
    );
    // print_r($data);
    $db->insert('invoice',$data);
    $res=$db->getResult();
}

$sql_invoice = "SELECT id, invoice_date FROM invoice WHERE order_id =" . $id;

    // Execute query
    $db->sql($sql_invoice);
    // store result 
    $res_invoice=$db->getResult();
$order_list = $encoded_items;
?>
<style>
@page { size: auto;  margin: 0mm; }
</style>

<style>

.borderless td,.heading th{
    border: none!important;
    padding: 0px!important;
}

</style>

<section class="content-header">
    <h1>
        Invoice /
        <small><a href="home.php"><i class="fa fa-home"></i> Home</a></small>
    </h1>
</section>
<section class="content">
    <?php if($permissions['reports']['create']==0){?>
    <div class="alert alert-danger topmargin-sm">You have no permission to generate invoice</div>
    <?php exit(); } ?>
    <section class="invoice">
        <!-- title row -->
        <!--<div class="row">-->
        <!--    <div class="col-xs-12">-->
        <!--    <div class="col-md-6">-->
        <!--        <h2 class="page-header text-left">-->
        <!--            <?php //$settings['app_name'];?> -->
        <!--        </h2>-->
        <!--    </div>-->
        <!--    <div class="col-md-6">-->
        <!--        <h2 class="page-header text-right">-->
        <!--            Mo. +91 <?php //$settings['support_number'];?>-->
        <!--        </h2>-->
        <!--    </div>-->
        <!--    </div><!-- /.col -->
        <!--</div>-->
        <div class="row">
            <!-- <div class="col-xs-12"> -->
            <div class="col-md-12">
                <h2 class="page-header text-left">
                    <?=$settings['app_name'];?> <br/>
                </h2>
               <!--  <h2 class="page-header text-right">
                     -->
                <!-- </h2> -->
            </div>
            <div class="col-md-12">
                <h2 class="page-header">
                    <span class="text-left">Mo. +91 <?=$settings['support_number'];?></span>
                     <!-- 12721066001560 old number -->
                    <span class="text-right" style="float: right;"><b>FSSAI: </b><?php echo '12724045000814'; ?></span>
                </h2>                
            </div>
            
           <!--  </div> -->
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                From
                <address>
                    <strong><?=$settings['app_name'];?></strong><br>
                    Email: <?=$settings['support_email'];?><br>
                    Customer Care : +91 <?=$settings['support_number'];?><br>
                    Delivery By: &nbsp; <?php echo $res_outer[0]['delivery_boy']; ?>
                </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
                To
                <address>
                     <strong><?php echo $res_outer[0]['uname']; ?></strong><br>
                     <?php echo $res_outer[0]['address']; ?><br>
                     <strong><?php echo $res_outer[0]['mobile']; ?></strong><br>
                     <strong><?php echo $res_outer[0]['email']; ?></strong><br>
                </address>

            </div><!-- /.col -->
            <div class="col-sm-2 invoice-col">
                Retail Invoice<br>
                <b>No : </b>#<?php echo $res_invoice[0]['id']; ?>
                <br>
                <b>Date: </b><?php echo date('d-m-Y',strtotime($res_invoice[0]['invoice_date'])); ?>
                <br>
                <b>Order ID: </b>#<?php echo $res_outer[0]['id']; ?>
                <br>
                <b>Date: </b><?php echo date('d-m-Y h:i A',strtotime($res_outer[0]['date_added'])); ?>
                <br>
                <b>Payment Mode : </b><?php echo $res_outer[0]['payment_method']; ?>
                <br>
            </div>
        </div><!-- /.row -->

        <!-- Table row -->
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table borderless">
                    <thead class="text-center">
                        <tr>
                            <th>Sr No.</th>
                            <th>Product Code</th>
                            <th>Name</th>
                            <th>Unit</th>
                            <th>Qty</th>
                            <th>SubTotal (<?=$currency;?>)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $decoded_items=json_decode(stripSlashes($order_list));
                        // print_r($decoded_items);
                            $qty = 0;
                            $i=1;
                            $total=0;
                            foreach ($decoded_items as $item) {
                                if($item[8]!='cancelled' && $item[8]!='returned'){
                            ?>
                        <tr>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;<?=$i?><br></td>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;<?=$item[0] ?><br></td>
                                <td><?=$item[1] ?><br></td>
                                <td><?=$item[3]." ".$item[4] ?><br></td>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;<?=$item[2] ?><br></td>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;<?=$item[7] ?><br></td>
                        </tr>
                        <?php $qty = $qty+$item[2];
                        $i++;
                        $total+=$item[7];
                    } }?>
                    <?php
                        $sql_total = 'select total from orders where id='.$ID;
                        $db->sql($sql_total);
                        $res_total = $db->getResult();
                    ?>
                    </tbody>
                        <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                            <th>Total</th>
                           <td>&nbsp;&nbsp;&nbsp;&nbsp;<?=$qty?><br></td>
                           <td>&nbsp;&nbsp;&nbsp;&nbsp;<?=$res_total[0]['total'];?><br></td>
                        </tr>
                </table>
            </div><!-- /.col -->
        </div><!-- /.row -->

        <?php if($res_outer[0]['discount']>0){
            $discounted_amount = $res_total[0]['total'] * $res_outer[0]['discount'] / 100; /*  */
    	    $final_total = $res_total[0]['total'] - $discounted_amount;
            $discount_in_rupees = $res_total[0]['total']-$final_total;
            $discount_in_rupees = $discount_in_rupees;
            // echo $discount_in_rupees;
        } else {
            $discount_in_rupees = 0;
        }?>
        <div class="row">
            
            <!-- accepted payments column -->
            <div class="col-xs-6 col-xs-offset-6">
                <!--<p class="lead">Payment Date: </p>-->
                <div class="table-responsive">
                    <table class="table borderless heading">
                    <th></th>
                        <tr>
                            <th>Total Order Price (<?=$currency;?>)</th>
                            <td><?php echo '+ '.$res_total[0]['total']; ?></td>
                        </tr>
                        <tr>
                            <th>Delivery Charge (<?=$currency;?>)</th>
                            
                            <td><?='+ '.$res_outer[0]['delivery_charge'];?></td>
                        </tr>
                        <tr>
                            <th>Tax <?=$currency;?>(%)</th>
                            <td><?='+ '.$res_outer[0]['tax_amount'].' ('.$res_outer[0]['tax_percentage'].'%)'; ?></td>
                        </tr>
                        <tr>
                            <th>Discount <?=$currency;?>(%)</th>
                            <td><?='- '.$discount_in_rupees.' ('.$res_outer[0]['discount'].'%)'; ?></td>
                        </tr>
                        <tr>
                            <th>Promo (<?=$res_outer[0]['promo_code'];?>) Discount (<?=$currency;?>)</th>
                            <td><?='- '.$res_outer[0]['promo_discount'];?></td>
                        </tr>
                        <tr>
                            <th>Wallet Used (<?=$currency;?>)</th>
                            <td><?='- '.$res_outer[0]['wallet_balance']; ?></td>
                        </tr>
                        
                        
                         
                        <th>Final Total (<?=$currency;?>)</th>
                        <?php
                            $total = $res_total[0]['total'];
                            $delivery_charge = $res_outer[0]['delivery_charge'];
                            $tax_amount = $res_outer[0]['tax_amount'];
                            $promo_discount = $res_outer[0]['promo_discount'];
                            $wallet = $res_outer[0]['wallet_balance'];
                            $final_total = $total+$delivery_charge+$tax_amount-$discount_in_rupees-$promo_discount-$wallet;
                            
                        ?>
                        <td><?='= '.ceil($final_total);?></td>
                        </tr>
                    </table>
                </div>
            </div><!-- /.col -->
            <?php if($res_outer[0]['instructions'] != ""){ ?>
            <div class="col-xs-6 col-xs-offset-6" style="margin:300px 0px 0px;">
                <div class="table-responsive">
                    <table class="table borderless heading">
                        <tr>
                            <th>Instructions:</th>
                            <td><?php echo $res_outer[0]['instructions']; ?></td>
                        </tr>  
                    </table>
                </div>
            </div>
            <?php } ?>
        </div><!-- /.row -->

        <!-- this row will not appear when printing -->
        <div class="row no-print">
            <div class="col-xs-12">
                <form><button type='button' value='Print this page' onclick='printpage();' class="btn btn-default"><i class="fa fa-print"></i> Print</button>
                </form>
                <script language="javascript">
                    function printpage()
                    {
                        window.print();
                    }
                </script>
            </div>
        </div>
    </section>
</section>