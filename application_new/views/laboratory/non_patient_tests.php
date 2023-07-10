
<section id="container" class="">

<section id="main-content">
<section class="wrapper site-min-height">
 
<div class="row">
<div class="col-lg-12">
<section class="panel">
<header class="panel-heading">
    Lab Tests for <?php echo ucfirst($patient["first_name"])." ".ucfirst($patient["middle_name"])." ".ucfirst($patient["last_name"]); ?>
</header>
<div class="panel-body">
<div class="adv-table">
    
<table class="display table table-bordered table-striped" id="patients">
<thead>
    
    
<tr>
<th>Name</th>
<th>Lab Test</th>
<th>Date Performed</th>

</tr>
</thead>
<tbody>
<?php foreach($lab_results as $result){ ?>
<tr class="gradeX">
    
<td><a href="<?=base_url() ?>index.php/laboratory/result/<?php echo $result["id"];?>"><?php echo ucfirst($result['order_details']['name']); ?></a></td>
   
<td><a href="<?=base_url() ?>index.php/laboratory/result/<?php echo $result["id"];?>"><?php echo ucfirst($result['test_info']['name']); ?></a></td>
<td><?php  echo $result["date_created"]; ?></td>
</tr>

<?php }?>
</tbody>

</table>


<script>
    
    $(document).ready(function(){
            
            $("a.perform_test").click(function(){
                
                var id = $(this).attr("id");
                
                $("input#order_id").val(id);
                
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


 