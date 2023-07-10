
<section id="container" class="">

<section id="main-content">
<section class="wrapper site-min-height">

    <div class="row">

        <div class="col-lg-12">

            <ul class="breadcrumb">
                <li><a href="#">Cashier</a></li>
                <li class="active">search</li>
            </ul>

        </div>
    </div>

    <div class="row">




    <div class="row">
<div class="col-lg-12">
<section class="panel">
<header class="panel-heading">
Pending Bills
</header>
<div class="panel-body">
<div class="adv-table">
    
<table class="display table table-bordered table-striped" id="patients">
<thead>
    
    
<tr>
<th>Reference</th>
<th>Name</th>
<th>Patient Number</th>
<th>Type</th>
<th>Date</th>
<th>Total</th>
<th>Amount Due</th>
</tr>
</thead>
<tbody>
<?php foreach($unposted as $bill){ ?>


<tr class="gradeX">
<?php if($bill['patient_number'] == NON_CUSTOMER_ID){?>

<td><a href="<?=base_url()?>index.php/billing/nonCustomerBill/<?php echo $bill['reference_id'];?>/1" target="_blank"><?php echo $bill['reference_id']; ?></a></td>

<td><?php echo ucfirst($bill['first_name'])." ".ucfirst($bill['last_name']); ?></td>

<td>N/A</td>

<?php } else{?>
<td><a target="_blank" href="<?php if($bill['status'] != "R"){?><?=base_url()?>index.php/billing/currentBill/<?php echo $bill['patient_number']."/1";} else  {?> <?=base_url()?>index.php/billing/partialPaymentUpdate/<?php echo $bill['reference_id']."/1"; }?>"><?php echo $bill['reference_id']; ?></a></td>

<td><?php echo ucfirst($bill['first_name'])." ".ucfirst($bill['last_name']); ?></td>

<td><?php echo $bill['patient_number']; ?></td>

<?php } ?>


<td><?php if($bill['status'] == "R")echo "Partial Payment"; else echo "New"; ?></td>
<td><?php  echo $bill['date_created']; ?></td>

<td><?php echo $bill['patient_total'] ?></td>

<td><?php echo  ($bill['patient_total']) - ($bill['patient_partial_payment']) ?></td>


</tr>

<?php } ?>
</tbody>

</table>
</div>
</div>
</section>
</div>
</div>
 
</section>
</section>
 


