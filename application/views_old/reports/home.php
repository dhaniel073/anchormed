

 
 
 
<section id="main-content" >
<section class="wrapper">
 
<div class="row" >
    
    
<div class="col-lg-12" style="margin-top:100px;margin-bottom:100px;">
<section class="panel">
<header class="panel-heading">
Reports
<span class="tools pull-right">
<a href="javascript:;" class="fa fa-chevron-down"></a>
<a href="javascript:;" class="fa fa-times"></a>
</span>
</header>
<div class="panel-body" style="margin-top:50px;">


<div style="width:100%; text-align: center; margin-bottom:200px;">
   


    <a  href="#reports" data-toggle="modal" >
       <div class="option-icon">
        <i class="fa fa-file-excel-o fa-5x"></i>
        <p>Reports</p>
        
    </div>
   </a>
    
    
      
      
 

<div class="option-icon">
       
        <p>&nbsp;</p>
        
    </div>

  
 
  
       
          
    
       
       
      
      
</div>

</div>
</section>
</div>




   


</div>

<!--------Begining of create provider dialogue--------------------------------------->
<form name="processReport"  action="<?=base_url()?>index.php/reports/process" method="post">
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="reports" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title"><span id='dia_title'>Generate Report</span> </h4>
</div>
<div class="modal-body">
 


 
 
 <div class="form-group">
<label for="exampleInputEmail1">Select Report</label>

<select class="form-control" name="report_id" id="report_id">
    <option value="">Select A Report</option>
    <?php foreach($reports as $report) {?>
    
            <option value="<?php echo $report["report_id"]; ?>"><?php echo ucfirst($report["report_name"]); ?></option>
     <?php } ?>
     
      <?php foreach($reports as $report) {?>
     <input type="hidden" value="<?php echo $report["report_params"]; ?>" name="req_param_<?php echo $report["report_id"]; ?>" id="req_param_<?php echo $report["report_id"]; ?>"/>
     <?php } ?>

</select>
</div>
 
 <?php
        foreach($report_params as $param)
        {
            echo $param;
        }
 ?>

<script>
    
    function initParams() {
         $("div.report-param input, div.report-param input").attr("disabled", "disabled");
        $("div.report-param").hide();
    }
    $(document).ready(function(){
        
                initParams();               
                
                $("select#report_id").change(function(){
                    initParams();
                    var id = $(this).val();
                    
                    if (id != "")
                    {
                      // alert($("input#req_param_"+id).val());
                       var params = $("input#req_param_"+id).val().split(",");
                       
                       
                       for (var i = 0; i < params.length; i++) {
                          
                          $("div[report_id="+params[i]+"] input, div[report_id="+params[i]+"] select").removeAttr("disabled");
                          $("div[report_id="+params[i]+"]").show();
                       }
                    }
                                          
                    });
                
        });
</script>
 
  
  <button type="button" class="btn btn-success" onclick="javascript:generateReport();">Generate</button>
   </form>

   <script>
    
     function generateReport() {
        
        var id = $("select#report_id").val();
        
        if (id != "") {
            
            $("form[name=processReport]").submit();
        }
        else
        
        {
            alert("Select a Report");
        }
     }
    
   </script>
 
    
</div>
</div>
</div>
</div>

</section>
</section>
 