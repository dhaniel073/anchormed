
 
 <?php
     $role = $this->session->userdata('role');
	 $printReferalDocument = "index.php/workbench/printReferalDoc/";  
 ?>
 
<section id="main-content">
<section class="wrapper">
 
<div class="row">
<div class="col-lg-12">
 
<ul class="breadcrumb">
<li><a href="<?=base_url()?>index.php/frontdesk"><i class="fa fa-home"></i> FrontDesk</a></li>
<li><a href="#">Patient</a></li>
<li class="active">view</li>


</ul>
</div>

</div>




<div class="row">
    
<div class="col-lg-12">
<section class="panel">
<div class="panel-body">
<ul class="summary-list">
    
    
<?php if ($current_bills['total'] > 0){?>
<li>
    
<a href="<?=base_url()?>index.php/billing/currentBill/<?php echo $patient['patient_number']?>">
    
<i class=" fa fa-shopping-cart text-primary"></i>
<?php echo $current_bills['total'];?> Current Bill (s)
</a>
</li>

<?php } ?>



<!--------------------------------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------------------------->
<!---------------------------Hidden form to perform as search for partial bills with patient number-------------------------->
<!--------------------------------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------------------------->
<form name="partial_bill_form" id="partial_bill_form" action="<?=base_url()?>index.php/cashier/search" method="post">
    <input type="hidden" name="name" value="<?php echo $patient["patient_number"]; ?>"/>
</form>

<!--------------------------------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------------------------->
<!---------------------------javascript on click handler for the partial payments button ------------------------------------>
<!--------------------------------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------------------------->
<script>
    $(document).ready(function(){
            $("a#view_partial_bills").click(function(){
                
                    $("form[name=partial_bill_form]").submit();
                });
        });    
</script>


<li>
<a href="<?=base_url()?>index.php/billing/patientbill/<?php echo $patient['patient_number']?>">
<i class=" fa fa-tags text-primary"></i>
Create Bill
</a>
</li>
<li>
<a  href="#myModal6" data-toggle="modal">
<i class="fa fa-calendar text-info"></i>
Schedule Appointment

</a>
</li>
<?php if($patient['patient_type_code'] != "H"){ ?>
<li>
<a href="javascript:;">
<i class=" fa fa-credit-card text-muted"></i>
Make Payment
</a>
</li>

<?php }?>

<?php if($admission_status){ ?>
<li>
<a href="#reassignWard" data-toggle="modal">
<i class=" fa fa-wheelchair text-danger"></i>
    Ward Assignment
</a>
</li>

<?php }?>


<?php if(isset($patient['old_patient_data']) && $patient['old_patient_data'] == "Y"){ ?>
<li>
<a target="_blank" href="<?=base_url()?>patients/legacy_history/<?php echo $patient['patient_number'].".pdf"?>">
<i class=" fa fa-cloud-download"></i>
View Legacy History
</a>
</li>

<?php }?>
<li>
<a  href="#myModal3" data-toggle="modal">
<i class="fa fa-tags text-success"></i>
User Data
</a>
</li>

<?php if ($partial_bills['total'] > 0){?>
<li>
    
<a id="view_partial_bills" href="#">
    
<i class=" fa fa-shopping-cart text-primary"></i>
<?php echo $partial_bills['total'];?> Pending Partial Bill(s)
</a>
</li>

<?php } ?>


<li>
<a href="<?=base_url()?>index.php/laboratory/viewPatientTests/<?php echo $patient["patient_number"];?>" data-toggle="modal">
<i class=" fa fa-folder-open text-success"></i>
    View Test Results
</a>
</li>


<?php if($patient['patient_type_code'] == "H"){ ?>

    <li>
        <a href="<?=base_url()?>index.php/provider/view/<?php echo $patient['hmo_code']?>">
        <i class="fa fa-check-square text-success"></i>
                HMO Info (<?php echo $patient['hmo_code']?>|<?php echo $hmo['hmo_name'] ?>)
        </a>
    </li>
    
    
<?php }?>

<?php if($patient['patient_type_code'] == "F"){ ?>

    <li>
        <a href="#family" data-toggle="modal">
        <i class="fa fa-check-square text-success"></i>
                Family
        </a>
    </li>
    
    
<?php }?>

<?php if($role == 1){ ?>
<li>
<a href="#" id="workbench_trans" >
<i class="fa fa-edit text-info"></i>
Transfer to Workbench
</a>
</li>

<?php }?>


<?php if($role == 2 ){ ?>
<li>
<a href="#" id="perform_action" >
<i class="fa fa-edit text-info"></i>
Create Nurse Task
</a>
</li>

<?php }?>


<li>
<a  href="#myModal26" data-toggle="modal">
<i class="fa fa-tags text-success"></i>
Change File Type
</a>
</li>

</ul>
</div>
</section>
</div>
</div>
</div>
</div>

<form name="workbenchTransForm" id="workbenchTransForm" method="post" action="<?=base_url()?>index.php/workbench/forceTakeUpPatient">
    <input type="hidden" value="<?php echo $patient["patient_number"] ?>" name="patient_number"/>
	
		
	 <?php if(isset($patient_family_id_new)){?>
		<input name="patient_family_id_new" type="hidden" value="<?php echo $patient_family_id_new ?>"/>
		
	 <?php }?>
	 
	    
</form>


<form name="performActionForm" id="performActionForm" method="post" action="<?=base_url()?>index.php/workbench/forcePerformAction">
    <input type="hidden" value="<?php echo $patient["patient_number"] ?>" name="patient_number"/>
	
	
</form>
<script>
    $(document).ready(function(){
        
        $("a#workbench_trans").click(function(){
            
                $("form#workbenchTransForm").submit();
				 
            });
        
        $("a#perform_action").click(function(){
            
                $("form#performActionForm").submit();
            });
        
        
        });
</script>
<div class="row">
<div class="col-lg-4">
 
    <section class="panel">
        <div class="twt-feed blue-bg">
        <h1><?php echo ucfirst($patient['first_name'])." ".ucfirst($patient['middle_name'])." ".ucfirst($patient['last_name']);?></h1>
        <p><?php echo $patient['patient_number']; ?></p>
        <a href="#">
            <?php if(!isset($family_member)) {?>
            <?php if(isset($patient['patient_pic'])){?>
        <img src="<?=base_url()?><?php echo $patient['patient_pic'];?>" alt="">
        <?php }else {?>
        <img src="" alt="">
        <?php }?>
        <?php } else if(isset($family_member['patient_pic'])) {?>
          <img src="<?=base_url()?><?php echo $family_member['patient_pic'];?>" alt="">
        <?php }else {?>
        <img src="" alt="">
         <?php }?>
        </a>
        </div>
        <div class="weather-category twt-category">
            <ul>
            <li class="active">
            <h5><?php echo $age;?></h5>
            Age
            </li>
            <li>
            <h5><?php if( is_array($bloodgroup) && sizeof($bloodgroup) > 1) echo $bloodgroup['blood_group_code']; ?></h5>
            Blood Group
            </li>
            <li>
            <h5><?php echo $dob;?></h5>
            Date Of Birth
            </li>
            </ul>
        </div>
        <hr/>
 <div class="weather-category twt-category">
            <ul>
            <li class="active">
            <h5><?php echo ucfirst($patient['sex']);?></h5>
            Sex
            </li>
            <li>
            <h5><?php if(is_array($phenotype) && sizeof($phenotype) > 1) echo $phenotype['phenotype_code']; ?></h5>
            Genotype
            </li>
            <li>
            <h5><?php if($patient['patient_type_code']=="h")echo ucfirst($hmo['hmo_code']);else echo "Self";?></h5>
            Provider
            </li>
            </ul>
        </div>
        
      
        
        
        <div class="twt-write col-sm-12">
      
        </div>
        <footer class="twt-footer">
        
        <button class="btn btn-space btn-info" type="button" onclick="javascript:seeDoc();">
        <i class="fa fa-user-md"></i>
            <a  id="seedoc" href="#myModal4" data-toggle="modal" >See Doctor/Nurse</a>
        </button>
			
        </footer>
        
       
        
    </section>
    
    
</div>


<div class="col-lg-8">
    
<aside class="profile-info col-lg-12">

    <section class="panel">

        <!--Enrolled Number : --><?php /*echo $patient['hmo_enrolee_id'];*/?>
        <div class="panel-body bio-graph-info">
       <h3>File Number : <?php echo $patient['patient_number'];?>
       
       <?php if($admission_status){?>
       <span style="margin-left:370px;"><a style="font:20px" class="btn btn-shadow btn-lg btn-danger" href=""><i class="fa fa-wheelchair"></i> In Patient</a></span>
       <?php } else {?>
       
       <span style="margin-left:370px;"><a style="font:20px" class="btn btn-shadow btn-lg btn-success" href=""><i class="fa fa-stethoscope"></i> Out Patient</a></span>
       
       <?php } ?>
       </h3>
       <hr/>
        <div class="row">
        <div class="bio-row">
        <p><span>First Name </span>: <?php echo ucfirst($patient['first_name']);?></p>
        </div>
        <div class="bio-row">
        <p><span>Last Name </span>: <?php echo ucfirst($patient['last_name']);?></p>
        </div>
        <div class="bio-row">
        <p><span>Country </span>: <?php if(isset($orign_country['country_name'])) echo ucfirst($orign_country['country_name']);?></p>
        </div>
        <div class="bio-row">
        <p><span>Birthday</span>: <?php echo ucfirst($patient['dob']);?></p>
        </div>
        <div class="bio-row">
        <p><span>Occupation </span>: <?php if(isset($occupation['occupation_name']))echo ucfirst($occupation['occupation_name']);?></p>
        </div>
        <div class="bio-row">
        <p><span>Email </span>: <?php if(isset($patient['email'])) echo $patient['email'];?></p>
        </div>
        <div class="bio-row">
        <p><span>Mobile </span>: <?php if(isset($patient['mobile_number'])) echo ucfirst($patient['mobile_number']);?></p>
        </div>
        <div class="bio-row">
        <p><span>Phone </span>: <?php if(isset($patient['cell_number']))  echo ucfirst($patient['cell_number']);?></p>
        </div>
        </div>
        </div>
        <a href="#myModal2" data-toggle="modal" class="btn btn-xs btn-success" style="margin: 5px;">
        View Vitals
        </a>
         
         <a href="#myModal" data-toggle="modal" class="btn btn-xs btn-success" style="margin: 5px;">
        Record Vitals
        </a>
		
		<a href="#myModal20" data-toggle="modal" class="btn btn-xs btn-success" style="margin: 5px;">
        Historic Vitals
        </a>
		
		<a href="#myModal10" data-toggle="modal" class="btn btn-xs btn-success" style="margin: 5px;">
        Allergy
        </a>
		
		<a href="#myModal11" data-toggle="modal" class="btn btn-xs btn-success" style="margin: 5px;">
        Examination
        </a>
		
		<a href="#myModal13" data-toggle="modal" class="btn btn-xs btn-success" style="margin: 5px;">
        Past Medical History
        </a>
		
		<a href="#myModal23" data-toggle="modal" class="btn btn-xs btn-success" style="margin: 5px;">
        Legacy Medical History
        </a>
		
		<a href="#myModal14" data-toggle="modal" class="btn btn-xs btn-success" style="margin: 5px;">
        Diagnosis
        </a>
		
		<a href="#myModal15" data-toggle="modal" class="btn btn-xs btn-success" style="margin: 5px;">
        Surgery
        </a>
		
		<a href="#myModal16" data-toggle="modal" class="btn btn-xs btn-success" style="margin: 5px;">
        Presenting History
        </a>
		
		<a href="#myModal17" data-toggle="modal" class="btn btn-xs btn-success" style="margin: 5px;">
        Treatment
        </a>
		
		<a href="#myModal18" data-toggle="modal" class="btn btn-xs btn-success" style="margin: 5px;">
        Gynaecology History
        </a>
		
		<a href="#myModal19" data-toggle="modal" class="btn btn-xs btn-success" style="margin: 5px;">
        System review
        </a>
		
		  <?php if($admission_status){?>		
		<a href="#myModal12" data-toggle="modal" class="btn btn-xs btn-success" style="margin: 5px;">
        Record Intake
        </a>
		 <?php } ?>
		
		<?php if($admission_status){?>
		<a href="#myModal7" data-toggle="modal" class="btn btn-xs btn-success" style="margin: 5px;">
        Record Output
        </a>
		<?php } ?>
		
		<a href="#myModal8" data-toggle="modal" class="btn btn-xs btn-success" style="margin: 5px;">
        View Input Chart
        </a>
		
		<a href="#myModal9" data-toggle="modal" class="btn btn-xs btn-success" style="margin: 5px;">
        View Output Chart
        </a>
		
		<a href="#myModal21" data-toggle="modal" class="btn btn-xs btn-success" style="margin: 5px;">
        Add Delivery Report
        </a>
		
		<a href="#myModal22" data-toggle="modal" class="btn btn-xs btn-success" style="margin: 5px;">
        Post Surgery Report
        </a>
		
		<a href="#myModal24" data-toggle="modal" class="btn btn-xs btn-success" style="margin: 5px;">
        View Delivery Report
        </a>
		
		<a href="#myModal25" data-toggle="modal" class="btn btn-xs btn-success" style="margin: 5px;">
        View Surgery Report
        </a>
		
		<!--<a href="#myModal27" data-toggle="modal" class="btn btn-xs btn-success" style="margin: 5px;">-->
       <!-- Refer Patient-->
        <!--</a>-->
		
		<a href="#myModal28" data-toggle="modal" class="btn btn-xs btn-success" style="margin: 5px;">
        View referals
        </a>
		

    </section>

    
    
 

<!--------Begining of family dialogue--------------------------------------->
<form name="create_form"  action="<?=base_url()?>index.php/provider/create" method="post">
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="family" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title"><span id='dia_title'>Create Provider</span> </h4>
</div>
<div class="modal-body" style="height:130px;">
 
 <div class="form-group">
 <a href="#" class="fam_func" function="add">
        <div class="option-icon"> 
            <i class="fa fa-plus-circle fa-5x"></i>
            <p>Add Family Member</p>
        </div>
    </a>
    
      <a href="#" class="fam_func" function="rem" >
      <div class="option-icon patient-menu">
        <i class="fa fa-ban fa-5x"></i>
        <p>Remove Family Member</p>
        
    </div>
      </a>
      
         <a href="#" class="fam_func" function="view">
      <div class="option-icon patient-menu">
        <i class="fa fa-users fa-5x"></i>
        <p>View Family Members</p>
        
    </div>
      </a>
    
 
</div>

 
   </form>
   
   <script>
    $(document).ready(function(){
        
        $("a.fam_func").click(function(){
            
            var func = $(this).attr("function");
             $("button.close").click();
             
             var selector = "a#fam_"+func;
             
             $(selector).click();
            });
        
        });
       
    </script>

</div>
</div>
</div>
</div>   
    
    
    
    
    
    
    
    
    
    <!--------Begining of add family member dialogue--------------------------------------->
<form name="add_form"  action="<?=base_url()?>index.php/patient/addFamMember" method="post">
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="new_member" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title"><span id='dia_title'>Add New Family Member</span> </h4>
</div>
<div class="modal-body">
 
 <div class="form-group">
    <label for="exampleInputEmail1">First Name</label>
    <input type="text" class="form-control" value="" name="fam_first_name" id="fam_first_name" placeholder="First Name" >
     <input type="hidden" name="patient_number" value="<?php echo $patient['patient_number']?>"/>
</div>

<div class="form-group">
    <label for="exampleInputEmail1">Middle Name</label>
    <input type="text" class="form-control" value="" name="fam_middle_name" id="fam_middle_name" placeholder="Middle Name" >
 
</div>


<div class="form-group">
    <label for="exampleInputEmail1">Last Name</label>
    <input  type="text" class="form-control" value="<?php echo ucfirst($patient['last_name']); ?>" name="fam_last_name" id="fam_last_name" placeholder="Last Name" >
 
</div>

<div class="form-group">
    <label for="exampleInputEmail1">Sex</label>
    <select  class="form-control" name="sex">
        <option value="F">Female</option>
        <option value="M">Male</option>
    </select>
</div>

            
   <div class="form-group">
    <label for="exampleInputEmail1">Date Of Birth</label>
    <input name="fam_dob" id="fam_dob" class="form-control form-control-inline input-medium default-date-picker" size="16" type="text"
            value="" />
</div>

  

  
   
  
  
  <div class="form-group">
    <label for="exampleInputEmail1">Relationship</label>
    <select class="form-control" name="fam_relationship_id" id="fam_relationship_id" >
    <option></option>
    <?php foreach($relationships as $u){?>
        <?php if(false){?>
    <option value="<?php echo $u['religion_id'];?>" selected="selected"> <?php echo ucwords($u['religion_name']);?></option>
    
        <?php } else { ?>
         <option value="<?php echo $u['relationship_id'];?>"> <?php echo ucwords($u['relationship_name']);?></option>
        <?php }?>
     <?php }?>
    
</select>

</div>
  
  
  
  <div class="form-group">
    <label for="exampleInputEmail1">Mobile Number</label>
    <input name="mobile_number" id="fam_mobile_number" value="" type="text" placeholder="" data-mask="(999) 999-9999-999" class="form-control">
    <span class="help-inline">(234) 809-9999-999</span>
</div>
  
  
  <div class="form-group">
    <label for="exampleInputEmail1">Cell Number</label>
     <input name="cell_number" id="fam_cell_number" value="" type="text" placeholder="" data-mask="(999) 999-9999-999" class="form-control">
    <span class="help-inline">(234) 809-9999-999</span>
</div>
    
    
    
 <div class="form-group">
    <label for="exampleInputEmail1">Email</label>
    <input type="text" class="form-control" value="" name="fam_email" id="email" placeholder="Email" >
 
</div>
    
    <div class="form-group">
    <label for="exampleInputEmail1">Alternate Email</label>
    <input type="text" class="form-control" value="" name="fam_alt_email" id="fam_alt_email" placeholder="Alt Email" >
 
</div>
    
 <button type="button" id="add_member" class="btn btn-default" >Add</button>
 
   </form>
   
   <script>
    $(document).ready(function(){
        
        $("button#add_member").click(function(){
             var error = false;
            
           if ($.trim($("#fam_first_name").val()) == "") {
            //code  
            error = true;
            
            alert("First Name Cannot be empty");
           }
           
           
           if ($.trim($("#fam_last_name").val()) == "") {
            //code  
            error = true;
            
            alert("Last Name Cannot be empty");
           }
           
           if ($.trim($("#fam_dob").val()) == "") {
            //code  
            error = true;
            
            alert("Please Enter Date Of Birth");
           }
           
           if ($.trim($("select#fam_relationship_id").val()) == "") {
            //code  
            error = true;
            
            alert("Must Select Relation");
           }
           
          if (!error) {
            //code
            $("form[name = add_form]").submit();
          }
           
            });
       
     
        });
       
    </script>

</div>
</div>
</div>
</div>   
    
    
    
   <!--------Begining of remove family member dialogue--------------------------------------->
<form name="rem_form"  action="<?=base_url()?>index.php/patient/removeFromFam" method="post">
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="rem_member" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title"><span id='dia_title'>Remove Family Member</span> </h4>
</div>
<div class="modal-body">
 
 <div class="form-group">
    <input type="hidden" name="patient_number" value="<?php echo $patient["patient_number"];?>" />
    <select class="form-control" name="fam_patient_family_id" id="rem_fam_id">
    <option value="">Select Family Member</option>
    <?php if($patient['patient_type_code'] == 'F'){ ?>    
        <?php foreach($family_members as $member){ ?>
            <option value="<?php echo $member['patient_family_id'] ?>"><?php echo ucfirst($member['first_name'])." ".ucfirst($member['last_name'])?></option>
        <?php } ?>  
     <?php } ?>    
    </select>
 
</div>
 
  <button type="button" id="rem_member" class="btn btn-default" >Remove</button>

 
   </form>
   
   <script>
    $(document).ready(function(){
        
            $("button#rem_member").click(function(){
                
                var family_id = $("select#rem_fam_id").val();
                var error = false;
                if (family_id == "") {
                    //code
                    error = true;
                    alert("Select a Family Member");
                }
                if (!error)
                {
                   var retval =  confirm("Are You Sure you want to remove family member");
                   if (retval) {
                    //code
                    
                     $("form[name=rem_form]").submit();
                   }
                  
                }
                
                
                });
     
        });
       
    </script>

</div>
</div>
</div>
</div>   




<!--------Change File Type--------------------------------------->

<form name="change_file_type" id="change_file_type" action="<?=base_url()?>index.php/patient/changeFIleType" method="post">
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal26" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title"><span id='dia_title'>Change File Type</span> </h4>
</div>
<div class="modal-body">
    
  <div class="form-group">
    <label for="exampleInputEmail1">Select File Type</label>
        <input type="hidden" name="patient_number" value="<?php echo $patient["patient_number"];?>" />
     <select class="form-control" name="patient_type" id="patient_type">      
        <?php foreach($patienttype as $patienttypes){ ?>
            <option <?php if($patient['patient_type_code'] == $patienttypes['patient_type_code']){?> selected = "selected"<?php } ?> value="<?php echo $patienttypes["patient_type_code"];?>"><?php echo ucfirst($patienttypes['patient_type_name']);?></option>

     <?php } ?>    
    </select>
     
             
  </div>
  
   

  <button type="submit" id="change_file_type_btn" class="btn btn-default" >Change File Type</button>
 
   </form>
  
</div>
</div>
</div>
</div> 


<!--------Begining of Reassign ward dialogue--------------------------------------->

<form name="reassign_ward"  action="<?=base_url()?>index.php/workbench/reassignWard" method="post">
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="reassignWard" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title"><span id='dia_title'>Reassign Ward</span> </h4>
</div>
<div class="modal-body">
    
  <div class="form-group">
    <label for="exampleInputEmail1">Current Ward</label>
    <input type="hidden" name="id" value="<?php echo $admission_status['id'];?>"/>
     <input type="hidden" name="patient_number" value="<?php echo $patient["patient_number"];?>" />
     <select disabled = "disabled" class="form-control">      
        <?php foreach($wards as $ward){ ?>
            <option <?php if(isset($admission_status) && $admission_status['ward_id'] == $ward['ward_id']){?> selected = "selected"<?php } ?>><?php echo ucfirst($ward['ward_name']);?></option>
       
     <?php } ?>    
    </select>
     
             
  </div>
  
   <div class="form-group">
    <label for="exampleInputEmail1">Current Bed</label>
     <select disabled = "disabled" class="form-control">      
        <?php foreach($beds_in_ward as $bed){ ?>
            <option <?php if(isset($admission_status) && $admission_status['bed_id'] == $bed['bed_id']){?> selected = "selected"<?php } ?>><?php echo ucfirst($bed['bed_name']);?></option>
       
     <?php } ?>    
    </select>
     
             
  </div>
   
   
  
  
    <div class="form-group">
    <label for="exampleInputEmail1">New Ward</label>
     <select name="new_ward" id="new_ward" class="form-control">
        <option value="">Select New Ward </option>
        <?php foreach($wards as $ward){ ?>
            <option value="<?php echo $ward['ward_id']; ?>"><?php echo ucfirst($ward['ward_name']);?></option>
       
     <?php } ?>    
    </select>
     
             
  </div>
    
    

    
  
 <div class="form-group">
     <label for="exampleInputEmail1">Bed</label>
    <select class="form-control" name="new_bed_id" id="new_bed_id">
    <option value=""></option>     
    </select>
 
</div>
 
 <input value="" name="hidden_bed_ward_id"  id="hidden_bed_ward_id" type="hidden"/>
 

  <button type="button" id="reassign_ward_btn" class="btn btn-default" onclick="javascript:change_ward()" >Reassign</button>
 
 <script>
    
    $(document).ready(function(){
            
            $("select#new_ward").change(function(){
                
                $("input#hidden_bed_ward_id").val($(this).val());
                get_beds_in_ward();
                
                });
        });
    
    function change_ward() {
        
        var error = false;
      
         if ($("select#new_ward").val() == "" || $("select#new_bed_id").val() == "" || !$("select#new_bed_id").val() || !$("select#new_ward").val()) {
               error = true;
               
               alert("Please select a new ward and bed");
            }
        
        if (!error) {
          
             var sure = confirm("Do you want to transfer the patient to the selected ward");
                if (sure)
                {
                    $("form[name=reassign_ward]").submit();
                }   
        }
       
    }
    
    function get_beds_in_ward() {
        
         var obj ="";
         var url = "<?= base_url() ?>"+"index.php/workbench/getAvailableBedsinWardJson";
       
       
        $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form[name=reassign_ward]').serialize(),
		success: function(json){						
		try{
			obj = jQuery.parseJSON(json);
                    	
                        console.log(json);
			//return obj;
                        
                        $("select#new_bed_id")
                   .find('option')
                   .remove()
                   .end()
                   //.append('<option value="whatever">text</option>')
                   //.val('whatever')
               ;
                var arrayLength = obj.length;
                
                for (var i = 0; i < arrayLength; i++) {
                    var newoption = "<option  style='text-transform: capitalize' value='"+obj[i]['bed_id']+"'>"+obj[i]['bed_name']+"</option>";
                     
                     $("select#new_bed_id").append(newoption);
                   
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
   </form>
  
</div>
</div>
</div>
</div>   
    
 <!--------Begining of view family member dialogue--------------------------------------->
<form name="view_form"  action="<?=base_url()?>index.php/patient/viewFamMember" method="post">
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="view_member" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title"><span id='dia_title'>View Family Member</span> </h4>
</div>
<div class="modal-body">
 
 <div class="form-group">
    <input type="hidden" name="patient_number" value="<?php echo $patient["patient_number"];?>" />
	
    <select class="form-control" name="patient_family_id" id="view_fam_id">
    <option>Select Family Member</option>
    <?php if($patient['patient_type_code'] == 'F'){ ?>    
        <?php foreach($family_members as $member){ ?>
            <option value="<?php echo $member['patient_family_id'] ?>"><?php echo ucfirst($member['first_name'])." ".ucfirst($member['last_name'])?></option>
        <?php } ?>  
     <?php } ?>    
    </select>
 
</div>

  <button type="button" id="view_member" class="btn btn-default" >View</button>
 
   </form>
   
   <script>
    $(document).ready(function(){
        
            $("button#view_member").click(function(){
                
                var family_id = $("select#view_fam_id").val();
                var error = false;
                if (family_id == "") {
                    //code
                    error = true;
                    alert("Select a Family Member");
                }
                if (!error)
                {
                  
                     $("form[name=view_form]").submit();
                  
                  
                }
                
                });
        });
       
    </script>

</div>
</div>
</div>
</div>   
    
    
    
    
    
    
    
    
    
       <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="datauser" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Patient data</h4>
</div>
<div class="modal-body">
 <a  id="viewdata" href="#datauser" data-toggle="modal" ></a>
 
<section class="panel">
<header class="panel-heading tab-bg-dark-navy-blue " style="background: #00A8B3; height: 38px;">
<ul class="nav nav-tabs">
<li class="active">
<a data-toggle="tab" href="#home">Personal</a>

</li>

<?php if(!isset($family_member)){?>
<li class="">
<a data-toggle="tab" href="#about">Address</a>
</li>
<li class="">
<a data-toggle="tab" href="#profile">Next Of Kin</a>
</li>
<?php }?>

<li class="">
<a data-toggle="tab" href="#contact">Physcal Attributes</a>

    <?php if($patient['patient_type_code'] == "H"){?>
</li>

    <li class="" >
        <a data-toggle="tab" href="#hmo">Hmo</a>
    </li>

</ul>

    <?php } ?>


</header>
<div class="panel-body">
<div class="tab-content">
<div id="home" class="tab-pane active">

<form name="personal_form" method="post" action="<?= base_url() ?>index.php/patient/updatePersonalData">
 <?php if(isset($family_member)){?>
    <input name="patient_family_id" type="hidden" value="<?php echo $family_member['patient_family_id']?>"/>
 <?php }?>
   
<div class="form-group">
    <label for="exampleInputEmail1">First Name</label>
    <input type="text" class="form-control" value="<?php echo ucfirst($patient['first_name']); ?>" name="first_name" id="first_name" placeholder="First Name" >
     <input type="hidden" name="patient_number" value="<?php echo $patient['patient_number'];?>"/>
</div>

<div class="form-group">
    <label for="exampleInputEmail1">Middle Name</label>
    <input type="text" class="form-control" value="<?php echo ucfirst($patient['middle_name']); ?>" name="middle_name" id="middle_name" placeholder="Middle Name" >
 
</div>


<div class="form-group">
    <label for="exampleInputEmail1">Last Name</label>
    <input  type="text" class="form-control" value="<?php echo ucfirst($patient['last_name']); ?>" name="last_name" id="last_name" placeholder="Last Name" >
 
</div>


            
   <div class="form-group">
    <label for="exampleInputEmail1">Date Of Birth</label>
    <input name="dob" id="dob" class="form-control form-control-inline input-medium default-date-picker" size="16" type="text"
            value="<?php  if(isset($dob))echo $dob; ?>" />
</div>

  
   <?php if(!isset($family_member)){?>
 
  <div class="form-group">
    <label for="exampleInputEmail1">Marital Status</label>
    <select class="form-control" name="marital_status" id="marital_status" >
    
    
    <option <?php if($patient['marital_status'] == "M")echo "selected='selected'"?> value="M">Married</option>
    <option <?php if($patient['marital_status'] == "S")echo "selected='selected'"?> value="S">Single</option>
    
</select>

</div>
  

  
  
  <div class="form-group">
    <label for="exampleInputEmail1">Occupation</label>
    <select class="form-control" name="occupation_id" id="occupation_id" >
    
    <?php foreach($occupations as $u){?>
        <?php if($u['occupation_id'] == $occupation['occupation_id']){?>
    <option value="<?php echo $u['occupation_id'];?>" selected="selected"> <?php echo ucwords($u['occupation_name']);?></option>
    
        <?php } else { ?>
         <option value="<?php echo $u['occupation_id'];?>"> <?php echo ucwords($u['occupation_name']);?></option>
        <?php }?>
     <?php }?>
    
</select>

</div>
  
  
  
  <div class="form-group">
    <label for="exampleInputEmail1">Religion</label>
    <select class="form-control" name="religion_id" id="religion_id" >
    
    <?php foreach($religions as $u){?>
        <?php if($u['religion_id'] == $religion['religion_id']){?>
    <option value="<?php echo $u['religion_id'];?>" selected="selected"> <?php echo ucwords($u['religion_name']);?></option>
    
        <?php } else { ?>
         <option value="<?php echo $u['religion_id'];?>"> <?php echo ucwords($u['religion_name']);?></option>
        <?php }?>
     <?php }?>
    
</select>

</div>
  
   <?php }?>
  
  <div class="form-group">
    <label for="exampleInputEmail1">Mobile Number</label>
    <input name="mobile_number" id="mobile_number" value="<?php  if(isset($patient['mobile_number']))echo $patient['mobile_number']; ?>" type="text" placeholder="" data-mask="(999) 999-9999-999" class="form-control">
    <span class="help-inline">(234) 809-9999-999</span>
</div>
  
  
  <div class="form-group">
    <label for="exampleInputEmail1">Cell Number</label>
     <input name="cell_number" id="cell_number" value="<?php  if(isset($patient['cell_number']))echo $patient['cell_number']; ?>" type="text" placeholder="" data-mask="(999) 999-9999-999" class="form-control">
    <span class="help-inline">(234) 809-9999-999</span>
</div>
    
    
    
 <div class="form-group">
    <label for="exampleInputEmail1">Email</label>
    <input type="text" class="form-control" value="<?php echo strtolower($patient['email']); ?>" name="email" id="email" placeholder="Email" >
 
</div>
    
    <div class="form-group">
    <label for="exampleInputEmail1">Alternate Email</label>
    <input type="text" class="form-control" value="<?php echo strtolower($patient['alt_email']); ?>" name="alt_email" id="alt_email" placeholder="Alt Email" >
 
</div>

<div class="form-group">
    <label for="exampleInputEmail1">Free Code 1</label>
    <select class="form-control" name="free_code_1" id="free_code_1" >
    
    <?php foreach($freecodes1 as $code){?>
        <?php if($code['id'] == $freecode1['id']){?>
    <option value="<?php echo $code["id"]; ?>" selected="selected"><?php echo ucfirst($code["name"]); ?></option>
                                               
    
        <?php } else { ?>

		 <option value="<?php echo $code["id"]; ?>"><?php echo ucfirst($code["name"]); ?></option>
		 
        <?php }?>
     <?php }?>
    
</select>

</div>

<div class="form-group">
    <label for="exampleInputEmail1">Free Code 2</label>
    <select class="form-control" name="free_code_2" id="free_code_2" >
    
    <?php foreach($freecodes2 as $code){?>
        <?php if($code['id'] == $freecode2['id']){?>
	<option value="<?php echo $code["id"]; ?>" selected="selected"><?php echo ucfirst($code["name"]); ?></option>
    
        <?php } else { ?>
		 <option value="<?php echo $code["id"]; ?>"><?php echo ucfirst($code["name"]); ?></option>
        <?php }?>
     <?php }?>
    
</select>

</div>


    

    <button type="button" id="update_personal" class="btn btn-default" onclick="javascript:updatePersonal();">Update</button>
  
    <script>
        
        function updatePersonal() {
            
            var error = false; 
            //code
            var firstname = $.trim($("input#first_name").val());
            var lastname = $.trim($("input#last_name").val());
            
            
            if (lastname == "") {
                //code
                
                error = true;
                alert("First Name Cannot be empty");
            }
            
             if (lastname == "") {
                //code
                error = true;
                
                alert("Last Name Cannot be empty");
            }
            
            if (error) {
                //code
            }
            else
            {
                $("form[name=personal_form]").submit();
            }
            
        }
        
    </script>
    
</form>


</div>

<!--address data-->
<div id="about" class="tab-pane">
 
 <form name="address_update" method="post" action="<?= base_url() ?>index.php/patient/updateAddressData">
  <div class="form-group">
    <label for="exampleInputEmail1">Address Line 1</label>
    <input type="text" class="form-control" value="<?php echo ucwords($patient['address_line_1']); ?>" name="address_line_1" id="address_line_1" placeholder="Address Line 1">
    <input type="hidden" name="patient_number" value="<?php echo $patient['patient_number'];?>"/>
</div>
  

  <div class="form-group">
    <label for="exampleInputEmail1">Address Line 2</label>
    <input type="text" class="form-control" value="<?php echo ucwords($patient['address_line_2']); ?>" name="address_line_2" id="address_line_2" placeholder="Address Line 2">
 
</div>
  
  
    <div class="form-group">
    <label for="exampleInputEmail1">State</label>
    <select class="form-control" name="address_state_code" id="address_state_code" >
    
    <?php foreach($address_states as $u){?>
        <?php if($u['state_code'] == $patient['address_state_code']){?>
    <option value="<?php echo $u['state_code'];?>" selected="selected"> <?php echo ucwords($u['state_name']);?></option>
    
        <?php } else { ?>
         <option value="<?php echo $u['state_code'];?>"> <?php echo ucwords($u['state_name']);?></option>
        <?php }?>
     <?php }?>
    
</select>

</div>
    
    
     <div class="form-group">
    <label for="exampleInputEmail1">Country</label>
    <select class="form-control" name="address_country_code" id="address_country_code" >
    
    <?php foreach($countries as $u){?>
        <?php if($u['country_code'] == $patient['address_country_code']){?>
    <option value="<?php echo $u['country_code'];?>" selected="selected"> <?php echo ucwords($u['country_name']);?></option>
    
        <?php } else { ?>
         <option value="<?php echo $u['country_code'];?>"> <?php echo ucwords($u['country_name']);?></option>
        <?php }?>
     <?php }?>
     
     
     
    
</select>

</div>
    
<script>
    
    $(document).ready(function(){
        $('select#address_country_code').change(function(){
            
                $('input#get_country_code').val($(this).val());
                
                getStatesByCountry("select#address_state_code");
            });
        });
    
    function getStatesByCountry(selectid) {
        var obj ="";
         var url = "<?= base_url() ?>"+"index.php/state/getStatesByCountryJson";
       
        
        $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#getStates').serialize(),
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
                for (var i = 0; i < arrayLength; i++)
                {
                    var newoption = "<option  style='text-transform: capitalize' value='"+obj[i]['state_code']+"'>"+obj[i]['state_name']+"</option>";
                     
                     $(selectid).append(newoption);
                     
                    
                   
                 
                }
                    
		}catch(e) {		
			alert('Exception while request..');
		}		
		},
		error: function(){						
			alert('Error while request..');
		}
                
                 });
        
        
        
    }
    
</script>

<button type="button" id="update_address" class="btn btn-default" onclick="javascript:updateAddress();">Update</button>

<script>
    
    function updateAddress() {
        //code
        
        $("form[name=address_update]").submit();
    }
</script>
</form>
 
 
</div>
<div id="profile" class="tab-pane">

<form name="updatenextkin" method="post" action="<?= base_url() ?>index.php/patient/updateKinData">

<div class="form-group">
    <label for="exampleInputEmail1">First Name</label>
    <input type="text" class="form-control" value="<?php if(isset($next_of_kin['first_name']))echo ucfirst($next_of_kin['first_name']); ?>" name="first_name" id="nok_first_name" placeholder="First Name">
     <input type="hidden" name="patient_number" value="<?php echo $patient['patient_number'];?>"/>

</div>


<div class="form-group">
    <label for="exampleInputEmail1">Middle Name</label>
    <input type="text" class="form-control" value="<?php if(isset($next_of_kin['middle_name']))echo ucfirst($next_of_kin['middle_name']); ?>" name="middle_name" id="nok_middle_name" placeholder="Middle Name" >
 
</div>


<div class="form-group">
    <label for="exampleInputEmail1">Last Name</label>
    <input type="text" class="form-control" value="<?php if(isset($next_of_kin['last_name']))echo ucfirst($next_of_kin['last_name']); ?>" name="last_name" id="nok_last_name" placeholder="Last Name" >
 
</div>

     <div class="form-group">
    <label for="exampleInputEmail1">Relationship</label>
    <select class="form-control" name="relationship_id" id="relationship_id" >
    <option></option>
    <?php foreach($relationships as $u){?>
        <?php if($u['relationship_id'] == $next_of_kin['relationship_id']){?>
    <option value="<?php echo $u['relationship_id'];?>" selected="selected"> <?php echo ucwords($u['relationship_name']);?></option>
    
        <?php } else { ?>
         <option value="<?php echo $u['relationship_id'];?>"> <?php echo ucwords($u['relationship_name']);?></option>
        <?php }?>
     <?php }?>
     
    
</select>

</div>
     
     
 
  <div class="form-group">
    <label for="exampleInputEmail1">Mobile Number</label>
    <input name="mobile_number" id="nok_mobile_number" value="<?php  if(isset($next_of_kin['mobile_number']))echo $next_of_kin['mobile_number']; ?>" type="text" placeholder="" data-mask="(999) 999-9999-999" class="form-control">
    <span class="help-inline">(234) 809-9999-999</span>
</div>
  
  
  <div class="form-group">
    <label for="exampleInputEmail1">Cell Number</label>
     <input name="cell_number" id="nok_cell_number" value="<?php  if(isset($next_of_kin['cell_number']))echo $next_of_kin['cell_number']; ?>" type="text" placeholder="" data-mask="(999) 999-9999-999" class="form-control">
    <span class="help-inline">(234) 809-9999-999</span>
</div>
  
  
  
   <div class="form-group">
    <label for="exampleInputEmail1">Address Line 1</label>
    <input type="text" class="form-control" value="<?php if(isset($next_of_kin['address_line_1'])) echo ucwords($next_of_kin['address_line_1']); ?>" name="address_line_1" id="nok_address_line_1" placeholder="Address Line 1">
 
</div>
  

  <div class="form-group">
    <label for="exampleInputEmail1">Address Line 2</label>
    <input type="text" class="form-control" value="<?php if(isset($next_of_kin['address_line_2'])) echo ucwords($next_of_kin['address_line_2']); ?>" name="address_line_2" id="nok_address_line_2" placeholder="Address Line 2">
 
</div>
  
     <div class="form-group">
    <label for="exampleInputEmail1">State</label>
    <select class="form-control" name="kin_state_code" id="kin_state_code" >
    <option value=""></option>
    <?php foreach($kin_states as $u){?>
        <?php if($u['state_code'] == $patient['address_state_code']){?>
    <option value="<?php echo $u['state_code'];?>" selected="selected"> <?php echo ucwords($u['state_name']);?></option>
    
        <?php } else { ?>
         <option value="<?php echo $u['state_code'];?>"> <?php echo ucwords($u['state_name']);?></option>
        <?php }?>
     <?php }?>
    
</select>

</div>
     <script>
    
    $(document).ready(function(){
        $('select#nok_country_code').change(function(){
            
                $('input#get_country_code').val($(this).val());
                
                getStatesByCountry("select#kin_state_code");
            });
        });
     </script>
  
  
  <div class="form-group">
    <label for="exampleInputEmail1">Country</label>
    <select class="form-control" name="country_code" id="nok_country_code" >
    
    <option></option>
    <?php foreach($countries as $u){?>
        <?php if($u['country_code'] == $next_of_kin['country_code']){?>
    <option value="<?php echo $u['country_code'];?>" selected="selected"> <?php echo ucwords($u['country_name']);?></option>
    
        <?php } else { ?>
         <option value="<?php echo $u['country_code'];?>"> <?php echo ucwords($u['country_name']);?></option>
        <?php }?>
     <?php }?>
     
     
     
    
</select>

</div>
  
  
  
  <button type="button" id="update_kin" class="btn btn-default" onclick="javascript:updateKin();">Update</button>

  
</form>
  <script>
    function updateKin() {
        //code
        var error = false;
        
        var first_name = $.trim($("input#nok_first_name").val());
        var last_name = $.trim($("input#nok_last_name").val());
        
        if (first_name == "") {
            //code
            error = true;
            alert("Supply kin first name");
        }
         if (last_name == "") {
            //code
            error = true;
            alert("Supply kin last name");
        }
        
        if (error) {
            //code
        }
        else
        {
             $("form[name=updatenextkin]").submit();
        }
       
    }
    
  </script>

</div>
<div id="contact" class="tab-pane">
    
    <form name="updatePhysic" method="post" action="<?= base_url() ?>index.php/patient/updatePhysicData">
        <?php if(isset($family_member)){?>
    <input name="patient_family_id" type="hidden" value="<?php echo $family_member['patient_family_id']?>"/>
 <?php }?>
 
 
     <div class="form-group">
    <label for="exampleInputEmail1">Blood Group</label>
         <input type="hidden" name="patient_number" value="<?php echo $patient['patient_number'];?>"/>

    <select class="form-control" name="blood_group_id" id="nok_blood_group_id" >
    
    <option></option>
    <?php foreach($bloodgroups as $u){?>
        <?php if($u['blood_group_id'] == $bloodgroup['blood_group_id']){?>
    <option value="<?php echo $u['blood_group_id'];?>" selected="selected"> <?php echo ucwords($u['blood_group_code']);?></option>
    
        <?php } else { ?>
         <option value="<?php echo $u['blood_group_id'];?>"> <?php echo ucwords($u['blood_group_code']);?></option>
        <?php }?>
     <?php }?>
     
     
     
    
</select>

</div>
     
    
    
    
    
      <div class="form-group">
    <label for="exampleInputEmail1">GenoType</label>
    <select class="form-control" name="genotype_id" id="nok_genotype_id" >
    
    <option></option>
    <?php foreach($phenotypes as $u){?>
        <?php if($u['phenotype_id'] == $phenotype['phenotype_id']){?>
    <option value="<?php echo $u['phenotype_id'];?>" selected="selected"> <?php echo ucwords($u['phenotype_code']);?></option>
    
        <?php } else { ?>
         <option value="<?php echo $u['phenotype_id'];?>"> <?php echo ucwords($u['phenotype_code']);?></option>
        <?php }?>
     <?php }?>
     
     
     
    
</select>

</div>
    
 
  <div class="form-group">
    <label for="exampleInputEmail1">Height</label>
    <input type="text" class="form-control" value="<?php echo $patient['height']; ?>" name="height" id="height" placeholder="Height">
 
</div>
  
  

  <div class="form-group">
    <label for="exampleInputEmail1">Weight</label>
    <input type="text" class="form-control" value="<?php echo $patient['weight']; ?>" name="weight" id="weight" placeholder="Weight">
 
</div>
  
   <button type="submit" id="update_physic" class="btn btn-default" onclick="javascript:updatePhysic();">Update</button>

</form>




</div>
    <div id="hmo" class="tab-pane">

        <form name="updateHmo" method="post" action="<?= base_url() ?>index.php/patient/updateHmo">


			 <div class="form-group">
				<label for="exampleInputEmail1">HMO CODE</label>
				<select name="hmo_code" id="hmo_code" class="form-control m-bot15">
						<option value="<?php echo $patient['hmo_code']; ?>"><?php echo $patient['hmo_code']; ?></option>
						<?php
						foreach($providers as $hmo)
						{
							echo "<option value='".$hmo['hmo_code']."'>".ucfirst($hmo['hmo_name'])."</option>";
						}
						?>
				
					</select>
			</div>

            <div class="form-group">
                <label for="exampleInputEmail1">HMO Enrolle ID</label>
                <input type="text" class="form-control" value="<?php echo ($patient['hmo_enrolee_id']); ?>"
                       name="hmo_enrolee_id" id="hmo_enrolee_id" placeholder="HMO ENROLLEE ID">
                <input type="hidden" name="patient_number" value="<?php echo $patient['patient_number'];?>"/>

            </div>	

            <button type="button" id="update_physic" class="btn btn-default" onclick="javascript:updateHmoData();">Update</button>

        </form>


        <script>
            function updateHmoData(){

                var enroleeId = $("input#hmo_enrolee_id").val();
                if($.trim(enroleeId) == ""){
                    alert("HMO ID can not be empty");
                }else{
                    $("form[name=updateHmo]").submit();
                }
            }
        </script>


    </div>

</div>
</div>
</section>
 


 
</div>
</div>
</div>
</div>
       
       

    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal3" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Select Data to Upload</h4>
</div>
<div class="modal-body">
 
 
<div class=" state-overview">   
    <section class="panel">
    <div class="symbol red" style="background:#66ff60;">
    <i class="fa fa-picture-o"></i>
    </div>
    <div class="value">
    <a href="#" id ="picdata">
    <h1>Picture Data</h1>
    </a>
    <p></p>
    </div>
    </section>
</div>
 
 
 <div class=" state-overview">   
    <section class="panel">
    <div class="symbol red" style="background:#66ff60;">
   
    <i class="fa fa-folder-open"></i>
    
    </div>
    <div class="value">
    <a href="#" id ="userdata">
    <h1>User Data</h1>
    </a>
    <p></p>
    </div>
    </section>
</div>
 
 <script>
    $(document).ready(function(){
            
            $("#userdata").click(function(){
                
                   $("button.close").click();
                   $("a#viewdata").click();
                   
                   
                });
            
            
            $("#picdata").click(function(){
                
                   $("button.close").click();
                   $("a#viewpicdata").click();
                   
                   
                });
        
        });
 </script>
 
</div>
</div>
</div>
</div>
    
    
    
    
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="picturedata" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Manage Patient Picture</h4>
</div>
<div class="modal-body">
 
  <a  id="viewpicdata" href="#picturedata" data-toggle="modal" ></a>

 


<?php /**echo form_open_multipart(base_url()."index.php/patient/uploadPatientPic");**/?>

<form name="uploadpatientpic" enctype="multipart/form-data" action="<?=base_url()?>index.php/patient/uploadPatientPic" method="post">
<input type="hidden" id="patient_number" value="<?php echo $patient['patient_number'];?>" name="patient_number"/>
 <?php if(isset($family_member)){ ?>
 <input type="hidden" value="<?php echo $family_member['patient_family_id'];?>" name="patient_family_id"/>
   <?php } ?>
 <div class="form-group">
<label class="control-label col-md-3">Select New Patient Picture</label>
<div class="controls col-md-9">
<div class="fileupload fileupload-new" data-provides="fileupload">
<span class="btn btn-white btn-file">
<span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select Picture</span>
<span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>

<input id="pic" type="file" name="userfile" size="20"  class="default"/>

</span>
<span class="fileupload-preview" style="margin-left:5px;"></span>
<a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
</div>
</div>
</div>
 
 
  <button type="button" id="upload" class="btn btn-default" onclick="javascript:uploadPic();">Upload</button>
   </form>

 <script>
    
    function uploadPic() {
        //code
       $("form[name=uploadpatientpic]").submit();
    }
 </script>
</div>
</div>
</div>
</div>
    



    
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal2" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title"><?php if(isset($vitals['date_created'])){ ?>Vital Readings. Taken on <?php echo $vitals['date_created']; ?><?php } else echo "No Previous Vital Reading"?></h4>
</div>
<div class="modal-body">
 
  <?php if(isset($vitals['blood_pressure']) && $vitals['blood_pressure'] != ""){?>
<div class=" state-overview">   
    <section class="panel">
    <div class="symbol red">
    <i class="fa fa-heart"></i>
    </div>
    <div class="value">
    <h1><?php foreach($unit as $u){if($u['id'] == $vitals['blood_pressure_unit']){
             echo $vitals['blood_pressure']." ".$u['symbol'];
             break;
        }}
    ?></h1>
    <p>Systolic Blood Pressure</p>
    </div>
    </section>
</div>
 <?php }?>
 
  <?php if(isset($vitals['blood_presure_diastolic']) && $vitals['blood_presure_diastolic'] != ""){?>
<div class=" state-overview"> 
<section class="panel">
<div class="symbol red">
<i class="fa fa-heart"></i>
</div>
<div class="value">
<h1><?php foreach($unit as $u){if($u['id'] == $vitals['blood_pressure_unit']){
             echo $vitals['blood_presure_diastolic']." ".$u['symbol'];
             break;
        }}
    ?></h1>
<p>Diastolic Blood Pressure</p>
</div>
</section>
</div>
<?php }?>

 <?php if(isset($vitals['temperature']) && $vitals['temperature'] != ""){?>
<div class=" state-overview">   
    <section class="panel">
    <div class="symbol red">
    <i class="fa fa-tags"></i>
    </div>
    <div class="value">
    <h1><?php foreach($unit as $u){if($u['id'] == $vitals['temperature_unit']){
             echo $vitals['temperature']." ".$u['symbol'];
             break;
        }}
    ?></h1>
    <p>Temperature</p>
    </div>
    </section>
</div>
<?php }?>


 <?php if(isset($vitals['respiratory_rate']) && $vitals['respiratory_rate'] != ""){?>
 
<div class=" state-overview"> 
<section class="panel">
<div class="symbol red">
<i class="fa fa-tags"></i>
</div>
<div class="value">
<h1><?php foreach($unit as $u){if($u['id'] == $vitals['respiratory_rate_unit']){
             echo $vitals['respiratory_rate']." ".$u['symbol'];
             break;
        }}
    ?></h1>
<p>Respiratory Rate</p>
</div>
</section>
</div>
<?php }?>


 <?php if(isset($vitals['feotal_heart_rate']) && $vitals['feotal_heart_rate'] != ""){?>
<div class=" state-overview">   
    <section class="panel">
    <div class="symbol red">
    <i class="fa fa-tags"></i>
    </div>
    <div class="value">
    <h1><?php foreach($unit as $u){if($u['id'] == $vitals['feotal_heart_rate_unit']){
             echo $vitals['feotal_heart_rate']." ".$u['symbol'];
             break;
        }}
    ?></h1>
    <p>Feotal Heart Rate</p>
    </div>
    </section>
</div>
<?php }?>


 <?php if(isset($vitals['spo2']) && $vitals['spo2'] != ""){?>
<div class=" state-overview">   
    <section class="panel">
    <div class="symbol red">
    <i class="fa fa-tags"></i>
    </div>
    <div class="value">
    <h1><?php foreach($unit as $u){if($u['id'] == $vitals['spo2_unit']){
             echo $vitals['spo2']." ".$u['symbol'];
             break;
        }}
    ?></h1>
    <p>SPO2</p>
    </div>
    </section>
</div>
<?php }?>


<?php if(isset($vitals['bmi']) && $vitals['bmi'] != ""){?>
<div class=" state-overview">   
    <section class="panel">
    <div class="symbol red">
    <i class="fa fa-tags"></i>
    </div>
    <div class="value">
    <h1><?php foreach($unit as $u){if($u['id'] == $vitals['bmi_unit']){
             echo $vitals['bmi']." ".$u['symbol'];
             break;
        }}
    ?></h1>
    <p>BMI</p>
    </div>
    </section>
</div>
<?php }?>



</div>
</div>
</div>
</div>
    
    
    
    
    
    
    
    
    
	
	
	
	
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal10" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Allergies</div>
<div class="modal-body">
    
<table class="table table-hover">
<thead>
<tr>
<th>#</th>
<th>Date</th>
<th>Allergy</th>
<th>Doctor</th>
</tr>
</thead> 



    <input type="hidden" id="patient_number" value="<?php echo $patient['patient_number'];?>" name="patient_number"/>

    <?php foreach($allergy as $allergies){?>
		<tr>
			<td><?php echo $allergies['consultation_id']; ?></td>
			<td><?php echo $allergies['date_time_created']; ?></td>
			<td><?php echo $allergies['allergy']; ?></td>
			<td><?php foreach($doctors as $doctor){ if($allergies['consulting_doctor'] == $doctor['staff_no']){echo ucfirst($doctor['first_name'])." ".ucfirst($doctor['last_name']); break;}} ?></td>
		</tr>
     <?php }?>
    

</table>
 
 



</div>
</div>
</div>
</div>
	
	
	
	



<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal11" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Examination</div>
<div class="modal-body">
    
<table class="table table-hover">
<thead>
<tr>
<th>#</th>
<th>Date</th>
<th>Examination</th>
<th>Doctor</th>
</tr>
</thead> 



    <input type="hidden" id="patient_number" value="<?php echo $patient['patient_number'];?>" name="patient_number"/>

    <?php foreach($examination as $examinations){?>
		<tr>
			<td><?php echo $examinations['consultation_id']; ?></td>
			<td><?php echo $examinations['date_time_created']; ?></td>
			<td><?php echo $examinations['examination']; ?></td>
			<td><?php foreach($doctors as $doctor){ if($examinations['consulting_doctor'] == $doctor['staff_no']){echo ucfirst($doctor['first_name'])." ".ucfirst($doctor['last_name']); break;}} ?></td>
		</tr>
     <?php }?>
    

</table>
 
 



</div>
</div>
</div>
</div>
	
	



<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal13" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Past Medical History</div>
<div class="modal-body">
    
<table class="table table-hover">
<thead>
<tr>
<th>#</th>
<th>Date</th>
<th>Past Medical Histories</th>
<th>Doctor</th>
</tr>
</thead> 



    <input type="hidden" id="patient_number" value="<?php echo $patient['patient_number'];?>" name="patient_number"/>

    <?php foreach($pastmedicalhistory as $pastmedicalhistories){?>
		<tr>
			<td><?php echo $pastmedicalhistories['consultation_id']; ?></td>
			<td><?php echo $pastmedicalhistories['date_time_created']; ?></td>
			<td><?php echo $pastmedicalhistories['past_medical_history']; ?></td>
			<td><?php foreach($doctors as $doctor){ if($pastmedicalhistories['consulting_doctor'] == $doctor['staff_no']){echo ucfirst($doctor['first_name'])." ".ucfirst($doctor['last_name']); break;}} ?></td>
		</tr>
     <?php }?>
    

</table>
 
 



</div>
</div>
</div>
</div>



<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal23" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Legacy Medical History</div>
<div class="modal-body">
    
<table class="table table-hover">
<thead>
<tr>
<th>#</th>
<th>Date</th>
<th>Description</th>
<th>DOctors Notes</th>
<th>Doctor</th>
</tr>
</thead> 



    <input type="hidden" id="patient_number" value="<?php echo $patient['patient_number'];?>" name="patient_number"/>

    <?php foreach($legacymedicalhistory as $legacymedicalhistories){?>
		<tr>
			<td><?php echo $legacymedicalhistories['patient_history_id']; ?></td>
			<td><?php echo $legacymedicalhistories['date_created']; ?></td>
			<td><?php echo $legacymedicalhistories['description']; ?></td>
			<td><?php echo $legacymedicalhistories['doctors_notes']; ?></td>
			<td><?php foreach($doctors as $doctor){ if($legacymedicalhistories['consulting_doctor'] == $doctor['staff_no']){echo ucfirst($doctor['first_name'])." ".ucfirst($doctor['last_name']); break;}} ?></td>
		</tr>
     <?php }?>
    

</table>
 
 



</div>
</div>
</div>
</div>



<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal14" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Diagnosis</div>
<div class="modal-body">
    
<table class="table table-hover">
<thead>
<tr>
<th>#</th>
<th>Date</th>
<th>Diagnosis</th>
<th>Doctor</th>
</tr>
</thead> 



    <input type="hidden" id="patient_number" value="<?php echo $patient['patient_number'];?>" name="patient_number"/>

    <?php foreach($diagnosis as $diagnosiss){?>
		<tr>
			<td><?php echo $diagnosiss['consultation_id']; ?></td>
			<td><?php echo $diagnosiss['date_time_created']; ?></td>
			<td><?php echo $diagnosiss['diagnosis']; ?></td>
			<td><?php foreach($doctors as $doctor){ if($diagnosiss['consulting_doctor'] == $doctor['staff_no']){echo ucfirst($doctor['first_name'])." ".ucfirst($doctor['last_name']); break;}} ?></td>
		</tr>
     <?php }?>
    

</table>
 
 



</div>
</div>
</div>
</div>



<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal15" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Surgery</div>
<div class="modal-body">
    
<table class="table table-hover">
<thead>
<tr>
<th>#</th>
<th>Date</th>
<th>Surgery</th>
<th>Doctor</th>
</tr>
</thead> 



    <input type="hidden" id="patient_number" value="<?php echo $patient['patient_number'];?>" name="patient_number"/>

    <?php foreach($surgery as $surgeries){?>
		<tr>
			<td><?php echo $surgeries['consultation_id']; ?></td>
			<td><?php echo $surgeries['date_time_created']; ?></td>
			<td><?php echo $surgeries['surgery_history']; ?></td>
			<td><?php foreach($doctors as $doctor){ if($surgeries['consulting_doctor'] == $doctor['staff_no']){echo ucfirst($doctor['first_name'])." ".ucfirst($doctor['last_name']); break;}} ?></td>
		</tr>
     <?php }?>
    

</table>
 </div>
</div>
</div>
</div>



<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal16" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Presenting History</div>
<div class="modal-body">
    
<table class="table table-hover">
<thead>
<tr>
<th>#</th>
<th>Date</th>
<th>Presnting History</th>
<th>Doctor</th>
</tr>
</thead> 



    <input type="hidden" id="patient_number" value="<?php echo $patient['patient_number'];?>" name="patient_number"/>

    <?php foreach($presentinghistory as $presentinghistories){?>
		<tr>
			<td><?php echo $presentinghistories['consultation_id']; ?></td>
			<td><?php echo $presentinghistories['date_time_created']; ?></td>
			<td><?php echo $presentinghistories['presenting_history']; ?></td>
			<td><?php foreach($doctors as $doctor){ if($presentinghistories['consulting_doctor'] == $doctor['staff_no']){echo ucfirst($doctor['first_name'])." ".ucfirst($doctor['last_name']); break;}} ?></td>
		</tr>
     <?php }?>
    

</table>
 </div>
</div>
</div>
</div>




<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal17" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Treatement</div>
<div class="modal-body">
    
<table class="table table-hover">
<thead>
<tr>
<th>#</th>
<th>Date</th>
<th>Treatment</th>
<th>Doctor</th>
</tr>
</thead> 



    <input type="hidden" id="patient_number" value="<?php echo $patient['patient_number'];?>" name="patient_number"/>

    <?php foreach($treatment as $treatments){?>
		<tr>
			<td><?php echo $treatments['consultation_id']; ?></td>
			<td><?php echo $treatments['date_time_created']; ?></td>
			<td><?php echo $treatments['treatment']; ?></td>
			<td><?php foreach($doctors as $doctor){ if($treatments['consulting_doctor'] == $doctor['staff_no']){echo ucfirst($doctor['first_name'])." ".ucfirst($doctor['last_name']); break;}} ?></td>
		</tr>
     <?php }?>
    

</table>
 </div>
</div>
</div>
</div>




<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal18" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Gynaecology</div>
<div class="modal-body">
    
<table class="table table-hover">
<thead>
<tr>
<th>#</th>
<th>Date</th>
<th>Gynaecology history</th>
<th>Doctor</th>
</tr>
</thead> 



    <input type="hidden" id="patient_number" value="<?php echo $patient['patient_number'];?>" name="patient_number"/>

    <?php foreach($gynaecology as $gynaecologies){?>
		<tr>
			<td><?php echo $gynaecologies['consultation_id']; ?></td>
			<td><?php echo $gynaecologies['date_time_created']; ?></td>
			<td><?php echo $gynaecologies['gynaecology_history']; ?></td>
			<td><?php foreach($doctors as $doctor){ if($gynaecologies['consulting_doctor'] == $doctor['staff_no']){echo ucfirst($doctor['first_name'])." ".ucfirst($doctor['last_name']); break;}} ?></td>
		</tr>
     <?php }?>
    

</table>
 </div>
</div>
</div>
</div>

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal19" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">System review</div>
<div class="modal-body">
    
<table class="table table-hover">
<thead>
<tr>
<th>#</th>
<th>Date</th>
<th>System review</th>
<th>Doctor</th>
</tr>
</thead> 



    <input type="hidden" id="patient_number" value="<?php echo $patient['patient_number'];?>" name="patient_number"/>

    <?php foreach($systemreview as $systemreviews){?>
		<tr>
			<td><?php echo $systemreviews['consultation_id']; ?></td>
			<td><?php echo $systemreviews['date_time_created']; ?></td>
			<td><?php echo $systemreviews['review_system']; ?></td>
			<td><?php foreach($doctors as $doctor){ if($systemreviews['consulting_doctor'] == $doctor['staff_no']){echo ucfirst($doctor['first_name'])." ".ucfirst($doctor['last_name']); break;}} ?></td>
		</tr>
     <?php }?>
    

</table>
 </div>
</div>
</div>
</div>







<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal8" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Input Chart</div>
<div class="modal-body">
    
<table class="table table-hover">
<thead>
<tr>
<th>Date</th>
<th>Intake Amt</th>
<th>Intake Type</th>
<th>Intake Date</th>
<th>Intake Time</th>
</tr>
</thead> 



    <input type="hidden" id="patient_number" value="<?php echo $patient['patient_number'];?>" name="patient_number"/>

    <?php foreach($getintaketype as $getintaketypes){?>
		<tr>
			<td><?php echo $getintaketypes['date_created']; ?></td>
			<td><?php echo $getintaketypes['intake_amount']; ?></td>
			<td><?php foreach($intaketype as $intaketypes){ if($intaketypes['id'] == $getintaketypes['intake_type']){echo ucfirst($intaketypes['type']); break;}} ?></td>
			<td><?php echo $getintaketypes['intake_date']; ?></td>
			<td><?php echo $getintaketypes['intake_time']; ?></td>
		
		</tr>
     <?php }?>
    

</table>
 </div>
</div>
</div>
</div>





<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal9" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Output Chart</div>
<div class="modal-body">
    
<table class="table table-hover">
<thead>
<tr>
<th>Date</th>
<th>Output Amt</th>
<th>Output Type</th>
<th>Output Date</th>
<th>Output Time</th>
</tr>
</thead> 



    <input type="hidden" id="patient_number" value="<?php echo $patient['patient_number'];?>" name="patient_number"/>

    <?php foreach($getoutputtype as $getoutputtypes){?>
		<tr>
			<td><?php echo $getoutputtypes['date_created']; ?></td>
			<td><?php echo $getoutputtypes['output_amount']; ?></td>
			<td><?php foreach($outputtype as $outputtypes){ if($outputtypes['id'] == $getoutputtypes['output_type']){echo ucfirst($outputtypes['type']); break;}} ?></td>
			<td><?php echo $getoutputtypes['output_date']; ?></td>
			<td><?php echo $getoutputtypes['output_time']; ?></td>
		
		</tr>
     <?php }?>
    

</table>
 </div>
</div>
</div>
</div>




<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal20" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Historic Vitals</div>
<div class="modal-body">
    
<table class="table table-hover">
<thead>
<tr>
<th>Date</th>
<th>Temp</th>
<th>BP Sys</th>
<th>BP Dia</th>
<th>Pulse</th>
<th>Resp Rate</th>
<th>Feotal HR</th>
<th>SPO2</th>
<th>BMI</th>
</tr>
</thead> 



    <input type="hidden" id="patient_number" value="<?php echo $patient['patient_number'];?>" name="patient_number"/>

    <?php foreach($vitalhistory as $vitalhistories){?>
		<tr>
			<td><?php echo $vitalhistories['date_created']; ?></td>
			<td><?php echo $vitalhistories['temperature']; ?> <?php foreach($unit as $units){ if($vitalhistories['temperature_unit'] == $units['id']){echo ucfirst($units['unit_name']); break;}} ?></td>
			<td><?php echo $vitalhistories['blood_pressure']; ?> <?php foreach($unit as $units){ if($vitalhistories['blood_pressure_unit'] == $units['id']){echo ucfirst($units['unit_name']); break;}} ?></td>
			<td><?php echo $vitalhistories['blood_presure_diastolic']; ?> <?php foreach($unit as $units){ if($vitalhistories['blood_pressure_unit'] == $units['id']){echo ucfirst($units['unit_name']); break;}} ?></td>
			<td><?php echo $vitalhistories['pulse']; ?> <?php foreach($unit as $units){ if($vitalhistories['pulse_unit'] == $units['id']){echo ucfirst($units['unit_name']); break;}} ?></td>
			<td><?php echo $vitalhistories['respiratory_rate']; ?> <?php foreach($unit as $units){ if($vitalhistories['respiratory_rate_unit'] == $units['id']){echo ucfirst($units['unit_name']); break;}} ?></td>	
			<td><?php echo $vitalhistories['feotal_heart_rate']; ?> <?php foreach($unit as $units){ if($vitalhistories['feotal_heart_rate_unit'] == $units['id']){echo ucfirst($units['unit_name']); break;}} ?></td>
			<td><?php echo $vitalhistories['spo2']; ?> <?php foreach($unit as $units){ if($vitalhistories['spo2_unit'] == $units['id']){echo ucfirst($units['unit_name']); break;}} ?></td>
			<td><?php echo $vitalhistories['bmi']; ?> <?php foreach($unit as $units){ if($vitalhistories['bmi_unit'] == $units['id']){echo ucfirst($units['unit_name']); break;}} ?></td>
		</tr>
     <?php }?>
    

</table>
 
 



</div>
</div>
</div>
</div>



<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal24" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">View Delivery report</div>
<div class="modal-body">
    
<table class="table table-hover">
<thead>
<tr>
<th>Date</th>
<th>Duration</th>
<th>Num of Babies</th>
<th>Delivery Type</th>
<th>Details</th>
</tr>
</thead> 



    <input type="hidden" id="patient_number" value="<?php echo $patient['patient_number'];?>" name="patient_number"/>

    <?php foreach($postdelivery as $postdeliveries){?>
		<tr class="delivery_report" id="<?php echo $postdeliveries['delivery_id']; ?>">
			<td><?php echo $postdeliveries['dob']; ?></td>
			<td><?php echo $postdeliveries['duration_preg']; ?></td>
			<td><?php echo $postdeliveries['num_of_baby']; ?></td>
			<td><?php foreach($deliverttype as $deliverttypes){ if($postdeliveries['delivery_type'] == $deliverttypes['id']){echo ucfirst($deliverttypes['type']); break;}} ?></td>
			<td><button href="#deliveryReportDetails" data-toggle="modal" class="btn btn-xs btn-success" style="margin: 5px;" >View Details</button></td>
		</tr>
     <?php }?>
    

</table>
 </div>
</div>
</div>
</div>

<form name="getDeliveryReportDetails" id="getDeliveryReportDetails"  method="post">
    <input type="hidden" name="deliver_report_id" id="h_deliver_report_id"/>
</form>


<script>
    
	
    $(document).ready(function(){
        
       
       $("tr.delivery_report").css("cursor","pointer").click(function(){
            var id = $(this).attr("id");
            
            $('input#h_deliver_report_id').val(id);
            
            
             var url = "<?= base_url() ?>"+"index.php/patient/getDeliveryReportDataJson";             
             
             $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form[name=getDeliveryReportDetails]').serialize(),
		success: function(json){
                    
		try{
			var obj = jQuery.parseJSON(json);
			//alert( obj['0']['date_created']);
						$("span#delivery_id_date").html(obj['0']['date_created']);
                        $("div#date_of_delivery").html(obj['0']['dob']);
                        $("div#duration_of_preg").html(obj['0']['duration_preg']);
						$("div#number_of_baby").html(obj['0']['num_of_baby']);
						$("div#sex_of_baby").html(obj['0']['sex_baby']);
						$("div#weight_of_baby").html(obj['0']['weight']);
						$("div#delivery_type").html(obj['0']['delivery_type']);
						$("div#babdy_aa_dd").html(obj['0']['baby_a_d']);
						$("div#delivery_id_time").html(obj['0']['time_of_delivery']);
						$("div#first_skin_color").html(obj['0']['first_skin_color']);
						$("div#first_muslce_tone").html(obj['0']['first_muslce_tone']);
						$("div#first_resp_effort").html(obj['0']['first_resp_effort']);
						$("div#first_heart_rate").html(obj['0']['first_heart_rate']);
						$("div#first_resp_to_stimulis").html(obj['0']['first_resp_to_stimulis']);
						$("div#first_apga_total").html(obj['0']['first_apga_total']);
						$("div#fifth_skin_color").html(obj['0']['fifth_skin_color']);
						$("div#fifth_muslce_tone").html(obj['0']['fifth_muslce_tone']);
						$("div#fifth_resp_effort").html(obj['0']['fifth_resp_effort']);
						$("div#fifth_heart_rate").html(obj['0']['fifth_heart_rate']);
						$("div#fifth_resp_to_stimulis").html(obj['0']['fifth_resp_to_stimulis']);
						$("div#fifth_apga_total").html(obj['0']['fifth_apga_total']);
						
						
                        
                       
                        		
			
		}catch(e) {		
			alert('Exception while request..here');
                     
		}		
		},
		error: function(){						
			alert('Error while request..');
		}
                
                
 });
 
 

             
             
             //$("a#viewhist").click();
            
            
        });
        
        });
</script>







<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal28" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">View Referrals</div>
<div class="modal-body">
    
<table class="table table-hover">
<thead>
<tr>
<th>Date created</th>
<th>Reason</th>
<th>Hospital</th>
<th>Doctor</th>
<th>Details</th>
</tr>
</thead> 



    <input type="hidden" id="patient_number" value="<?php echo $patient['patient_number'];?>" name="patient_number"/>

    <?php foreach($referralreport as $referralreports){?>
		<tr class="referral_report" id="<?php echo $referralreports['id']; ?>">
			<td><?php echo $referralreports['date_time_created']; ?></td>
			<td><?php echo $referralreports['reason']; ?></td>
			<td><?php echo $referralreports['hospital_name']; ?></td>
			<td><?php foreach($doctors as $doctor){ if($referralreports['consulting_doctor'] == $doctor['staff_no']){echo ucfirst($doctor['first_name'])." ".ucfirst($doctor['last_name']); break;}} ?></td>
			<td><button href="#referralReportDetails" data-toggle="modal" class="btn btn-xs btn-success" style="margin: 5px;" >View Details</button></td>
			<td><a id="printbutton" href="<?= base_url() ?><?php echo $printReferalDocument.$referralreports['id'];  ?>" target="_blank" ><i class="fa fa-print"></i><b>Print</b></a></td>
		</tr>
     <?php }?>
    

</table>
 </div>
</div>
</div>
</div>

<form name="getReferralReportDetails" id="getReferralReportDetails"  method="post" action="#">
    <input type="hidden" name="referral_report_id" id="h_referral_report_id"/>
</form>



<div aria-hidden="true" aria-labelledby="myModalLabel29" role="dialog" tabindex="-1" id="referralReportDetails" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Referal Report Details</h4>
</div>
<div class="modal-body">


								<div class="form-group">
                                        <th><strong>Referral Date:</strong></th>
                  
                                          <div  name="referal_date" id="referal_date" > 
											</div>
										
                                    </div>



<div class="form-group">
<th><strong>Reason:</strong></th>

<div  name="referal_reason" id="referal_reason" >

</div>
</div>

<div class="form-group">
<label><strong>Refferal Notes:</strong></label>
<div  name="referal_notes" id="referal_notes" >
</div>

</div>

<div class="form-group">
<label><strong>Hospital Name:</strong></label>
<div  name="referal_hospital_name" id="referal_hospital_name" >
</div>

</div>

<div class="form-group">
<label><strong>Hospital Address:</strong></label>

<div  name="hospital_address" id="hospital_address" >
</div>

</div>

<div class="form-group">
<label><strong>Doctor that refered:</strong></label>

<div  name="referal_consulting_doctor" id="referal_consulting_doctor" >
</div>
</div>



</div>
</div>
</div>
</div>





<script>
    
	
    $(document).ready(function(){
        
       
       $("tr.referral_report").css("cursor","pointer").click(function(){
            var id = $(this).attr("id");
            
            $('input#h_referral_report_id').val(id);
            
            
             var url = "<?= base_url() ?>"+"index.php/patient/getReferralReportDataJson";             
             
             $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form[name=getReferralReportDetails]').serialize(),
		success: function(json){
                    
		try{
			var obj = jQuery.parseJSON(json);
			var referal_j_id = obj['0']['id'];
			//alert( obj['0']['date_time_created']);
						$('input#h_referral_report_id').val(id);
						$("div#referal_id").html(obj['0']['id']);
						$("div#referal_date").html(obj['0']['date_time_created']);
                        $("div#referal_reason").html(obj['0']['reason']);
                        $("div#referal_notes").html(obj['0']['refferal_notes']);
						$("div#referal_hospital_name").html(obj['0']['hospital_name']);
						$("div#hospital_address").html(obj['0']['address']);
						$("div#referal_consulting_doctor").html(obj['0']['consulting_doctor']);
						$("div#patient_family_id").html(obj['0']['patient_family_id']);

						
                        
                               		
			
		}catch(e) {		
			alert('Exception while request..here');
                     
		}		
		},
		error: function(){						
			alert('Error while request..');
		}
                
                
 });
 
 
	            
             
             //$("a#viewhist").click();
            
            
        });
        
        });
</script>




<script>
    
	
    $(document).ready(function(){
        
       
       $("tr.surgery_report").css("cursor","pointer").click(function(){
            var id = $(this).attr("id");
            
            $('input#h_surgery_report_id').val(id);
            
            
             var url = "<?= base_url() ?>"+"index.php/patient/getSurgeryReportDataJson";             
             
             $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form[name=getSurgeryReportDetails]').serialize(),
		success: function(json){
                    
		try{
			var obj = jQuery.parseJSON(json);
			//alert( obj['0']['date_time_created']);
						$("div#surgery_id").html(obj['0']['id']);
						$("div#surgery_date_v").html(obj['0']['surgery_date']);
						$("div#operation_v").html(obj['0']['operation']);
						$("div#surgeons_v").html(obj['0']['surgeons']);
						$("div#anaesthetist_v").html(obj['0']['anaesthetist']);
						$("div#indication_v").html(obj['0']['indication']);
						$("div#findings_v").html(obj['0']['findings']);
						$("div#icd10code_v").html(obj['0']['icd10code']);
						$("div#Incision_v").html(obj['0']['Incision']);
						$("div#procedures_v").html(obj['0']['procedures']);
						$("div#closure_v").html(obj['0']['closure']);
						$("div#drains_v").html(obj['0']['drains']);
						$("div#instrument_v").html(obj['0']['instrument']);
						$("div#bloodloss_v").html(obj['0']['bloodloss']);
						$("div#urine_v").html(obj['0']['urine']);
						$("div#date_created_v").html(obj['0']['date_created']);
						$("div#patient_family_id").html(obj['0']['patient_family_id']);

						
                        
                               		
			
		}catch(e) {		
			alert('Exception while request..here');
                     
		}		
		},
		error: function(){						
			alert('Error while request..');
		}
                
                
 });
 
 
	            
             
             //$("a#viewhist").click();
            
            
        });
        
        });
</script>



<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal25" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">View Surgery report</div>
<div class="modal-body">
    
<table class="table table-hover">
<thead>
<tr>
<th>Surgery Date</th>
<th>Operation</th>
<th>Surgeons</th>
<th>Details</th>
</tr>
</thead> 



    <input type="hidden" id="patient_number" value="<?php echo $patient['patient_number'];?>" name="patient_number"/>

    <?php foreach($surgeryreport as $surgeryreports){?>
		<tr class="surgery_report" id="<?php echo $surgeryreports['surgery_id']; ?>">
			<td><?php echo $surgeryreports['surgery_date']; ?></td>
			<td><?php echo $surgeryreports['operation']; ?></td>
			<td><?php echo $surgeryreports['surgeons']; ?></td>
			<td><button href="#surgeryReportDetails" data-toggle="modal" class="btn btn-xs btn-success" style="margin: 5px;" >View Details</button></td>
		</tr>
     <?php }?>
    

</table>
 </div>
</div>
</div>
</div>

<form name="getSurgeryReportDetails" id="getSurgeryReportDetails"  method="post" >
    <input type="hidden" name="surgery_report_id" id="h_surgery_report_id"/>
</form>




<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="surgeryReportDetails" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Surgery Report Details</h4>
</div>
<div class="modal-body">



<div class="form-group">
<label><strong>Surgery Date:</strong></label>
<div  name="surgery_date_v" id="surgery_date_v" >
</div>
</div>


<div class="form-group">
<label><strong>Surgery Date:</strong></label>
<div  name="surgery_date_v" id="operation_v" >
</div>
</div>

<div class="form-group">
<label><strong>Surgeons:</strong></label>
<div  name="surgeons_v" id="surgeons_v" >
</div>
</div>

<div class="form-group">
<label><strong>Anaesthetist:</strong></label>
<div  name="anaesthetist_v" id="anaesthetist_v" >
</div>
</div>

<div class="form-group">
<label><strong>Indication:</strong></label>
<div  name="indication_v" id="indication_v" >
</div>
</div>

<div class="form-group">
<label><strong>Findings:</strong></label>
<div  name="findings_v" id="findings_v" >
</div>
</div>

<div class="form-group">
<label><strong>Icd10code:</strong></label>
<div  name="icd10code_v" id="icd10code_v" >
</div>
</div>

<div class="form-group">
<label><strong>Incision:</strong></label>
<div  name="Incision_v" id="Incision_v" >
</div>
</div>

<div class="form-group">
<label><strong>Procedures:</strong></label>
<div  name="procedures_v" id="procedures_v" >
</div>
</div>

<div class="form-group">
<label><strong>Closure:</strong></label>
<div  name="closure_v" id="closure_v" >
</div>
</div>

<div class="form-group">
<label><strong>Drains:</strong></label>
<div  name="drains_v" id="drains_v" >
</div>
</div>

<div class="form-group">
<label><strong>Instrument:</strong></label>
<div  name="instrument_v" id="instrument_v" >
</div>
</div>

<div class="form-group">
<label><strong>Bloodloss:</strong></label>
<div  name="bloodloss_v" id="bloodloss_v" >
</div>
</div>

<div class="form-group">
<label><strong>Urine:</strong></label>
<div  name="urine_v" id="urine_v" >
</div>
</div>

</div>
</div>
</div>
</div>
    
    
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal4" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Queue Check In</div>
<div class="modal-body">
    
    
 <form id="enterQueue" method="post">
 
 
 <div class="form-group">
<label for="exampleInputEmail1">Deparment</label>
    <input type="hidden" id="patient_number" value="<?php echo $patient['patient_number'];?>" name="patient_number"/>
    <?php if(isset($family_member)){?>
    <input type="hidden" value="<?php echo $family_member['patient_family_id'];?>" name="patient_family_id"/>
  <?php } ?>
<select class="form-control" name="dept_id" id="dept_id" >
     <option value=""></option>
    <?php foreach($departments as $dept){?>
    <option value="<?php echo $dept['dept_id']; ?>"> <?php echo $dept['name'];?></option>
     <?php }?>
    
</select>
</div>
 
 
  <div class="form-group">
<label for="exampleInputEmail1">Doctor</label>

<select class="form-control" name="staff_no" id="staff_no" >
     <option value=""></option>
      
</select>
</div>
  
  
  <button type="button" id="join_queue" class="btn btn-default" onclick="javascript:patientCheckIn();">Join Queue</button>
   </form>
 
 
 
 
  
 
 <form method="post" id="getdept">
    <input type="hidden" name="dept_id" id="h_dept"/>
 </form>
  <script>
    function getStaffByDept(dept) {
        
        
        var url = "<?= base_url() ?>"+"index.php/staff/getDepartmentDoctorsJson";
        $("#h_dept").val(dept);
        
        $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#getdept').serialize(),
		success: function(json){						
		try{
			var obj = jQuery.parseJSON(json);
			//alert( obj['STATUS']);
                         
            $('select#staff_no')
                   .find('option')
                   .remove()
                   .end()
                   //.append('<option value="whatever">text</option>')
                   //.val('whatever')
               ;
                var arrayLength = obj.length;
                for (var i = 0; i < arrayLength; i++) {
                    var newoption = "<option  style='text-transform: capitalize' value='"+obj[i]['staff_no']+"'>"+obj[i]['first_name']+"</option>";
                    $('select#staff_no').append(newoption);
                }
                        		
			
		}catch(e) {		
			//alert('Exception while request..');
		}		
		},
		error: function(){						
			//alert('Error while request..');
		}
                
                 });
    }
    
    $(document).ready(function(){
       
                     
               
           $("select#dept_id").change(function(){
                //run ajax doctor drop down populate
                
                //getDepartmentDoctorsJson
                var deptid = $(this).val();
                getStaffByDept(deptid);
            });
        });
    
    
    function patientCheckIn() {
        
        var department = $("select#dept_id").val();
        
    
        var url = "<?= base_url() ?>"+"index.php/patient/queueCheckIn";
    
   
   
   if (department == "") {
    alert("Please Select a Department");
    return false;
   }
   
   
    
    $("button#join_queue").attr("disabled", "diisabled");
    $("button#join_queue").addClass("spinner");
    
   
  
	$.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#enterQueue').serialize(),
		success: function(json){
                    
		try{
			var obj = jQuery.parseJSON(json);
			//alert( obj['STATUS']);
                        if (obj['STATUS'] == "true") {
                            //code
                          //  $("button.close").click();
                           alert("Patient sucessfully added to the queue with number :" + obj['NUMBER']);
                           $("button.close").click();
                         
                        }
                        else
                        {
                             alert(obj['ERROR']);
			
                        }
                        		
			
		}catch(e) {		
			alert('Exception while request..here');
                     
		}		
		},
		error: function(){						
			alert('Error while request..');
		}
                
                
 });
        
       $("button#join_queue").removeClass("spinner");
        
        $("button#join_queue").removeAttr("disabled");
    
    }
	
	
	
	 function patientCheckInVitals() {
        
        var department = $("select#dept_id").val();
        
    
        var url = "<?= base_url() ?>"+"index.php/patient/queueCheckInVitals";
    
   
   
   
    
    $("button#join_queue").attr("disabled", "diisabled");
    $("button#join_queue").addClass("spinner");
    
   
  
	$.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#enterQueueVital').serialize(),
		success: function(json){
                    
		try{
			var obj = jQuery.parseJSON(json);
			//alert( obj['STATUS']);
                        if (obj['STATUS'] == "true") {
                            //code
                          //  $("button.close").click();
                           alert("Patient sucessfully added to the Vital collection queue with number :" + obj['NUMBER']);
                           $("button.close").click();
                         
                        }
                        else
                        {
                             alert(obj['ERROR']);
			
                        }
                        		
			
		}catch(e) {		
			alert('Exception while request..here');
                     
		}		
		},
		error: function(){						
			alert('Error while request..');
		}
                
                
 });
        
       $("button#join_queue").removeClass("spinner");
        
        $("button#join_queue").removeAttr("disabled");
    
    }
	
	
  </script>
 

</div>
</div>
</div>
</div>
    
	
   
  
  <form id="addVital" name="addVital" action="<?=base_url()?>index.php/patient/recordVital" method="post">
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">New Vital Readings </h4>
</div>
<div class="modal-body">
<div class="form-group">
<label for="exampleInputEmail1">Temperature</label>
<input type="text" class="form-control" name="temperature" id="temperature" placeholder="Temperature">
    <input type="hidden" id="patient_number" value="<?php echo $patient['patient_number'];?>" name="patient_number"/>
    <?php if(isset($family_member) && $family_member != ""){?>
    
    <input type="hidden" value="<?php echo $family_member['patient_family_id'];?>" name="patient_family_id"/>
    <?php } ?>
    <br/>
<select class="form-control" name="temperature_unit" id="temperature_unit" >
    
    <?php foreach($unit as $u){?>
    <option value=" <?php echo $u['id']; ?>"> <?php echo $u['unit_name'];?></option>
     <?php }?>
    
</select>
</div>

<div class="form-group">
<label for="exampleInputEmail1">Blood Pressure Systolic</label>
<input type="text" class="form-control" name="blood_pressure" id="blood_pressure" placeholder="Systolic">
    <br/>
<select class="form-control" name="blood_pressure_unit" id="blood_pressure_unit" >
    
    <?php foreach($unit as $u){?>
    <option value=" <?php echo $u['id']; ?>"> <?php echo $u['unit_name'];?></option>
     <?php }?>
    
</select>
</div>

<div class="form-group">
<label for="exampleInputEmail1">Blood Pressure Diastolic</label>
<input type="text" class="form-control" name="blood_pressure_diastolic" id="blood_pressure_diastolic" placeholder="Diastolic">
    <br/>
<select class="form-control" name="blood_pressure_unit" id="blood_pressure_unit" >
    
    <?php foreach($unit as $u){?>
    <option value=" <?php echo $u['id']; ?>"> <?php echo $u['unit_name'];?></option>
     <?php }?>
    
</select>
</div>

<div class="form-group">
<label for="exampleInputEmail1">Pulse</label>
<input type="text" class="form-control" name="pulse" id="pulse" placeholder="Pulse">
    <br/>
<select class="form-control" name="pulse_unit" id="pulse_unit" >
    
    <?php foreach($unit as $u){?>
    <option value=" <?php echo $u['id']; ?>"> <?php echo $u['unit_name'];?></option>
     <?php }?>
    
</select>
</div>

<div class="form-group">
<label for="exampleInputEmail1">Respiratory rate</label>
<input type="text" class="form-control" name="respiratory_rate" id="respiratory_rate" placeholder="Respiratory rate">
    <br/>
<select class="form-control" name="respiratory_rate_unit" id="respiratory_rate_unit" >
    
    <?php foreach($unit as $u){?>
    <option value=" <?php echo $u['id']; ?>"> <?php echo $u['unit_name'];?></option>
     <?php }?>
    
</select>
</div>


<div class="form-group">
<label for="exampleInputEmail1">Feotal Heart Rate</label>
<input type="text" class="form-control" name="feotal_heart_rate" id="feotal_heart_rate" placeholder="Feotal Heart Rate">
    <br/>
<select class="form-control" name="feotal_heart_rate_unit" id="feotal_heart_rate_unit" >
    
    <?php foreach($unit as $u){?>
    <option value=" <?php echo $u['id']; ?>"> <?php echo $u['unit_name'];?></option>
     <?php }?>
    
</select>
</div>

<div class="form-group">
<label for="exampleInputEmail1">SPO2</label>
<input type="text" class="form-control" name="spo" id="spo" placeholder="SPO2">
    <br/>
<select class="form-control" name="spo_unit" id="spo_unit" >
    
    <?php foreach($unit as $u){?>
    <option value=" <?php echo $u['id']; ?>"> <?php echo $u['unit_name'];?></option>
     <?php }?>
    
</select>
</div>

<div class="form-group">
<label for="exampleInputEmail1">BMI</label>
<input type="text" class="form-control" name="bmi" id="bmi" placeholder="BMI">
    <br/>
<select class="form-control" name="bmi_unit" id="bmi_unit" >
    
    <?php foreach($unit as $u){?>
    <option value=" <?php echo $u['id']; ?>"> <?php echo $u['unit_name'];?></option>
     <?php }?>
    
</select>
</div>



<button type="button" id="save" class="btn btn-default" onclick="javascript:update_vital();">Save</button>
</form>
</div>
</div>
</div>
</div>
    
    </form>








<form id="addIntake" name="addIntake" action="<?=base_url()?>index.php/patient/recordIntake" method="post">
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal12" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Record Intake </h4>
</div>
<div class="modal-body">


								<div class="form-group">
                                        <label>Intake Date</label>
                  
                                            <input name="intakedate" id="intakedate"
                                                   class="form-control form-control-inline input-medium default-date-picker"
                                                   size="16" type="text"
                                                   value="<?php echo date("d-m-Y");?>"/>
                                            <span class="help-block"></span>
                                        
                                    </div>



<div class="form-group">
<label>Time</label>
<div class="input-group bootstrap-timepicker">
<input type="text" class="form-control timepicker-24" name="intake_time" id="intake_time">
<span class="input-group-btn">
<button class="btn btn-default" type="button"><i class="fa fa-clock-o"></i></button>
</span>
</div>
</div>


<div class="form-group">
<label for="exampleInputEmail1">Type</label>
    <input type="hidden" id="patient_number" value="<?php echo $patient['patient_number'];?>" name="patient_number"/>
    <?php if(isset($family_member) && $family_member != ""){?>
    
    <input type="hidden" value="<?php echo $family_member['patient_family_id'];?>" name="patient_family_id"/>
    <?php } ?>
    <br/>
<select class="form-control" name="intake_type" id="intake_type" >
    
    <?php foreach($intaketype as $intaketypes){?>
    <option value=" <?php echo $intaketypes['id']; ?>"> <?php echo $intaketypes['type'];?></option>
     <?php }?>
    
</select>
</div>

<div class="form-group">
<label for="exampleInputEmail1">Amount</label>
<input type="text" class="form-control" name="intake_amount" id="intake_amount" placeholder="Amount">
    <br/>

</div>




<button type="button" id="save" class="btn btn-default" onclick="javascript:add_patient_intake();">Save</button>
</form>
</div>
</div>
</div>
</div>
    
    </form>
    


<form id="addOutput" name="addOutput" action="<?=base_url()?>index.php/patient/recordOutput" method="post">
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal7" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Record Output </h4>
</div>
<div class="modal-body">


								<div class="form-group">
                                        <label>Output Date</label>
                  
                                            <input name="outputdate" id="outputdate"
                                                   class="form-control form-control-inline input-medium default-date-picker"
                                                   size="16" type="text"
                                                   value="<?php echo date("d-m-Y");?>"/>
                                            <span class="help-block"></span>
                                        
                                    </div>



<div class="form-group">
<label>Time</label>
<div class="input-group bootstrap-timepicker">
<input type="text" class="form-control timepicker-24" name="output_time" id="output_time">
<span class="input-group-btn">
<button class="btn btn-default" type="button"><i class="fa fa-clock-o"></i></button>
</span>
</div>
</div>


<div class="form-group">
<label for="exampleInputEmail1">Type</label>
    <input type="hidden" id="patient_number" value="<?php echo $patient['patient_number'];?>" name="patient_number"/>
    <?php if(isset($family_member) && $family_member != ""){?>
    
    <input type="hidden" value="<?php echo $family_member['patient_family_id'];?>" name="patient_family_id"/>
    <?php } ?>
    <br/>
<select class="form-control" name="output_type" id="output_type" >
    
    <?php foreach($outputtype as $outputtypes){?>
    <option value=" <?php echo $outputtypes['id']; ?>"> <?php echo $outputtypes['type'];?></option>
     <?php }?>
    
</select>
</div>

<div class="form-group">
<label for="exampleInputEmail1">Amount</label>
<input type="text" class="form-control" name="output_amount" id="output_amount" placeholder="Amount">
    <br/>

</div>




<button type="button" id="save" class="btn btn-default" onclick="javascript:add_patient_output();">Save</button>
</form>
</div>
</div>
</div>
</div>
    

    
   
 



<form id="addPostDelivery" name="addPostDelivery" action="<?=base_url()?>index.php/patient/recordPostDelivery" method="post">
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal21" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Add Delivery Report </h4>
</div>
<div class="modal-body">


								<div class="form-group">
                                        <label>Delivery Date</label>
                  
                                            <input name="deliverydate" id="deliverydate"
                                                   class="form-control form-control-inline input-medium default-date-picker"
                                                   size="16" type="text"
                                                   value="<?php echo date("Y-m-d");?>"/>
                                            <span class="help-block"></span>
                                        
                                    </div>



<div class="form-group">
<label>Deleivery Time</label>
<div class="input-group bootstrap-timepicker">
<input type="text" class="form-control timepicker-24" name="delevery_time" id="delevery_time">
<span class="input-group-btn">
<button class="btn btn-default" type="button"><i class="fa fa-clock-o"></i></button>
</span>
</div>
</div>

<div class="form-group">
<label for="exampleInputEmail1">Duration of Pregnancy (Days)</label>
<input type="text" class="form-control" name="preg_duration" id="preg_duration" placeholder="duration in days">
    <br/>

</div>

<div class="form-group">
<label for="exampleInputEmail1">Weight of Baby (KG)</label>
<input type="text" class="form-control" name="wieght" id="wieght" placeholder="wieght in kg">
    <br/>

</div>

<div class="form-group">
<label for="exampleInputEmail1">Number of Baby</label>
<input type="text" class="form-control" name="num_of_baby" id="num_of_baby" placeholder="Number of Babies">
    <br/>

</div>

<div class="form-group">
<label for="exampleInputEmail1">Baby A/SB NDD/D</label>
<input type="text" class="form-control" name="baby_sb_ndd" id="baby_sb_ndd" placeholder="Baby A/SB NDD/D">
    <br/>

</div>


<div class="form-group">
<label for="exampleInputEmail1">Sex of  Baby</label>
<select class="form-control" name="sex_baby" id="sex_baby" >
    
	 <option value="M">Male</option>
	 <option value="F">Female</option>
    
</select>
</div>



<div class="form-group">
<label for="exampleInputEmail1">Type of Delivery</label>
    <input type="hidden" id="patient_number" value="<?php echo $patient['patient_number'];?>" name="patient_number"/>
    <?php if(isset($family_member) && $family_member != ""){?>
    
    <input type="hidden" value="<?php echo $family_member['patient_family_id'];?>" name="patient_family_id"/>
    <?php } ?>
    <br/>
<select class="form-control" name="delivery_type" id="delivery_type" >
    
    <?php foreach($deliverttype as $deliverttypes){?>
    <option value=" <?php echo $deliverttypes['id']; ?>"> <?php echo $deliverttypes['type'];?></option>
     <?php }?>
    
</select>
</div>
<hr>
<p>FIRST MINUTE ASSESSMENT OF NEW BORN BABY</p>
<hr>
<div class="form-group">
<label for="exampleInputEmail1">Skin Colour</label>
<select class="form-control" name="first_skin_color" id="first_skin_color" >
<option></option>
<option>Cyanosis pallor</option>    
<option>Peripheral cyanosis</option>
<option>Pink</option>
</select>
</div>

<div class="form-group">
<label for="exampleInputEmail1">Muscle Tone</label>
<select class="form-control" name="first_muslce_tone" id="first_muslce_tone" >
<option></option>
<option>Flaccid</option>    
<option>Moves limbs</option>
<option>Good</option>
</select>
</div>

<div class="form-group">
<label for="exampleInputEmail1">Resp Effort</label>
<select class="form-control" name="first_resp_effort" id="first_resp_effort" >
<option></option>
<option>None</option>    
<option>Gasps</option>
<option>Good</option>
</select>
</div>

<div class="form-group">
<label for="exampleInputEmail1">Heart Rate</label>
<select class="form-control" name="first_heart_rate" id="first_heart_rate" >
<option></option>
<option>None</option>    
<option>Less than 100</option>
<option>Greater than 100</option>  
</select>
</div>


<div class="form-group">
<label for="exampleInputEmail1">Response to Stimulus</label>
<select class="form-control" name="first_resp_to_stimulis" id="first_resp_to_stimulis" >
<option></option>
<option>None</option>    
<option>Slight</option>
<option>Good</option>
</select>
</div>

<div class="form-group">
<label for="exampleInputEmail1">First Minute APGA Total</label>
<input type="text" class="form-control" name="first_apga_total" id="first_apga_total" placeholder="APGA TOTAL">
    <br/>

</div>


<hr>
<p>FIFTH MINUTE ASSESSMENT OF NEW BORN BABY</p>
<hr>
<div class="form-group">
<label for="exampleInputEmail1">Skin Colour</label>
<select class="form-control" name="fifth_skin_color" id="fifth_skin_color" >
<option></option>
<option>Cyanosis pallor</option>    
<option>Peripheral cyanosis</option>
<option>Pink</option>
</select>
</div>

<div class="form-group">
<label for="exampleInputEmail1">Muscle Tone</label>
<select class="form-control" name="fifth_muslce_tone" id="fifth_muslce_tone" >
<option></option>
<option>Flaccid</option>    
<option>Moves limbs</option>
<option>Good</option>
</select>
</div>

<div class="form-group">
<label for="exampleInputEmail1">Resp Effort</label>
<select class="form-control" name="fifth_resp_effort" id="fifth_resp_effort" >
<option></option>
<option>None</option>    
<option>Gasps</option>
<option>Good</option>
</select>
</div>

<div class="form-group">
<label for="exampleInputEmail1">Heart Rate</label>
<select class="form-control" name="fifth_heart_rate" id="fifth_heart_rate" >
<option></option>
<option>None</option>    
<option>Less than 100</option>
<option>Greater than 100</option>  
</select>
</div>


<div class="form-group">
<label for="exampleInputEmail1">Response to Stimulus</label>
<select class="form-control" name="fifth_resp_to_stimulis" id="fifth_resp_to_stimulis" >
<option></option>
<option>None</option>    
<option>Slight</option>
<option>Good</option>
</select>
</div>

<div class="form-group">
<label for="exampleInputEmail1">Fifth Minute APGA Total</label>
<input type="text" class="form-control" name="fifth_apga_total" id="fifth_apga_total" placeholder="APGA TOTAL">
    <br/>

</div>



<button type="button" id="save" class="btn btn-default" onclick="javascript:add_post_delivery();">Save</button>
</form>
</div>
</div>
</div>
</div>

	
	
	

<form id="addPostSurgery" name="addPostSurgery" action="<?=base_url()?>index.php/patient/recordPostSurgery" method="post">
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal22" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Surgery Report </h4>
</div>
<div class="modal-body">


								<div class="form-group">
                                        <label>Surgery Date</label>
                  
                                            <input name="surgurydate" id="surgurydate"
                                                   class="form-control form-control-inline input-medium default-date-picker"
                                                   size="16" type="text"
                                                   value="<?php echo date("d-m-Y");?>"/>
                                            <span class="help-block"></span>
                                        
                                    </div>


<div class="form-group">
<label for="exampleInputEmail1">Operation</label>
<input type="hidden" id="patient_number" value="<?php echo $patient['patient_number'];?>" name="patient_number"/>
    <?php if(isset($family_member) && $family_member != ""){?>
    
    <input type="hidden" value="<?php echo $family_member['patient_family_id'];?>" name="patient_family_id"/>
    <?php } ?>
    <br/>
<textarea class="form-control" name="operation"></textarea>
    <br/>

</div>

<div class="form-group">
<label for="exampleInputEmail1">Surgeons</label>
<textarea class="form-control" name="surgeons"></textarea>
    <br/>

</div>


<div class="form-group">
<label for="exampleInputEmail1">Anaesthetist</label>
<input type="text" class="form-control" name="anaesthetist" id="anaesthetist" placeholder="Anaesthetist">
    <br/>

</div>


<div class="form-group">
<label for="exampleInputEmail1">Indication</label>
<input type="text" class="form-control" name="indication" id="indication" placeholder="Indication">
    <br/>

</div>

<div class="form-group">
<label for="exampleInputEmail1">Findings</label>
<textarea class="form-control" name="findings"></textarea>
    <br/>

</div>

<div class="form-group">
<label for="exampleInputEmail1">ICD 10 Code</label>
<input type="text" class="form-control" name="icd10code" id="icd10code" placeholder="icd10code">
    <br/>

</div>

<div class="form-group">
<label for="exampleInputEmail1">Incision</label>
<input type="text" class="form-control" name="incision" id="incision" placeholder="incision">
    <br/>

</div>

<div class="form-group">
<label for="exampleInputEmail1">Procedures</label>
<textarea class="form-control" name="procedure"></textarea>
    <br/>

</div>

<div class="form-group">
<label for="exampleInputEmail1">Closure</label>
<input type="text" class="form-control" name="closure" id="closure" placeholder="closure">
    <br/>

</div>

<div class="form-group">
<label for="exampleInputEmail1">Drains</label>
<input type="text" class="form-control" name="drains" id="drains" placeholder="drains">
    <br/>

</div>

<div class="form-group">
<label for="exampleInputEmail1">Swabs, Needles, Instruments</label>
<input type="text" class="form-control" name="instruments" id="instruments" placeholder="instruments">
    <br/>

</div>

<div class="form-group">
<label for="exampleInputEmail1">Bloodloss</label>
<input type="text" class="form-control" name="bloodloss" id="bloodloss" placeholder="Blood Loss">
    <br/>

</div>

<div class="form-group">
<label for="exampleInputEmail1">Urine</label>
<input type="text" class="form-control" name="urine" id="urine" placeholder="Urine">
    <br/>

</div>






<button type="button" id="save" class="btn btn-default" onclick="javascript:add_post_surgery();">Save</button>
</form>
</div>
</div>
</div>
</div>







<form id="addReferal" name="addReferal" action="<?=base_url()?>index.php/patient/recordAddReferal" method="post">
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal27" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Referal Notes </h4>
</div>
<div class="modal-body">

<div class="form-group">
<label for="exampleInputEmail1">Reason For Referal</label>
<input type="text" class="form-control" name="referalreason" id="referalreason" placeholder="">
   
</div>


<div class="form-group">
<label for="exampleInputEmail1">Doctors Note</label>
<input type="hidden" id="patient_number" value="<?php echo $patient['patient_number'];?>" name="patient_number"/>
    <?php if(isset($family_member) && $family_member != ""){?>
    
    <input type="hidden" value="<?php echo $family_member['patient_family_id'];?>" name="patient_family_id"/>
    <?php } ?>
    <br/>
<textarea class="form-control" name="referalnotes"></textarea>
    <br/>

</div>


<div class="form-group">
<label for="exampleInputEmail1">Hospital Name</label>
<input type="text" class="form-control" name="hospitalname" id="hospitalname" placeholder="">
   
</div>

<div class="form-group">
<label for="exampleInputEmail1">Address of Hospital</label>
<textarea class="form-control" name="hospitaladdress"></textarea>
    <br/>

</div>




<button type="button" id="save" class="btn btn-default" onclick="javascript:add_referal();">Save</button>
</form>
</div>
</div>
</div>
</div>
 
	
	







 



<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deliveryReportDetails" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Post Delivery Report </h4>
</div>
<div class="modal-body">


								<div class="form-group">
                                        <label><strong>Delivery Date:</strong></label>
                  
                                          <div  name="date_of_delivery" id="date_of_delivery" > 
											</div>
										
                                    </div>



<div class="form-group">
<label><strong>Delivery Time:</strong></label>

<div  name="delivery_id_time" id="delivery_id_time" >

</div>
</div>

<div class="form-group">
<label><strong>Duration of Pregnancy (Days):</strong></label>
<div  name="duration_of_preg" id="duration_of_preg" >
</div>

</div>

<div class="form-group">
<label><strong>Weight of Baby (KG):</strong></label>
<div  name="weight_of_baby" id="weight_of_baby" >
</div>

</div>

<div class="form-group">
<label><strong>Number of Baby:</strong></label>

<div  name="number_of_baby" id="number_of_baby" >
</div>

</div>

<div class="form-group">
<label><strong>Baby A/SB NDD/D:</strong></label>

<div  name="babdy_aa_dd" id="babdy_aa_dd" >
</div>

</div>


<div class="form-group">
<label><strong>Type of Delivery:</strong></label>

<div  name="delivery_type" id="delivery_type" >
</div>

</div>

<p><strong>First Minute Assessment of the New born Baby</strong?</p>
<div class="form-group">
<label><strong>Skin Color:</strong></label>

<div  name="first_skin_color" id="first_skin_color" >
</div>

</div>

<div class="form-group">
<label><strong>Muscle tone:</strong></label>

<div  name="first_muslce_tone" id="first_muslce_tone" >
</div>

</div>

<div class="form-group">
<label><strong>Resp Effort:</strong></label>

<div  name="first_resp_effort" id="first_resp_effort" >
</div>

</div>

<div class="form-group">
<label><strong>Hear Rate:</strong></label>

<div  name="first_heart_rate" id="first_heart_rate" >
</div>

</div>

<div class="form-group">
<label><strong>Response to Stimulus:</strong></label>

<div  name="first_resp_to_stimulis" id="first_resp_to_stimulis" >
</div>

</div>

<div class="form-group">
<label><strong>First Minute APGA Total:</strong></label>

<div  name="first_apga_total" id="first_apga_total" >
</div>

</div>

<p><strong>Fifth Minute Assessment of the New born Baby</strong?</p>

<div class="form-group">
<label><strong>Skin Color:</strong></label>

<div  name="fifth_skin_color" id="fifth_skin_color" >
</div>

</div>


<div class="form-group">
<label><strong>Muscle Tone:</strong></label>

<div  name="fifth_muslce_tone" id="fifth_muslce_tone" >
</div>

</div>

<div class="form-group">
<label><strong>Resp Effort:</strong></label>

<div  name="fifth_resp_effort" id="fifth_resp_effort" >
</div>

</div>

<div class="form-group">
<label><strong>Heart Rate:</strong></label>

<div  name="fifth_heart_rate" id="fifth_heart_rate" >
</div>

</div>

<div class="form-group">
<label><strong>Response To Stimulus:</strong></label>

<div  name="fifth_resp_to_stimulis" id="fifth_resp_to_stimulis" >
</div>

</div>

<div class="form-group">
<label><strong>Fifth APGA Total:</strong></label>

<div  name="fifth_apga_total" id="fifth_apga_total" >
</div>

</div>

</div>
</div>
</div>
</div>

 
    
     
  <form id="schedule" name="schedule" method="post">
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal6" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Schedule Appointment</h4>
</div>
<div class="modal-body">
    <div class="form-group">
<label for="exampleInputEmail1">Doctor</label>
<?php if(isset($family_member)){ ?>

<input name="patient_family_id" type="hidden" value="<?php echo $family_member['patient_family_id']?>" />
<?php } ?>
<select class="form-control" name="staff_no" id="staff_no" >
     <option value=""></option>
    <?php foreach($doctors as $doctor){?>
    <option value="<?php echo $doctor['staff_no']; ?>"> <?php echo $doctor['first_name']." ".$doctor['last_name'];?></option>
     <?php }?>
    
</select>
</div>

<div class="form-group">
<label for="exampleInputEmail1">Reason For Appointment</label>
<input type="text" class="form-control" name="reason" id="reason" placeholder="">
   
</div>

<div class="form-group">
<label for="exampleInputEmail1">Date</label>
 <input name="date" id="date" class="form-control form-control-inline input-medium default-date-picker" size="16" type="text"
            value="" />
      <span class="help-block">Select Appointment date</span>
    <input type="hidden" id="patient_number" value="<?php echo $patient['patient_number'];?>" name="patient_number"/>
   
</div>

<div class="form-group">
<label class="control-label col-md-3">Appointment time</label>
<div class="col-md-4">
<div class="input-group bootstrap-timepicker">
<input type="text" class="form-control timepicker-24" name="time" >
<span class="input-group-btn">
<button class="btn btn-default" type="button"><i class="fa fa-clock-o"></i></button>
</span>
</div>
</div>
</div>

  

<button type="button" id="save" class="btn btn-default" onclick="javascript:schedule_appointment();">Schedule</button>
</form>
</div>
</div>
</div>
</div>
    
    
    
    </form>  
    
    <script>
        //getHistoryDataJson
        
        function getHistoryDetails() {
            //code
           
            
            
        }
        
        function schedule_appointment() {
            
           var url = "<?= base_url() ?>"+"index.php/patient/scheduleAppointment";
           // alert("test");
             var reason = $("#reason").val();
            var time = $("form#schedule input[name=time]").val();
            var staff_no = $("form#schedule select#staff_no").val();
            var date = $("form#schedule input#date").val();
            
            var error = false;
            if (time == "") {
                alert("please select a valid appointment time");
                error = true;
            }
            
            if (staff_no == "") {
                 alert("please select the consulting doctor");
                  error = true;
            }
            
             if (date == "") {
                 alert("please select a valid date");
                  error = true;
            }
            
            if (!error) {
                $("button#join_queue").attr("disabled", "diisabled");
    $("button#join_queue").addClass("spinner");
    
   
  
	$.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#schedule').serialize(),
		success: function(json){
                    
		try{
			var obj = jQuery.parseJSON(json);
			//alert( obj['STATUS']);
                        if (obj['STATUS'] == "true") {
                            //code
                          //  $("button.close").click();
                           alert("Appointment Sucessfully Scheduled");
                           $("button.close").click();
                         
                        }
                        else
                        {
                             alert(obj['ERROR']);
			
                        }
                        		
			
		}catch(e) {		
			alert('Exception while request..here');
                     
		}		
		},
		error: function(){						
			alert('Error while request..');
		}
                
                
 });
        
       $("button#join_queue").removeClass("spinner");
        
        $("button#join_queue").removeAttr("disabled");
            }
        }
        function update_vital() {
           var temperature = $("#temperature").val();
           var respiratory_rate = $("#respiratory_rate").val();
           var pulse = $("#pulse").val();
           var blood_pressure = $("#blood_pressure").val();
            var feotal_heart_rate = $("#feotal_heart_rate").val();
            var spo2 = $("#spo").val();
           
           if (temperature == "" && respiratory_rate == "" && pulse == "" && blood_pressure == "" && feotal_heart_rate == "" && spo2 == "") {
                alert("please fill at least one vital field");
                
           }
           else
           {
            //alert($("#patient_number").val());
             $("form#addVital").submit();
           }
        }
		
		function add_patient_intake() {
           var intake_amount = $("#intake_amount").val();
           var intake_time = $("#intake_time").val();
           var intake_type = $("#intake_type").val();
           var intakedate = $("#intakedate").val();
           
           if (intake_amount == "" || intake_time == "" || intakedate == ""  || intake_type == "") {
                alert("Please fill all the Intake fields");
                
           }
           else
           {
            //alert($("#patient_number").val());
             $("form#addIntake").submit();
           }
        }
		
		
		function add_patient_output() {
           var output_amount = $("#output_amount").val();
           var output_time = $("#output_time").val();
           var output_type = $("#output_type").val();
           var outputdate = $("#outputdate").val();
           
           if (output_amount == "" || output_time == "" || output_type == ""  || outputdate == "") {
                alert("Please fill all the Output fields");
                
           }
           else
           {
            //alert($("#patient_number").val());
             $("form#addOutput").submit();
           }
        }
		
		
		function add_post_surgery() {
           var surgurydate = $("#surgurydate").val();
           var operation = $("#operation").val();
           var surgeons = $("#surgeons").val();
           var procedure = $("#procedure").val();
           
           if (surgurydate == "" || operation == "" || surgeons == ""  || procedure == "") {
                alert("Surgery Date, Operation details, Surgeons and Prcedures fields are mandatory");
                
           }
           else
           {
            //alert($("#patient_number").val());
             $("form#addPostSurgery").submit();
           }
        }
		
		
		function add_post_delivery() {
           var deliverydate = $("#deliverydate").val();
           var delevery_time = $("#delevery_time").val();
           var wieght = $("#wieght").val();
           var delivery_type = $("#delivery_type").val();
		   
		   //alert(deliverydate);
           
           if (output_amount == "" || output_time == "" || output_type == ""  || outputdate == "") {
                alert("Delivery Date, Delivery time, Weight and Delivery Type fields are mandatory");
                
           }
           else
           {
            //alert($("#patient_number").val());
             $("form#addPostDelivery").submit();
           }
        }
		
		
		
		function add_referal() {
           var referalreason = $("#referalreason").val();
           var referalnotes = $("#referalnotes").val();
           var hospitaladdress = $("#hospitaladdress").val();
           var hospitalname = $("#hospitalname").val();
           
           if (referalreason == "" || referalnotes == "" || hospitaladdress == ""  || hospitalname == "") {
                alert("All fields are mandatory");
                
           }
           else
           {
            //alert($("#patient_number").val());
             $("form#addReferal").submit();
           }
        }
        
        
    </script>
    
    <section class="panel">
<header class="panel-heading">
</header>
<table class="table table-hover">
<thead>
<tr>
<th>#</th>
<th>Date</th>
<th>Reason For Visit</th>
<th>Residing Physician</th>
</tr>
</thead>
<tbody>
<?php $counter = 1; foreach($history as $h) {?>
<tr class="history" id="<?php echo $h['id']; ?>">
<td ><?php echo $counter; ?></td>
<td><?php echo $h['date_created']; ?></td>
<td><?php echo $h['description']; ?></td>
<td><?php foreach($doctors as $doctor){ if($h['consulting_doctor'] == $doctor['staff_no']){echo ucfirst($doctor['first_name'])." ".ucfirst($doctor['last_name']); break;}} ?></td>
</tr>
<?php $counter++;}?>
</tbody>
</table>

<form name="getHistory" id="getHistory" action="" method="post">
    <input type="hidden" value="" name="patient_history_id" id="h_patient_history_id"/>
</form>


<script>
    
    $(document).ready(function(){
        
       
       $("tr.history").css("cursor","pointer").click(function(){
            var id = $(this).attr("id");
            
            $('input#h_patient_history_id').val(id);
            
            
             var url = "<?= base_url() ?>"+"index.php/patient/getConsultationDataJson";             
             
             $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form[name=getHistory]').serialize(),
		success: function(json){
                    
		try{
			var obj = jQuery.parseJSON(json);
			//alert( obj['treatment']);
                        $("span#history_id").html(obj['date_created']);
                        $("div#history_reason").html(obj['description']);
                        $("div#history_notes").html(obj['doctors_notes']);
						$("div#history_treatment").html(obj['treatment']);
						$("div#history_present").html(obj['presenting_history']);
						$("div#history_diagnosis").html(obj['diagnosis']);
						$("div#history_examination").html(obj['examination']);
						$("div#history_examination_hand_neck").html(obj['hand_neck']);
						$("div#history_examination_upper_limp").html(obj['upper_limp']);
						$("div#history_examination_abdomen").html(obj['abdomen']);
						$("div#history_examination_ve").html(obj['ve']);
						$("div#history_examination_pr").html(obj['pr']);
						$("div#history_systemreview").html(obj['review_system']);
						$("div#history_systemreview_cns").html(obj['cns']);
						$("div#history_systemreview_respiratory").html(obj['respiratory']);
						$("div#history_systemreview_cardiovascular").html(obj['cardiovascular']);
						$("div#history_systemreview_git").html(obj['git']);
						$("div#history_systemreview_urinary").html(obj['urinary']);
						$("div#history_systemreview_genital").html(obj['genital']);
						$("div#history_systemreview_musculoskeletal").html(obj['musculoskeletal']);
						
                        
                       
                        		
			
		}catch(e) {		
			alert('Exception while request..here');
                     
		}		
		},
		error: function(){						
			alert('Error while request..');
		}
                
                
 });
 
 

             
             
             $("a#viewhist").click();
            
            
        });
        
        });
</script>

<footer class="twt-footer">
    
     <button class="btn btn-space btn-info" type="button">
            View All Previous visits
        </button>
</footer>
</section>

</aside>
   
   
</div>





</div>

<!------------------------------------------------ Patient view ---------------------------------------------------------->



<form method="post" action="<?=base_url() ?>index.php/patient/number">

<a id="viewhist" href="#history_view" data-toggle="modal"></a>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="history_view" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title"><span id="history_id"></span></h4>
</div>
<div class="modal-body">


    <div class="form-group">
    <label for="exampleInputEmail1"><b>Reason For Visit</b></label>
    <div  name="history_reason" id="history_reason" >
        
        
    </div>
   
</div>
     <hr/>
<div class="form-group">
    <label for="exampleInputEmail1"><b>Doctor's Notes</b></label>
   
    
    <div  name="history_notes" id="history_notes" >
        
        
    </div>
</div>
	
<div class="form-group">
    <label for="exampleInputEmail1"><b>Presenting History</b></label>
   
    
    <div  name="history_present" id="history_present" >
        
        
    </div>
</div>
	<hr/>
<div class="form-group">
    <label for="exampleInputEmail1"><b>Examination</b></label>
    
    <div  name="history_examination" id="history_examination" > 
    </div>
	<br />
	<label for="exampleInputEmail1"><b>Head and Neck</b></label>
	<div  name="history_examination_hand_neck" id="history_examination_hand_neck" >
    </div>
	<br />
	<label for="exampleInputEmail1"><b>Upper Limp</b></label>
	<div  name="history_examination_upper_limp" id="history_examination_upper_limp" >
    </div>
	<br />
	<label for="exampleInputEmail1"><b>Abdomen</b></label>
	<div  name="history_examination_abdomen" id="history_examination_abdomen" >
    </div>
	<br />
	<label for="exampleInputEmail1"><b>VE</b></label>
	<div  name="history_examination_ve" id="history_examination_ve" >
    </div>
	<br />
	<label for="exampleInputEmail1"><b>PR</b></label>
	<div  name="history_examination_pr" id="history_examination_pr" >
    </div>
</div>
	<hr/>
<div class="form-group">
    <label for="exampleInputEmail1"><b>Diagnosis</b></label>
   
    
    <div  name="history_diagnosis" id="history_diagnosis" >
        
        
    </div>
</div>
	<hr/>	
<div class="form-group">
    <label for="exampleInputEmail1"><b>Treatment</b></label>
   
    
    <div  name="history_treatment" id="history_treatment" >
        
        
    </div>
</div>
	<hr/>

<div class="form-group">
    <label for="exampleInputEmail1"><b>System Review</b></label>
   
    
    <div  name="history_systemreview" id="history_systemreview" >       
    </div>
	<br />
	<label for="exampleInputEmail1"><b>CNS</b></label>
	<div  name="history_systemreview" id="history_systemreview_cns" >       
    </div>
	<br />
	<label for="exampleInputEmail1"><b>Respiratory</b></label>
	<div  name="history_systemreview" id="history_systemreview_respiratory" >       
    </div>
	<br />
	<label for="exampleInputEmail1"><b>Cardiovascular</b></label>
	<div  name="history_systemreview" id="history_systemreview_cardiovascular" >       
    </div>
	<br />
	<label for="exampleInputEmail1"><b>GIT</b></label>
	<div  name="history_systemreview" id="history_systemreview_git" >       
    </div>
	<br />
	<label for="exampleInputEmail1"><b>Urinary</b></label>
	<div  name="history_systemreview" id="history_systemreview_urinary" >       
    </div>
	<label for="exampleInputEmail1"><b>Genital</b></label>
	<div  name="history_systemreview" id="history_systemreview_genital" >       
    </div>
	<br />
	<label for="exampleInputEmail1"><b>Musculoskeletal</b></label>
	<div  name="history_systemreview" id="history_systemreview_musculoskeletal" >       
    </div>
	
	
</div>





</div>
</div>
</div>
</div>
</form>

<form id="getStates" method="post">
        <input type="hidden" name="country_code" id="get_country_code" value=""/>
     </form>


</section>
</section>
<a id="fam_add" href="#new_member" data-toggle="modal" ></a>
<a id="fam_rem" href="#rem_member" data-toggle="modal" ></a>
<a id="fam_view" href="#view_member" data-toggle="modal" ></a>
 <script>
    
    
$(document).ready(function(){
    
    
        <?php
        
        
            if(isset($alert))
            {
                echo "alert('".$alert."');";
            }
            
        
        ?>
    
    });
 </script>
 
<script src="<?=base_url() ?>assets/assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>