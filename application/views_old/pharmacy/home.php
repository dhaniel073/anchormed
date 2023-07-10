

 
 
 
<section id="main-content" >
<section class="wrapper">
 
<div class="row" >
    
    
<div class="col-lg-12" style="margin-top:100px;margin-bottom:100px;">
<section class="panel">
<header class="panel-heading">
Pharmacy
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
    

      
 
    <a  href="<?=base_url()?>index.php/pharmacy/add">
        <div class="option-icon">       
        <i class="fa fa-plus fa-5x"></i>
        <p>Add New Drug</p>
        
        </div>
    </a>
          
    
    
    <a  href="#search_drug" id="find_drug" data-toggle="modal">
        <div class="option-icon">       
        <i class="fa fa-search fa-5x"></i>
        <p>Find Drug</p>
        
        </div>
    </a>
       
       
     <a  data-toggle="modal" href="#dispenseJobSearch">
        <div class="option-icon">       
        <i class="fa fa-shopping-cart fa-5x"></i>
        <p>Dispense</p>
        
        </div>
    </a>
       
     <?php
       
       if($dispense_without_payment)
       {
       
       ?>
       
    <a  data-toggle="modal" href="#dispenseJobFullSearch">
        <div class="option-icon">       
        <i class="fa fa-shopping-cart fa-5x"></i>
        <p>Dispense Without Payment</p>
        
        </div>
    </a>
       
       
       <?php
       }
              
       ?> 
       
      
      
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


<!------------------------------------------------ Pharmacy search bar ------------------------------------------------------->

<form name="find_drugs" method="post" action="<?=base_url() ?>index.php/pharmacy/search">

<a id="viewday" href="#user_appointment" data-toggle="modal"></a>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="search_drug" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Search</h4>
</div>


<div class="modal-body">
  
            <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Name">
          </div>
            
            
     <button type="submit" id="find_all_hmo_patients" class="btn btn-default" onclick="javascript:findDrug();">Search</button>


</div>



</div>
</div>
</div>
</form>




<form id="findJob2" method="post" action="<?=base_url() ?>index.php/pharmacy/findFullDispenseJob">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="dispenseJobFullSearch" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Find Dispense Job</h4>
</div>
<div class="modal-body">
    
<!--<div class="form-group">
<label for="exampleInputEmail1">Bill Reference</label>
<input type="text" class="form-control" name="reference_id" id="reference_id" placeholder="Bill Reference">
</div>-->
<div id="occupation-create-error"></div>
<button type="button" id="find_reference" class="btn btn-default" onclick="javascript:findAllUnpaid();">Find All Unpaid Dispense Job</button>
<hr/>

<input type="hidden" name="return_base" value="<?=base_url() ?>index.php/pharmacy/findFullDispenseJob"/>
  
  <div class="form-group">
<label for="exampleInputEmail1">Patient</label>
<input type="text" class="form-control" name="name" id="job_name_2" placeholder="Name">
</div>
  
   <button type="button" id="find_by_patient" class="btn btn-default" onclick="javascript:findRefByName2();">Find Job</button>
 
  
  <hr/>

  
  <div class="form-group">
<label for="exampleInputEmail1">Walk In Patient</label>
<input type="text" class="form-control" name="walk_in_name" id="walk_in_patient_name" placeholder="Walk in Name">
</div>
  
  <button type="button" id="find_by_walk_in" class="btn btn-default" onclick="javascript:findByWalkInName();">Find Job</button>
  
  
<script>
    
    function findByWalkInName() {
        
       var name = $("input#walk_in_patient_name").val();
       
       if ($.trim(name) == "")
       {
         alert("Please enter Walk in patient name");
       }
       else
       {
         $("form#findJob2").attr("action", "<?=base_url() ?>index.php/pharmacy/findNonPatientJob");
         $("form#findJob2").submit();
       }
    }
    
    function findRefByName2() {
        
        var name = $("input#job_name_2").val();
      
        if ($.trim(name) == "")
        {
           alert("Please enter patient name or number");
        }
        else
        {
            $("form#findJob2").attr("action", "<?=base_url() ?>index.php/patient/search");
            $("form#findJob2").submit();
        }
    }
    
    function findAllUnpaid() {

        $("form#findJob2").attr("action", "<?=base_url() ?>index.php/pharmacy/findAllPendingDispenseJobs");
        $("form#findJob2").submit();
        
    }

</script>


</div>
</div>
</div>
</div>
</form>




<form id="findJob" method="post" action="<?=base_url() ?>index.php/pharmacy/findDispenseJob">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="dispenseJobSearch" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Find Dispense Job</h4>
</div>
<div class="modal-body">
<form role="form" id="add-new-occupation"  name="add-new-occupation" method="post" action="text.php">
<!--<div class="form-group">
<label for="exampleInputEmail1">Bill Reference</label>
<input type="text" class="form-control" name="reference_id" id="reference_id" placeholder="Bill Reference">
</div>-->
<div id="occupation-create-error"></div>
<button type="button" id="find_reference" class="btn btn-default" onclick="javascript:findAll();">Find All Dispense Job</button>
<hr/>

<input type="hidden" name="return_base" value="<?=base_url() ?>index.php/pharmacy/findDispenseJob"/>
  
  <div class="form-group">
<label for="exampleInputEmail1">Patient</label>
<input type="text" class="form-control" name="name" id="job_name" placeholder="Name">
</div>
  
  <button type="button" id="find_by_patient" class="btn btn-default" onclick="javascript:findRefByName();">Find Job</button>
  
  <hr/>

  
  <div class="form-group">
<label for="exampleInputEmail1">Walk In Patient</label>
<input type="text" class="form-control" name="walk_in_name" id="walk_in_patient" placeholder="Name">
</div>
  
  <button type="button" id="find_by_patient" class="btn btn-default" onclick="javascript:findByWalkInByName();">Find Job</button>
  
  
  
<script>
    
    //findPaidNonPatientJob
    
    function findByWalkInByName() {
        
        var name = $("input#walk_in_patient").val();
        
         if ($.trim(name) == "")
            {
               alert("Please enter Walk in Patient name");
            }
            else
            {
                $("form#findJob").attr("action", "<?=base_url() ?>index.php/pharmacy/findPaidNonPatientJob");
                $("form#findJob").submit();
            }   
    }
    function findRefByName() {
        
        var name = $("input#job_name").val();
      
        if ($.trim(name) == "")
        {
           alert("Please enter patient name or number");
        }
        else
        {
            $("form#findJob").attr("action", "<?=base_url() ?>index.php/patient/search");
            $("form#findJob").submit();
        }
    }
    
    function findAll() {

        $("form#findJob").attr("action", "<?=base_url() ?>index.php/pharmacy/findAllPaidPendingDispenseJobs");
        $("form#findJob").submit();
    }

</script>


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
                            var performed = confirm("View Pharmacy Request");
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
        
        getPharmacyPendingTaskCount();
        
        
        }, 10000);
      
      $(document).ready(function(){
        
        getPharmacyPendingTaskCount();
        
        });
      
    
    function getPharmacyPendingTaskCount() {
       var url = "<?= base_url() ?>"+"index.php/workbench/getPharmacyPendingTasksJson";
       
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
    
    <input name="dept" value="drugs" type="hidden"/>
    
 </form>
 
 
 
  <form name="viewLabOrder" id="viewLabOrder" method="post" action="<?=base_url()?>index.php/workbench/getHistorySpecific">
    
    <input name="patient_history_id" id="v_patient_history_id" type="hidden"/>
    <input name="order_id" id="v_order_id" type="hidden"/>
    <input name="action_type" value="drugs" type="hidden"/>
    
 </form>
 
 
 
 
 
 
 