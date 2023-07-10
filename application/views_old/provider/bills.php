
<section id="container" class="">

<section id="main-content">
<section class="wrapper site-min-height">
 
<div class="row">
<div class="col-lg-12">
<section class="panel">
<header class="panel-heading">
<?php echo ucfirst($provider["hmo_name"])."'s Bills";?>
</header>
<div class="panel-body">
<div class="adv-table">
<table class="display table table-bordered table-striped" id="patients">
<thead>
    
    
<tr>
<th>Reference</th>
<th>Date</th>
<th>Amount</th>
<th>#</th>
<th>#</th>

</tr>
</thead>
<tbody>
<?php foreach($hmo_bills as $bill){ ?>
<tr class="gradeX">
    
    
<td><a data-toggle="modal" amount="<?php echo $bill['total_amount']; ?>" class="ref" ref="<?php echo $bill['reference_id']; ?>" href="#pay"><?php echo $bill['reference_id']; ?></a></td>
<td><?php echo $bill['date_created'];?></td>
<td><?php echo  $this->session->userdata("currency_symbol")." ". number_format($bill['total_amount'], 2); ?></td>

 <td><a href="<?=base_url()?>index.php/provider/breakdown/<?php echo $bill['reference_id'];?>">Bill Breakdown</a></td>
    <td><a data-toggle="modal" amount="<?php echo $bill['total_amount']; ?>" class="ref" ref="<?php echo $bill['reference_id']; ?>" href="#pay">Pay Bill</a></td>


</tr>

<?php }?>
</tbody>

</table>
</div>
</div>
</section>
</div>
</div>
 
</section>
</section>


<script>
    
    var originalAmount = 0;
    
    $(document).ready(function(){
        
        $("a.ref").click(function(){
            
               $("input#reference_id").val($(this).attr("ref"));
                originalAmount = $(this).attr("amount");
                $("input#amount").val(originalAmount);
                
                
            });
        
        });
</script>


<form id="payBill" method="post" action="<?=base_url() ?>index.php/provider/payBill">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="pay" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Log Provider Payment</h4>
</div>
<div class="modal-body">
    
<div class="form-group">
<label for="exampleInputEmail1">Amount</label>
<input type="text" class="form-control" name="amount" id="amount" placeholder="Amount">
<input type="hidden"  name="reference_id" id="reference_id" >
</div>


<div class="form-group">
<label for="exampleInputEmail1">Transaction Details</label>
<input type="text" class="form-control" name="payment_details" id="payment_details" placeholder="Transaction Details">
</div>



<button type="button" id="pay_bill" class="btn btn-default" onclick="javascript:payBill();">Pay Bill</button>

<script>
    
    
    function payBill() {



       var amount = parseFloat($("input#amount").val());

        console.log("original amount : " + originalAmount);
        console.log("bill amount : " + amount);
       

       if (!$.isNumeric(amount) || amount < 1) {
            
            alert("Invalid Amount");
            return false;
       }
       
       if (amount < originalAmount) {
        
            var confirmed = confirm("Amount is less than Bill amount, Do you want to make a partial payment ?");
            if (!confirmed) {
                return false;
            }           
       }

       else if(amount > originalAmount){
        
            alert("Invalid Amount : Amount is greater than Bill amount");
            return false;
       }
       
       $("form#payBill").submit();
       
       return true;
    }
</script>

</div>
</div>
</div>
</div>
</form>
 
 