
<?php
    if($this->session->userdata('current_patient'))
    {
        $current_patient = $this->session->userdata('current_patient');
    }
    
    if($this->session->userdata('admission_data'))
    {
        $admission_data = $this->session->userdata('admission_data');
        $this->session->unset_userdata('admission_data');
    }
    
    
    $role = $this->session->userdata('role');
    
   
$printReferalDocument = "index.php/workbench/printReferalDoc/";  
$patientfulldetailspath = "index.php/patient/number/"
    
?>



<form name="next_patient" id="next_patient" action="<?=base_url()?>index.php/workbench/takeUpPatient" method="post">
    
    <input type="hidden" value="<?php echo $this->session->userdata('staff_no');?>"  name="staff_no"/>
    <input type="hidden" value=""  name="schedule_id" id="np_schedule_id"/>
        
</form>

<section id="main-content">
<section class="wrapper">
 
<div class="row">
<div class="col-lg-12">
 
<ul class="breadcrumb">
<li><a href="#"><i class="fa fa-home"></i> Workbench</a></li>
</ul>
 
</div>
</div>

<div class="row">
    
<div class="col-lg-12">
<section class="panel">
<div class="panel-body">
<ul class="summary-list">
<?php if($role == 1){?>
<?php if(isset($current_patient) && !isset($action_patient)){?>
<li>
<a  id="consult_patient" href="#prescribe" data-toggle="modal">
<i class="fa fa-edit text-info"></i>
Consultation Notes
</a>
</li>
<?php } ?>
<?php }?>

<?php if($role == "1" && isset($current_patient)){?>

<?php if(!isset($admission_data)){?>
<li>
<a id="admit_patient"  href="#prescribe" data-toggle="modal">
<i class="fa fa-tags text-info"></i>
Admit Patient
</a>
</li>
<?php } ?>
<?php if(isset($admission_data)){?>
<li>
<a  href="#dischargePatient" data-toggle="modal">
<i class="fa fa-tags text-success"></i>
Discharge Patient


</a>
</li>

<?php } ?>
<?php }?>



<li>
<?php
if(isset($current_patient)){
?>
<a  target="_blank" href="<?=base_url()?>index.php/billing/patientbill/<?php echo $current_patient['patient_number'];?>" data-toggle="modal">

<?php }else if(isset($action_patient)){ ?>

<a  target="_blank" href="<?=base_url()?>index.php/billing/patientbill/<?php echo $action_patient['patient_number'];?>" data-toggle="modal">

<?php }else{?>
<a  target="_blank" href="<?=base_url()?>index.php/billing" data-toggle="modal">

<?php }?>
<i class="fa fa-tags text-success"></i>
Raise Bill
</a>
</li>

<li>
<a  href="#sendMessage" data-toggle="modal">
<i class="fa fa-tags text-success"></i>
Send Message
</a>
</li>

<?php if(isset($current_patient) && !isset($action_patient)){?>

<li>
<a  target="_blank" href="<?=base_url()?>index.php/patient/number/<?php echo $current_patient['patient_number']; ?>">
<i class="fa fa-user text-info"></i>
View Patient Full Profile
</a>
</li>

<?php } ?>

<li>
<a  href="#myModal3" data-toggle="modal">
<i class="fa fa-tags text-success"></i>
Shift Inquiry
</a>
</li>


</ul>
</div>
</section>
</div>
</div>
</div>
</div>

<!-------------------       Main content----------->

<div class="row">
    
    <aside class="profile-nav col-lg-3">
<section class="panel">
<div class="user-heading round">
<a href="#">
  
<img src="<?=base_url()?>assets/img/profiles/<?php echo $pic['picture']?>" alt="">
</a>
<h1><?php echo ucfirst($staff['first_name'])." ".ucfirst($staff['last_name'])?></h1>

</div>
<ul class="nav nav-pills nav-stacked">
   
   
   
<?php if(isset($current_patient)){?>
<li class="active"></i> <a> <i class="fa fa-user"></i>Currently Consulting Patient</a></li>
<?php }?>
<?php if($role == "5"){?>
<li><a  href="#current_orders_others" id="get_referal_orders" data-toggle="modal"> <i class="fa fa-list-alt fa-5x"></i>Referal Order Management<span id="order_count" class="label label-danger pull-right r-activity">0</span></a></li>
<li><a  href="#current_orders_others" id="get_patient_visit_orders" data-toggle="modal"> <i class="fa fa-list-alt fa-5x"></i>Patients Doctor Visits<span id="patient_visit_order_count" class="label label-danger pull-right r-activity">0</span></a></li>
<?php }?>

<?php if(($role == "1")||($role == "2")||($role == "5")){?>
<li><a id="wb_personal_queue" href="#personal_queue" data-toggle="modal"> <i class="fa fa-calendar"></i> Queue  <span id="w_queue" class="label label-danger pull-right r-activity">0</span></a></li>
<li><a id="wb_dept_queue" href="#deptqueue" data-toggle="modal"> <i class="fa fa-calendar"></i>Dept Queue<span id="w_dept_queue" class="label label-danger pull-right r-activity">0</span></a></li>

<li><a id="wb_appointment" href="#user_appointment" data-toggle="modal"> <i class="fa fa-calendar"></i>Appointments<span id="w_appointment" class="label label-danger pull-right r-activity">0</span></a></li>
<?php }?>

<li><a href="#"> <i class="fa fa-info-circle"></i> Current Shift</a></li>
<?php if($role == "2"){?>
<li><a id="get_orders" href="#current_orders" data-toggle="modal"> <i class="fa fa-bell-o"></i> Pending Tasks<span id="w_nurse_tasks" class="label label-danger pull-right r-activity">0</span></a></li>
<?php }?>

<?php if($role == "2"){?>
<li><a id="get_admissionlist" href="#current_orders" data-toggle="modal"> <i class="fa fa-bell-o"></i> Patients Pending Ward Assignments<span id="w_admit_tasks" class="label label-danger pull-right r-activity">0</span></a></li>
<?php }?>

<li><a id="get_admit_patients" href="#admittedpatients" data-toggle="modal"> <i class="fa fa-bell-o"></i> admitted Patients<span id="w_admitted_patients" class="label label-danger pull-right r-activity">0</span></a></li>



<li><a href="#changePassword" data-toggle="modal"> <i class="fa fa-edit"></i> Change Password</a></li>
<li><a target="_blank" href="<?=base_url()?>index.php/staff/number/<?php echo $staff['staff_no'];?>"> <i class="fa fa-edit"></i> My Profile</a></li>
</ul>
</section>
</aside>
    
    
    
<aside class="profile-info col-lg-9">

<?php if(isset($current_patient) || isset($action_patient)){?>
<section class="panel">
<div class="bio-graph-heading">
   <?php if(isset($action_patient)){echo "Current Patient";} else{ ?> Current Patient <?php }?>
   
          <?php if(isset($admission_data) && $admission_data){?>
       <span style="margin-left:370px;"><a style="font:20px" class="btn btn-shadow btn-lg btn-danger" href=""><i class="fa fa-wheelchair"></i> In Patient</a></span>
       <?php } else {?>
       
       <span style="margin-left:370px;"><a style="font:20px" class="btn btn-shadow btn-lg btn-success" href=""><i class="fa fa-stethoscope"></i> Out Patient</a></span>
       
       <?php } ?>
</div>
<div class="panel-body bio-graph-info">
<h1></h1>
<?php if(!isset($action_patient)) {?>
<div class="row">
<div class="bio-row">
<p><span>First Name </span>:<?php if(isset($current_patient)) echo ucfirst($current_patient['first_name']);?> </p>
</div>
<div class="bio-row">
<p><span>Last Name </span>: <?php if(isset($current_patient['last_name'])) echo ucfirst($current_patient['last_name']);?> </p>
</div>
<div class="bio-row">
<p><span>Country </span>: <?php if(isset($current_patient['last_name'])) echo ucfirst($current_patient['last_name']);?></p>
</div>
<div class="bio-row">
<p><span>Birthday</span>: <?php if(isset($current_patient)) echo $current_patient['dob'];?></p>
</div>
<div class="bio-row">
<p><span>Occupation </span>: <?php if(isset($current_patient['occupation'])) echo ucfirst($current_patient['occupation']['occupation_name']);?></p>
</div>
<div class="bio-row">
<p><span>Email </span>: <?php if(isset($current_patient['email']) ) echo $current_patient['email'];?>
</div>


<div class="bio-row">
<p><span>Mobile </span>: <?php if(isset($current_patient['mobile_number'])) echo $current_patient['mobile_number'];?></p>
</div>
<div class="bio-row">
<p><span>Phone  </span>: <?php if(isset($current_patient['cell_number'])) echo $current_patient['cell_number'];?></p>
</div>
<div class="bio-row">
<p><span>Patient Number </span>: <a  target="_blank" href="<?=base_url()?>index.php/patient/number/<?php echo $current_patient['patient_number']; ?>"> <?php if(isset($current_patient['patient_number'])) echo $current_patient['patient_number'];?></p> </a>
</div>
<div class="bio-row">
<p><span>Patient Type </span>: <?php if(isset($current_patient['patient_type_code'])) echo $current_patient['patient_type_code'];?></p>
</div>
<div class="bio-row">
<p><span>HMO Code</span>: <?php if(isset($current_patient['hmo_code'])) echo $current_patient['hmo_code'];?></p>
</div>
<div class="bio-row">
<p><span>HMO Enrolle No</span>: <?php if(isset($current_patient['hmo_enrolee_id '])) echo $current_patient['hmo_enrolee_id '];?></p>
</div>
</div>

<div>
<?php } else{
    
    
    ?>

    <div class="row">
<div class="bio-row">
<p><span>First Name </span>:<?php if(isset($action_patient)) echo ucfirst($action_patient['first_name']);?> </p>
</div>
<div class="bio-row">
<p><span>Last Name </span>: <?php if(isset($action_patient['last_name'])) echo ucfirst($action_patient['last_name']);?> </p>
</div>
<div class="bio-row">
<p><span>Country </span>: <?php if(isset($action_patient['last_name'])) echo ucfirst($action_patient['last_name']);?></p>
</div>
<div class="bio-row">
<p><span>Birthday</span>: <?php if(isset($action_patient)) echo $action_patient['dob'];?></p>
</div>
<div class="bio-row">
<p><span>Occupation </span>: <?php if(isset($action_patient['occupation'])) echo ucfirst($action_patient['occupation']['occupation_name']);?></p>
</div>
<div class="bio-row">
<p><span>Email </span>: <?php if(isset($action_patient['email']) ) echo $action_patient['email'];?>
</div>


<div class="bio-row">
<p><span>Mobile </span>: <?php if(isset($action_patient['mobile_number'])) echo $action_patient['mobile_number'];?></p>
</div>
<div class="bio-row">
<p><span>Phone </span>: <?php if(isset($action_patient['cell_number'])) echo $action_patient['cell_number'];?></p>
</div>
<div class="bio-row">
<p><span>Patient Number </span>: <a  target="_blank" href="<?=base_url()?>index.php/patient/number/<?php echo $action_patient['patient_number']; ?>"> <?php if(isset($action_patient['patient_number'])) echo $action_patient['patient_number'];?></a></p>
</div>
<div class="bio-row">
<p><span>Patient Type </span>: <?php if(isset($action_patient['patient_type_code'])) echo $action_patient['patient_type_code'];?></p>
</div>
<div class="bio-row">
<p><span>HMO Code</span>: <?php if(isset($action_patient['hmo_code'])) echo $action_patient['hmo_code'];?></p>
</div>
<div class="bio-row">
<p><span>HMO Name</span>: <?php if(isset($hmo_name['hmo_name'])) echo $hmo_name['hmo_name'];?></p>
</div>
<div class="bio-row">
<p><span>HMO Enrolle No</span>: <?php if(isset($action_patient['hmo_enrolee_id '])) echo $action_patient['hmo_enrolee_id '];?></p>
</div>
</div>
    
<div class="alert alert-success alert-block fade in" style="padding:40px;">
    
    <h4>
    <i class="fa fa-ok-sign"></i>
    <?php if($action_type != "admit"){ ?>
    Action Required (<?php echo $action_type;?>)!
		
	
     <?php } else { echo "Assign Patient to ward"; }?>
    </h4>
    <p><?php echo "Notes : ".$action_details; ?></p>
	<?php if(isset($referalID[0]['id'])&&($action_type == "referal")){ ?>
	
	<a id="printbutton" href="<?= base_url() ?><?php echo $printReferalDocument . $referalID[0]['id'];?>" target="_blank" ><i class="fa fa-print"></i><b>Click Here Print Referal Document </b></a>
	</br>
	</br>
	<p><b>Please ensure you print the Referal Document for the Patient before finishing this task</b></p>
	
	<?php } ?>
	
	<?php if($action_type == "patientvisit"){ ?>
	
	<a  target="_blank" href="<?=base_url()?>index.php/patient/number/<?php echo $action_patient['patient_number']; ?>"><i class="fa fa-print"></i><b>Click Here to view Patients records </b></a>
	</br>
	</br>
		
	<?php } ?>
	
    <br/><br/>
     <h4>
    <i class="fa fa-ok-sign"></i>
    </h4>
     
       <?php if($action_type != "admit"){ ?>
     <form name="peformAction" method="post" action="<?=base_url()?>index.php/workbench/takeAction">
    <input type="hidden" value="<?php echo $order_id;?>" name="id"/>
    

    <textarea name="action_notes" id="action_notes" class="wysihtml5 form-control" rows="10"></textarea>
    
    <br/>
    
    <button type="button" id="apply" class="btn btn-success">Finish</button>
    <script>
        $(document).ready(function(){
            
            $("button#apply").click(function(){
                    $("form[name=peformAction]").submit();
                });
                
            });       
        
    </script>
    </form>
    <?php } else{?>
    
    <form name="assignToWard" method="post" action="<?=base_url()?>index.php/workbench/assignToWard">
    
        <div class="form-group" style="width:50%;">
<label for="exampleInputEmail1">Select Ward </label>
<input type="hidden" name="order_id" value="<?php if(isset($order_id)){echo $order_id;}?>"/>
 <select name="ward_id" id="ward_id" class="form-control m-bot15">
        <option></option>
        <?php
        foreach($wards as $ward)
        {
            echo "<option value='".$ward['ward_id']."'>".ucfirst($ward['ward_name'])."</option>";
        }
        ?>
         
        
    </select></div>
        

    <script>
        //get_beds
        
        $(document).ready(function(){
            
            $("select#ward_id").change(function(){
               
               
                $("input#hidden_bed_ward_id").val($("select#ward_id").val());
                
                getFreeBeds();
                });
            
            });
        
    function getFreeBeds() {
         var obj ="";
         var url = "<?= base_url() ?>"+"index.php/workbench/getAvailableBedsinWardJson";
       
       
        $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#get_beds').serialize(),
		success: function(json){						
		try{
			obj = jQuery.parseJSON(json);
                    	
                        console.log(json);
			//return obj;
                        
                        $("select#bed_id")
                   .find('option')
                   .remove()
                   .end()
                   //.append('<option value="whatever">text</option>')
                   //.val('whatever')
               ;
                var arrayLength = obj.length;
                
                for (var i = 0; i < arrayLength; i++) {
                    var newoption = "<option  style='text-transform: capitalize' value='"+obj[i]['bed_id']+"'>"+obj[i]['bed_name']+"</option>";
                     
                     $("select#bed_id").append(newoption);
                   
                }
                    
		}catch(e) {		
			console.log(e);
                        
                      
		}		
		},
		error: function(){						
			console.log('Error while request..');
		}
                
                 });
        
        
        
    }
    </script>
    
            <div class="form-group" style="width:50%;">
<label for="exampleInputEmail1">Available Beds</label>
 <select name="bed_id" id="bed_id" class="form-control m-bot15">
        <option></option>
              
    </select></div>
            
        <input type="hidden" value="<?php if(isset($action_patient)){ echo $action_patient['patient_number'];}?>" name="patient_number"/>
            
            
            <button id="assign" type="button" class="btn btn-default" >Assign To Ward</button>
    </form>
    
    <script>
        
        
        $(document).ready(function(){
            
            $("#assign").click(function(){
                
                if ($.trim($("select#ward_id").val()) == "" || $.trim($("select#bed_id").val()) == "") {
                   
                   alert("Select Ward and Bed to assign");
                }
                else
                {
                    $("form[name=assignToWard]").submit();
                }
                
                
                
                });
            
            });
        
        
    </script>
    
    <?php } ?>
    
</div>
<?php }?>






</div>
    
    


</div>

</div>
</section>
<?php }?>
</aside>
</div>
</div>
<form id="count" method="post" action="test.php">
    <input type="hidden" name="staff_no"/>
</form>



<!------------------------------------------------ dept queue view ---------------------------------------------------------->
<form method="post" action="<?=base_url() ?>index.php/patient/number">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deptqueue" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Patients Waiting to See your Department</h4>
</div>
<div class="modal-body">


        <div class="form-group">
        
<label for="exampleInputEmail1"></label>

                <table class="display table table-bordered table-striped" >
                <thead>
                    
                    
                <tr>
                <th>Queue Number</th>
                <th>Name</th>
                <th>Sex</th>
                
                </tr>
                </thead>
                <tbody id='dept_queue_body'>
                   
                </tbody>
                
                </table>
                
              
        </div>
    





</div>
</div>
</div>
</div>
</form>


<form method="post" action="<?=base_url() ?>index.php/patient/number">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="personal_queue" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Patients Waiting to See you</h4>
</div>
<div class="modal-body">


        <div class="form-group">
        
<label for="exampleInputEmail1"></label>

                <table class="display table table-bordered table-striped" >
                <thead>
                    
                    
                <tr>
                <th>Queue Number</th>
                <th>Name</th>
                <th>Sex</th>
                
                </tr>
                </thead>
                <tbody id='personal_queue_body'>
                   
                </tbody>
                
                </table>
                
              
        </div>
    





</div>
</div>
</div>
</div>
</form>



<form method="post" id="message_form" action="<?=base_url() ?>index.php/workbench/sendMessage">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="sendMessage" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Send Message</h4>
</div>
<div class="modal-body">
    <div class="form-group">
        <label class="label_check" for="checkbox-01"> Message Type</label>
    <select class="form-control" name="destination_type" id="destination_type" >
        <option value="S" >User</option>
        <option value="A" >All Users</option>
        <option value="D" >Department</option>
    </select>
    
    </div>
    
    <div class="form-group" id="to_div">
        <label class="label_check" for="checkbox-01"> To</label>
    <select class="form-control" name="to" id="to" >
        <option value=""></option>
        <?php foreach($staffs as $staff){  if($staff['staff_no'] == "2005/10/01"){continue;}?>
        <option value="<?php echo $staff['staff_no'];?>" ><?php echo ucfirst($staff['first_name'])." ".ucfirst($staff['middle_name'])." ".ucfirst($staff['last_name']);?></option>
        <?php } ?>
    </select>
    
    </div>
    
     <div class="form-group" id="add_cc">
        <a id="add_recipient" href="#">Add CC</a>
     </div>

    <script>
        var number_of_ccs = 0;
        
          function removeCC(selector)
            {
                
                $("div#"+selector+"_div").remove();
                $("div[for="+selector+"]").remove();
            }
            
        
        $(document).ready(function(){
            
          
            $("a#add_recipient").click(function(){
                    
                   
                   var des_type = $("select#destination_type").val();
                   var new_cc_field = "<div class=\"form-group\" id=\"cc_"+number_of_ccs+"_div\"><label class=\"label_check\" for=\"checkbox-01\"> CC</label>";
                   new_cc_field = new_cc_field + "<select class=\"form-control\" name=\"cc[]\" id=\"cc_"+number_of_ccs+"\" >";
                   new_cc_field = new_cc_field + " </select>";
                   new_cc_field = new_cc_field + " </div>";
                   new_cc_field = new_cc_field + " <div class=\"form-group\" for=\"cc_"+number_of_ccs+"\">";
                   new_cc_field = new_cc_field + "<a class=\"remove_cc\" onclick=\"javascript:removeCC('cc_"+number_of_ccs+"');\" cc=\"cc_"+number_of_ccs+"\" href=\"#\">Remove CC</a>";
                   new_cc_field = new_cc_field + " </div>";
                   
                 
                   $(new_cc_field).insertAfter("div#add_cc");
                   
                   if (des_type == 'S')
                    {
                        getToField("select#cc_"+number_of_ccs,"<?= base_url() ?>"+"index.php/workbench/getUsersJson", des_type);
                        $("div#to_div, div#add_cc").show();
                    }
                     else if (des_type == 'D')
                        {
                            getToField("select#cc_"+number_of_ccs,"<?= base_url() ?>"+"index.php/workbench/getDeptsJson", des_type);
                            
                             $("div#to_div, div#add_cc").show();
                        }
                        
                        number_of_ccs++;
                });
            
            
            $("select#destination_type").change(function(){
                    var des_type = $(this).val();
                    if (des_type == 'S')
                    {
                        getToField("select#to","<?= base_url() ?>"+"index.php/workbench/getUsersJson", des_type);
                        $("div#to_div, div#add_cc").show();
                    }
                    else if (des_type == 'D')
                    {
                        getToField("select#to","<?= base_url() ?>"+"index.php/workbench/getDeptsJson", des_type);
                        
                         $("div#to_div, div#add_cc").show();
                    }
                    else if (des_type == 'A')
                    {
                        $("div#to_div, div#add_cc").hide();
                    }
                });
            });
        
        function getToField(selectid, url, type)
        {
            var obj ="";
           // var url = "<?= base_url() ?>"+"index.php/workbench/getDeptsJson";
          
            
           $.ajax({
                   type: "post",
                   url: url,
                   cache: false,				
                   data: $('form#message_form').serialize(),
                   success: function(json){						
                   try{
                           obj = jQuery.parseJSON(json);
                           
                           //return obj;
                           
                           $(selectid)
                      .find('option')
                      .remove()
                      .end()
                      //.append('<option value="whatever">text</option>')
                      //.val('whatever')
                  ;
                   var arrayLength = obj.length;
                   $(selectid).append("<option  style='text-transform: capitalize' value=''></option>");
                   for (var i = 0; i < arrayLength; i++)
                   {
                        //if system skip
                        if (obj[i]['staff_no'] == "2005/10/01")
                        {
                            continue;
                        }
                        if (obj[i]['middle_name'] == null)
                        {
                            obj[i]['middle_name'] == " ";
                        }
                        if (type == "S")
                        {
                            var newoption = "<option  style='text-transform: capitalize' value='"+obj[i]['staff_no']+"'>"+obj[i]['first_name']+" "+obj[i]['middle_name']+" "+obj[i]['last_name']+"</option>";
                        }
                        else if (type == "D")
                        {
                            var newoption = "<option  style='text-transform: capitalize' value='"+obj[i]['dept_id']+"'>"+obj[i]['name']+"</option>";
                        }
                        
                        $(selectid).append(newoption);
                       //Do something
                      
                   }
                       
                   }catch(e) {		
                           console.log('Exception while request..');
                   }		
                   },
                   error: function(){						
                           console.log('Error while request..');
                   }
                   
                    });    
        }
        
    </script>
    
    
 <div class="form-group">
        <label class="label_check" for="checkbox-01"> Subject</label>
    <input class="form-control" name="subject" id="subject" placeholder="Message Subject"/>

    
    </div>
    
  <div class="form-group">
    
    <label class="label_check" for="checkbox-01">
<div id="message_div" >
    <textarea  name="message" id="message_contents" class="wysihtml5 form-control" rows="5"></textarea>
</div>

</label>

 </div>
  <input type="hidden" name="patient_number" value="<?php if(isset($admission_data)){echo $admission_data['patient_number'];} ?>"/>
  

 <button type="button" id="discharge_btn" class="btn btn-default" onclick="javascript:SendMessage();">Send</button>

 <script>
    
    function SendMessage()
    {
       var to =  $("select#to").val();
       var sub =  $("input#subject").val();
       var message =  $("textarea#message_contents").val();
       var destination_type = $("select#destination_type").val();
       var error = false;
       if (to == "" && destination_type != "A")
       {
            error = true;
            alert("Please Select Recipent");
       }
       
       if (message == "")
       {
            error = true;
            alert("Message is empty");
       }
     
       if ($.trim(sub) == "" && !error)
        {
           
            var sure = confirm("Do You Really want to send an empty message ? ");
            if (!sure)
            {
               error = true;
            }
        }
              
       
       if (!error)
       {
         $("form#message_form").submit();
       }
    }
    
    
 </script>
</div>
</div>
</div>
</div>
</form>

<script>
      
</script>


<!------------------------------------------------ Discharge patient view ---------------------------------------------------------->



<form method="post" id="discharge_form" action="<?=base_url() ?>index.php/workbench/dischargePatient">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="dischargePatient" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Discharge Patient</h4>
</div>
<div class="modal-body">

  <div class="form-group">
    
    <label class="label_check" for="checkbox-01">
<div id="discharge_notes_div" >
    <textarea  name="notes" id="discharge_notes" class="wysihtml5 form-control" rows="5"></textarea>
</div>

</label>

 </div>
  <input type="hidden" name="patient_number" value="<?php if(isset($admission_data)){echo $admission_data['patient_number'];} ?>"/>
  

 <button type="button" id="discharge_btn" class="btn btn-default" onclick="javascript:discharge_patient()">Discharge Patient</button>

</div>
</div>
</div>
</div>
</form>

<script>
        function discharge_patient() {
            
            var discharge = confirm("Patient will be Discharged From ward" );
            if (discharge)
            {
                $("form#discharge_form").submit();
            }
        }
</script>

<!------------------------------------------------ Appointment view ---------------------------------------------------------->



<form name="prescribe" method="post" action="<?=base_url() ?>index.php/workbench/recordPatientHistory">

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="prescribe" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Doctor's Notes</h4>
</div>
<div class="modal-body">


        
       <div class="form-group">
        <label for="exampleInputEmail1">Reason for Visit</label>
        
        <input type="text"  class="form-control" value="<?php if(isset($history_data)) echo $history_data['description'];?>" name="note_description" id="desc"/>
            
        <?php if(isset($history_data['doctors_notes'])){ ?>
            <div class="form-group">
                <br/><br/>
                 <h5>Previous note</h5>
                 
                 <hr/>
                 <div>
                    <?php if(isset($history_data['doctors_notes']))echo $history_data['doctors_notes']; ?>
                 </div>
                   <hr/>
            </div>
			
			
            
        <?php }?>
        <input type="hidden" name="doc_notes" id="doc_notes" value=""/>
        
        <?php if(isset($current_patient)){?>
        
                 <input type="hidden" name="patient_number"  value="<?php echo $current_patient['patient_number']; ?>"/>
                 
        
        <?php }?>
        
    </div>
        
        
<div class="panel-body">

</div>

			<?php if(isset($patient_family_id_new)){ ?>
                     <input type="hidden" name="patient_family_id_new"  value="<?php echo $patient_family_id_new; ?>"/>
                 
            <?php }?>


<div class="form-group">
	<label class="label_check" for="checkbox-01">
		<input name="presenting_history" class="action_details" destination="presenting_div" id="presenting_history" value="1" type="checkbox"  /> Presenting History
		<div id="presenting_div" class="more_details">
			<textarea  name="presenting_history_action" id="presenting_div_text" class="wysihtml5 form-control" rows="5"></textarea>
		</div>

	</label>

 </div>


 
 
 <div class="form-group">
	<label class="label_check" for="checkbox-01">
		<input name="obstetrics_history" class="action_details" destination="obstetrics_div" id="obstetrics_history" value="1" type="checkbox"  /> Obstetrics History
		<div id="obstetrics_div" class="more_details">
			<textarea  name="obstetrics_history_action" id="obstetrics_div_text" class="wysihtml5 form-control" rows="5"></textarea>
		</div>

	</label>

 </div>
 
 <div class="form-group">
	<label class="label_check" for="checkbox-01">
		<input name="gynaecology_history" class="action_details" destination="gynaecology_div" id="gynaecology_history" value="1" type="checkbox"  /> Gynaecology History
		<div id="gynaecology_div" class="more_details">
			<textarea  name="gynaecology_history_action" id="gynaecology_div_text" class="wysihtml5 form-control" rows="5"></textarea>
		</div>

	</label>

 </div>
 
 <div class="form-group">
	<label class="label_check" for="checkbox-01">
		<input name="pastmedicalhistory" class="action_details" destination="pastmedicalhistory_div" id="pastmedicalhistory" value="1" type="checkbox"  /> Past Medical History
		<div id="pastmedicalhistory_div" class="more_details">
			<textarea  name="pastmedicalhistory_action" id="pastmedicalhistory_div_text" class="wysihtml5 form-control" rows="5"></textarea>
		</div>

	</label>

 </div>
 
 <div class="form-group">
	<label class="label_check" for="checkbox-01">
		<input name="surgeryhistory" class="action_details" destination="surgeryhistory_div" id="surgeryhistory" value="1" type="checkbox"  /> Surgery History
		<div id="surgeryhistory_div" class="more_details">
			<textarea  name="surgeryhistory_action" id="surgeryhistory_div_text" class="wysihtml5 form-control" rows="5"></textarea>
		</div>

	</label>

 </div>
 
 <div class="form-group">
	<label class="label_check" for="checkbox-01">
		<input name="familyhistory" class="action_details" destination="familyhistory_div" id="familyhistory" value="1" type="checkbox"  /> Family and Social History
		<div id="familyhistory_div" class="more_details">
			<textarea  name="familyhistory_action" id="familyhistory_div_text" class="wysihtml5 form-control" rows="5"></textarea>
		</div>

	</label>

 </div>
 
 
 <div class="form-group">
	<label class="label_check" for="checkbox-01">
		<input name="allergy" class="action_details" destination="allergy_div" id="allergy" value="1" type="checkbox"  /> Allergies
		<div id="allergy_div" class="more_details">
			<textarea  name="allergy_action" id="allergy_div_text" class="wysihtml5 form-control" rows="5"></textarea>
		</div>

	</label>

 </div>
 
 
 
  <div class="form-group">
	<label class="label_check" for="checkbox-01">
		<input name="systemreview" class="action_details" destination="systemreview_div" id="systemreview" value="1" type="checkbox"  /> Review of systems
		<div id="systemreview_div" class="more_details">
			<label class="label_check" for="checkbox-01">General Details</label>
			<textarea  name="systemreview_action" id="systemreview_div_text" class="wysihtml5 form-control" rows="3"></textarea>
			
			<label class="label_check" for="checkbox-01">CNS</label>
			<input name="systemreview_cns"  id="systemreview_cns_div" class="form-control"  type="text"  /> 
			
			<label class="label_check" for="checkbox-01">Respiratory</label>
			<input name="systemreview_respiratory"  id="systemreview_respiratory_div" class="form-control"  type="text"  /> 
			
			<label class="label_check" for="checkbox-01">Cardiovascular</label>
			<input name="systemreview_cardio"  id="systemreview_cardio_div" class="form-control"  type="text"  /> 
			
			<label class="label_check" for="checkbox-01">GIT</label>
			<input name="systemreview_git"  id="systemreview_git_div" class="form-control"  type="text"  /> 
			
			<label class="label_check" for="checkbox-01">Urinary</label>
			<input name="systemreview_urinary"  id="systemreview_urinary_div" class="form-control"  type="text"  /> 
			
			<label class="label_check" for="checkbox-01">Genital</label>
			<input name="systemreview_genital"  id="systemreview_genital_div" class="form-control"  type="text"  /> 
			
			<label class="label_check" for="checkbox-01">Musculoskeletal</label>
			<input name="systemreview_musculo"  id="systemreview_musculo_div" class="form-control"  type="text"  /> 
			
		</div>
		
		
		
	</label>

 </div>
 
 
 
 <div class="form-group">
	<label class="label_check" for="checkbox-01">
		<input name="examination" class="action_details" destination="examination_div" id="examination" value="1" type="checkbox"  /> Examination
		<div id="examination_div" class="more_details">
			<label class="label_check" for="checkbox-01">General details</label>
			<textarea  name="examination_action" id="examination_div_text" class="wysihtml5 form-control" rows="3"></textarea>
						
			<label class="label_check" for="checkbox-01">Head and Neck</label>
			<input name="examination_head_neck"  id="examination_head_neck_div" class="form-control"  type="text"  /> 
			
			<label class="label_check" for="checkbox-01">Upper Limp</label>
			<input name="examination_upper_limp"  id="examination_upper_limp_div" class="form-control"  type="text"  /> 
			
			<label class="label_check" for="checkbox-01">Abdomen</label>
			<input name="examination_abdomen"  id="examination_abdomen_div" class="form-control"  type="text"  /> 
			
			<label class="label_check" for="checkbox-01">VE</label>
			<input name="examination_ve"  id="examination_ve_div" class="form-control"  type="text"  /> 
			
			<label class="label_check" for="checkbox-01">PR</label>
			<input name="examination_pr"  id="examination_pr_div" class="form-control"  type="text"  /> 
			
 
		</div>

	</label>

 </div>
 
 
 <div class="form-group">
	<label class="label_check" for="checkbox-01">
		<input name="diagnosis" class="action_details" destination="diagnosis_div" id="diagnosis" value="1" type="checkbox"  /> Diagonosis
		<div id="diagnosis_div" class="more_details">
			<textarea  name="diagnosis_action" id="diagnosis_div_text" class="wysihtml5 form-control" rows="5"></textarea>
		</div>

	</label>

 </div>

 
 
 
 <div class="form-group">
    
    <label class="label_check" for="checkbox-01">
<input name="lab" class="action_details" destination="lab_div" id="lab" value="1" type="checkbox"  /> Laboratory Action Required.

<div id="lab_div" class="more_details">
    <textarea  name="lab_action" id="lab_div_text" class="wysihtml5 form-control" rows="5"></textarea>
</div>

</label>

 </div>


 <div class="form-group">
	<label class="label_check" for="checkbox-01">
		<input name="treatment" class="action_details" destination="treatment_div" id="treatment" value="1" type="checkbox"  /> Treatment
		<div id="treatment_div" class="more_details">
			<textarea  name="treatment_action" id="treatment_div_text" class="wysihtml5 form-control" rows="5"></textarea>
		</div>

	</label>

 </div>



<div class="form-group">
    <label class="label_check" for="checkbox-01">
<input name="drugs" class="action_details" destination="drugs_div" id="drugs" value="1" type="checkbox"  /> Drug(s) Prescribed.
<div id="drugs_div" class="more_details">
    <textarea  name="prescribed_drugs" id="drugs_div_text" class="wysihtml5 form-control" rows="5"></textarea>
</div>

</label>

 </div>
 
  
<div class="form-group">
    <label class="label_check" for="checkbox-01">
<input name="nurse" class="action_details" destination="nurse_div" id="nurse" value="1" type="checkbox"  /> Nurse Action Required.
<div id="nurse_div" class="more_details">
    <textarea  name="nurse_action" id="nurse_div_text" class="wysihtml5 form-control" rows="5"></textarea>
</div>

</label>

</div>


 
<div class="form-group">
	<label class="label_check" for="checkbox-01">
		<input name="referal" class="action_details" destination="referal_div" id="referal" value="1" type="checkbox"  /> Referal
		<div id="referal_div" class="more_details">
					
			<label for="exampleInputEmail1">Reason For Referal</label>
			<input type="text" class="form-control" name="referal_referalreason" id="referal_referalreason_div" placeholder="">
		   	
			
			<label for="exampleInputEmail1">Doctors Note</label>
			<textarea class="wysihtml5 form-control" rows="5" name="referal_action" id="referal_div_text" ></textarea>
			
			
			<label for="exampleInputEmail1">Hospital Name</label>
			<input type="text" class="form-control" name="referal_hospitalname" id="referal_hospitalname_div" placeholder="">
  
		
			<label for="exampleInputEmail1">Address of Hospital</label>
			<textarea class="wysihtml5 form-control" rows="5" name="referal_hospitaladdress" id="referal_hospitaladdress_div"></textarea>
		

			
		</div>

		


	</label>

</div>
 
 <form action="#" class="form-horizontal tasi-form">
    <?php if(isset($family_member)){ ?>
                     <input type="hidden" name="patient_family_id"  value="<?php echo $family_member; ?>"/>
                 
            <?php }?>

  <div class="form-group" id = "hidden_admit_check">
    
    <label class="label_check" for="checkbox-01">
<input name="admit_patient"  id="admit_check_box" value="1" type="checkbox"  /> Admit Patient.

</label>

 </div>
  
  
<div class="form-group">
<label for="exampleInputEmail1">Doctor's Notes</label>
<div class="col-md-12">
<textarea name="notes" id="notes" class="wysihtml5 form-control" rows="10"></textarea>
</div>
</div>


</form>
 
 
  
  
  
  

 <?php if(isset($current_patient)){?>
 <button type="button" id="upload" class="btn btn-default" onclick="javascript:SaveSession();">Save & End Session</button>
 <?php } ?>

</div>
</div>
</div>
</div>
</form>

<script>
//admit_patient    
    $(document).ready(function(){
        
        $("div.more_details, div#hidden_admit_check").hide();
        
        $("a#admit_patient").click(function(){
           
           $("div#hidden_admit_check").show();
           $('#admit_check_box').prop('checked', true);
           
            });
        
         $("a#consult_patient").click(function(){
           
           $("div#hidden_admit_check").hide();
           $('#admit_check_box').prop('checked', false);
           
            });
        
        
        $("input.action_details").click(function(){
            
            var checked = $(this).is(':checked');
            var selector = "div#"+$(this).attr("destination");
            var text_area_selector = "textarea#" + $(this).attr("destination") +"_text" ;
           
            //if it is checked unlck the hidden div
            if (checked) {
                
                $(selector).show();
                $(text_area_selector).removeAttr("disabled");
            }
            //else lock the div
            else
            {
                $(selector).hide();
                $(text_area_selector).attr("disabled","disabled");
            }
           
            
            });
        
        });
    
    
    function SaveSession() {
        //code
        var notes = $.trim($("textarea#notes").val());
        var reason = $.trim($("input#desc").val());
       var error = false;

       if (notes == "") {
        
            error = true;
            alert("Please Record Observation and Notes");
       }
       
        if (reason == "") {
        
            error = true;
            alert("Please Record Observation and Notes");
       }
       
       //check if anjy action was checked
       $("input.action_details").each(function(){
            
            if ($(this).is(':checked')) {
                
                var text_area_selector = "#" + $(this).attr("destination") +"_text" ;
                
                if($.trim($(text_area_selector).val()) == "")
                {
                    error = true;
                    alert("Action Checked but no corresponding action was listed");
                }
               
            }
        });
       if (!error) {
        //code
        
        $("form[name=prescribe]").submit();
        
       }
       
    }
</script>

<script>
    
      window.setInterval(function(){
        
        getPendingReferalOrderCount();
		getPendingPatientvisitOrderCount();
        
        
        }, 10000);
      
      $(document).ready(function(){
        
        getPendingReferalOrderCount();
		getPendingPatientvisitOrderCount();
        
        });
		
 
	  
    
    function getPendingReferalOrderCount() {
       var url = "<?= base_url() ?>"+"index.php/workbench/getPendingReferalOrderJson";
       
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
	
	function getPendingPatientvisitOrderCount() {
       var url = "<?= base_url() ?>"+"index.php/workbench/getPendingPatientvisitOrderJson";
       
       $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#count').serialize(),
		success: function(json){
		try{
			var obj = jQuery.parseJSON(json);
			//alert( obj['STATUS']);
                      //  alert( $("span#patient_visit_order_count").html());
            	
                $("span#patient_visit_order_count").html(obj["total"]);
                        		
			
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

<form method="post" action="">

<a id="viewday" href="#user_appointment" data-toggle="modal"></a>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="admittedpatients" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Admitted Patients</h4>
</div>
<div class="modal-body">


        <div class="form-group">
        
<label for="exampleInputEmail1"></label>

                <table class="display table table-bordered table-striped" >
                <thead>
                    
                    
                <tr>
                <th>Patient Number</th>
                <th>Name</th>
                <th>Admitted By</th>
                 <th>Ward</th>
                </tr>
                </thead>
                <tbody id='admitted_patient'>
                   
                </tbody>
                
                </table>
                
              
        </div>
    





</div>
</div>
</div>
</div>
</form>



<!------------------------------------------------ Appointment view ---------------------------------------------------------->



<form method="post" action="<?=base_url() ?>index.php/patient/number">

<a id="viewday" href="#user_appointment" data-toggle="modal"></a>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="user_appointment" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Todays Appointments</h4>
</div>
<div class="modal-body">


        <div class="form-group">
        
<label for="exampleInputEmail1"></label>

                <table class="display table table-bordered table-striped" id="">
                <thead>
                    
                    
                <tr>
                <th>Name</th>
                <th>Reason</th>
                <th>Time</th>
                </tr>
                </thead>
                <tbody id='appointment_body'>
                   
                </tbody>
                
                </table>
                
              
        </div>
    





</div>
</div>
</div>
</div>
</form>



<!------------------------------------------------ Order Management ---------------------------------------------------------->



<form name="get_orders_others" method="post" action="<?=base_url() ?>index.php/workbench/getOrdersJson">

<a id="viewday" href="#user_appointment" data-toggle="modal"></a>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="current_orders_others" class="modal fade">
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
				<th>HMO Code</th>
				<th>HMO Name</th>
                </tr>
                </thead>
                <tbody id='order_body_others'>
                   
                </tbody>
                
                </table>
                
              
        </div>
		
		

    
</div>
</div>
</div>
</div>
</form>





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
    
</div>
</div>
</div>
</div>
</form>

<script>
    
   
     var isclicked = false;
     
     
     function performTest(patient_history_id, id){
                          if (!isclicked) {
                            
                            isclicked = true; 
                            
                            //alert($(this).attr("task_id"));
                            var performed = confirm("View Task");
                            if (performed) {
                                //code
                               
                               $("input#v_patient_history_id").val(patient_history_id);
                               $("input#v_order_id").val(id);
                             
                               $("form#viewLabOrder").submit();
                            }
                            
                            isclicked = false; 
                          }
                           
            }
            
       
       
     function getAdmissionList() {
        
        
        var url = "<?= base_url() ?>"+"index.php/workbench/getOrdersJson";
        $("tbody#order_body").html("");
        
        
        $("#hidden_action_type").val("admit");
        
        //$("tbody.roaster_body").html("");
        
        $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#getAdmissionOrders').serialize(),
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
    
    
    function getQueueList() {
        
        
        var url = "<?= base_url() ?>"+"index.php/workbench/getOrdersJson";
        $("tbody#order_body").html("");
        $("#hidden_action_type").val("nurse");
        
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
	
	
	
	function getReferalQueueList() {
        
        
        var url = "<?= base_url() ?>"+"index.php/workbench/getOrdersJson";
        $("tbody#order_body_others").html("");
        $("#hidden_action_type").val("referal");
        
        //$("tbody.roaster_body").html("");
        
        $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#getReferalOrders').serialize(),
		success: function(json){
		try{
			var obj = jQuery.parseJSON(json);
			//alert( obj['STATUS']);
                        for (var i =0; i < obj.length; i++) {
                            //code
                            
            $("tbody#order_body_others").append("<tr><td><a class='single_order' onclick='javascript:performTest(\""+obj[i]['patient_history_id']+"\",\""+obj[i]['id']+"\")' href='#'>"+obj[i]['first_name']+" "+obj[i]['last_name']+"</a></td><td>"+obj[i]['date_created']+"</td><td>"+obj[i]['ordered_by']+"</td><td>"+obj[i]['hmo_code']+"</td><td>"+obj[i]['hmo_name']+"</td></tr>");
                         
                          
                    
                        
                        
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
    
	
	function getPatientVisitQueueList() {
        
        
        var url = "<?= base_url() ?>"+"index.php/workbench/getOrdersJson";
        $("tbody#order_body_others").html("");
        $("#hidden_action_type").val("patientvisit");
        
        //$("tbody.roaster_body").html("");
        
        $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#getPatientVisitOrders').serialize(),
		success: function(json){
		try{
			var obj = jQuery.parseJSON(json);
			//alert( obj['STATUS']);
                        for (var i =0; i < obj.length; i++) {
                            //code
                            
            $("tbody#order_body_others").append("<tr><td><a class='single_order' onclick='javascript:performTest(\""+obj[i]['patient_history_id']+"\",\""+obj[i]['id']+"\")' href='#'>"+obj[i]['first_name']+" "+obj[i]['last_name']+"</a></td><td>"+obj[i]['date_created']+"</td><td>"+obj[i]['ordered_by']+"</td><td>"+obj[i]['hmo_code']+"</td><td>"+obj[i]['hmo_name']+"</td></tr>");
                         
                          
                    
                        
                        
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
        
        $("a#get_admissionlist").click(function(){
            
            
                getAdmissionList();
            });
        
        
        
        $("a#get_orders").click(function(){
            
            
                getQueueList();
            });
			
		$("a#get_referal_orders").click(function(){
            
            
                getReferalQueueList();
            });
        
        $("a#get_patient_visit_orders").click(function(){
            
            
                getPatientVisitQueueList();
            });
        
        
        
        });
    
</script>




<!--------------------------------  Password Change Dialogue----------------------------------------->


<form id="change_pass" method="post" action="<?=base_url() ?>index.php/workbench/changePassword">



<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="changePassword" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Change User Password</h4>
</div>
<div class="modal-body">

<input type="hidden" value="<?php echo $staff['staff_no']?>" name="staff_no"/>
     <div class="form-group">
        <label for="exampleInputEmail1">Current Password</label>
        <input type="password"  class="form-control" name="cur_pass" id="cur_pass" placeholder="Current Password">
        
        
    </div>
     
      <div class="form-group">
        <label for="exampleInputEmail1">New Password</label>
        <input type="password"  class="form-control" name="new_pass" id="new_pass" placeholder="New Password">
        
        
    </div>
      
       <div class="form-group">
        <label for="exampleInputEmail1">Confirm New Password</label>
        <input type="password"  class="form-control" name="new_pass_confirm" id="new_pass_confirm" placeholder="Confirm New Password">
        
        
    </div>
    
 <button type="button" id="passwd" class="btn btn-default" >Change Password</button>
       

<script>
    
    //timer events counter updates
    window.setInterval(function(){
        
        getUserWaitListCount();
        getDeptWaitListCount();
        getUserAppointmentListCount();
        getNursePendingTaskCount();
        getAdmitPendingTaskCount();
        getAdmittedPatientCountJson();
        
        
        }, 10000);
    
    $(document).ready(function(){
        
        //initialise all timed events first
        getUserWaitListCount();
        getDeptWaitListCount();
        getUserAppointmentListCount();
         getNursePendingTaskCount();
         getAdmitPendingTaskCount();
         getAdmittedPatientCountJson();
        
       
       $("#get_admit_patients").click(function(){
        
            getAdmittedPatients() ;
        });
        $("#wb_appointment").click(function(){
            
            getUserAppointmentList();
            
            });
        
        $("#wb_dept_queue").click(function(){
            
            $("tbody#dept_queue_body").html("");
            var queue_size  = $("span#w_dept_queue").html();
            if (queue_size != "0") {
                //cod!
                getDeptQueueList();
            }
                
            });
        
        $("#wb_personal_queue").click(function(){
                getPersonalQueueList();
            });
        
        $("button#passwd").click(function(){
                var oldpass = $("input#cur_pass").val();
                var newpass = $("input#new_pass").val();
                var newpass2 = $("input#new_pass_confirm").val();
                
                var error = false;
                if ($.trim(oldpass) == "") {
                    //code
                    alert("Current Password Required");
                    error = true;
                    
                }
                
                if ($.trim(newpass) == "") {
                    //code
                    alert("New Password Required");
                    error = true;
                    
                }
                
                if ($.trim(newpass2) == "") {
                    //code
                    alert("Please Confirm the New Password");
                    error = true;
                    
                }
                
                if (newpass2 != newpass) {
                    //code
                    alert("Passwords do not match");
                    error = true;
                }
                
                if (newpass == oldpass) {
                    //code
                     alert("New Password Cannot be the same as the old password");
                    error = true;
                }
                
                if (newpass.length < 6) {
                     alert("Password must be at least 6 characters");
                    error = true;
                }
                
                if (!error) {
                    //code
                    
                    $("form#change_pass").submit();
                }
                
            });
        
        });
     function getPersonalQueueList() {
        
        
        var url = "<?= base_url() ?>"+"index.php/workbench/getPersonalQueueJson";
        
        //$("tbody.roaster_body").html("");
        
        $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#count').serialize(),
		success: function(json){
                    
		try{
			var obj = jQuery.parseJSON(json);
                         $("tbody#personal_queue_body").html("");
                         console.log(json);
			//alert( obj['STATUS']);
                        for (var i =0; i < obj.length; i++) {
                            //code
                           
            $("tbody#personal_queue_body").append("<tr><td>"+obj[i]['queue_number']+"</td><td><a style='cursor:pointer' onclick='javascript:takeOwnership("+obj[i]['schdule_id']+")'>"+obj[i]['first_name']+" "+obj[i]['middle_name']+" "+obj[i]['last_name']+"</a></td><td>"+obj[i]['sex']+"</td></tr>");
                            
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
    function takeOwnership(schedule_id) {
        //code
        $("input#np_schedule_id").val(schedule_id);
        $("form[name=next_patient]").submit();
        
    }
    
    function getAdmittedPatients() {
        
        var url = "<?= base_url() ?>"+"index.php/workbench/getAdmittedPatientsJson";
      
         $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#count').serialize(),
		success: function(json){
		try{
			var obj = jQuery.parseJSON(json);
			//alert( obj['STATUS']);
                         $("tbody#admitted_patient").html("");
                         
                        for (var i =0; i < obj.length; i++) {
                            //code
            
            $("tbody#admitted_patient").append("<tr><td><a href='<?=base_url()?>index.php/patient/number/"+obj[i]['patient_number']+"'>"+obj[i]['patient_number']+"</a></td><td>"+obj[i]['patient']['first_name']+" "+obj[i]['patient']['middle_name']+" "+obj[i]['patient']['last_name']+"</td><td>"+obj[i]['admitted_by']+"</td><td>"+obj[i]['ward_name']+"</td></tr>");
                            
                        }
            	
			
		}catch(e) {		
			console.log('Exception while request..'+e);
                        
		}		
		},
		error: function(){						
			console.log('Error while request..');
		}
                
                 });
         
    }
    //dept_queue_body
    function getDeptQueueList() {
        
        
        var url = "<?= base_url() ?>"+"index.php/workbench/getDeptQueueJson";
        
        //$("tbody.roaster_body").html("");
        
        $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#count').serialize(),
		success: function(json){
		try{
			var obj = jQuery.parseJSON(json);
			//alert( obj['STATUS']);
                         $("tbody#dept_queue_body").html("");
                         
                        for (var i =0; i < obj.length; i++) {
                            //code
            $("tbody#dept_queue_body").append("<tr><td>"+obj[i]['queue_number']+"</td><td><a href='#' onclick='javascript:takeOwnership("+obj[i]['schdule_id']+")' class='dept_p_q' schdule_id='"+obj[i]['schdule_id']+"'>"+obj[i]['first_name']+" "+obj[i]['middle_name']+" "+obj[i]['last_name']+"</a></td><td>"+obj[i]['sex']+"</td></tr>");
                            
                        }
            	
			
		}catch(e) {		
			console.log('Exception while request..'+e);
                        
		}		
		},
		error: function(){						
			console.log('Error while request..');
		}
                
                 });
    }
    
    
    function getAdmittedPatientCountJson() {
       var url = "<?= base_url() ?>"+"index.php/workbench/getAdmittedPatientCountJson";
        
        //$("tbody.roaster_body").html("");
        
        $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#count').serialize(),
		success: function(json){
		try{
			var obj = jQuery.parseJSON(json);
			//alert( obj['STATUS']);
                         
            						
                $("span#w_admitted_patients").html(obj["total"]);
                        		
			
		}catch(e) {		
			console.log('Exception while request..'+e);
                        
		}		
		},
		error: function(){						
			console.log('Error while request..');
		}
                
                 });
    }
    function getUserWaitListCount() {
        
        
        var url = "<?= base_url() ?>"+"index.php/workbench/getUserWaitListJson";
        
        //$("tbody.roaster_body").html("");
        
        $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#count').serialize(),
		success: function(json){
		try{
			var obj = jQuery.parseJSON(json);
			//alert( obj['STATUS']);
                         
            						
                $("span#w_queue").html(obj["total"]);
                        		
			
		}catch(e) {		
			console.log('Exception while request..'+e);
                        
		}		
		},
		error: function(){						
			console.log('Error while request..');
		}
                
                 });
    }
    function getAdmitPendingTaskCount() {
       var url = "<?= base_url() ?>"+"index.php/workbench/getAdmissionPendingTasksJson";
       
       $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#count').serialize(),
		success: function(json){
		try{
			var obj = jQuery.parseJSON(json);
			//alert( obj['STATUS']);
                         
            						
                $("span#w_admit_tasks").html(obj["total"]);
                        		
			
		}catch(e) {		
			//alert('Exception while request..');
                        console.log(e);
                        
		}		
		},
		error: function(){						
			console.log('Error while request..');
		}
                
                 });
    }
    
    
    
    function getNursePendingTaskCount() {
       var url = "<?= base_url() ?>"+"index.php/workbench/getNursePendingTasksJson";
       
       $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#count').serialize(),
		success: function(json){
		try{
			var obj = jQuery.parseJSON(json);
			//alert( obj['STATUS']);
                         
            						
                $("span#w_nurse_tasks").html(obj["total"]);
                        		
			
		}catch(e) {		
			//alert('Exception while request..');
                        console.log(e);
                        
		}		
		},
		error: function(){						
			console.log('Error while request..');
		}
                
                 });
    }
    
    function getUserAppointmentListCount() {
        
        
        var url = "<?= base_url() ?>"+"index.php/workbench/getTodayAppointmentCountJson";
        
        //$("tbody.roaster_body").html("");
        
        $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#count').serialize(),
		success: function(json){
		try{
			var obj = jQuery.parseJSON(json);
			//alert( obj['STATUS']);
                         
            						
                $("span#w_appointment").html(obj["total"]);
                        		
			
		}catch(e) {		
			console.log('Exception while request..' + e);
                        
		}		
		},
		error: function(){						
			console.log('Error while request..');
		}
                
                 });
    }
    
    function getUserAppointmentList() {
        
        
        var url = "<?= base_url() ?>"+"index.php/workbench/getTodayAppointmentJson";
        
        //$("tbody.roaster_body").html("");
        
        $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#count').serialize(),
		success: function(json){
		try{
			var obj = jQuery.parseJSON(json);
			//alert( obj['STATUS']);
                        for (var i =0; i < obj.length; i++) {
                            //code
                            
            $("tbody#appointment_body").html("<tr><td><a target='_blank' href='<?=base_url()?>index.php/patient/number/"+obj[i]['patient_number']+"'>"+obj[i]['first_name']+" "+obj[i]['middle_name']+" "+obj[i]['last_name']+"</a></td><td>"+obj[i]['reason']+"</td><td>"+obj[i]['appointment_time'].substring(10,16)+"</td></tr>");
                            
                        }
            	
                        		
			
		}catch(e) {		
			//alert('Exception while request..');
                        console.log(e);
		}		
		},
		error: function(){						
			console.log('Error while request..');
		}
                
                 });
    }
    
    
    
     function getDeptWaitListCount() {
        
        
        var url = "<?= base_url() ?>"+"index.php/workbench/getDeptWaitListJson";
        
        //$("tbody.roaster_body").html("");
        
        $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#count').serialize(),
		success: function(json){
		try{
			var obj = jQuery.parseJSON(json);
			//alert( obj['STATUS']);
                         
            						
               $("span#w_dept_queue").html(obj["total"]);
                        		
			
		}catch(e) {		
			console.log('Exception while request..'+e);
                        
		}		
		},
		error: function(){						
			console.log('Error while request..');
		}
                
                 });
    }
</script>


</div>
</div>
</div>
</div>
</form>

</section>
</section>

 <form name="getLabOrders" id="getLabOrders" method="post" >
    
    <input name="dept" value="nurse" type="hidden"/>
    
 </form>
 
 <form name="getReferalOrders" id="getReferalOrders" method="post" >
    
    <input name="dept" value="referal" type="hidden"/>
    
 </form>
 
 <form name="getPatientVisitOrders" id="getPatientVisitOrders" method="post" >
    
    <input name="dept" value="admin" type="hidden"/>
    
 </form>
 
  <form name="getAdmissionOrders" id="getAdmissionOrders" method="post" >
    
    <input name="dept" value="admit" type="hidden"/>
    
 </form>
 
 
  <form name="get_beds" id="get_beds" action="<?=base_url()?>index.php/workbench/getAvailableBedsinWardJson" method="post" >
    
    <input name="hidden_bed_ward_id" id="hidden_bed_ward_id" value="" type="hidden"/>
    
 </form>
 
 
  <form name="viewLabOrder" id="viewLabOrder" method="post" action="<?=base_url()?>index.php/workbench/getHistorySpecific">
    
    <input name="patient_history_id" id="v_patient_history_id" type="hidden"/>
    <input name="order_id" id="v_order_id" type="hidden"/>
    <input name="action_type" id="hidden_action_type" value="nurse" type="hidden"/>
    
 </form>
    
