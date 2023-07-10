
 
 
 
<section id="main-content" >
<section class="wrapper">
 
<div class="row" <?php if(!$front_desk_operations){?>style="min-height: 370px;<?php } ?>">
    
    
<div class="col-lg-6">
<section class="panel">
<header class="panel-heading">
Patient Management
<span class="tools pull-right">
<a href="javascript:;" class="fa fa-chevron-down"></a>
<a href="javascript:;" class="fa fa-times"></a>
</span>
</header>
<div class="panel-body">


<div style="width:100%; text-align: center; margin-bottom:200px;">
   
   <?php if($front_desk_operations){?>
    <div class="option-icon" key="new"> 
        <i class="fa fa-plus-circle fa-5x"></i>
        <p>Add New Patient</p>
    </div>
    <?php }?>
    
      <a href="#myModal2" id="find" data-toggle="modal" >
      <div class="option-icon patient-menu" key="find">
        <i class="fa fa-search fa-5x"></i>
        <p><a href="#" id="show" class="button left">Find Patient</a>
        

</p>
        
    </div>
      </a>
    <a href="<?=base_url()?>index.php/dailyroaster">
    <div class="option-icon">
        <i class="fa fa-calendar fa-5x"></i>
        <p>Daily Roaster</p>
        
    </div>
     </a> 
       
       
       <script>
        
        $(document).ready(function(){
            
            $("div.option-icon").click(function(){
                var key = $(this).attr("key");
                
                if (key == "new")
                {
                    document.location.replace("<?=base_url() ?>index.php/patient/add");
                }
                else if (key == "find")
                {
                   $("a#find").click();
                }
            });
            
            });
        
       </script>
      
</div>

</div>
</section>
</div>


<div class="col-lg-6" style="min-height: 100px;">
<section class="panel">
<header class="panel-heading">
Today's Queue (Click on Patient to process)
</header>
<div class="panel-body" >
    
<?php if($front_desk_operations){?> 
<div class="adv-table">
<table class="display table table-bordered table-striped" id="queue">
<thead>
<tr>
<th>Patient</th>
<th>Queue Number</th>
<th>Date</th>
<th>Dept</th>
<th>Admission Status</th>
<th>Doctor</th>
</tr>
</thead>
<tbody>
<?php foreach($queue as $q){ ?>
<tr class="gradeX" id="<?php echo $q['schdule_id'];?>">
<td><a href="#myModal3" class="turn" data-toggle="modal" sid="<?php echo $q['schdule_id'];?>"><?php foreach($patients as $patient){if($patient['patient_number'] == $q['patient_number'] && $patient['patient_family_id'] == $q['patient_family_id']){ echo ucfirst($patient['last_name'])." ".
ucfirst($patient['first_name']);break;}}?></a></td>
<td><?php echo $q['queue_number'];?></td>
<td><?php echo $q['date'];?></td>
<td><?php foreach($departments as $dept){if($dept['dept_id'] == $q['dept_id']){ echo ucfirst($dept['name']);break;}}?></td>
<td><?php print_r($q["admission_status"]);?></td>
<td><?php foreach($doctors as $doc){if($doc['staff_no'] == $q['staff_no']){ echo ucfirst($doc['last_name'])." ".
ucfirst($doc['first_name']);break;}}?></td>
</tr>
<?php }?>

</table>
</div>
<?php } ?>

</div>
</section>
</div>







</div>




<form id="find" method="post" action="<?=base_url() ?>index.php/patient/number">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal2" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Find Patient</h4>
</div>
<div class="modal-body">
<form role="form" id="add-new-occupation"  name="add-new-occupation" method="post" action="text.php">
<div class="form-group">
<label for="exampleInputEmail1">File Number</label>
<input type="text" class="form-control" name="patient_number" id="patient_number" placeholder="File Number">
</div>
<div id="occupation-create-error"></div>
<button type="button" id="find_patient" class="btn btn-default" onclick="javascript:findPatient();">View Patient</button>
<hr/>
<div class="form-group">
<label for="exampleInputEmail1">HMO</label>
 <select name="hmo_code" id="hmo_code" class="form-control m-bot15">
        <option value="">All</option>
        <?php
        foreach($hmos as $hmo)
        {
            echo "<option value='".$hmo['hmo_code']."'>".ucfirst($hmo['hmo_name'])."</option>";
        }
        ?>
        
    
        
    </select></div>

    
    
  <button type="button" id="find_all_hmo_patients" class="btn btn-default" onclick="javascript:findHmoPatient();">Find By Provider</button>
  
  <hr/>
  
  <div class="form-group">
<label for="exampleInputEmail1">Family Files</label>
 <select name="fam" id="fam" class="form-control m-bot15">
        <option value="">All</option>
       
    
        
    </select></div>

    
    
  <button type="button" id="find_all_fams" class="btn btn-default" onclick="javascript:findFamily();">Find By Family</button>
  
  <hr/>
  
  <div class="form-group">
<label for="exampleInputEmail1">Name</label>
<input type="text" class="form-control" name="name" id="name" placeholder="Name">
</div>
  
  <button type="button" id="find_all_hmo_patients" class="btn btn-default" onclick="javascript:findPatientByName();">Find By Name</button>
  
  
<script>
    
    function findPatient() {
        
        if ($("#patient_number").val() != "")
        {
            $("form#find").attr("action","<?=base_url()?>index.php/patient/searchNumber").submit();
        }
       
    }
    function findFamily() {
        //code        
        $("form#find").attr("action","<?=base_url()?>index.php/patient/searchFamily").submit();
    }
    
    function findHmoPatient() {
        if (true)
        {
            $("form#find").attr("action","<?=base_url()?>index.php/patient/searchSubscribers").submit();
        }
       else alert("Select a Provider");
    }
    
    function findPatientByName() {
        if ($("#name").val() != "")
        {
            $("form#find").attr("action","<?=base_url()?>index.php/patient/search").submit();
        }
       else alert("Enter Patient Name");
    }
</script>
</form>
</div>
</div>
</div>
</div>
</form>


<!----------------------------------------------------------------------------->







<form id="take_turn" method="post">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal3" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">&nbsp;</h4>
</div>
<div class="modal-body">

<input type="hidden" name="schdule_id" id="schdule_id"/>
<button type="button" id="take_turn" class="btn btn-default" onclick="javascript:takeTurn();">Take Turn</button>
  
<script>
    function takeTurn() {
        
         var url = "<?= base_url() ?>"+"index.php/patient/takeTurn";
            
            $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#take_turn').serialize(),
		success: function(json){
                    
		try{
			var obj = jQuery.parseJSON(json);
			//alert( obj['STATUS']);
                        if (obj['STATUS'] == "true") {
                            //code
                          //  $("button.close").click();
                           alert("File Sent to Doctor, Patient May go in");
                           $("button.close").click();
                           location.reload();
                         
                        }
                        else
                        {
                             alert(obj['ERROR']);
			
                        }
                        		
			
		}catch(e) {		
			alert('Exception while request..here');
                        alert(e);
                     
		}		
		},
		error: function(){						
			alert('Error while request..');
		}
                
                
 });
        //code
    }
    $(document).ready(function(){
        
        $("a.turn").click(function(){
            var sid = $(this).attr("sid");
            $("input#schdule_id").val(sid);
            
           
            });
        });
    
</script>
</form>
</div>
</div>
</div>
</div>
</form>


<div class="row">
    <div class="col-lg-6" style="min-height: 100px;">
<section class="panel">
<header class="panel-heading">
Today's Appointment (Click Patient to add to today's queue)
</header>
<div class="panel-body" >
<?php if($front_desk_operations){?> 
<div class="adv-table">
<table class="display table table-bordered table-striped" id="today_appointments">
<thead>
<tr>
<th>Patient</th>
<th>Appointment Time</th>
<th>Doctor</th>
<th>reason for appointment</th>
</tr>
</thead>
<tbody>appointment
<?php if($appointments){foreach($appointments as $q){ ?>
<tr class="gradeX" >
<td><a href="#" class="appoint" data-toggle="modal" patient_family_id="<?php if(isset($q['patient_family_id']))echo $q['patient_family_id'];?>" patient_number="<?php echo $q['patient_number'];?>" doctor="<?php echo $q['consulting_doctor']['staff_no'];?>" sid="<?php echo $q['appointment_id'];?>"><?php echo $q['first_name']." ".$q['last_name']?></a></td>
<td><?php echo $q['appointment_time'];?></td>
<td><?php echo $q['consulting_doctor']['first_name']." ".$q['consulting_doctor']['last_name'];?></td>
<td><?php echo $q['reason'];?></td>
</tr>
<?php }}?>

</table>
</div>
</div>

<?php } ?>
</section>
</div>




<form id="queue_check_in" method="post" action="<?=base_url()?>index.php/patient/addToQueue">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="appointment" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">&nbsp;</h4>
</div>
<div class="modal-body">

<input type="hidden" name="appointment_id" id="appointment_id"/>
<input type="hidden" name="staff_no" id="consulting_doctor"/>
<input type="hidden" name="patient_number" id="a_patient_number"/>
<input type="hidden" name="patient_family_id" id="a_patient_family_id"/>

<button type="button" id="add_to_queue" class="btn btn-default" onclick="javascript:addToQueue();">Add To Queue</button>
  
<script>
    
    function addToQueue() {
        //code
        $("form#queue_check_in").submit();
        
    }
    function addTodQueue() {
        
         var url = "<?= base_url() ?>"+"index.php/patient/addToQueue";
            
            $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#queue_check_in').serialize(),
		success: function(json){
                    
		try{
			var obj = jQuery.parseJSON(json);
			//alert( obj['STATUS']);
                        if (obj['STATUS'] == "true") {
                            //code
                          //  $("button.close").click();
                           alert("Patient checked in to Queue, Patient may wait for turn");
                           $("button.close").click();
                           location.reload();
                         
                        }
                        else
                        {
                             alert(obj['ERROR']);
			
                        }
                        		
			
		}catch(e) {		
			console.log('Exception while request..here');
                        console.log(e);
                     
		}		
		},
		error: function(){						
			console.log('Error while request..');
		}
                
                
 });
        //code
    }
    $(document).ready(function(){
        
        $("a.appoint").click(function(){
            var sid = $(this).attr("sid");
            $("input#appointment_id").val(sid);
            
             var patient_number = $(this).attr("patient_number");
            $("input#a_patient_number").val(patient_number);
            
             var doctor = $(this).attr("doctor");
            $("input#consulting_doctor").val(doctor);
            
             var fam = $(this).attr("patient_family_id");
            $("input#a_patient_family_id").val(fam);
            
           
            });
        });
    
</script>
</form>
</div>
</div>
</div>
</div>
</form>



</div>

</div>
 
</section>
</section>
 