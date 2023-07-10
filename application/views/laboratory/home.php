

 
 
 
<section id="main-content" >
<section class="wrapper">
 
<div class="row" >
    
    
<div class="col-lg-12" style="margin-top:100px;margin-bottom:100px;">
<section class="panel">
<header class="panel-heading">
Laboratory
<span class="tools pull-right">
<a href="javascript:;" class="fa fa-chevron-down"></a>
<a href="javascript:;" class="fa fa-times"></a>
</span>
</header>
<div class="panel-body" style="margin-top:50px;">


<div style="width:100%; text-align: center; margin-bottom:200px;">
   
    <a  href="#current_orders" id="get_orders" data-toggle="modal">
       <div class="option-icon">
        <span class="badge bg-warning nofication_count" id="order_count">0</span>
        <i class="fa fa-list-alt fa-5x"></i>
        
        <p>Order Management</p>
       
    </div>
   </a>
    
     <a  href="<?=base_url()?>index.php/laboratory/createSampleType" >
       <div class="option-icon">
        <i class="fa fa-plus-circle fa-5x"></i>
        
        <p>Define New Sample Type</p>
       
    </div>
   </a>
       
     <a  href="<?=base_url()?>index.php/laboratory/add" >
       <div class="option-icon">
        <i class="fa fa-plus-circle fa-5x"></i>
        
        <p>Create New Test Type</p>
       
    </div>
   </a>
    
  <a  href="#search"  data-toggle="modal">
       <div class="option-icon">
        <i class="fa fa-search fa-5x"></i>
        
        <p>Search Tests</p>
       
    </div>
   </a>
   
   
  <a  href="#perform"  data-toggle="modal">
       <div class="option-icon">
        <i class="fa fa-edit fa-5x"></i>
        
        <p>Record Test Sample</p>
       
    </div>
 </a>
  
  
    <a  href="#publish"  data-toggle="modal">
       <div class="option-icon">
        <i class="fa fa-inbox fa-5x"></i>
        
        <p>Publish Test Results</p>
       
    </div>
 </a>
   
   
   
   
   <a  href="#searchSample"  data-toggle="modal">
       <div class="option-icon">
        <i class="fa fa-search fa-5x"></i>
        
        <p>Search Sample Types</p>
       
    </div>
   </a>
   
   
      
   <a  href="#searchUnregisteredResults"  data-toggle="modal">
       <div class="option-icon">
        <i class="fa fa-search fa-5x"></i>
        
        <p>Non Customer Results</p>
       
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





</div>
</div>
</div>
</div>

</section>
</section>


<form id="searchUnregisteredResultsForm" method="post" action="<?=base_url() ?>index.php/laboratory/viewNonPatientTests">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="searchUnregisteredResults" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Find Non patient Results</h4>
</div>
<div class="modal-body">
<div class="form-group">
<label for="exampleInputEmail1">Patient Name</label>
<input type="text" class="form-control" name="name" id="result_name" placeholder="Patient Name">
</div>

<button type="button" onclick="javascript:searchResults();" id="btn_search" class="btn btn-default" >Search</button>
  
  
  <script>
    
   function searchResults() {
        
        if ($.trim($("input#result_name").val()) == "") {
        alert("Enter walk in patient name");
       }      
       
       else
       {
         $("form#searchUnregisteredResultsForm").submit();
         
       }
    }
    
    
    
  </script>

</div>
</div>
</div>
</div>
</form>



<form id="findJob" method="post" action="<?=base_url() ?>index.php/patient/search">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="perform" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Perform Laboratory Test</h4>
</div>
<div class="modal-body">

<div class="form-group">
<label for="exampleInputEmail1">Patient Name</label>
<input type="text" class="form-control" name="name" id="name" placeholder="Patient Name">
</div>


<input type="hidden" name="return_base" value="<?=base_url() ?>index.php/laboratory/getLabJobs"/>

<button type="submit" id="btn_search" class="btn btn-default" >Search</button>

<hr/>
  
<div class="form-group">
<label for="exampleInputEmail1">Walk In Patient</label>
<input type="text" class="form-control" name="walk_in" id="walk_in" placeholder="Walk in Name">
</div>

<button type="button" onclick="javascript:findWalkInJob();" id="btn_search" class="btn btn-default" >Search</button>
  
<script>
    
    function findWalkInJob() {
        
       if ($.trim($("input#walk_in").val()) == "") {
        alert("enter walk in patient name");
       }      
       
       else
       {
         $("input#name").val($("input#walk_in").val());
         $("form#findJob").attr("action","<?=base_url() ?>index.php/laboratory/findNonPatientJob").submit();
         
       }
    }
</script>
</div>
</div>
</div>
</div>
</form>


<form id="reusltpost" method="post" action="<?=base_url() ?>index.php/patient/search">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="publish" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Pubish Laboratory Test Results</h4>
</div>
<div class="modal-body">
<div class="form-group">
<label for="exampleInputEmail1">Patient Name</label>
<input type="text" class="form-control" name="name" id="name" placeholder="Patient Name">
</div>
<input type="hidden" name="return_base" value="<?=base_url() ?>index.php/laboratory/getCollectedSamplesNeedingResult"/>

  <button type="submit" id="btn_search" class="btn btn-default" >Search</button>
  
  
  <hr/>
  
<div class="form-group">
<label for="exampleInputEmail1">Walk In Patient</label>
<input type="text" class="form-control" name="walk_in_publish" id="walk_in_publish" placeholder="Walk in Name">
</div>

<button type="button" onclick="javascript:findWalkInJobToPublish();" id="btn_search" class="btn btn-default" >Search</button>
  
  <script>
    
    var returnBase = "<?=base_url()?>index.php/laboratory/getNonPatientCollectedSample";  
    
    function findWalkInJobToPublish() {
        
        if ($.trim($("input#walk_in_publish").val()) == "") {
        alert("enter walk in patient name");
       }      
       
       else
       {
         $("input#name").val($("input#walk_in_publish").val());
         $("input[name=return_base]").val(returnBase);
         $("form#reusltpost").attr("action","<?=base_url() ?>index.php/laboratory/findNonPatientJob").submit();
         
       }
    }
    
    
    
  </script>

</div>
</div>
</div>
</div>
</form>


<form id="findSampleType" method="post" action="<?=base_url() ?>index.php/laboratory/searchSampleType">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="searchSample" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Find Sample Type</h4>
</div>
<div class="modal-body">
<div class="form-group">
<label for="exampleInputEmail1">Sample Type</label>
<input type="text" class="form-control" name="name" id="name" placeholder="Sample Type">
</div>

  <button type="submit" id="btn_search" class="btn btn-default" >Search</button>
  
  

</div>
</div>
</div>
</div>
</form>




<form id="findJob" method="post" action="<?=base_url() ?>index.php/laboratory/search">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="search" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Find Laboratory test</h4>
</div>
<div class="modal-body">
<form role="form" id="add-new-occupation"  name="add-new-occupation" method="post" action="text.php">
<div class="form-group">
<label for="exampleInputEmail1">Test Name</label>
<input type="text" class="form-control" name="name" id="name" placeholder="Test Name">
</div>

  <button type="submit" id="btn_search" class="btn btn-default" >Search</button>
  
  


</form>
</div>
</div>
</div>
</div>
</form>



<!------------------------------------------------ Order Management ---------------------------------------------------------->



<form name="get_orders" method="post" action="<?=base_url() ?>index.php/workbench/getOrdersJson">

<a id="viewday" href="#user_appointment" data-toggle="modal"></a>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="current_orders" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Pending Orders</h4>
</div>
<div class="modal-body">


        <div class="form-group">
        
<label for="exampleInputEmail1"></label>

                <table class="display table table-bordered table-striped" id="">
                <thead>
                    
                    
                <tr>
                <th>Name</th>
                <th>Order Time</th>
                <th>Ordered By</th>
                </tr>
                </thead>
                <tbody id='order_body'>
                   
                </tbody>
                
                </table>
                
              
        </div>
    


<script>
    
   
     var isclicked = false;
     
     
     function performTest(patient_history_id, id){
                          if (!isclicked) {
                            
                            isclicked = true; 
                            
                            //alert($(this).attr("task_id"));
                            var performed = confirm("View Lab Request");
                            if (performed) {
                                //code
                               
                               $("input#v_patient_history_id").val(patient_history_id);
                               $("input#v_order_id").val(id);
                             
                               $("form#viewLabOrder").submit();
                            }
                            
                            isclicked = false; 
                          }
                           
            }
            
            
    
    function getQueueList() {
        
        
        var url = "<?= base_url() ?>"+"index.php/workbench/getOrdersJson";
        $("tbody#order_body").html("");
        
        //$("tbody.roaster_body").html("");
        
        $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#getLabOrders').serialize(),
		success: function(json){
		try{
			var obj = jQuery.parseJSON(json);
			//alert( obj['STATUS']);
                        for (var i =0; i < obj.length; i++) {
                            //code
                            
            $("tbody#order_body").append("<tr><td><a class='single_order' onclick='javascript:performTest(\""+obj[i]['patient_history_id']+"\",\""+obj[i]['id']+"\")' href='#'>"+obj[i]['first_name']+" "+obj[i]['last_name']+"</a></td><td>"+obj[i]['date_created']+"</td><td>"+obj[i]['ordered_by']+"</td></tr>");
                         
                          
                    
                        
                        
                        }
            	
                        		
			
		}catch(e) {		
			 console.log('Exception while request..');
                        console.log(e);
                        
		}		
		},
		error: function(){						
			 console.log('Error while request..');
		}
                
                 });
    }
    
    
     $(document).ready(function(){
        
        $("a#get_orders").click(function(){
            
            
                getQueueList();
            });
        
        
        
        
        
        });
    
</script>


</div>
</div>
</div>
</div>
</form>

<script>
    
      window.setInterval(function(){
        
        getLabPendingTaskCount();
        
        
        }, 10000);
      
      $(document).ready(function(){
        
        getLabPendingTaskCount();
        
        });
      
    
    function getLabPendingTaskCount() {
       var url = "<?= base_url() ?>"+"index.php/workbench/getLabPendingTasksJson";
       
       $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#count').serialize(),
		success: function(json){
		try{
			var obj = jQuery.parseJSON(json);
			//alert( obj['STATUS']);
                      //  alert( $("span#order_count").html());
            	
                $("span#order_count").html(obj["total"]);
                        		
			
		}catch(e) {		
			//alert('Exception while request..');
                        console.log(e);
                        
		}		
		},
		error: function(){						
			//alert('Error while request..');
		}
                
                 });
    }
</script>
 
 
 <form name="getLabOrders" id="getLabOrders" method="post" >
    
    <input name="dept" value="lab" type="hidden"/>
    
 </form>
 
 
 
  <form name="viewLabOrder" id="viewLabOrder" method="post" action="<?=base_url()?>index.php/workbench/getHistorySpecific">
    
    <input name="patient_history_id" id="v_patient_history_id" type="hidden"/>
    <input name="order_id" id="v_order_id" type="hidden"/>
    <input name="action_type" value="lab" type="hidden"/>
    
 </form>