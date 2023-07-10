<form name="dispenseForm" id="dispenseForm" method="post" action="<?=base_url()?>index.php/pharmacy/dispense">
    

<section id="container" class="">

<section id="main-content">
<section class="wrapper site-min-height">
 
<div class="row">
<div class="col-lg-12">
<section class="panel">
<header class="panel-heading">
Dispense Job
</header>
<div class="panel-body">
<div class="adv-table">
    
<table class="display table table-bordered table-striped" id="patients">
<thead>
    
    
<tr>
<th>Drug Name</th>
<th>Quantity to Dispense</th>
<th>Dispense Data</th>

</tr>
</thead>
<tbody>
<?php foreach($dispenseJobs as $job){ ?>
<tr class="gradeX">
    
    
<td><?php echo ucfirst($job['drug']['name']); ?></td>
<td><?php echo $job['qty']." ".ucfirst($job['drug_bill_form']['name'])."(s)";?></td>
<td><?php echo $job['dispense_data'];?></td>

</tr>

<?php }?>
</tbody>

</table>





</div>

</div>
</section>
</div>
</div>
 

 <input type="hidden" name="reference_id" value="<?php echo $reference_id; ?>"/>
<button type="button" id="dispense" class="btn btn-success" onclick="javascript:dispenseDrug();">Dispense</button>

<script>
    
    function dispenseDrug() {
        
       var dispense =  confirm("dispense job will be updated to dispensed status");
       
       if (dispense)
       {
            $("form#dispenseForm").submit();
       }
        //code
    }
</script>

</section>
</section>
 
 </form>
 