
<section id="container" class="">

<section id="main-content">
<section class="wrapper site-min-height">
 
     <div class="row">
<div class="col-lg-12">
 
<ul class="breadcrumb">
<li><a href="<?=base_url()?>index.php/pharmacy"><i class="fa fa-home"></i> Pharmacy</a></li>
<li><a href="#">search</a></li>


</ul>
</div>

</div>
     
     
<div class="row">
<div class="col-lg-12">
<section class="panel">
<header class="panel-heading">
Pharmacy Drug Search Results
</header>
<div class="panel-body">
<div class="adv-table">
    
<table class="display table table-bordered table-striped" id="patients">
<thead>
    
    
<tr>
<th>Name</th>
<th>Manufacturer</th>
<th>Packaging</th>
<th>Dosage Form</th>
</tr>
</thead>
<tbody>
<?php foreach($drugs as $drug){ ?>
<tr class="gradeX">
  <?php if(isset($return_base)  && $return_base != "")
  { ?>
  
  <td><a href="<?php echo $return_base;?>/<?php echo $drug['drug_id']; ?>"><?php echo $drug['name']; ?></a></td>
  <?php
    }else {
        ?>  
<td><a href="<?=base_url() ?>index.php/pharmacy/view/<?php echo $drug['drug_id']; ?>"><?php echo $drug['name']; ?></a></td>
<?php }?>

<td><?php echo ucfirst($drug['manufacturer'])?></td>
<td><?php echo $drug['packaging_description']; ?></td>
<td><?php

foreach($drug_presentations as $presentation)
{
    if($presentation['drug_presentation_id'] == $drug['drug_presentation_id'])
    {
        echo $presentation['name'];
    }
}



?></td>


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
 
 