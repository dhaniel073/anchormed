
 
 
 
<section id="main-content">
<section class="wrapper">
  
<div class="row" style="min-height: 600px;">
    
    
<div class="col-lg-12">
<section class="panel">
<header class="panel-heading">
<?php echo ucfirst($lab_result["test_info"]["name"]). " result for ".ucfirst($patient['first_name'])." ".ucfirst($patient['middle_name'])." ".ucfirst($patient['last_name']);?>
<span class="tools pull-right">
<a href="javascript:;" class="fa fa-chevron-down"></a>
<a href="javascript:;" class="fa fa-times"></a>
</span>
</header>
<div class="panel-body">
 
  <!-- begining of form section-->
<section class="panel">

<div class="panel-body">

<p> Date : <?php echo $lab_result["date_created"]; ?></p>

<p> Result : <?php echo $lab_result["result"]; ?></p>

</div>
</section>
 <!-- end of form section-->
</div>
</section>
</div>




</div>



 
</section>
</section>



