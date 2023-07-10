
<section id="container" class="">

<section id="main-content">
<section class="wrapper site-min-height">
 
<div class="row">
<div class="col-lg-12">
<section class="panel">
<header class="panel-heading">
Patient Search Results
</header>
<div class="panel-body">
<div class="adv-table">
    
<table class="display table table-bordered table-striped" id="patients">
<thead>
    
    
<tr>
<th>File Number</th>
<th>Name</th>
<th>Type</th>
<th>HMO</th>
<th>Enrollee ID</th>
<th>Sex</th>
</tr>
</thead>
<tbody>
<?php foreach($patients as $patient){ ?>
<tr class="gradeX">
  <?php if(isset($return_base)  && $return_base != "")
  { ?>
  
  <td><a href="<?php echo $return_base;?>/<?php echo $patient['patient_number']; ?>"><?php echo $patient['patient_number']; ?></a></td>
  <?php
    }else {
        ?>  
<td><a href="<?=base_url() ?>index.php/patient/number/<?php echo $patient['patient_number']; ?>"><?php echo $patient['patient_number']; ?></a></td>
<?php }?>
<td><?php echo ucfirst($patient['first_name'])." ".ucfirst($patient['middle_name'])." ".ucfirst($patient['last_name']); ?></td>
<td><?php

foreach($patient_types as $type)
{
    if($type['patient_type_code'] == $patient['patient_type_code'])
    {
        echo $type['patient_type_name'];
    }
}



?></td>
<td><?php

if(isset($patient['hmo_code'])){
	if(isset($providers)){
		foreach($providers as $hmodetails)
		{
			if($hmodetails['hmo_code'] == $patient['hmo_code'])
			{
				if(isset($hmodetails['hmo_name'])) {echo $hmodetails['hmo_name'];}
			}
		}
	}
}



?></td>
<td><?php echo $patient['hmo_enrolee_id']; ?></td>
<td><?php echo $patient['sex']; ?></td>
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
 
 