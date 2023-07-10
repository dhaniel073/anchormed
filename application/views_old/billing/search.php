
<?php

    $data  = $this->session->userdata("data");

?>



<section id="container" class="">

<section id="main-content">
<section class="wrapper site-min-height">
 
<div class="row">
<div class="col-lg-12">
<section class="panel">
<header class="panel-heading">
Billable Items
</header>
<div class="panel-body">

    <?php if(isset($data) && $data["patient_number"] != "WALK_IN_CUSTOMER"){ ?>
        <a class="btn btn-success" href="<?=base_url()?>index.php/billing"> Finish Selection</a>
        <a class="btn btn-success" href="<?=base_url()?>index.php/billing/currentBill/<?php echo $data["patient_number"];?>"> View Customer Current Bills</a>
    <?php } else { ?>

        <a style="display: none;" id="walkin-finish-btn" class="btn btn-success">Finish Selection</a>

    <?php } ?>
    <div class="adv-table">


<table class="display table table-bordered table-striped" id="patients">
<thead>
    
    
<tr>
<th>Service Name</th>
<th>Description</th>
<th>Unit_Price</th>

</tr>
</thead>
<tbody>

<?php foreach($bill_defs as $def){ ?>
<tr class="gradeX">
    <?php if(isset($data) && $data["patient_number"] != "WALKD_IN_CUSTOMER"){ ?>

        <td><a drug-name="<?php echo $def['service_name']; ?>" unit-price="<?php echo $def['unit_price']; ?>" drug-id="<?php echo $def['bill_id']; ?>" data-toggle="modal" class="addBillToUser" href="#addBillItem"><?php echo ucfirst($def['service_name']); ?></a></td>

    <?php }else { ?>

        <td><a href="<?=base_url() ?><?php echo $return_url."/".$def['bill_id']?>"><?php echo ucfirst($def['service_name']); ?></a></td>

    <?php } ?>

<td><?php echo ucfirst($def['description']); ?></td>
<td><?php echo number_format($def['unit_price'],2) ?></td>

<?php }?>
</tbody>

</table>
</div>
</div>
</section>
</div>
</div>



    <form name="addBillItemForm" id="addBillItemForm" action="<?= base_url() ?>index.php/billing/addItemJson" method="post">
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="addBillItem"
             class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">
                            &#10006;</button>
                        <h4 class="modal-title">Add Item</div>
                    <div class="modal-body" id="create-bill">


                        <div class="form-group">

                            <label for="exampleInputEmail1">Name</label>
                            <input type="hidden" id="drug_id" value="" name="bill_id"/>
                            <input type="hidden" id="current_reference" value="<?php if(isset($data["reference"]))echo $data["reference"]; ?>" name="current_reference"/>
                            <input type="hidden" id="patient_name" value="<?php if(isset($data["patient_name"]))echo $data["patient_name"]; ?>" name="patient_name"/>
                            <input class="form-control" disabled="disabled" type="text" name="drug_name" id="drug_name" value="Drug"/>
                        </div>

                        <div class="form-group">

                            <input type="hidden" id="patient_number"
                                   value="<?php echo $data["patient_number"]; ?>" name="patient_number"/>
                            <label for="qty"><span id="qty-label">Quantity</span></label>

                            <input class="form-control" type="number" name="qty" value="1"/>

                        </div>


                        <div class="form-group">

                            <label for="price"><span id="total-label">Total</span></label>

                            <input type="hidden" name="unit-price-input" id="unit-price-input" value=""/>
                            <input class="form-control" readonly="readonly" id="total" name="total" value="1"/>

                        </div>


                        <button type="button" id="add" class="btn btn-default"
                                onclick="javascript:addBill();">Add
                        </button>




                    </div>
                </div>
            </div>
        </div>


    </form>




    <form name="viewPatientBill" id="viewPatientBillForm" action="<?= base_url() ?>index.php/billing/addItemJson" method="post">

        <a id="post-option-select" data-toggle="modal" href="#selectDialogue" class=""></a>
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="selectDialogue"
             class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">
                            &#10006;</button>
                        <h4 class="modal-title">Add Item</div>
                    <div class="modal-body" id="dialogue">




                    </div>
                </div>
            </div>
        </div>


    </form>





</section>
</section>
 

<script>

    var currentReference = "";

    function formatCurrency(amount){
        var DecimalSeparator = Number("1.2").toLocaleString().substr(1,1);

        var AmountWithCommas = amount.toLocaleString();
        var arParts = String(AmountWithCommas).split(DecimalSeparator);
        var intPart = arParts[0];
        var decPart = (arParts.length > 1 ? arParts[1] : '');
        decPart = (decPart + '00').substr(0,2);

        return ''+ intPart + DecimalSeparator + decPart;

    }


    $("input[name=qty]").change(function(){

        var qty = $(this).val();
        var unitPrice = $("input#unit-price-input").val();
        var total = qty * unitPrice;
        $("input#total").val(formatCurrency(total));



    });

   $("a.addBillToUser").click(function(){
       $("input#drug_id").val($(this).attr("drug-id"));
       $("input#drug_name").val($(this).attr("drug-name"));
       $("input[name=qty]").val(1);

       var total = 1 * $(this).attr("unit-price");

       $("input#total").val(formatCurrency(total));
       $("input#unit-price-input").val($(this).attr("unit-price"));


       if($(this).attr("drug-name") === "Deposit" || $(this).attr("drug-name") === "deposit"){

           $("span#qty-label").html("Deposit Amount");

       }else{

           $("span#qty-label").html("Quantity");
       }
    });

    function addBill(){

        //check if the quantity is 0

        var qty = $("input[name=qty]").val();

        if(qty < 1){

            alert("Invalid quantity");
            return false;
        }

        $.isLoading({ text: "Loading" });


        var url = "<?=base_url()?>index.php/billing/apiCreateBill";

        $.ajax({
            type: "post",
            url: url,
            cache: false,
            data: $('form#addBillItemForm').serialize(),
            success: function (json) {
                try {
                    var obj = jQuery.parseJSON(json);

                    console.log(obj);
                    
                    if (obj['STATUS'] == true) {
                        //code
                        alertify.message(obj['description']);
                        currentReference = obj['reference'];
                        $("input#current_reference").val(currentReference);

                        if($("input#patient_number").val() == "WALK_IN_CUSTOMER"){

                            //enable the finish selection button
                            $("a#walkin-finish-btn").attr("href","<?=base_url()?>index.php/billing/nonCustomerBill/"+encodeURIComponent(currentReference));

                            $("a#walkin-finish-btn").css("display", "block");
                        }
                    }
                    else {
                        alertify.error(obj['description']);

                    }

                    $("button.close").click();


                    $.isLoading( "hide" );


                } catch (e) {
                    console.log('Exception while request..');
                    console.log(e);
                    $.isLoading( "hide" );
                    alertify.error('server error');


                }
            },
            error: function (e) {
                console.log('Error while request..');
                $.isLoading( "hide" );
                alertify.error('server error');


            }


        });


    }



</script>