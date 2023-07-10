

 
 
 
<section id="main-content" >
<section class="wrapper">
 
<div class="row" >
    
    
<div class="col-lg-12" style="margin-top:100px;margin-bottom:100px;">
<section class="panel">
<header class="panel-heading">
HMO Management
<span class="tools pull-right">
<a href="javascript:;" class="fa fa-chevron-down"></a>
<a href="javascript:;" class="fa fa-times"></a>
</span>
</header>
<div class="panel-body" style="margin-top:50px;">


<div style="width:100%; text-align: center; margin-bottom:200px;">
    <a  href="#provider_create" id="create-bill" data-toggle="modal">
       <div class="option-icon">
        <i class="fa fa-plus fa-5x"></i>
        <p>Define New HMO</p>
       
    </div>
   </a>
    

 <a  href="#provider_select" id="view_provider" data-toggle="modal">
       <div class="option-icon">
        <i class="fa fa-shield fa-5x"></i>
        <p>View HMO</p>
        
    </div>
       </a>


    <a  href="#reports" data-toggle="modal" upload="lga">
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


<!--------Begining of provider inquire dialogue--------------------------------------->
<form name="multiform"  action="<?=base_url()?>index.php/provider/view" method="post">
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="provider_select" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title"><span id='dia_title'>HMO</span> </h4>
</div>
<div class="modal-body">
 


 
 
 <div class="form-group">
<label for="exampleInputEmail1">Select HMO</label>
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
            alert("Select a HMO");
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
<h4 class="modal-title"><span id='dia_title'>Create HMO</span> </h4>
</div>
<div class="modal-body">
 


 
 
 <div class="form-group">
<label for="exampleInputEmail1">HMO Code (3 Characters Only)</label>
<input type="text" class="form-control" value="" name="hmo_code" id="hmo_code" placeholder="Code" >
</div>

 <div class="form-group">
<label for="exampleInputEmail1">HMO Name</label>
<input type="text" class="form-control" value="" name="hmo_name" id="hmo_name" placeholder="HMO Name" >
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
            alert("Define HMO Code");
        }
        else if (code.length != 3) {
            //code
            alert("HMO Code Must Be 3 Characters long");
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
 