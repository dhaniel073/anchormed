
<section id="container" class="">

<section id="main-content">
<section class="wrapper site-min-height">
 
<div class="row">
<div class="col-lg-12">
<section class="panel">
<header class="panel-heading">
Legacy Medical Report
</header>
<div class="panel-body">
<div class="adv-table">
    
<table class="table table-hover">
<thead>
<tr>
<th>#</th>
<th>Date</th>
<th>Description</th>
<th>Doctor's Note</th>
<th>Doctor</th>
</tr>
</thead> 




    <?php foreach($legacymedicalhistory as $legacymedicalhistories){?>
		<tr>
			<td><?php echo $legacymedicalhistories['patient_history_id']; ?></td>
			<td><?php echo $legacymedicalhistories['date_created']; ?></td>
			<td><?php echo $legacymedicalhistories['description']; ?></td>
			<td><?php echo $legacymedicalhistories['doctors_notes']; ?></td>
			<td><?php foreach($doctors as $doctor){ if($legacymedicalhistories['consulting_doctor'] == $doctor['staff_no']){echo ucfirst($doctor['first_name'])." ".ucfirst($doctor['last_name']); break;}} ?></td>

		</tr>

     <?php }?>

</table>


</div>
</div>
</div>
</div>




 
 