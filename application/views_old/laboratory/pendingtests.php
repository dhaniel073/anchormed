
<section id="container" class="">

<section id="main-content">
<section class="wrapper site-min-height">
 
<div class="row">
<div class="col-lg-12">
<section class="panel">
<header class="panel-heading">
 Tests for <?php echo ucfirst($patient["first_name"])." ".ucfirst($patient["middle_name"])." ".ucfirst($patient["last_name"]); ?>
</header>
<div class="panel-body">
<div class="adv-table">
    
<table class="display table table-bordered table-striped" id="patients">
<thead>
    
    
<tr>
<th>Lab Test</th>
<th>Lab Sample Reference</th>
<th>Sample Type</th>
<th>Bill Reference</th>
<th>Bill Status</th>
<th>&nbsp;</th>

</tr>
</thead>
<tbody>
<?php foreach($orders as $order){ ?>
<tr class="gradeX">
    
    
<td><?php echo ucfirst($order['test_info']['name']); ?></td>
<td><?php echo ($order['sample']['sample_reference']); ?></td>
<td><?php echo ucfirst($order['sample_type']['name']); ?></td>
<td><?php  echo $order["reference_id"]; ?></td>
<td><?php  $status = $order["bill_info"][0]["status"];

$status_description = "Not Paid";
if($status == "P"  || $status == "H")
{
    $status_description = "Paid";
}

echo $status_description;

?></td>
<td><a sample_type="<?php echo $order["sample_type"]["sample_type_id"]?>" class="perform_test" id="<?php echo $order["order_id"]; ?>" href="#perform" data-toggle="modal">Publish Result</a></td>
</tr>

<?php }?>
</tbody>

</table>


<script>
    
    $(document).ready(function(){
            
            $("a.perform_test").click(function(){
                
                var id = $(this).attr("id");
                 var sampleType = $(this).attr("sample_type");
                 
                $("input#order_id").val(id);
                 $("input#sample_type").val(sampleType);
                
                });
        
        });
</script>


</div>

</div>
</section>
</div>
</div>
 

</section>
</section>



<form id="perform_test" method="post" action="<?=base_url() ?>index.php/laboratory/performTest">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="perform" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Publish Results</h4>
</div>
<div class="modal-body">


<div class="form-group">
<label for="exampleInputEmail1">Results</label>
   <textarea name="test_results" id="test_results" class="wysihtml5 form-control" rows="10"></textarea>
</div>




<input type="hidden" id="order_id" name="order_id" value=""/>
<input type="hidden" id="patient_number" value="<?php echo $patient["patient_number"]; ?>" name="patient_number"/>
<input type="hidden" id="sample_type" value="" name="sample_type"/>

  <button type="submit" id="btn_search"  class="btn btn-default" >Publish Results</button>
  
  

</div>
</div>
</div>
</div>
</form>
 