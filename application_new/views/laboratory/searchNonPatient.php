
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
Lab Walk In Patient Search
</header>
<div class="panel-body">
<div class="adv-table">
    
<table class="display table table-bordered table-striped" id="patients">
<thead>
    
    
<tr>
<th>Reference</th>
<th>Name</th>
</tr>
</thead>
<tbody>
<?php foreach($walk_in_patients as $order){ ?>
<tr class="gradeX">
 
 <?php if(isset($return_base)){?>
 <td><a href="<?php echo $return_base; ?>/<?php echo $order['reference_id']; ?>"><?php echo $order['reference_id']; ?></a></td>

 <?php }else { ?>
<td><a href="<?=base_url() ?>index.php/laboratory/getWalkInLabJob/<?php echo $order['reference_id']; ?>"><?php echo $order['reference_id']; ?></a></td>
<?php } ?>

<td><?php if(isset($order['name']))echo ucfirst($order['name'])?></td>


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
 
 