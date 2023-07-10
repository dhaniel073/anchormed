
<section id="container" class="">

<section id="main-content">
<section class="wrapper site-min-height">

        <div class="row">

                <div class="col-lg-12">

                        <ul class="breadcrumb">
                                <li><a href="<?=base_url()?>index.php/provider"><i class="fa fa-home"></i> HMO Central</a></li>
                                <li><a href="<?=base_url()?>index.php/provider/view/<?php echo $provider["hmo_code"];?>"><?php echo ucfirst($provider["hmo_name"]); ?></a></li>
                                <li class="active">paid bills</li>
                        </ul>

                </div>
        </div>

        <div class="row">


        <div class="row">
<div class="col-lg-12">
<section class="panel">
<header class="panel-heading">
<?php echo ucfirst($provider["hmo_name"])."'s Bill Activity";?>
</header>
<div class="panel-body">
<div class="adv-table">
<table class="display table table-bordered table-striped" id="queue">
<thead>
    
    
<tr>
<th>Reference</th>
<th>Date</th>
<th>Amount Paid</th>
<th>Bill Amount</th>
<th>Status</th>
<th></th>
</tr>
</thead>
<tbody>
<?php foreach($hmo_bills as $bill){ ?>
<tr class="gradeX">
    
    
<td><a><?php echo $bill['reference_id']; ?></a></td>
<td><?php echo $bill['date_created'];?></td>
<td><?php echo  $this->session->userdata("currency_symbol")." ". number_format($bill['amount_paid']); ?></td>
<td><?php echo  $this->session->userdata("currency_symbol")." ". number_format($bill['total_amount']); ?></td>
<td><?php
        
        $status = "Full Payment";
        
        if($bill["status"] == "R")
        {
            $status = "Partial Payment";
        }
        
        echo $status;



?>


</td>
<td><a target="_blank" href="<?=base_url()?>index.php/provider/breakdown/<?php echo $bill['reference_id'];?>">Bill Breakdown</a></td>
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



 
 