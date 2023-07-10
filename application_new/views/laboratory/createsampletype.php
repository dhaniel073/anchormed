
 
 
 
<section id="main-content">
<section class="wrapper">
  
<div class="row" style="min-height: 600px;">
    
    
<div class="col-lg-12">
<section class="panel">
<header class="panel-heading">
Laboratory Sample Type Creation Form
<span class="tools pull-right">
<a href="javascript:;" class="fa fa-chevron-down"></a>
<a href="javascript:;" class="fa fa-times"></a>
</span>
</header>
<div class="panel-body">
 
  <!-- begining of form section-->
<section class="panel">

<div class="panel-body">
<div class="stepy-tab">
<ul id="default-titles" class="stepy-titles clearfix">
<li id="default-title-0" class="current-step">
<div>Sample Type Info</div>
</li>
<li id="default-title-1" class="">
<div>Step 2</div>
</li>
<li id="default-title-2" class="">
<div>Step 3</div>
</li>
</ul>
</div>
<!--form class="form-horizontal" id="default"-->

<?php echo validation_errors(); ?>

<?php echo form_open('laboratory/createSampleType') ?>
    

<fieldset title="Drug Info" class="step" id="default-step-0">
    
<legend> </legend>
<div class="form-group">
    <label class="col-lg-2 control-label">Name</label>
    <div class="col-lg-10"> 
    <input name="name" value="<?php  if(isset($name))echo $name; ?>" id="name" type="text" class="form-control" placeholder="Name">
    </div>
</div>


<div class="form-group">
    <label class="col-lg-2 control-label">Description</label>
    <div class="col-lg-10"> 
    <input name="description" value="<?php  if(isset($description))echo $description; ?>" id="description" type="text" class="form-control" placeholder="Description">
    </div>
</div>


</fieldset>






<input type="button" class="finish btn btn-success"  value="Create"/>


</form>
</div>
</section>
 <!-- end of form section-->
</div>
</section>
</div>




</div>



 
</section>
</section>

<script src="<?= base_url() ?>assets/js/jquery.stepy.js"></script>



<script>

    //step wizard

    $(function() {
        $('#default').stepy({
            backLabel: 'Previous',
            block: true,
            nextLabel: 'Next',
            titleClick: true,
            titleTarget: '.stepy-tab'
        });
    });
</script>


