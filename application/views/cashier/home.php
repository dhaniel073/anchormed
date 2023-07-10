

 
 
 
<section id="main-content" >
<section class="wrapper">
 
<div class="row" >
    
    
<div class="col-lg-12" style="margin-top:100px;margin-bottom:100px;">
<section class="panel">
<header class="panel-heading">
Cash Management
<span class="tools pull-right">
<a href="javascript:;" class="fa fa-chevron-down"></a>
<a href="javascript:;" class="fa fa-times"></a>
</span>
</header>
<div class="panel-body" style="margin-top:50px;">


<div style="width:100%; text-align: center; margin-bottom:200px;">
    <a  href="<?=base_url()?>index.php/cashier/search">
       <div class="option-icon">
        <i class="fa fa-search fa-5x"></i>
        <p>Find Bills</p>
       
    </div>
   </a>
   
   <a  href="#patientSearch" data-toggle="modal" purpose="print" class="patient_function" url="<?=base_url()?>index.php/billing/processedBills"  >
     <div class="option-icon">
        <i class="fa fa-print fa-5x"></i>
        <p>Paid Bills</p>
        
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




  
  <form id="find" method="post" action="<?=base_url() ?>index.php/patient/number">
<input type="hidden" name="return_base" id="return_base" value=""/>

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="patientSearch" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
    
    <input value="<?=base_url()?>index.php/billing/processedBills" type="hidden" name="return_base" />
    
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Find Patient</h4>
</div>
<div class="modal-body">

  
  <div class="form-group">
<label for="exampleInputEmail1">Name</label>
<input type="text" class="form-control" name="name" id="name" placeholder="Name">
</div>
  
  <button type="button" id="find_all_hmo_patients" class="btn btn-default" onclick="javascript:findPatientByName();">Find By Name</button>
  
  <hr/>
  
  <div class="form-group" func="print">
<label for="exampleInputEmail1">Reference</label>
<input type="text" class="form-control" name="ref" id="ref" placeholder="Name">
</div>
  
  <button func="print" type="button" id="find_ref" class="btn btn-default" onclick="javascript:findRecieptByRef();">Find By Reference</button>
  
  
<script>
    
     function findRecieptByRef() {
        if ($("#ref").val() != "")
        {
          $("form#find").attr("action","<?=base_url()?>index.php/billing/searchBillByReference").submit();
         //  document.location.replace("<?=base_url()?>index.php/billing/viewBill/"+$("#ref").val());
        }
       else alert("Enter Reciept Ref ");
    }
    
    function findPatientByName() {
        if ($("#name").val() != "")
        {
            $("form#find").attr("action","<?=base_url()?>index.php/patient/search").submit();
        }
       else alert("Enter Patient Name");
    }
    
    
</script>

</div>
</div>
</div>
</div>
</form>

<!--------Begining of provider inquire dialogue--------------------------------------->
<form name="multiform"  action="<?=base_url()?>index.php/provider/view" method="post">
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="provider_select" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title"><span id='dia_title'>Provider</span> </h4>
</div>
<div class="modal-body">
 


 
 
 <div class="form-group">
<label for="exampleInputEmail1">Select Provider</label>
<select name="hmo_code" id="hmo_code" class="form-control m-bot15">
        <option></option>
        <?php
        foreach($providers as $hmo)
        {
            echo "<option value='".$hmo['hmo_code']."'>".ucfirst($hmo['hmo_name'])."</option>";
        }
        ?>
        
    
        
    </select></div>

  
  <button type="button" id="save" class="btn btn-default" onclick="javascript:viewProvider();">View</button>
   </form>

 <script>
    
    function viewProvider() {
        //code
        var error = false;
        var code = $("select#hmo_code").val();
        if (code == "")
        {
            //code
            error = true;
            alert("Select a Provider");
        }
       
       if (!error) {
        //code
         $("form[name=multiform]").submit();
       }
       
    }
 </script>
</div>
</div>
</div>
</div>




<!--------Begining of create provider dialogue--------------------------------------->
<form name="create_form"  action="<?=base_url()?>index.php/provider/create" method="post">
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="provider_create" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title"><span id='dia_title'>Create Provider</span> </h4>
</div>
<div class="modal-body">
 


 
 
 <div class="form-group">
<label for="exampleInputEmail1">Provider Code (3 Characters Only)</label>
<input type="text" class="form-control" value="" name="hmo_code" id="hmo_code" placeholder="Code" >
</div>

 <div class="form-group">
<label for="exampleInputEmail1">Provider Name</label>
<input type="text" class="form-control" value="" name="hmo_name" id="hmo_name" placeholder="Provider Name" >
</div>
 
 
  
  <button type="button" id="save" class="btn btn-default" onclick="javascript:createProvider();">Create</button>
   </form>

 <script>
    
    function createProvider() {
        //code
        var error = false;
        var code = $("input#hmo_code").val();
        var name = $("input#hmo_name").val();
        
        if (code == "")
        {
            //code
            error = true;
            alert("Define Provider Code");
        }
        else if (code.length != 3) {
            //code
            alert("Provider Code Must Be 3 Characters long");
             error = true;
        }
        
        
        if (name == "")
        {
            //code
            error = true;
            alert("HMO name cannot be empty");
        }
       
       if (!error) {
        //code
         $("form[name=create_form]").submit();
       }
       
    }
 </script>
</div>
</div>
</div>
</div>

</section>
</section>
 