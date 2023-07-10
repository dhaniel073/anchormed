
<section id="container" class="">

<section id="main-content">
<section class="wrapper site-min-height">
 
<div class="row">
<div class="col-lg-12">
<section class="panel">
<header class="panel-heading">
Patient Processed Bills
</header>
<div class="panel-body">
<div class="adv-table">
<table class="display table table-bordered table-striped" id="patients">
<thead>
    
    
<tr>
<th>Reference</th>
<th>Date</th>
<th>Name</th>
<th>Amount</th>

</tr>
</thead>
<tbody>
<?php foreach($bills as $bill){ ?>
<tr class="gradeX">
    
    
<td><?php if(isset($bill["patient"]) && $bill["patient"]["patient_number"]==NON_CUSTOMER_ID){?>
<a href="<?=base_url() ?>index.php/billing/nonCustomerBill/<?php echo $bill['reference_id']; ?>">
<?php }else {?>
<a href="<?=base_url() ?>index.php/billing/viewBill/<?php echo $bill['reference_id']; ?>">
<?php }?>
<?php echo $bill['reference_id']; ?>
</a></td>
<td><?php echo $bill['date_posted'];?></td>
<td> <?php if(isset($patient) && $patient["patient_number"] != ""){?><?php echo ucfirst($patient['first_name'])." ".ucfirst($patient['middle_name'])." ".ucfirst($patient['last_name']); ?><?php } else { echo ucfirst($bill["patient"]["first_name"])." ".ucfirst($bill["patient"]["last_name"]); }?></td>

<td><?php echo number_format($bill['total_amount']); ?></td>
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
 
 