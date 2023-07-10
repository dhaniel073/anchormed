<?php

setlocale(LC_MONETARY, 'en_US');

$hospital_address = $this->session->userdata('hospital_address');
$currencySymbol = $this->session->userdata('currency_symbol');
$settings_show_unit_price = $this->session->userdata('show_unit_price');
//allow_editable_bills
$allow_editable_bills = $this->session->userdata('allow_editable_bills');
$allow_refunds = $this->session->userdata('allow_refunds');

$show_item_totals = $this->session->userdata('show_item_totals');
$show_item_quantity = $this->session->userdata('show_item_quantity');

if(strtolower($show_item_totals) == "true"){

    $show_item_totals = true;

}else{

    $show_item_totals = false;
}



if(strtolower($show_item_quantity) == "true"){

    $show_item_quantity = true;

}else{

    $show_item_quantity = false;

}


$showUnitPrice = true;
$mode = $this->session->userdata('mode');


if(strtolower($settings_show_unit_price['value']) == "true"){

    $showUnitPrice = true;

}else{

    $showUnitPrice = false;
}


$isSecurityDeposit = false;

if ($this->session->userdata('submit')) {
    $data = $this->session->userdata('data');
    $patient_name = $data['patient_name'];
    $patient_number = $data['patient_number'];

    if(isset($data['bill'])){

        $bill_id = $data['bill']['bill_id'];
        $bill_name = $data['bill']['service_name'];
        $bill_description = $data['bill']['description'];
        $bill_unit_price = $data['bill']['unit_price'];
    }



    $this->session->unset_userdata('submit');
    $this->session->unset_userdata('data');

}


$print_mode = "";

if ($this->session->userdata('print_mode')) {

    $print_mode = $this->session->userdata('print_mode');
    $this->session->unset_userdata('print_mode');

}

$totalPaidSofar = 0;
if (isset($partial_payment_data)) {
    foreach ($partial_payment_data as $partial_payment) {
        $totalPaidSofar = $totalPaidSofar + $partial_payment["amount_paid"];
    }
}

$printAddressBase = "index.php/billing/viewBill/";

if ($patient["patient_number"] == NON_CUSTOMER_ID) {

    $printAddressBase = "index.php/billing/nonCustomerBill/";
}

?>


<script>
    $(document).ready(function () {


        <?php $notice = $this->session->userdata('notice');  $this->session->unset_userdata('notice'); if($notice && $notice != ""){ ?>

        alert("<?php echo $notice; ?>");


        <?php } ?>
    });
</script>


<section id="container" class="">

    <section id="main-content">
        <section class="wrapper site-min-height">
            <section style="position: absolute; left: 0px; top: 0px; width:100%;">
                <div class="panel panel-primary">

                    <div class="panel-body">
                        <div class="row invoice-list">
                            <div class="text-left corporate-id">
                                
                                <img src="<?= base_url() ?>assets/img/logo/logo.png" alt="" height="75">
                            </div>
                            <div class="col-lg-4 col-sm-4">

<p>Date/Time:
  <?php
    $currentDateTime = date("F j, Y, g:i a"); 
    echo $currentDateTime;
?>
</p>
                                <h4>BILLING ADDRESS</h4>

                                <p>
                                    <b>Patient Name: <?php if (isset($patient['first_name'])) echo ucwords($patient['first_name'] . " ");
                                    if (isset($patient['last_name'])) echo($patient['last_name']); ?> </b> <br />
					
                                     Patient Number :  <?php if (isset($patient['patient_number'])) echo ucwords($patient['patient_number'] . " "); ?> <br>
                               
                                    Patient Type :  <?php if (isset($patient['patient_type_code'])) if($patient['patient_type_code']=='S') echo 'Standard'; elseif($patient['patient_type_code']=='H') echo 'Health Insurance'; elseif($patient['patient_type_code']=='F') echo 'Family'; ?> <br>
                               			
                                    HMO Name : <?php if (isset($hmo_name['hmo_name'])) echo $hmo_name['hmo_name']; ?> <br />
                           				
                                    <?php if (isset($patient['country_name'])) echo ucwords($country['country_name']); ?>
                                    Tel: <?php if (isset($patient['mobile_number'])) echo $patient['mobile_number']; ?> <br />
                            			
					Reference : <?php echo $reference; ?> <br>
					Reference Date : <?php if (isset($referenceDate)) echo $referenceDate; ?> <br>

                                
                                    Status : <?php $status = "Posted";
                                    foreach ($current_bill as $bill) {

                                        //if it is a security deposit, should be only one entry
                                        if(strtolower($bill["service_name"]) == "deposit"){

                                            $isSecurityDeposit = true;
                                        }


                                        if ($bill['status'] == "N") {
                                            $status = "Not Posted";
                                            break;
                                        } else if ($bill['status'] == "R") {
                                            $status = "Partially Paid";
                                            break;
                                        }
                                    }; ?> <span
                                        style="color:<?php if ($status == "Posted") echo "#71be3c"; else echo "#FF6C60"; ?>;"><?php echo $status; ?></span><br>
                                </p>

								
                            </div>

                            

                           

                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <input type="hidden" name="patient_number"
                                   value="<?php echo $patient['patient_number']; ?>"/>
                            <input type="hidden" name="patient_type_code"
                                   value="<?php echo $patient['patient_type_code']; ?>"/>
                            <input type="hidden" value="<?php echo $reference; ?>" name="reference_id"/>
                            <input type="hidden" name="partial_amount" id="partial_amount" type="hidden" value="0"/>
                            <input type="hidden" name="partial_payment_flag" id="partial_payment_flag" type="hidden"
                                   value="N"/>
                            <input type="hidden" name="offset_from_deposit_flag" id="offset_from_deposit_flag" type="hidden"
                                   value="N"/>


                            <input type="hidden" name="hmo_split_flag" id="hmo_split_flag" type="hidden"
                                   value="N"/>

                            <input type="hidden" name="hmo_patient_split_amount" id="hmo_patient_split_amount" type="hidden"
                                   value="0"/>


                            <input type="hidden" name="partial_previously_recieved" id="partial_previously_recieved"
                                   type="hidden"
                                   value="<?php if (isset($partial_payment_data)) echo "Y"; else echo "N"; ?>"/>
                            <?php if (isset($partial_payment_data)) { ?>


                                <input type="hidden" name="partial_payment_ref" id="partial_payment_ref" type="hidden"
                                       value="<?php echo $partial_payment_data[0]["reference_id"]; ?>"/>
                            <?php } ?>


                                <thead>
                                <tr>            
                                    <th><b>BILL DETAILS</b></th>                                     
                                </tr>
                                </thead>

								<br />

                                <?php $counter = 1;
                                $grandTotal = 0;
                                foreach ($current_bill as $item) {


                                    if(isset($item["selling_price"])){

                                        //selling price that was edited
                                        $total = $item['selling_price'];
                                    }else{
                                        $total = $item['unit_price'] * $item['qty'];

                                    }

                                    $grandTotal += $total; ?>

                                    <tr>
                                        <br />
                                        <td class="hidden-phone"><b>Item Name:</b> <?php echo ucwords($item['service_name']); ?><br />
										<td class="hidden-phone"><b>Price:</b> <?php echo $total; ?><br />
																		
									<?php }?>
									<p><b>Payment Mode</b></p>
									<?php
									  foreach ($payment_mode_list as $payment_mode_lists) {
											echo $payment_mode_lists["amount_paid"]." :".$payment_mode_lists["mode"];
											?>
											</br>
										<?php
										}
									?>
									<p></p>
									</br>
									</br>
									<p>Mediphix Powered By Phixotech</p>
                                </ul>

							</tr>
                          
                        </div>

							
                        
						

                        <?php if(isset($refunds)){ ?>
                        <div class="row" style="margin-top:40px;">
                            <div class="col-lg-4 invoice-block pull-right">
                                <ul class="unstyled amounts">
                                    <?php foreach($refunds as $refund){ ?>

                                        <li><strong>Refunded :
                                            <?php echo $currencySymbol; ?> <?php
                                            echo number_format((float)$refund['refund_amount'],2,'.','');
                                            //echo money_format('%(#10n', $refund['refund_amount']) ; ?></strong></li>

                                    <?php } ?>

                                       </ul>
                            </div>
                        </div>
                        <?php } ?>







                        <div class="text-center invoice-btn">
                            <?php


                            if ($mode != 'print') {
                                ?>

                                <a href="<?= base_url() ?>" class="btn btn-info btn-lg"><i class="fa fa-plus"></i> Home
                                </a>




                                <?php if (!isset($partial_payment_data) && !$isSecurityDeposit) { ?>
                                    <a id="create-bill" data-toggle="modal" href="#myModal" class="btn btn-info btn-lg"><i
                                            class="fa fa-plus"></i> Add Bill Item </a>
                                <?php }?>

                                <!--check if  user has deposit to offset the bill-->

                                <?php if(!$isSecurityDeposit && isset($patient_deposit) && sizeof($patient_deposit) > 1) { ?>

                                    <a id="offsetBill" data-toggle="modal" href="#billOffset" class="btn btn-success btn-lg"><i
                                            class="fa fa-plus"></i> Offset Bill from Security Deposit </a>

                                <?php } ?>


                                <?php if ($post_access) { ?>
                                    <a id="post" patient_type="<?php echo $patient['patient_type_code']; ?>"
                                       class="btn btn-danger btn-lg"><i
                                            class="fa fa-check"></i><?php if ($patient['patient_type_code'] == 'H') echo "Add To Provider Bill"; else echo "Post Invoice "; ?>
                                    </a>

                                    <!--add support for patient bill offset-->
                                    <?php if($patient['patient_type_code'] == 'H'){?>

                                        <a data-toggle="modal" href="#splitBillModal" id="split" patient_type="<?php echo $patient['patient_type_code']; ?>"
                                           class="btn btn-warning btn-lg"><i
                                                class="fa fa-check"></i><?php  echo "Split Bill"; ?>
                                        </a>

                                    <?php }?>


                                <?php } ?>
                                <?php if (!isset($partial_payment_data)) { ?>
                                    <a id="rem" class="btn btn-danger btn-lg"><i class="fa fa-check"></i> Remove Checked
                                        Items </a>
                                <?php }?>
                                <a href="<?= base_url() ?><?php echo $printAddressBase . $reference;?>?print_mode=true"
                                   target="_blank" class="btn btn-info btn-lg"><i class="fa fa-print"></i> Print </a>

                            <?php
                            } else {


                                ?>

                                <?php $this->session->unset_userdata('mode');?>

                                <?php if ($print_mode != "true") { ?>
                                    <a href="<?= base_url() ?>" class="btn btn-info btn-lg"><i class="fa fa-plus"></i>
                                        Home </a>
                                    <a class="btn btn-info btn-lg"
                                       href="<?= base_url() ?><?php echo $printAddressBase . $reference; ?>?print_mode=true"
                                       target="_blank"><i class="fa fa-print"></i> Print </a>

                                    <?php  if($can_perform_refund && $allow_refunds == "true"){
                                        if(isset($refunds)){
                                            if( sizeof($refunds) < 1){ ?>
                                    <a href="#refundBill" data-toggle="modal" class="btn btn-success btn-lg"><i class="fa fa-money"></i>
                                        Refund </a>
                                        <?php }
                                        }
                                    }?>

                                <?php } ?>

                            <?php } ?>
                        </div>
                    </div>
                </div>
                <script>

                    $(document).ready(function () {
                        <?php if(isset($bill_id) && $bill_id !=""){?>

                        $("a#create-bill").click();
                        <?php } ?>
                    });
                </script>
                <script>


                    function performBillPosting(patientType){

                        console.log("submitting checked items");

                        var numberOfBillItems = $(".bill-item").length;

                        var isAllBillsSelected = true;

                        //confirm all bills have been checked before posting
                        //fixes bug of submiting a bill while some items are unchecked
                        if(numberOfBillItems > 0 ){

                            $(".bill-item").each(function(){

                                if(!$(this).is(":checked")){

                                    isAllBillsSelected = false;
                                    return;
                                }
                            });

                        }

                        if(!isAllBillsSelected){
                            alert("Delete all unwanted bill items before posting");
                            return;
                        }


                        //var patientType = $(this).attr("patient_type");

                        //if patient type is hmo or non patient submit bill for posting else ask how much to be posted
                        //hack to enable partial payment of bills as this was not initially supported
                        if (patientType == "H" || patientType == "N") {
                            //  alert("submitting");
                            var confirmPosting = confirm("Confirm payment received");
                            if(confirmPosting){
                                $("form[name=postBill]").submit();
                            }else return;
                        }

                        else {
                            //bring up a payment confirm modal before posting
                            $("a#paymentConfirmModalLink").click();

                        }
                    }

                    $(document).ready(function () {
                        $("a#post").click(function () {
                            performBillPosting($(this).attr("patient_type"));
                        });


                        $("a#rem").click(function () {

                            console.log("deleteing checked items");
                            $("form[name=postBill]").attr("action", "<?=base_url()?>index.php/billing/removeBillItems").submit();

                        });

                    });
                </script>


            </section>


        </section>
    </section>


</section>


</section>

<!--splitBillModal-->
<!------------------------------------------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------------------------------------------------->
<!--------------------------------------------- Split Bill Data Modal------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------------------------------------------------->

<?php if($patient['patient_type_code'] == 'H'){?>

    <form name="splitBillForm" id="splitForm" method="post" action="<?= base_url() ?>index.php/billing/splitBill">

        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="splitBillModal"
             class="modal fade">

            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
                        <h4 class="modal-title">Split Bill Between HMO and Patient</h4>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" name="bill_reference" id="bill_reference" value="<?php echo $reference; ?>"/>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Patient Amount</label>
                            <input type="number" class="form-control" name="patient_amount" id="patient_amount"
                                   value="0"/>

                        </div>

                        <input type="hidden" name="real_hmo_amount"
                               id="real_hmo_amount" value="<?php echo (float)$grandTotal; ?>"/>

                        <div class="form-group">
                            <label for="exampleInputEmail1">HMO Amount</label>
                            <input type="number" readonly="readonly" class="form-control" name="hmo_amount" id="hmo_amount"
                                   value="<?php echo (float)$grandTotal; ?>"/>

                        </div>


                        <button type="button" id="submit-split-request" class="btn btn-success"
                                onclick="javascript:splitBill();">Split
                        </button>

                        <script type="application/x-javascript">

                            function resetSplitValues(){
                                $(this).val(0);
                                $("input#hmo_amount").val($("input#real_hmo_amount").val());
                            }

                            $(document).ready(function(){

                                $("input#patient_amount").change(function(){

                                    if($.isNumeric($(this).val())){

                                        if((Number($(this).val()) < 0) || (Number($(this).val()) > Number($("input#real_hmo_amount").val() ))){
											
											alert($(this).val());
											alert($("input#real_hmo_amount").val());
                                            alert("invalid amount");
                                            resetSplitValues();
                                        }else{

                                            //update the other amount
                                            $("input#hmo_amount").val($("input#real_hmo_amount").val() - $(this).val());
                                        }

                                    }else{

                                       resetSplitValues();
                                    }

                                });

                            });


                            function splitBill(){

                                var patientAmount = $("input#patient_amount").val();
                                var billAmount = $("input#real_hmo_amount").val();
                                var isValidSplit = false;

                                if((Number(patientAmount) > 0 )&& (Number(patientAmount) <= Number(billAmount)) ){

                                    isValidSplit = true;
                                }
                                if(isValidSplit){

                                    $("input#hmo_patient_split_amount").val(patientAmount);
                                    $("input#hmo_split_flag").val("Y");

                                    performBillPosting("H");

                                }else{

                                    
									alert($("input#patient_amount").val());
									alert($("input#real_hmo_amount").val());
									alert("invalid amount");

                                }
                            }
                        </script>


                    </div>
                </div>
            </div>
        </div>

    </form>


<?php } ?>

<!------------------------------------------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------Pop up User to enter Refund------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------------------------------------------------->

<form name="refundForm" id="refundForm" method="post" action="<?= base_url() ?>index.php/billing/refundBill">

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="refundBill"
     class="modal fade">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
                <h4 class="modal-title">Refund Bill Amount</h4>
            </div>
            <div class="modal-body">

                <input type="hidden" name="refund_bill_reference" id="refund_bill_reference" value="<?php echo $reference; ?>"/>

                <div class="form-group">
                    <label for="exampleInputEmail1">Amount</label>
                    <input type="text" class="form-control" name="refund_amount" id="refund_amount"
                           value=""/>

                </div>


                <button type="button" id="update-item-price" class="btn btn-success"
                        onclick="javascript:refundAmount();">Refund
                </button>

                <script type="application/x-javascript">

                    function refundAmount(){

                        var error = "";
                        var originalTotal = <?php echo $grandTotal; ?>;

                        var performRefund = true;

                        if($.isNumeric($("input#refund_amount").val())){

                            if($("input#refund_amount").val() < 0){

                                performRefund = false;
                                error = "Amount cannot be less than 0";
                            }

                            if($("input#refund_amount").val() > Number(originalTotal)){

                                performRefund = false;
                                error = "Amount must be less than bill total amount";
                            }

                        }else{

                            performRefund = false;
                            error = "Amount must be a decimal";
                        }

                        if(performRefund){

                            $("form#refundForm").submit();

                        }else{

                            alert(error);

                        }
                    }

                </script>


            </div>
        </div>
    </div>
</div>

</form>
<!--
refundBill-->
<!------------------------------------------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------Pop up User to enter custom amount------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------------------------------------------------->

<form name="updateItemPriceForm" id="updateItemPriceForm" method="post" action="<?= base_url() ?>index.php/billing/updateCustomItemPrice">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="customItemAmount"
     class="modal fade">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
                <h4 class="modal-title">Update Item Total</h4>
            </div>
            <div class="modal-body">

                <input type="hidden" name="bill_item_id" id="update_bill_item_id"/>
                <div class="form-group">
                    <label for="exampleInputEmail1">Custom Amount</label>
                    <input type="text" class="form-control" name="custom_amount" id="custom_amount"
                           value=""/>

                </div>


                <button type="button" id="update-item-price" class="btn btn-default"
                        onclick="javascript:updateItemPrice();">Update Item Price
                </button>

                <script type="application/x-javascript">

                    $(document).ready(function(){

                        $("a.update_item_price").click(function(){

                            $("input#update_bill_item_id").val($(this).attr("bill_id"));

                        });
                    });


                    function updateItemPrice(){
                       // alert("item price updated");
                        var updateAmount = true;
                        var error = "";

                        if($.isNumeric($("input#custom_amount").val())){

                            if(updateAmount < 0){

                                updateAmount = false;
                                error = "Amount cannot be less than 0";
                            }

                        }else{

                            updateAmount = false;
                            error = "Amount must be a decimal";
                        }

                        if(updateAmount){

                            $("form#updateItemPriceForm").submit();

                        }else{

                            alert(error);

                        }
                    }

                </script>


            </div>
        </div>
    </div>
</div>

</form>

<!------------------------------------------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------------------------------------------------->
<!-------------------------Pop up asking user to offset bill from the current security deposit----------------------------------->
<!------------------------------------------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------------------------------------------------->



<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="billOffset"
     class="modal fade">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
                <h4 class="modal-title">Offset Bill from security deposit</h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="exampleInputEmail1">Total Bill Amount</label>
                    <input type="text" class="form-control" name="pop_bill_amount" id="pop_bill_amount"
                           value="<?php if (isset($partial_payment_data)) echo($grandTotal - $totalPaidSofar); else echo $grandTotal; ?>"
                           disabled="disabled">

                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Security Deposit</label>
                    <input disabled="disabled" type="text" class="form-control" name="security_deposit" id="security_deposit"
                           value="<?php if (isset($patient_deposit)) echo($patient_deposit["deposit_amount"]); ?>">
                </div>



                <div id="pay-create-error"></div>
                <button type="button" id="add-pay" class="btn btn-success"
                        onclick="javascript:validateSecurityOffSet();">Make Payment
                </button>

                <script type="application/x-javascript">


                </script>


            </div>
        </div>
    </div>
</div>


<!------------------------------------------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------------------------------------------------->
<!-------------------------Pop up asking user if he would like to make a partial payment----------------------------------------->
<!------------------------------------------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------------------------------------------------->


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="paymentConfirmModal"
     class="modal fade">
    <a id="paymentConfirmModalLink" href="#paymentConfirmModal" data-toggle="modal"></a>

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
                <h4 class="modal-title">Post Bill</h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="exampleInputEmail1">Total Bill Amount</label>
                    <input type="text" class="form-control" name="pop_bill_amount" id="pop_bill_amount"
                           value="<?php if (isset($partial_payment_data)) echo($grandTotal - $totalPaidSofar); else echo $grandTotal; ?>"
                           disabled="disabled">

                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Received Amount</label>
                    <input type="text" class="form-control" name="recieved_amount" id="recieved_amount"
                           value="<?php if (isset($partial_payment_data)) echo($grandTotal - $totalPaidSofar); else echo $grandTotal; ?>"
                        />
                   <!-- <input type="text" class="form-control" name="recieved_amount" id="recieved_amount"/>-->
                </div>


                <div id="religion-create-error"></div>
                <button type="button" id="add-religion" class="btn btn-success"
                        onclick="javascript:validateAmountBeingPaid();">Make Payment
                </button>

                <script type="application/x-javascript">

                    function validateSecurityOffSet(){

                        var billAmount = parseFloat($("input#pop_bill_amount").val());

                        var securityDeposit = parseFloat($("input#security_deposit").val());

                        console.log("security deposit : " + securityDeposit);

                        var postBill = false;

                        //reset the partial payment flag

                        $("input#partial_payment_flag").val("N");
                        $("input#partial_amount").val(0);

                        $("input#offset_from_deposit_flag").val("N");


                        if(securityDeposit > billAmount ){
                            postBill = true;
                            $("input#offset_from_deposit_flag").val("Y");
                            console.log("valid bill amount");
                        }else  {
                            alert("Security Deposit, can not cover current bill");
                        }


                        if(postBill){

                            $("input#partial_amount").val(billAmount);
                            $("form[name=postBill]").submit();
                        }


                    }


                    function validateAmountBeingPaid() {

                        var billAmount = parseFloat($("input#pop_bill_amount").val());

                        var recievedAmount = parseFloat($("input#recieved_amount").val());
                        var postBill = false;

                        //reset the partial payment flag

                        $("input#partial_payment_flag").val("N");
                        $("input#partial_amount").val(0);

                        if (billAmount == recievedAmount) {
                            //code

                            postBill = true;
                        }
                        else if (recievedAmount < 1 || recievedAmount > billAmount) {

                            alert("Invalid Amount , Please enter a valid amount");

                        }
                        else {
                            if (confirm("Do you want to make a partial payment ? ")) {
                                console.log("Partial payment to be made");
                                postBill = true;
                                $("input#partial_payment_flag").val("Y");


                            }
                        }

                        console.log("billAmont = " + billAmount);
                        console.log("recievedAmount = " + recievedAmount);
                        console.log("partial Payment flag = " + $("input#partial_payment_flag").val());
                        console.log("Partial Payment Amount = " + $("input#partial_amount").val());


                        if (postBill) {
                            $("input#partial_amount").val(recievedAmount);
                            $("form[name=postBill]").submit();
                        }

                    }

                </script>


            </div>
        </div>
    </div>
</div>


<form name="createBill" id="createBill" action="<?= base_url() ?>index.php/billing/updateBill" method="post">
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
                    <h4 class="modal-title">Add Bill Item</div>
                <div class="modal-body" id="create-bill">


                    <div class="form-group">
                        <label for="exampleInputEmail1">Patient Name</label>
                        <input type="text" class="form-control" disabled="disabled" name="patient_name_display"
                               value="<?php if (isset($patient['first_name'])) echo ucwords($patient['first_name'] . " ");
                               if (isset($patient['last_name'])) echo($patient['last_name']); ?>" id="patient_name"
                               placeholder="Name"/>


                        <input type="hidden" class="form-control" name="patient_name"
                               value="<?php if (isset($patient['first_name'])) echo ucwords($patient['first_name'] . " ");
                               if (isset($patient['last_name'])) echo($patient['last_name']); ?>" id="patient_name"
                               placeholder="Name"/>


                        <input type="hidden" name="patient_number" value="<?php echo $patient['patient_number']; ?>"/>
                        <input type="hidden" name="reference" value="<?php echo $reference; ?>"/>
                        <input type="hidden" name="bill_id" value="<?php if (isset($bill_id)) echo $bill_id; ?>"/>
                        <input type="hidden" id="return_url" value="index.php/billing/bill" name="return_url"/>

                        <?php if ($patient['patient_type_code'] != 'N') { ?>
                            <input type="hidden" id="forward_url"
                                   value="/billing/currentBill/<?php echo $patient['patient_number']; ?>"
                                   name="forward_url"/>
                        <?php } else { ?>
                            <input type="hidden" id="forward_url"
                                   value="/billing/nonCustomerBill/<?php echo $reference; ?>" name="forward_url"/>

                        <?php } ?>

                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Department</label>

                        <input type="hidden" id="staff_no" value="<?php echo $this->session->userdata('staff_no'); ?>"
                               name="staff_no"/>
                        <br/>
                        <select class="form-control" name="dept_id" id="dept_id">

                            <option value=""></option>
                            <?php foreach ($departments as $department) { ?>
                                <option
                                    value=" <?php echo $department['dept_id']; ?>"> <?php echo $department['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <a id="select_bill" href="#" class="btn btn-xs btn-success">
                            Select Bill</a>
                        <script>

                            $(document).ready(function () {

                                $("a#select_bill").click(function () {
                                    $("form[name=createBill]").attr("action", "<?=base_url()?>index.php/billing/search").submit();
                                });
                            });
                        </script>

                    </div>


                    <div class="form-group">
                        <label for="exampleInputEmail1">Service Name</label>

                        <input type="text" value="<?php if (isset($bill_name)) echo $bill_name; ?>" disabled="disabled"
                               class="form-control" name="service_name" id="service_name" placeholder="Service Name">

                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Description</label>

                        <input type="text" disabled="disabled"
                               value="<?php if (isset($bill_description)) echo $bill_description; ?>"
                               class="form-control" name="description" id="desc" placeholder="Description">

                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Unit Price</label>
                        <input type="text" disabled="disabled"
                               value="<?php if (isset($bill_unit_price)) echo $bill_unit_price; ?>" class="form-control"
                               name="unit_price" id="unit_price" placeholder="Unit Price">

                    </div>


                    <div class="form-group">
                        <script>

                            $(document).ready(function () {

                                <?php if($print_mode == "true"){
                                    ?>
                                window.print();
                                <?php
                                }?>

                                $("input#qty").change(function () {
                                    var isnumeric = $.isNumeric($(this).val());

                                    if (isnumeric) {
                                        //code
                                        $("input#total").val($("input#unit_price").val() * $(this).val());
                                    }
                                    else {
                                        $(this).val("1");
                                    }

                                });
                            });
                        </script>

                        <label for="exampleInputEmail1">Number of Units</label>
                        <input type="text" class="form-control" value="<?php if (isset($bill_unit_price)) echo "1"; ?>"
                               name="qty" id="qty" placeholder="Quantity">

                        <div class="form-group">
                            <label for="exampleInputEmail1">Total</label>
                            <input type="text" disabled="disabled"
                                   value="<?php if (isset($bill_unit_price)) echo $bill_unit_price; ?>"
                                   class="form-control" name="total" id="total" placeholder="Unit Price">

                        </div>


                    </div>


                    <button type="button" id="upload" class="btn btn-default" onclick="javascript:CreateBill();">Add
                    </button>


                    <script>
                        $(document).ready(function () {
                            $("button#add").click(function () {

                                $("form#createBill").attr("action", "<?=base_url()?>index.php/billing/updateBill");
                                CreateBill();
                            });

                        });

                        function CreateBill() {



                            //code
                            var error = false;
                            var department = $("select#dept_id").val();

                            var description = $("input#desc").val();

                            var qty = $("input#qty").val();

                            var unit_price = $("input#unit_price").val();

                            if (department == "") {
                                //code
                                error = true;
                                alert("Please choose a department");
                            }

                            if (description == "") {
                                //code
                                error = true;
                                alert("Please fill out a description");
                            }

                            if (qty == "") {
                                //code
                                error = true;
                                alert("Please fill out a quantity");
                            }

                            if (unit_price == "") {
                                //code
                                error = true;
                                alert("Please fill out the unit price");
                            }


                            if (!$.isNumeric(qty)) {
                                //code
                                error = true;
                                alert("invalid quantity");
                            }
                            if (!$.isNumeric(unit_price)) {
                                //code
                                error = true;
                                alert("invalid Unity Price");
                            }


                            if (error) {
                                //code
                                return false;
                            }
                            else {
                                $("input#patient_name").removeAttr("disabled");
                                $("form#createBill").submit();
                                return true;
                            }
                        }

                    </script>

                </div>
            </div>
        </div>
    </div>


</form>
 
 <style>

     strong{

         font-size: 12px;
     }
 </style>