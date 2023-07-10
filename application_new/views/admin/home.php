
 
 
 
<section id="main-content" >
<section class="wrapper">
 
<div class="row">
    
    
<div class="col-lg-6">
<section class="panel">
<header class="panel-heading">
Staff Management 
<span class="tools pull-right">
<a href="javascript:;" class="fa fa-chevron-down"></a>
<a href="javascript:;" class="fa fa-times"></a>
</span>
</header>
<div class="panel-body">


<div style="width:100%; text-align: center; margin-bottom:200px;">
    <div class="option-icon" key="new"> 
        <i class="fa fa-plus-circle fa-5x"></i>
        <p>Add New Staff</p>
    </div>
      <a href="#myModal2" id="find" data-toggle="modal" >
      <div class="option-icon patient-menu" key="find">
        <i class="fa fa-search fa-5x"></i>
        <p><a href="#" id="show" class="button left">Find Staff</a>
        

</p>
        
    </div>
      </a>
    
       
       <script>
        
        $(document).ready(function(){
            
            $("div.option-icon").click(function(){
                var key = $(this).attr("key");
                
                if (key == "new")
                {
                    document.location.replace("<?=base_url() ?>index.php/staff/new");
                }
                else if (key == "find")
                {
                   $("a#find").click();
                }
                
                else if (key == "new-group")
                {
                   $("a#newGroup").click();
                }
                
                else if (key == "find-group")
                {
                   $("a#viewUserGroup").click();
                }
                
                else if (key == "edit-group")
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

<div class="col-lg-6">
<section class="panel">
<header class="panel-heading">
Manage Staff Groups
<span class="tools pull-right">
<a href="javascript:;" class="fa fa-chevron-down"></a>
<a href="javascript:;" class="fa fa-times"></a>
</span>
</header>
<div class="panel-body">


<div style="width:100%; text-align: center; margin-bottom:200px;">
    <a href="#createUserGroup" id="newGroup" data-toggle="modal" >
        <div class="option-icon" key="new-group">
            
            <i class="fa fa-plus-circle fa-5x"></i>
            <p>Add New Group</p>
        </div>
    </a>
     
        
<a href="#viewUserGroup" id="find-group" data-toggle="modal" >
      <div class="option-icon patient-menu" key="find-group">
       <i class="fa fa-pencil-square-o fa-5x"></i>
        <p>Edit Group Permissions</p>      

</p>       
    </div>
         </a>

      

    
     
      
</div>

</div>
</section>
</div>


<!------------------------------------ End of column -------------------------------------------------->


<div class="row">
    
    
<div class="col-lg-6">
<section class="panel">
<header class="panel-heading">
Shift Management 
<span class="tools pull-right">
<a href="javascript:;" class="fa fa-chevron-down"></a>
<a href="javascript:;" class="fa fa-times"></a>
</span>
</header>
<div class="panel-body">


<div style="width:100%; text-align: center; margin-bottom:200px;">
    
    <a href="#createShift" data-toggle="modal" >
        <div class="option-icon"> 
            <i class="fa fa-plus-circle fa-5x"></i>
            <p>Define New Shift</p>
        </div>
    </a>
    
      <a href="#trashShift" data-toggle="modal" >
      <div class="option-icon patient-menu">
        <i class="fa fa-ban fa-5x"></i>
        <p>Delete Shift</p>
        
    </div>
      </a>
      
        <a href="<?=base_url()?>index.php/dailyRoaster" >
      <div class="option-icon patient-menu">
        <i class="fa fa-calendar fa-5x"></i>
        <p>Daily Roaster</p>
        
    </div>
      </a>
    
       
       
      
</div>

</div>
</section>
</div>

<div class="col-lg-6">
<section class="panel">
<header class="panel-heading">
Create Bill
<span class="tools pull-right">
<a href="javascript:;" class="fa fa-chevron-down"></a>
<a href="javascript:;" class="fa fa-times"></a>
</span>
</header>
<div class="panel-body">


<div style="width:100%; text-align: center; margin-bottom:200px;">
    
    <a href="#createBill" data-toggle="modal" >
        <div class="option-icon"> 
            <i class="fa fa-plus-circle fa-5x"></i>
            <p>Define New Bill</p>
        </div>
    </a>
    
      <a href="#delbilldef" data-toggle="modal" >
      <div class="option-icon patient-menu">
        <i class="fa fa-ban fa-5x"></i>
        <p>Delete Bill</p>
        
    </div>
      </a>
      
      <a href="#updatebilldef" data-toggle="modal" >
      <div class="option-icon patient-menu">
        <i class="fa fa-pencil-square-o fa-5x"></i>
        <p>Update Bill</p>
        
    </div>
      </a>
    
       
       
      
</div>

</div>
</section>
</div>



<div class="col-lg-6">
<section class="panel">
<header class="panel-heading">
Department
<span class="tools pull-right">
<a href="javascript:;" class="fa fa-chevron-down"></a>
<a href="javascript:;" class="fa fa-times"></a>
</span>
</header>
<div class="panel-body">


<div style="width:100%; text-align: center; margin-bottom:200px;">
    
    <a href="#createDept" data-toggle="modal" >
        <div class="option-icon"> 
            <i class="fa fa-plus-circle fa-5x"></i>
            <p>Define New Department</p>
        </div>
    </a>
    
      <a href="#deleteDept" data-toggle="modal" >
      <div class="option-icon patient-menu">
        <i class="fa fa-ban fa-5x"></i>
        <p>Delete Department</p>
        
    </div>
      </a>
    
       
       
      
</div>

</div>
</section>
</div>


  
<div class="col-lg-6">
<section class="panel">
<header class="panel-heading">
Drug Basedata
<span class="tools pull-right">
<a href="javascript:;" class="fa fa-chevron-down"></a>
<a href="javascript:;" class="fa fa-times"></a>
</span>
</header>
<div class="panel-body">


<div style="width:100%; text-align: center; margin-bottom:200px;">
    
    <a href="#createDosageForm" data-toggle="modal" >
        <div class="option-icon"> 
            <i class="fa fa-plus-circle fa-5x"></i>
            <p>Define New Dosage Form</p>
        </div>
    </a>
    
     
         <a href="#editDosageForm" data-toggle="modal" >
        <div class="option-icon"> 
            <i class="fa fa-pencil-square-o fa-5x"></i>
            <p>Edit Dosage Form</p>
        </div>
    </a>
         
         
     <a href="#createDrugBillingForm" data-toggle="modal" >
        <div class="option-icon"> 
            <i class="fa fa-plus-circle fa-5x"></i>
            <p>Define New Drug Bill Form</p>
        </div>
    </a>
     
      
         <a href="#editDrugBillForm" data-toggle="modal" >
        <div class="option-icon"> 
            <i class="fa fa-pencil-square-o fa-5x"></i>
            <p>Edit Drug Bill Form</p>
        </div>
    </a>
    
    
       
       
      
</div>

</div>
</section>
</div>

<div class="col-lg-6">
<section class="panel">
<header class="panel-heading">
Ward Management
<span class="tools pull-right">
<a href="javascript:;" class="fa fa-chevron-down"></a>
<a href="javascript:;" class="fa fa-times"></a>
</span>
</header>
<div class="panel-body">


<div style="width:100%; text-align: center; margin-bottom:200px;">
    
    <a href="#createWard" data-toggle="modal" >
        <div class="option-icon"> 
            <i class="fa fa-plus-circle fa-5x"></i>
            <p>Define New Ward</p>
        </div>
    </a>
    
      <a href="#editWard" data-toggle="modal" >
      <div class="option-icon patient-menu">
        <i class="fa fa-pencil-square-o fa-5x"></i>
        <p>Edit Ward</p>
        
    </div>
      </a>
    
    
      <a href="#addBed" data-toggle="modal" >
      <div class="option-icon patient-menu">
        <i class="fa fa-plus-square fa-5x"></i>
        <p>Manage Beds</p>
        
    </div>
      </a>
       
       
      
</div>

</div>
</section>
</div>




<div class="col-lg-6">
<section class="panel">
<header class="panel-heading">
Basedata
<span class="tools pull-right">
<a href="javascript:;" class="fa fa-chevron-down"></a>
<a href="javascript:;" class="fa fa-times"></a>
</span>
</header>
<div class="panel-body">


<div style="width:100%; text-align: center; margin-bottom:200px;">

       <a href="#logodata" data-toggle="modal" >
      <div class="option-icon patient-menu">
        <i class="fa fa-picture-o fa-5x"></i>
        <p>Change Hospital Logo</p>
        
    </div>
      </a>
       
        <a href="#bloodgroup" data-toggle="modal" >
      <div class="option-icon patient-menu">
        <i class="fa fa-circle-o fa-5x"></i>
        <p>Blood Group</p>
        
    </div>
      </a>
        
        
         <a href="#genotype" data-toggle="modal" >
      <div class="option-icon patient-menu">
        <i class="fa fa-circle-o fa-5x"></i>
        <p>Genotype</p>
        
    </div>
      </a>
      
      
       <a href="#maritaldata" data-toggle="modal" >
      <div class="option-icon patient-menu">
        <i class="fa fa-circle-o fa-5x"></i>
        <p>Marital Status</p>
        
    </div>
      </a>
       
        <a href="#countrydata" data-toggle="modal" >
      <div class="option-icon patient-menu">
        <i class="fa fa-circle-o fa-5x"></i>
        <p>Country Data</p>
        
    </div>
      </a>
        
         <a href="#statedata" data-toggle="modal" >
      <div class="option-icon patient-menu">
        <i class="fa fa-circle-o fa-5x"></i>
        <p>State Data</p>
        
    </div>
      </a>
         
         <a href="#lgadata" data-toggle="modal" >
      <div class="option-icon patient-menu">
        <i class="fa fa-circle-o fa-5x"></i>
        <p>Local Government Data</p>
        
    </div>
      </a>
         
         
    <a href="#unit" data-toggle="modal" >
      <div class="option-icon patient-menu">
        <i class="fa fa-circle-o fa-5x"></i>
        <p>Unit of Measure</p>
        
    </div>
      
      
      </a>
    
      <a href="#freeCode" data-toggle="modal" >
      
      <div class="option-icon patient-menu">
        <i class="fa fa-circle-o fa-5x"></i>
        <p>Free Code 1</p>
        
      </div>
      
      
      </a>
      
        <a href="#freeCode2" data-toggle="modal" >
      
      <div class="option-icon patient-menu">
        <i class="fa fa-circle-o fa-5x"></i>
        <p>Free Code 2</p>
        
      </div>
      
      
      </a>
      
      
       <a href="#task" data-toggle="modal" >
      <div class="option-icon patient-menu">
        <i class="fa fa-circle-o fa-5x"></i>
        <p>In Patient Tasks</p>
        
    </div>
      </a>
	  
	  <a href="#intakeType" data-toggle="modal" >
      <div class="option-icon patient-menu">
        <i class="fa fa-circle-o fa-5x"></i>
        <p>Intake Type</p>
        
    </div>
      </a>
	  
	  
	  <a href="#outputType" data-toggle="modal" >
      <div class="option-icon patient-menu">
        <i class="fa fa-circle-o fa-5x"></i>
        <p>Output Type</p>
        
    </div>
      </a>
	  
	  
	  <a href="#deliveryType" data-toggle="modal" >
      <div class="option-icon patient-menu">
        <i class="fa fa-circle-o fa-5x"></i>
        <p>Delivery Type</p>
        
    </div>
      </a>
       
       

         <a href="#app_setting" data-toggle="modal" >
      <div class="option-icon patient-menu">
        <i class="fa fa-gear fa-5x"></i>
        <p>Settings</p>
        
    </div>
      </a>
      
      
      
</div>

</div>
</section>
</div>





<form id="drugbillform" name="drugbillform" method="post" action="#">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="editDrugBillForm" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Edit Drug Bill Form</h4>
</div>
<div class="modal-body">
<div class="form-group">
<label for="exampleInputEmail1">Drug Bill Form</label>




<select class="form-control" name="drug_bill_package_id" id="drug_bill_package_id">

<option value=""></option>
<?php foreach($drug_bill_forms as $form) {?>

     <option value="<?php echo $form["drug_bill_package_id"];?>"><?php echo ucfirst($form["name"]);?></option>
      
    
<?php }?>

</select>

</div>


<button type="button" id="deleteDrugbBillBtn" class="btn btn-default" onclick="javascript:deleteDrugBillForm();">Delete Drug Bill Form</button>

</div>
</div>
</div>
</div>
</form>
<script>
    
  
    function confirmDrugBillFormSelection() {
        
        var selected = $.trim( $("select#drug_bill_package_id").val());
        
        if (selected == "") {
            alert("Select a Drug Bill  form to edit");
            return false;
        }
        else
        {
            return true;
        }
    }
    
    function deleteDrugBillForm() {
        
    if(confirmDrugBillFormSelection())
     {
        var isConfirmed = confirm("Do you want to delete Drug Bill form ? ");
        if (isConfirmed) {
           $("form[name=drugbillform]").attr("action","<?=base_url()?>index.php/admin/deleteDrugBillForm").submit();
        }
        
     }
    }
</script>



<form id="editdosageform" name="editdosageform" method="post" action="#">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="editDosageForm" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Edit Dosage Form</h4>
</div>
<div class="modal-body">
<div class="form-group">
<label for="exampleInputEmail1">Dosage Form</label>

<?php foreach($dosage_forms as $form) {?>
<input type="hidden" value="<?php echo $form["description"];?>" id="dosage_description_<?php echo $form["drug_presentation_id"];?>"/>
<?php }?>



<select class="form-control" name="dosage_form_id" id="dosage_form_id">

<option value=""></option>
<?php foreach($dosage_forms as $form) {?>

     <option value="<?php echo $form["drug_presentation_id"];?>"><?php echo ucfirst($form["name"]);?></option>
      
    
<?php }?>

</select>

<script>
    $(document).ready(function(){
        
        $("select#dosage_form_id").change(function(){
            
            var value = $(this).val();
            
            var selector = "input#dosage_description_"+value;
          
            $("input#edit_dosage_description").val($(selector).val());
            
            });
        });
</script>
</div>

<div class="form-group">
<label for="exampleInputEmail1">Description</label>
<input type="text" class="form-control" name="description" id="edit_dosage_description" placeholder="Description">
</div>


<button type="button" id="updateDosageBtn" class="btn btn-default" onclick="javascript:updateDosage();">Update Dosage Form</button>

<button type="button" id="deleteDosageBtn" class="btn btn-default" onclick="javascript:deleteDosage();">Delete Dosage Form</button>

</div>
</div>
</div>
</div>
</form>
<script>
    
    function updateDosage() {
       
     if(confirmDosageSelection())
     {
        $("form[name=editdosageform]").attr("action","<?=base_url()?>index.php/admin/updateDosageForm").submit();
     }
    }
    function confirmDosageSelection() {
        
        var selected = $.trim( $("select#dosage_form_id").val());
        
        if (selected == "") {
            alert("Select a Dosage form to edit");
            return false;
        }
        else
        {
            return true;
        }
    }
    
    function deleteDosage() {
        
    if(confirmDosageSelection())
     {
        var isConfirmed = confirm("Do you want to delete dosage form ? ");
        if (isConfirmed) {
           $("form[name=editdosageform]").attr("action","<?=base_url()?>index.php/admin/deleteDosageForm").submit();
        }
        
     }
    }
</script>







<form id="adddrugbillform" name="adddrugbillform" method="post" action="<?=base_url() ?>index.php/admin/createDrugBillForm">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="createDrugBillingForm" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Define New Drug Bill Form</h4>
</div>
<div class="modal-body">
<div class="form-group">
<label for="exampleInputEmail1">Name</label>
<input type="text" class="form-control" name="name" id="bill-dosage-name" placeholder="Drug Bill Form Name">
</div>


<button type="button" id="create_dosage" class="btn btn-default" onclick="javascript:createBillForm();">Create</button>

  
<script>
    
    function createBillForm() {
        
        if ($.trim($("#bill-dosage-name").val()) != "")
        {
            $("form[name=adddrugbillform]").submit();
        }
       
    }
    
</script>
</div>
</div>
</div>
</div>
</form>




<form id="adddosageform" name="adddosageform" method="post" action="<?=base_url() ?>index.php/admin/createDosageForm">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="createDosageForm" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Define New Dosage Form</h4>
</div>
<div class="modal-body">
<div class="form-group">
<label for="exampleInputEmail1">Name</label>
<input type="text" class="form-control" name="name" id="dosage-name" placeholder="Dosage Form Name">
</div>

<div class="form-group">
<label for="exampleInputEmail1">Description</label>
<input type="text" class="form-control" name="description" id="dosage_description" placeholder="Description">
</div>


<div id="occupation-create-error"></div>
<button type="button" id="create_dosage" class="btn btn-default" onclick="javascript:createDosageForm();">Create Dosage Form</button>

  
<script>
    
    function createDosageForm() {
        
        if ($.trim($("#dosage-name").val()) != "")
        {
            $("form[name=adddosageform]").submit();
        }
       
    }
    
</script>
</div>
</div>
</div>
</div>
</form>




<!---------------------------------------delete bill def starts here-------------------------------------------------------->




<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="delbilldef" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Delete Bill Def</h4>
</div>
<div class="modal-body">
  <form id="del-bill" method="post" action="<?=base_url() ?>index.php/patient/number">  
<div class="form-group">
<label for="exampleInputEmail1">Bill</label>

<select class="form-control" name="bill_id" id="bill_id_del" >
    <?php foreach($bills as $bill){?>
    
    
    <option class="bill_option" value="<?php echo $bill['bill_id']; ?>" desc="<?php echo $bill['description']?>"><?php echo $bill['service_name']?></option>
    
    <?php }?>
    
</select>
    
</div><div class="form-group">
    <label for="exampleInputEmail1">Description</label>
   <input disabled="disabled" class="form-control" type="text" name="description" value="" id="del_description"/>
</div>


<div class="form-group">
    <label for="exampleInputEmail1">Unit Price</label>
   <input disabled="disabled" class="form-control" type="text" name="unit_price" value="" id="del_price"/>
</div>
<button type="button"  class="btn btn-default" onclick="javascript:deleteBillDef();">Delete Bill Def</button>

  </form>
<script>
    
   
    function getDellBill() {
        var obj ="";
         var url = "<?= base_url() ?>"+"index.php/admin/getBillJson";
       
       
        $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#del-bill').serialize(),
		success: function(json){						
		try{
			obj = jQuery.parseJSON(json);
                    	
			
                var description = obj['description'];
                var unit_price = obj['unit_price'];
              
                $("input#del_description").val(description);
                $("input#del_price").val(unit_price);
                    
		}catch(e) {		
			console.log('Exception while request..');
		}		
		},
		error: function(){						
			console.log('Error while request..');
		}
                
                 });
        
        
        
    }
    
   $(document).ready(function(){
    
     getDellBill();
     
        $("select#bill_id_del").change(function(){
            
            
            
            getDellBill();
            
            
            });
    
    });
    
    function deleteBillDef() {
       var sure = confirm("are you sure you want to delete bill definition ?");
        if (sure)
        {
            $("form#del-bill").attr("action","<?=base_url()?>index.php/admin/deleteBillDef").submit();
        }
       
    }
    
</script>





</div>
</div>
</div>
</div>




<!---------------------------------------update bill def starts here-------------------------------------------------------->




<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="updatebilldef" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Update Bill Def</h4>
</div>
<div class="modal-body">
  <form id="update-bill" method="post" action="<?=base_url() ?>index.php/patient/number">  
<div class="form-group">
<label for="exampleInputEmail1">Bill</label>

<select class="form-control" name="bill_id" id="bill_id_update" >
    <?php foreach($bills as $bill){?>
    
    
    <option class="bill_option" price="<?php echo $bill['unit_price']; ?>" value="<?php echo $bill['bill_id']; ?>" desc="<?php echo $bill['description']?>"><?php echo $bill['service_name']?></option>
    
    <?php }?>
    
</select>
    
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Description</label>
   <input class="form-control" type="text" name="description" value="" id="update_description"/>
</div>


<div class="form-group">
    <label for="exampleInputEmail1">Unit Price</label>
   <input class="form-control" type="text" name="unit_price" value="" id="update_unit_price"/>
</div>



<button type="button"  class="btn btn-default" onclick="javascript:updateBillDef();">Update Bill Def</button>

  </form>
<script>
    
    function getBill() {
        var obj ="";
         var url = "<?= base_url() ?>"+"index.php/admin/getBillJson";
       
       
        $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#update-bill').serialize(),
		success: function(json){						
		try{
			obj = jQuery.parseJSON(json);
                    	
			
                var description = obj['description'];
                var unit_price = obj['unit_price'];
              
                $("input#update_description").val(description);
                $("input#update_unit_price").val(unit_price);
                    
		}catch(e) {		
			console.log('Exception while request..');
		}		
		},
		error: function(){						
			console.log('Error while request..');
		}
                
                 });
        
        
        
    }
    
   $(document).ready(function(){
    
     getBill();
     
        $("select#bill_id_update").change(function(){
            
            
            
            getBill();
            
            
            });
    
    });
    
    
    function updateBillDef() {
       var error = false;
       var price = $("input#update_unit_price").val();
       if ($("input#update_unit_price").val() == "") {
        //code
        alert("unit price cannot be empty");
        error = true;
       }
       
       else if (!$.isNumeric(price)) {
        //code
        alert("Invalid Price");
        error = true;
       }
        if (!error)
        {
            $("form#update-bill").attr("action","<?=base_url()?>index.php/admin/updateBillDef").submit();
        }
       
    }
    
</script>





</div>
</div>
</div>
</div>


<!---------------------------------------genotype basedata starts here-------------------------------------------------------->




<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="genotype" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Genotype Basedata</h4>
</div>
<div class="modal-body">
  <form id="add-genotype" method="post" action="<?=base_url() ?>index.php/patient/number">  
<div class="form-group">
<label for="exampleInputEmail1">Genotype Code</label>
<input type="text" class="form-control" name="phenotype_code" id="genotype_code" placeholder="Enter Code">
</div>
<div id="occupation-create-error"></div>
<button type="button" id="gen_button" class="btn btn-default" onclick="javascript:createGenotype();">Create Genotype</button>

  </form>
<script>
    
    function createGenotype() {
        
        if ($("#genotype_code").val() != "")
        {
            $("form#add-genotype").attr("action","<?=base_url()?>index.php/admin/addGenotype").submit();
        }
       
    }
    
</script>


<hr/>

 <form id="delete_genotype" method="post" action="<?=base_url() ?>index.php/patient/number">  
<div class="form-group">
<label for="exampleInputEmail1">Genotype Code</label>

<select class="form-control" name="phenotype_id">
    <?php foreach($genotypes as $genotype){?>
        <option value="<?php echo $genotype['phenotype_id'];?>"><?php echo $genotype['phenotype_code'];?></option>
        
    <?php }?>
</select>
<input type = "hidden" name="basedata_type" value="genotype"/>

</div>
<button type="button" id="" class="btn btn-default" onclick="javascript:deleteBasedata('delete_genotype');">Delete</button>

  </form>

<script>
    function deleteBasedata(form_id) {
       var confirmdelete = confirm("Do you want to delete basedata");
       if (confirmdelete) {
        $("form#"+form_id).attr("action","<?=base_url() ?>index.php/admin/deleteBasedata" ).submit();
       
       }
      
    }
</script>

</div>
</div>
</div>
</div>


<!---------------------------------------unit basedata starts here-------------------------------------------------------->




<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="unit" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Unit Of Measure Basedata</h4>
</div>
<div class="modal-body">
  <form id="add_unit" method="post" action="<?=base_url() ?>index.php/patient/number">  
<div class="form-group">
<label for="exampleInputEmail1">Unit Name</label>
<input type="text" class="form-control" name="unit_name" id="unit_name" placeholder="Enter Unit Name">
</div>

<div class="form-group">
<label for="exampleInputEmail1">Symbol</label>
<input type="text" class="form-control" name="symbol" id="symbol" placeholder="symbol">
</div>


<button type="button" id="create_unit_btn" class="btn btn-default" onclick="javascript:createUnit();">Create Unit</button>

  </form>
<script>
    
    function createUnit() {
        
        if ($("#unit_name").val() != "")
        {
            $("form#add_unit").attr("action","<?=base_url()?>index.php/admin/addUnit").submit();
        }
       
    }
    
</script>


<hr/>

 <form id="deleteUnit" method="post" action="<?=base_url() ?>index.php/patient/number">  
<div class="form-group">
<label for="exampleInputEmail1">Unit</label>

<select class="form-control" name="unit">
    <?php foreach($units as $unit){?>
        <option value="<?php echo $unit['id'];?>"><?php echo ucfirst($unit['unit_name']);?></option>
        
    <?php }?>
</select>

<input type="hidden" name="basedata_type" value="unit"/>
</div>
<button type="button" id="" class="btn btn-default" onclick="javascript:deleteBasedata('deleteUnit');">Delete Unit</button>

  </form>



</div>
</div>
</div>
</div>




<!---------------------------------------bloodgroup basedata starts here-------------------------------------------------------->




<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="bloodgroup" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Blood Group Basedata</h4>
</div>
<div class="modal-body">
  <form id="add-blood-group" method="post" action="<?=base_url() ?>index.php/patient/number">  
<div class="form-group">
<label for="exampleInputEmail1">Blood Group Code</label>
<input type="text" class="form-control" name="blood_group_code" id="blood-group-code" placeholder="Enter Code">
</div>
<div id="occupation-create-error"></div>
<button type="button" id="bg" class="btn btn-default" onclick="javascript:createBloodGroup();">Create Blood Group</button>

  </form>
<script>
    
    function createBloodGroup() {
        
        if ($("#blood-group-code").val() != "")
        {
            $("form#add-blood-group").attr("action","<?=base_url()?>index.php/admin/addBloodGroup").submit();
        }
       
    }
    
</script>


<hr/>

 <form id="delete_blood_grp" method="post" action="<?=base_url() ?>index.php/patient/number">  
<div class="form-group">
<label for="exampleInputEmail1">Blood Group Code</label>

<select class="form-control" name="blood_group_id">
    <?php foreach($blood_groups as $group){?>
        <option value="<?php echo $group['blood_group_id'];?>"><?php echo $group['blood_group_code'];?></option>
        
    <?php }?>
</select>

<input type="hidden" name="basedata_type" value="bloodgroup"/>
</div>
<div id="occupation-create-error"></div>
<button type="button" id="deleteBloodGrpBtn" class="btn btn-default" onclick="javascript:deleteBasedata('delete_blood_grp');">Delete Group</button>

  </form>



</div>
</div>
</div>
</div>


<!---------------------------------------country basedata starts here-------------------------------------------------------->




<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="countrydata" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Country Basedata</h4>
</div>


<div class="modal-body">
  <form id="add_country_data" method="post" action="<?=base_url() ?>index.php/admin/addCountry">
  
<div class="form-group">
<label for="exampleInputEmail1">Country Code</label>
<input type="text" class="form-control" name="country_code" id="country_code_base" placeholder="Enter Code">
</div>

<div class="form-group">
<label for="exampleInputEmail1">Country Name</label>
<input type="text" class="form-control" name="country_name" id="country_name_base" placeholder="Enter Name">
</div>

<button type="button" id="cd" class="btn btn-default" onclick="javascript:createCountry();">Create Country</button>

  </form>
<script>
    
    function createCountry() {
        
        var error = false;
        var name = $("#country_name_base").val();
        
        var code = $("#country_code_base").val();
        
        if (name == "") {
            //code
            
            alert("Country Name Required");
            error = true;
        }
        
         if (code == "") {
            //code
            
            alert("Country Code Required");
            error = true;
        }
        
        
        if (code.length > 3) {
            //code
            alert("Country Code Cannot be Greater than 3");
            error = true;
        }
        
        
        if (error)
        {
            
        }
        else
        {
            $("form#add_country_data").attr("action","<?=base_url()?>index.php/admin/addCountry").submit();
        }
       
    }
    
</script>


<hr/>

 <form id="deleteCountryForm" method="post" action="<?=base_url() ?>index.php/patient/number">  
<div class="form-group">
<label for="exampleInputEmail1">Country</label>

<select class="form-control" name="country_code">
    <?php foreach($countries as $country){?>
        <option value="<?php echo $country['country_code'];?>"><?php echo ucfirst($country['country_name']);?></option>
        
    <?php }?>
</select>

<input type="hidden" name="basedata_type" value="country"/>
</div>
<button type="button" id="" class="btn btn-default" onclick="javascript:deleteBasedata('deleteCountryForm');">Delete</button>

  </form>



</div>
</div>
</div>
</div>





<!---------------------------------------state basedata starts here-------------------------------------------------------->




<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="statedata" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">State Basedata</h4>
</div>


<div class="modal-body">
  <form id="add_state_data" method="post" action="<?=base_url() ?>index.php/admin/addState">
  
<div class="form-group">
<label for="exampleInputEmail1">Country Code</label>

<select type="text" class="form-control" name="country_code" id="country_code_state_base" placeholder="Enter Code">
    
    <?php foreach($countries as $country){ ?>
        <option value="<?php echo $country['country_code']?>"><?php echo ucfirst($country['country_name']);?></option>
    <?php }?>
    
</select>
</div>

<div class="form-group">
<label for="exampleInputEmail1">State Code</label>
<input type="text" class="form-control" name="state_code" id="state_code_base" placeholder="Enter Code">
</div>


<div class="form-group">
<label for="exampleInputEmail1">State Name</label>
<input type="text" class="form-control" name="state_name" id="state_name_base" placeholder="Enter State Name">
</div>

<button type="button" id="cd" class="btn btn-default" onclick="javascript:createState();">Create State</button>

  </form>
<script>
    
    function createState() {
        
        var error = false;
        var name = $("#state_name_base").val();
        
        var code = $("#state_code_base").val();
        
        if (name == "") {
            //code
            
            alert("State Name Required");
            error = true;
        }
        
         if (code == "") {
            //code
            
            alert("State Code Required");
            error = true;
        }
        
        
        if (code.length > 3) {
            //code
            alert("State Code Cannot be Greater than 3");
            error = true;
        }
        
        
        if (error)
        {
            
        }
        else
        {
            $("form#add_state_data").attr("action","<?=base_url()?>index.php/admin/addState").submit();
        }
       
    }
    
</script>


<hr/>

 <form  id="deleteStateForm" method="post" action="<?=base_url() ?>index.php/patient/number">  
<div class="form-group">
<label for="exampleInputEmail1">Country</label>

<select id="state_view"  class="form-control" name="country_code">
    <?php foreach($countries as $country){?>
        <option value="<?php echo $country['country_code'];?>"><?php echo ucfirst($country['country_name']);?></option>
        
    <?php }?>
</select>


</div>


<div class="form-group">
<label for="exampleInputEmail1">State</label>

<select id="state_code_base_view" class="form-control" name="state_code">
<input type="hidden" name="basedata_type" value="state"/>
</select>


</div>


<button type="button" id="btnDeleteState" class="btn btn-default" onclick="javascript:deleteBasedata('deleteStateForm')">Delete</button>


<script>
    
    $(document).ready(function(){
        getStatesOfCountry($("select#state_view").val(), "state_code_base_view", false) ;
        
        
        $("select#state_view").change(function(){
            
            
            getStatesOfCountry($(this).val(), "state_code_base_view", false) ;
            
            });
        });
    
    
</script>

  </form>



</div>
</div>
</div>
</div>




<!---------------------------------------lga basedata starts here-------------------------------------------------------->




<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="lgadata" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">LGA Basedata</h4>
</div>


<div class="modal-body">
  <form id="add_lga_data" method="post" action="<?=base_url() ?>index.php/admin/addState">
  
<div class="form-group">
<label for="exampleInputEmail1">Country Code</label>

<select type="text" class="form-control" name="country_code" id="country_code_lga_base" placeholder="Enter Code">
    
    <?php foreach($countries as $country){ ?>
        <option value="<?php echo $country['country_code']?>"><?php echo ucfirst($country['country_name']);?></option>
    <?php }?>
    
</select>
</div>

<div class="form-group">
<label for="exampleInputEmail1">State</label>

<select id="state_lga_base_def_view" class="form-control" name="state_code">
    <option value=""></option>
  
</select>


</div>




<div class="form-group">
<label for="exampleInputEmail1">Lga Name</label>
<input type="text" class="form-control" name="lga_name" id="lga_name_base" placeholder="Enter Lga Name">
</div>

<button type="button" id="rr" class="btn btn-default" onclick="javascript:createLga();">Create Lga</button>

  </form>
<script>
    
    
    
    function createLga() {
       
        
        
        var error = false;
        var name = $("#lga_name_base").val();
        
        
        var state_code = $("#state_lga_base_def_view").val();
        
        if (name == "") {
            //code
            
            alert("Lga Name Required");
            error = true;
        }
        
         if (state_code == "" || state_code == null) {
            //code
            
            alert("State Code Required");
            error = true;
        }
        
        
                
        
        if (error)
        {
            
            
        }
        else
        {
            $("form#add_lga_data").attr("action","<?=base_url()?>index.php/admin/addLga").submit();
        }
       
    }
    
</script>


<hr/>

 <form id="deleteLgaForm" method="post" action="<?=base_url() ?>index.php/patient/number">  
<div class="form-group">
<label for="exampleInputEmail1">Country</label>

<select id="country_lga_view"  class="form-control" name="country_code">
    <?php foreach($countries as $country){?>
        <option value="<?php echo $country['country_code'];?>"><?php echo ucfirst($country['country_name']);?></option>
        
    <?php }?>
</select>


</div>
<input type="hidden" name="basedata_type" value="lga"/>

<div class="form-group">
<label for="exampleInputEmail1">State</label>

<select id="state_lga_base_view" class="form-control" name="state_code">
  
</select>


</div>

<div class="form-group">
<label for="exampleInputEmail1">LGA</label>

<select id="lga_base_view" class="form-control" name="lga_id">
  
</select>


</div>

<button type="button" id="" class="btn btn-default" onclick="javascript:deleteBasedata('deleteLgaForm')"> Delete</button>


<script>
    
    $(document).ready(function(){
        
        getStatesOfCountry($("select#country_code_lga_base").val(), "state_lga_base_def_view", false) ;
        getStatesOfCountry($("select#country_lga_view").val(), "state_lga_base_view", true) ;
        
        getLgasOfOrigin($("select#state_lga_base_view").val(), "lga_base_view");
        
        $("select#country_code_lga_base").change(function(){
            
            
            getStatesOfCountry($(this).val(), "state_lga_base_def_view", false) ;
            
            
            });
       
        $("select#state_lga_base_view").change(function(){
            
            
            getLgasOfOrigin($(this).val(), "lga_base_view") ;
            
            
            });
    
     $("select#country_lga_view").change(function(){
            
            
            getStatesOfCountry($(this).val(), "state_lga_base_view", true) ;
           
           
            
            });
        });
        
    
    
</script>

  </form>



</div>
</div>
</div>
</div>


<form id="find" method="post" action="<?=base_url() ?>index.php/patient/number">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal2" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Find Staff</h4>
</div>
<div class="modal-body">
<form role="form" id="add-new-occupation"  name="add-new-occupation" method="post" action="text.php">
<div class="form-group">
<label for="exampleInputEmail1">Staff Number</label>
<input type="text" class="form-control" name="staff_no" id="staff_no" placeholder="Staff Number">
</div>
<div id="occupation-create-error"></div>
<button type="button" id="find_patient" class="btn btn-default" onclick="javascript:findStaff();">View Staff</button>
<hr/>
<div class="form-group">
<label for="exampleInputEmail1">Department</label>
 <select name="dept_id" id="dept_id" class="form-control m-bot15">
        <option></option>
        <?php
        foreach($departments as $dept)
        {
            echo "<option value='".$dept['dept_id']."'>".ucfirst($dept['name'])."</option>";
        }
        ?>
        
    
        
    </select></div>

    
    
  <button type="button" id="find_staff_by_dept" class="btn btn-default" onclick="javascript:findDepartmentStaff();">Find By Department</button>
  
  <hr/>
  
  <div class="form-group">
<label for="exampleInputEmail1">Name</label>
<input type="text" class="form-control" name="name" id="name" placeholder="Name">
</div>
  
  <button type="button" id="find_all_hmo_patients" class="btn btn-default" onclick="javascript:findStaffByName();">Find By Name</button>
  
  
<script>
    
    function findStaff() {
        
        if ($("#staff_no").val() != "")
        {
            $("form#find").attr("action","<?=base_url()?>index.php/staff/searchNumber").submit();
        }
       
    }
    
    function findDepartmentStaff() {
        if ($("#dept_id").val() != "")
        {
            $("form#find").attr("action","<?=base_url()?>index.php/staff/searchDepartments").submit();
        }
       else alert("Select a Department");
    }
    
    function findStaffByName() {
        if ($("#name").val() != "")
        {
            $("form#find").attr("action","<?=base_url()?>index.php/staff/search").submit();
        }
       else alert("Enter Staff Name");
    }
</script>
</form>
</div>
</div>
</div>
</div>
</form>



<form id="add-group" method="post" action="<?=base_url() ?>index.php/patient/number">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="createUserGroup" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Create User Group</h4>
</div>
<div class="modal-body">
<form role="form" id="add-new-occupation"  name="add-new-occupation" method="post" action="text.php">
<div class="form-group">
<label for="exampleInputEmail1">Group Name</label>
<input type="text" class="form-control" name="name" id="group-name" placeholder="Enter Group Name">
</div>
<div id="occupation-create-error"></div>
<button type="button" id="find_patient" class="btn btn-default" onclick="javascript:createUserGroup();">Create User Group</button>

  
<script>
    
    function createUserGroup() {
        
        if ($("#group-name").val() != "")
        {
            $("form#add-group").attr("action","<?=base_url()?>index.php/staff/addGroup").submit();
        }
       
    }
    
</script>
</form>
</div>
</div>
</div>
</div>
</form>



<!------------------------------              begining of delete shift dialogue box              ---------------->

<form id="deleteShift" method="post" action="<?=base_url() ?>index.php/admin/deleteShift">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="trashShift" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Delete Shift</h4>
</div>
<div class="modal-body">
    
    
<div class="form-group">
<label for="exampleInputEmail1">Shift Name</label>
<select name ="shift_id" id="shift_id" class="form-control">
    
    <option value="">Select Shift Definition</option>
    <?php foreach($shifts as $shift) {?>
    <option value="<?php echo $shift['shift_id']?>"><?php echo $shift['shift_name']?></option>
    <?php }?>
</select>
</div>


<button type="button" id="delete_shift" class="btn btn-default" onclick="javascript:deleteShift();">Delete Shift</button>

  
<script>
    
    function deleteShift() {
        
        //form validation for shift 
        var error = false;
        
        //if no shift start time is specified
        if ($("select#shift_id").val() == "") {
            //code
            error = true;
            alert("No Shift Selected");
        }
        
        
        if (!error)
        {
            $("form#deleteShift").submit();
        }
       
    }
    
</script>
</div>
</div>
</div>
</div>
</form>


<!------------------------------              begining of define shift dialogue box              ---------------->

<form id="defineShift" method="post" action="<?=base_url() ?>index.php/admin/createShift">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="createShift" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Define New Shift</h4>
</div>
<div class="modal-body">
    
    
<div class="form-group">
<label for="exampleInputEmail1">Shift Name</label>

<input type="text" class="form-control" name="shift_name" id="shift_name" placeholder="Enter Shift Name">
</div>

<div class="form-group">
<label for="exampleInputEmail1">Description</label>
<input type="text" class="form-control" name="comments" id="comments" placeholder="Shift Description">
</div>


<div class="form-group">
<label>Start Time</label>

<div class="input-group bootstrap-timepicker">
<input type="text" name="shift_start_time" id="shift_start_time" class="form-control timepicker-24" placeholder="Define Start Time">
<span class="input-group-btn">
<button class="btn btn-default" type="button"><i class="fa fa-clock-o"></i></button>
</span>

</div>
</div>


<div class="form-group">
<label>End Time</label>
<div class="input-group bootstrap-timepicker">
<input type="text" name="shift_end_time" id="shift_end_time" class="form-control timepicker-24" placeholder="Define End Time">
<span class="input-group-btn">
<button class="btn btn-default" type="button"><i class="fa fa-clock-o"></i></button>
</span>
</div>
</div>


<button type="button" id="find_patient" class="btn btn-default" onclick="javascript:defineShift();">Define Shift</button>

  
<script>
    
    function defineShift() {
        
        //form validation for shift 
        var error = false;
        
        //if no shift start time is specified
        if ($("#shift_start_time").val() == "") {
            //code
            error = true;
            alert("Shift Start time cannot be empty");
        }
        //if no shift end time is specified
        if ($("#shift_end_time").val() == "") {
            //code
            error = true;
            alert("Shift end time cannot be empty");
        }
        
        //if no shift name is specified
        if ($("#shift_name").val() == "") {
            //code
            error = true;
            alert("Shift Name cannot be empty");
        }
       
        
        
        if (!error)
        {
            $("form#defineShift").submit();
        }
       
    }
    
</script>
</div>
</div>
</div>
</div>
</form>




<!------------------------------              begining of define Bill dialogue box              ---------------->

<form name="defineBill" method="post" action="<?=base_url() ?>index.php/admin/createBill">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="createBill" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Define New Bill</h4>
</div>
<div class="modal-body">

<div class="form-group">
<label for="exampleInputEmail1">Department</label>

<select class="form-control" name="dept_id">
    <option></option>
    <?php foreach($departments as $dept){?>
         <option value="<?php echo $dept['dept_id'];?>"><?php echo ucfirst($dept['name']);?></option>
     <?php }?>
</select>
</div>

    
<div class="form-group">
<label for="exampleInputEmail1">Bill Name</label>

<input type="text" class="form-control" name="service_name" id="bill_service_name" placeholder="Enter Bill Name">
</div>

<div class="form-group">
<label for="exampleInputEmail1">Description</label>
<input type="text" class="form-control" name="description" id="bill_description" placeholder="Bill Description">
</div>

<div class="form-group">
<label for="exampleInputEmail1">Unit Price</label>
<input type="text" class="form-control" name="unit_price" id="bill_unit_price" placeholder="Unit Price">
</div>



<button id="bill_def" type="button" class="btn btn-default" >Define Bill</button>

  
<script>
    
    $(document).ready(function(){
        
        
        $("button#bill_def").click(function(){
                
                //form validation for shift 
        var error = false;
        
        //if no shift start time is specified
        if ($("#bill_description").val() == "") {
            //code
            error = true;
            alert("description cannot be empty");
        }
        //if no shift end time is specified
        if ($("#bill_unit_price").val() == "") {
            //code
            error = true;
            alert("Unit Price cannot be empty");
        }
        else if(!$.isNumeric($("#bill_unit_price").val())){
            error = true;
            alert("Invalid Unit Price");
        }
        
        //if no shift name is specified
        if ($("#bill_service_name").val() == "") {
            //code
            error = true;
            alert("Please enter a Bill Name");
        }
       
        
        
        if (!error)
        {
            $("form[name=defineBill]").submit();
        }
            });
        
        });
    
  
    
</script>


</div>
</div>
</div>
</div>
</form>

<!------------------------------              begining of define Ward dialogue box              ---------------->


<form name="defineWard" method="post" action="<?=base_url() ?>index.php/admin/createWard">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="createWard" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Define New Ward</h4>
</div>
<div class="modal-body">
    
    
<div class="form-group">
<label for="exampleInputEmail1">Ward Name</label>

<input type="text" class="form-control" name="ward_name" id="ward_name" placeholder="Enter Ward Name">
</div>


<div class="form-group">
<label for="exampleInputEmail1">Maximum Bed Limit</label>

<input type="text" class="form-control" name="ward_bed_limit" id="ward_bed_limit" placeholder="Total Number of Beds">
</div>


<button id="ward_create" type="button" class="btn btn-default" >Create Ward</button>

  
<script>
    
    $(document).ready(function(){
        
        
        $("button#ward_create").click(function(){
                
                //form validation for shift 
        var error = false;
        
        //if no shift start time is specified
        if ($("#ward_name").val() == "") {
            //code
            error = true;
            alert("Ward Name Can not Be Empty");
        }
        
         if ($("#ward_bed_limit").val() == "" ) {
            //code
            error = true;
            alert("Ward Bed Limit Empty");
        }
        
         if (!$.isNumeric($("#ward_bed_limit").val())) {
            //code
            error = true;
            alert("Bed Limit Must Be a Number");
        }
        
        
        if (!error)
        {
            $("form[name=defineWard]").submit();
        }
            });
        
        });
    
  
    
</script>


</div>
</div>
</div>
</div>
</form>

<!------------------------------              begining of add bed to Ward dialogue box              ---------------->


<form name="addBedToWard" method="post" action="<?=base_url() ?>index.php/admin/addBedToWard">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="addBed" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Add Bed to Ward</h4>
</div>
<div class="modal-body">
    

<div class="form-group">
<label for="exampleInputEmail1">Select Ward</label>

<select class="form-control" name="ward_to_add_bed" id="ward_to_add_bed">
    
    <?php foreach($wards as $ward){?>
         <option value="<?php echo $ward['ward_id'];?>"><?php echo ucfirst($ward['ward_name'])." [ Count(".$ward['current_beds_in_ward'].") Maximum allowed(".$ward['ward_bed_limit'].") ]";?></option>
     <?php }?>
</select>
</div>


    
<div class="form-group">
<label for="exampleInputEmail1">Number of Beds</label>

<input type="text" class="form-control" name="num_beds" id="num_beds" placeholder="Number of Beds">
</div>


<button id="add_bed" type="button" class="btn btn-default" >Add</button>

<button id="sub_bed" type="button" class="btn btn-default" >Subtract</button>

<script>
    
    
    $(document).ready(function(){
        
                
        $("button#add_bed, button#sub_bed").click(function(){
                
                //form validation for shift 
        var error = false;
        
               
         if ($("#num_beds").val() == "" ) {
            //code
            error = true;
            alert("Enter Number of Beds");
        }
        
         if (!$.isNumeric($("#num_beds").val())) {
            //code
            error = true;
            alert("Number Expected");
        }
        
        
        if (!error)
        {
            var id = $(this).attr('id');
            console.log("it got here");
            
            if (id == "sub_bed") {
               $("form[name=addBedToWard]").attr("action", "<?=base_url() ?>index.php/admin/removeBedFromWard");
            }
            else
            {
                 $("form[name=addBedToWard]").attr("action", "<?=base_url() ?>index.php/admin/addBedToWard");
            }
            $("form[name=addBedToWard]").submit();
        }
            });
        
        });
    
  
    
</script>


</div>
</div>
</div>
</div>
</form>

<!------------------------------              begining of define Dept dialogue box              ---------------->


<form name="getWard" method="post" action="<?=base_url() ?>index.php/admin/getWardJson">
    <input type="hidden" name="ward_id" id="hidden_ward_id"/>
</form>


<!------------------------------              begining of edit Ward dialogue box              ---------------->


<form name="updateWard" method="post" action="<?=base_url() ?>index.php/admin/updateWard">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="editWard" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Edit Ward</h4>
</div>
<div class="modal-body">
    

<div class="form-group">
<label for="exampleInputEmail1">Select Ward</label>

<select class="form-control" name="ward_old_name" id="ward_old_name">
    
    <?php foreach($wards as $ward){?>
         <option value="<?php echo $ward['ward_id'];?>"><?php echo ucfirst($ward['ward_name']);?></option>
     <?php }?>
</select>
</div>


<script>
    $(document).ready(function(){
        getWard();
        
        $("select#ward_old_name").change(function(){
            getWard();
            });
        });
    
    
    
    function getWard() {
         var url = "<?= base_url() ?>"+"index.php/admin/getWardJson";
            
            $("input#hidden_ward_id").val($("select#ward_old_name").val());
            
            
            $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form[name=getWard]').serialize(),
		success: function(json){
                    
		try{
			var obj = jQuery.parseJSON(json);
			
                        if(obj != null)
                        {
                             $("#edit_ward_name").val(obj['ward_name']);
                             $("#edit_ward_bed_limit").val(obj['ward_bed_limit']);
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

    
<div class="form-group">
<label for="exampleInputEmail1">Ward Name</label>

<input type="text" class="form-control" name="ward_name" id="edit_ward_name" placeholder="Enter Ward Name">
</div>


<div class="form-group">
<label for="exampleInputEmail1">Maximum Bed Limit</label>

<input type="text" class="form-control" name="ward_bed_limit" id="edit_ward_bed_limit" placeholder="Total Number of Beds">
</div>


<button id="edit_create" type="button" class="btn btn-default" >Update Ward</button>

<button id="edit_delete" type="button" class="btn btn-default" >Delete Ward</button>
  
<script>
    
    $(document).ready(function(){
        
        $("button#edit_delete").click(function(){
            
                var isconfirmed = confirm("You are about to delete a ward, do you wish to continue ? ");
                
                if (isconfirmed) {
                    var url = "<?=base_url() ?>index.php/admin/deleteWard";
                    $("form[name=updateWard]").attr("action", url).submit();
                }
            });
        
        $("button#edit_create").click(function(){
                
                //form validation for shift 
        var error = false;
        
        //if no shift start time is specified
        if ($("#edit_ward_name").val() == "") {
            //code
            error = true;
            alert("Ward Name Can not Be Empty");
        }
        
         if ($("#edit_ward_bed_limit").val() == "" ) {
            //code
            error = true;
            alert("Ward Bed Limit Empty");
        }
        
         if (!$.isNumeric($("#edit_ward_bed_limit").val())) {
            //code
            error = true;
            alert("Bed Limit Must Be a Number");
        }
        
        
        if (!error)
        {
            $("form[name=updateWard]").submit();
        }
            });
        
        });
    
  
    
</script>


</div>
</div>
</div>
</div>
</form>


<!---------------------------------------------   Begining of define free code dialogue---------------------------------------------------------------------->

<form name="defineFreeCode" method="post" action="<?=base_url() ?>index.php/admin/addFreeCode">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="freeCode" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Free Code</h4>
</div>
<div class="modal-body">
    
    
<div class="form-group">
<label for="exampleInputEmail1">Enter Free Code</label>

<input type="text" class="form-control" name="name" id="free_name" placeholder="Enter New Free Code">
</div>


<button id="free_create" type="button" class="btn btn-default" >Create</button>

  
<script>
    
    $(document).ready(function(){
        
        
        $("button#free_create").click(function(){
                
                //form validation for shift 
        var error = false;
        
        //if no shift start time is specified
        if ($("#free_name").val() == "") {
            //code
            error = true;
            alert("Free Code Cannot Be Empty");
        }
        
        
        if (!error)
        {
            $("form[name=defineFreeCode]").submit();
        }
            });
        
        });
    
  
    
</script>

<hr/>

<div class="form-group">
<label for="exampleInputEmail1">Select Free Code</label>

    <select class="form-control" name="free_code_id" id="free_code_id">
        <option value=""></option>
        <?php foreach($freecodes as $code){?>
        
            <option value="<?php echo($code['id']);?>" ><?php echo ucfirst($code['name']);?></option>
            
        <?php } ?>
    </select>
</div>

<button id="del_free_code" type="button" class="btn btn-default" >Delete</button>

<script>
    
    $(document).ready(function(){
        
        
        $("button#del_free_code").click(function(){
                
                //form validation for shift 
        var error = false;
        
        //if no shift start time is specified
        if ($("#free_code_id").val() == "") {
            //code
            error = true;
            alert("Select a Free Code");
        }
        
        
        if (!error)
        {
            if (confirm("Do you want to delete free code ? ")) {
                //code
                $("form[name=defineFreeCode]").attr("action","<?=base_url()?>index.php/admin/delFreeCode").submit();
            }
            
        }
            });
        
        });
    
  
    
</script>
</div>
</div>
</div>
</div>
</form>



<!---------------------------------------------   Begining of define free code dialogue---------------------------------------------------------------------->

<form name="defineFreeCode2" method="post" action="<?=base_url() ?>index.php/admin/addFreeCode2">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="freeCode2" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Free Code 2</h4>
</div>
<div class="modal-body">
    
    
<div class="form-group">
<label for="exampleInputEmail1">Enter Free Code</label>

<input type="text" class="form-control" name="name" id="free_name_2" placeholder="Enter New Free Code">
</div>


<button id="free_create_2" type="button" class="btn btn-default" >Create</button>

  
<script>
    
    $(document).ready(function(){
        
        
        $("button#free_create_2").click(function(){
                
                //form validation for shift 
        var error = false;
        
        //if no shift start time is specified
        if ($("#free_name_2").val() == "") {
            //code
            error = true;
            alert("Free Code 2 Cannot Be Empty");
        }
        
        
        if (!error)
        {
            $("form[name=defineFreeCode2]").submit();
        }
            });
        
        });
    
  
    
</script>

<hr/>

<div class="form-group">
<label for="exampleInputEmail1">Select Free Code 2</label>

    <select class="form-control" name="free_code_id" id="free_code_2_id">
        <option value=""></option>
        <?php foreach($freecodes2 as $code){?>
        
            <option value="<?php echo($code['id']);?>" ><?php echo ucfirst($code['name']);?></option>
            
        <?php } ?>
    </select>
</div>

<button id="del_free_code_2" type="button" class="btn btn-default" >Delete</button>

<script>
    
    $(document).ready(function(){
        
        
        $("button#del_free_code_2").click(function(){
                
                //form validation for shift 
        var error = false;
        
        //if no shift start time is specified
        if ($("#free_code_2_id").val() == "") {
            //code
            error = true;
            alert("Select a Free Code 2");
        }
        
        
        if (!error)
        {
            if (confirm("Do you want to delete free code ? ")) {
                //code
                $("form[name=defineFreeCode2]").attr("action","<?=base_url()?>index.php/admin/delFreeCode2").submit();
            }
            
        }
            });
        
        });
    
  
    
</script>
</div>
</div>
</div>
</div>
</form>




<!---------------------------------------------   Begining of settings  dialogue---------------------------------------------------------------------->

<form name="app_setting_form" method="post" action="<?=base_url() ?>index.php/admin/updateHospitalSettings">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="app_setting" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">System Settings</h4>
</div>
<div class="modal-body">
    

    <?php foreach($settings as $setting){ ?>


        <div class="form-group">
            <label for="exampleInputEmail1"><?php echo $setting["name"]; ?></label>

            <input type="text" value="<?php echo $setting["value"]; ?>" class="form-control" name="<?php echo $setting["key"]; ?>" id="<?php echo $setting["key"]; ?>"
                   placeholder="<?php echo $setting["name"]; ?>">

        </div>


    <?php } ?>




<button id="update_setting_btn" type="button" class="btn btn-default" >Update</button>

<script>
    
    $(document).ready(function(){
        
        $("#update_setting_btn").click(function(){


            $("form[name=app_setting_form]").submit();
        
        
            });
      
     
        });
    
  
    
</script>
</div>
</div>
</div>
</div>
</form>





<!---------------------------------------------   Begining of define Task code dialogue---------------------------------------------------------------------->

<form name="defineTask" method="post" action="<?=base_url() ?>index.php/admin/defineNewTask">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="task" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">In Patient Tasks</h4>
</div>
<div class="modal-body">
    
    
<div class="form-group">
<label for="exampleInputEmail1">Task Name</label>

<input type="text" class="form-control" name="task_name" id="task_name" placeholder="Enter New Task Name">
</div>


<div class="form-group">
<label for="exampleInputEmail1">Task Description</label>

<input type="text" class="form-control" name="task_description" id="task_description" placeholder="Enter New Task Description">
</div>


<button id="task_create" type="button" class="btn btn-default" >Create</button>

  
<script>
    
    $(document).ready(function(){
        
        
        $("button#task_create").click(function(){
                
                //form validation for shift 
        var error = false;
        
        //if no shift start time is specified
        if ($("#task_name").val() == "") {
            //code
            error = true;
            alert("Task Name cannot be empty");
        }
        
        
        if (!error)
        {
            $("form[name=defineTask]").submit();
        }
            });
        
        });
    
  
    
</script>

<hr/>

<div class="form-group">
<label for="exampleInputEmail1">Select Task</label>

    <select class="form-control" name="task_id" id="task_id">
        <option value=""></option>
        <?php foreach($tasks as $task){?>
        
            <option value="<?php echo($task['task_id']);?>" ><?php echo ucfirst($task['name']);?></option>
            
        <?php } ?>
    </select>
</div>

<button id="del_task" type="button" class="btn btn-default" >Delete</button>

<script>
    
    $(document).ready(function(){
        
        
        $("button#del_task").click(function(){
                
                //form validation for shift 
        var error = false;
        
        //if no shift start time is specified
        if ($("#task_id").val() == "") {
            //code
            error = true;
            alert("Select a Task");
        }
        
        
        if (!error)
        {
            if (confirm("Do you want to delete task ? ")) {
                //code
                $("form[name=defineTask]").attr("action","<?=base_url()?>index.php/admin/delTask").submit();
            }
            
        }
            });
        
        });
    
  
    
</script>
</div>
</div>
</div>
</div>
</form>







<!---------------------------------------------   Begining of Intake Type code dialogue---------------------------------------------------------------------->

<form name="defineIntakeType" method="post" action="<?=base_url() ?>index.php/admin/defineNewIntakeType">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="intakeType" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Intake Type</h4>
</div>
<div class="modal-body">
    
    
<div class="form-group">
<label for="exampleInputEmail1">Intake Type</label>

<input type="text" class="form-control" name="intake_type" id="intake_type" placeholder="Enter Type">
</div>


<div class="form-group">
<label for="exampleInputEmail1">Description</label>

<input type="text" class="form-control" name="description" id="description" placeholder="Enter Description">
</div>


<button id="intake_create" type="button" class="btn btn-default" >Create</button>

  
<script>
    
    $(document).ready(function(){
        
        
        $("button#intake_create").click(function(){
                
                //form validation for shift 
        var error = false;
        
        //if no shift start time is specified
        if ($("#intake_type").val() == "") {
            //code
            error = true;
            alert("Intake Type cannot be empty");
        }
        
        
        if (!error)
        {
            $("form[name=defineIntakeType]").submit();
        }
            });
        
        });
    
  
    
</script>

<hr/>

<div class="form-group">
<label for="exampleInputEmail1">Select Intake Type</label>

    <select class="form-control" name="intake_id" id="intake_id">
        <option value=""></option>
        <?php foreach($intaketype as $intaketypes){?>
        
            <option value="<?php echo($intaketypes['id']);?>" ><?php echo ucfirst($intaketypes['type']);?></option>
            
        <?php } ?>
    </select>
</div>

<button id="del_intake" type="button" class="btn btn-default" >Delete</button>

<script>
    
    $(document).ready(function(){
        
        
        $("button#del_intake").click(function(){
                
                //form validation for shift 
        var error = false;
        
        //if no shift start time is specified
        if ($("#intake_id").val() == "") {
            //code
            error = true;
            alert("Select a Intake Type");
        }
        
        
        if (!error)
        {
            if (confirm("Do you want to delete Intake Type ? ")) {
                //code
                $("form[name=defineIntakeType]").attr("action","<?=base_url()?>index.php/admin/delIntakeType").submit();
            }
            
        }
            });
        
        });
    
  
    
</script>
</div>
</div>
</div>
</div>
</form>






<!---------------------------------------------   Begining of Output Type code dialogue---------------------------------------------------------------------->

<form name="defineOutputType" method="post" action="<?=base_url() ?>index.php/admin/defineNewOutputType">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="outputType" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Output Type</h4>
</div>
<div class="modal-body">
    
    
<div class="form-group">
<label for="exampleInputEmail1">Output Type</label>

<input type="text" class="form-control" name="output_type" id="output_type" placeholder="Enter Type">
</div>


<div class="form-group">
<label for="exampleInputEmail1">Description</label>

<input type="text" class="form-control" name="description" id="description" placeholder="Enter Description">
</div>


<button id="output_create" type="button" class="btn btn-default" >Create</button>

  
<script>
    
    $(document).ready(function(){
        
        
        $("button#output_create").click(function(){
                
                //form validation for shift 
        var error = false;
        
        //if no shift start time is specified
        if ($("#output_type").val() == "") {
            //code
            error = true;
            alert("Output Type cannot be empty");
        }
        
        
        if (!error)
        {
            $("form[name=defineOutputType]").submit();
        }
            });
        
        });
    
  
    
</script>

<hr/>

<div class="form-group">
<label for="exampleInputEmail1">Select Output Type</label>

    <select class="form-control" name="output_id" id="output_id">
        <option value=""></option>
        <?php foreach($outputtype as $outputtypes){?>
        
            <option value="<?php echo($outputtypes['id']);?>" ><?php echo ucfirst($outputtypes['type']);?></option>
            
        <?php } ?>
    </select>
</div>

<button id="del_output" type="button" class="btn btn-default" >Delete</button>

<script>
    
    $(document).ready(function(){
        
        
        $("button#del_output").click(function(){
                
                //form validation for shift 
        var error = false;
        
        //if no shift start time is specified
        if ($("#output_id").val() == "") {
            //code
            error = true;
            alert("Select a Output Type");
        }
        
        
        if (!error)
        {
            if (confirm("Do you want to delete Output Type ? ")) {
                //code
                $("form[name=defineOutputType]").attr("action","<?=base_url()?>index.php/admin/delOutputType").submit();
            }
            
        }
            });
        
        });
    
  
    
</script>
</div>
</div>
</div>
</div>
</form>






<!---------------------------------------------   Begining of Delivery Type code dialogue---------------------------------------------------------------------->

<form name="defineDeliveryType" method="post" action="<?=base_url() ?>index.php/admin/defineNewDeliveryType">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deliveryType" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Delivery Type</h4>
</div>
<div class="modal-body">
    
    
<div class="form-group">
<label for="exampleInputEmail1">Delivery Type</label>

<input type="text" class="form-control" name="delivery_type" id="delivery_type" placeholder="Enter Type">
</div>


<div class="form-group">
<label for="exampleInputEmail1">Description</label>

<input type="text" class="form-control" name="description" id="description" placeholder="Enter Description">
</div>


<button id="delivery_create" type="button" class="btn btn-default" >Create</button>

  
<script>
    
    $(document).ready(function(){
        
        
        $("button#delivery_create").click(function(){
                
                //form validation for shift 
        var error = false;
        
        //if no shift start time is specified
        if ($("#delivery_type").val() == "") {
            //code
            error = true;
            alert("Delivery Type cannot be empty");
        }
        
        
        if (!error)
        {
            $("form[name=defineDeliveryType]").submit();
        }
            });
        
        });
    
  
    
</script>

<hr/>

<div class="form-group">
<label for="exampleInputEmail1">Select Delivery Type</label>

    <select class="form-control" name="delivery_id" id="delivery_id">
        <option value=""></option>
        <?php foreach($deliverytype as $deliverytypes){?>
        
            <option value="<?php echo($deliverytypes['id']);?>" ><?php echo ucfirst($deliverytypes['type']);?></option>
            
        <?php } ?>
    </select>
</div>

<button id="del_delivery" type="button" class="btn btn-default" >Delete</button>

<script>
    
    $(document).ready(function(){
        
        
        $("button#del_delivery").click(function(){
                
                //form validation for shift 
        var error = false;
        
        //if no shift start time is specified
        if ($("#delivery_id").val() == "") {
            //code
            error = true;
            alert("Select a Delivery Type");
        }
        
        
        if (!error)
        {
            if (confirm("Do you want to delete Delivery Type ? ")) {
                //code
                $("form[name=defineDeliveryType]").attr("action","<?=base_url()?>index.php/admin/delDeliveryType").submit();
            }
            
        }
            });
        
        });
    
  
    
</script>
</div>
</div>
</div>
</div>
</form>





<!------------------------------              begining of define Dept dialogue box              ---------------->

<form name="defineDept" method="post" action="<?=base_url() ?>index.php/admin/createDepartment">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="createDept" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Define New Department</h4>
</div>
<div class="modal-body">
    
    
<div class="form-group">
<label for="exampleInputEmail1">Department Name</label>

<input type="text" class="form-control" name="department_name" id="department_name" placeholder="Enter Department Name">
</div>


<button id="dept_create" type="button" class="btn btn-default" >Create Dept</button>

  
<script>
    
    $(document).ready(function(){
        
        
        $("button#dept_create").click(function(){
                
                //form validation for shift 
        var error = false;
        
        //if no shift start time is specified
        if ($("#department_name").val() == "") {
            //code
            error = true;
            alert("Department Name Cannot Be Empty");
        }
        
        
        if (!error)
        {
            $("form[name=defineDept]").submit();
        }
            });
        
        });
    
  
    
</script>


</div>
</div>
</div>
</div>
</form>



<form id="view-group" method="post" action="<?=base_url() ?>index.php/patient/number">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="viewUserGroup" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">User Group</h4>
</div>
<div class="modal-body">
<form role="form" id="add-new-occupation"  name="add-new-occupation" method="post" action="text.php">
<div class="form-group">
<label for="exampleInputEmail1">User Group</label>
 <select name="user_group_id" id="user_group_id" class="form-control m-bot15">
        <option></option>
        <?php
        foreach($usergroups as $group)
        {
            echo "<option value='".$group['user_group_id']."'>".ucfirst($group['name'])."</option>";
        }
        ?>
        
    
        
    </select></div>

<div id="occupation-create-error"></div>

<button type="button" id="find_patient" class="btn btn-default" onclick="javascript:viewUserGroup();">View Group</button>
<button type="button" id="find_patient" class="btn btn-default" onclick="javascript:deleteUserGroup();">Delete Group</button>
  
<script>
    
    function deleteUserGroup() {
        
        
        
         if ($("#user_group_id").val() != "")
         {
            var isconfirmed = confirm("Do you want to delete user group ?");
            
            if (isconfirmed) {
                    $("form#view-group").attr("action","<?=base_url()?>index.php/admin/deleteUserGroup").submit();
            }
         }
         else
         {
            alert("Select a user group");
         }
        
    }
    function viewUserGroup() {
        
        if ($("#user_group_id").val() != "")
        {
            $("form#view-group").attr("action","<?=base_url()?>index.php/staff/editGroupPermissions").submit();
        }
       
    }
    
</script>
</form>
</div>
</div>
</div>
</div>
</form>




<form id="deldept" method="post" action="<?=base_url() ?>index.php/admin/deleteDept">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deleteDept" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Department</h4>
</div>
<div class="modal-body">
<form role="form" id="add-new-occupation"  name="add-new-occupation" method="post" action="text.php">
<div class="form-group">
<label for="exampleInputEmail1">Department</label>
 <select name="department" id="department_id" class="form-control m-bot15">
        <option></option>
        <?php
        foreach($departments as $dept)
        {
            echo "<option value='".$dept['dept_id']."'>".ucfirst($dept['name'])."</option>";
        }
        ?>
        
    
        
    </select></div>

<div id="occupation-create-error"></div>

<button type="button" id="delete_dept" class="btn btn-default" onclick="javascript:deleteDept();">Delete Dept</button>

  
<script>
    
    function deleteDept() {
        //code
        
        var deptid  = $("select#department_id").val();
        
        if ($.trim(deptid) == "") {
          alert("Choose a department");
        }
        
        else
        {
            
            var isConfirmed = confirm("Do you want to delete department ? ");
            
            if (isConfirmed) {
              
                $("form#deldept").submit();
            }
        }
    }
    
</script>
</form>
</div>
</div>
</div>
</div>
</form>




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
</form

<!---------------------------------------------   Begining of logo upload dialogue---------------------------------------------------------------------->

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="logodata" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Hospital Logo</h4>
</div>
<div class="modal-body">
 
  <a  id="viewpicdata" href="#picturedata" data-toggle="modal" ></a>

<form name="uploadlogo" enctype="multipart/form-data" action="<?=base_url()?>index.php/admin/uploadLogo" method="post">
 
 
 <div class="form-group">
<label class="control-label col-md-3">Select Logo File</label>
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
       $("form[name=uploadlogo]").submit();
    }
 </script>
</div>
</div>
</div>
</div>
    
 
    <!---------------------------------------------   Begining of marital status def dialogue---------------------------------------------------------------------->


    
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="maritaldata" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Marital Status</h4>
</div>
<div class="modal-body">
 
  <a  id="viewpicdata" href="#picturedata" data-toggle="modal" ></a>

<form name="maritalDef"  action="<?=base_url()?>index.php/admin/uploadMaritalStat" method="post">
 
 
 <div class="form-group">
<label for="exampleInputEmail1">Code</label>
<input type="text" class="form-control" name="marital_status" id="marital_status" placeholder="Code">
</div>
 
  <div class="form-group">
<label for="exampleInputEmail1">Description</label>
<input type="text" class="form-control" name="marital_description" id="marital_description" placeholder="Marital Status">
</div>
  
  
  <button type="button" id="save" class="btn btn-default" onclick="javascript:uploadMaritalData();">Save</button>
   </form>

 <script>
    
    function uploadMaritalData() {
        //code
        var error = false;
        var code = $("input#marital_status").val();
        if (code == "")
        {
            //code
            error = true;
            alert("Marital Status Code Required");
        }
        else if (code.length > 1) {
            //code
            error = true;
            alert("Marital status code cannot be longer than one character");
        }
       if (!error) {
        //code
        $("form[name=maritalDef]").submit();
       }
       
    }
    
    
    
    function getStatesOfCountry(country_code, selector,shouldgetlga) {
        
        $("input#country_code_input").val(country_code);
       
       var selectid = "#"+selector;
       getStatesByCountry(selectid,shouldgetlga);
  
    }
    
    function getLgasOfOrigin(state_code, selectid) {
        
      
        $("input#state_code_input").val(state_code);
        
     //  var selectid = "#origin_lga_id";
       getLgasByState("#"+selectid);
  
    }
    
    function getLgasByState(selectid) {
        var obj ="";
         var url = "<?= base_url() ?>"+"index.php/lga/getLgasByStateJson";
       
       
        $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#getlgas').serialize(),
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
                
                for (var i = 0; i < arrayLength; i++) {
                    var newoption = "<option  style='text-transform: capitalize' value='"+obj[i]['lga_id']+"'>"+obj[i]['lga_name']+"</option>";
                     
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
    
    
    function getStatesByCountry(selectid,shouldgetlga) {
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
                
                for (var i = 0; i < arrayLength; i++) {
                    var newoption = "<option  style='text-transform: capitalize' value='"+obj[i]['state_code']+"'>"+obj[i]['state_name']+"</option>";
                    
                     $(selectid).append(newoption);
                     
                     //fix to make lga work too
                     if (i == 0) {
                        $("input#state_code_input").val(obj[i]['state_code']);
                     }
                    //Do something
                     $('#origin_lga_id')
                   .find('option')
                   .remove()
                   .end();
                   
                   //if has submitted before
                    <?php if(isset($state_of_origin)){?>
           
                
                $("select#state_of_origin").val("<?php echo $state_of_origin;?>");
              
                    <?php }?>
                    
                    <?php if(isset($address_state_code)){?>
    
                
                $("select#address_state_code").val("<?php echo $address_state_code;?>");
               
            <?php }?>
                if (shouldgetlga) {
                    //code
                    // getLgasOfOrigin($("select#state_lga_base_view").val(),"lga_base_view");
                   getLgasOfOrigin($("input#state_code_input").val(), "lga_base_view");
                }
                   
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
 
 
 
<hr/>

 <form id="delete_maritalstat" method="post" action="<?=base_url() ?>index.php/patient/number">  
<div class="form-group">
<label for="exampleInputEmail1">Marital Status</label>

<select class="form-control" name="marital_status">
    <?php foreach($marital_stats as $m_stat){?>
        <option value="<?php echo $m_stat['id'];?>"><?php echo ucfirst($m_stat['description']);?></option>
        
    <?php }?>
</select>
<input type = "hidden" name="basedata_type" value="marital_status"/>

</div>
<button type="button" id="" class="btn btn-default" onclick="javascript:deleteBasedata('delete_maritalstat');">Delete</button>

  </form>
  
  
  
 
</div>
</div>
</div>
</div>
    
    <form id="getStates">
    
    <input type="hidden" name="country_code" id="country_code_input"/>
</form>

<form id="getlgas">
    
    <input type="hidden" name="state_code" id="state_code_input"/>
</form>



 
</section>
</section>
 