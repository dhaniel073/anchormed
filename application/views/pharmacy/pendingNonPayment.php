
<section id="container" class="">

<section id="main-content">
<section class="wrapper site-min-height">
 
<div class="row">
<div class="col-lg-12">
<section class="panel">
<header class="panel-heading">
Pending Dispense Jobs
</header>
<div class="panel-body">
<div class="adv-table">
<table class="display table table-bordered table-striped" id="patients">
<thead>
    
    
<tr>
<th>Reference</th>
<th>Order Date</th>
<th>Name</th>
<th>Status</th>
</tr>
</thead>
<tbody>
<?php foreach($bills as $bill){ ?>
<tr class="gradeX">
    
    
<td><a href="<?=base_url() ?>index.php/pharmacy/generateDispenseJob/<?php echo $bill['reference_id']; ?>"><?php echo $bill['reference_id']; ?></a></td>
<td><?php echo $bill['date_created'];?></td>
<td><?php echo  $bill['name']; ?></td>
<td><span style="color:<?php if($bill['status'] == "P") echo "#71be3c"; else echo "#FF6C60;";?>"><?php if($bill['status'] == "R") echo  "Partially Paid"; else if($bill['status'] == "P") echo "Paid"; else  echo "Not Paid"; ?></span></td>


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
 
 