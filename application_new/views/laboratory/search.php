
<section id="container" class="">

<section id="main-content">
<section class="wrapper site-min-height">
 
     <div class="row">
<div class="col-lg-12">
 
<ul class="breadcrumb">
<li><a href="<?=base_url()?>index.php/laboratory"><i class="fa fa-home"></i> Laboratory</a></li>
<li><a href="#">search</a></li>


</ul>
</div>

</div>
     
     
<div class="row">
<div class="col-lg-12">
<section class="panel">
<header class="panel-heading">
Lab Test Search Results
</header>
<div class="panel-body">
<div class="adv-table">
    
<table class="display table table-bordered table-striped" id="patients">
<thead>
    
    
<tr>
<th>Name</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<?php foreach($labs as $lab){ ?>
<tr class="gradeX">
  <?php if(isset($return_base)  && $return_base != "")
  { ?>
  
  <td><a href="<?php echo $return_base;?>/<?php echo $lab['lab_id']; ?>"><?php echo $lab['name']; ?></a></td>
  <?php
    }else {
        ?>  
<td><a href="<?=base_url() ?>index.php/laboratory/view/<?php echo $lab['lab_id']; ?>"><?php echo $lab['name']; ?></a></td>
<?php }?>

<td><?php if(isset($lab['description']))echo ucfirst($lab['description'])?></td>


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
 
 