
 
 
 
<section id="main-content">
<section class="wrapper">
 
<div class="row">
    
<div class="col-lg-12">
 
<ul class="breadcrumb">
<li><a href="<?=base_url()?>index.php/provider"><i class="fa fa-home"></i> HMO Central</a></li>
<li><a href="#">HMO Management</a></li>
<li class="active">view</li>
</ul>
 
</div>
</div>

<div class="row">
    
<div class="col-lg-12">
<section class="panel">
<div class="panel-body">
<ul class="summary-list">

<li>
<a  href="#datauser" data-toggle="modal">
<i class="fa fa-tags text-primary"></i>
HMO Data
</a>
</li>

<li>
<a  href="<?=base_url()?>index.php/provider/generateBill/<?php echo $provider["hmo_code"];?>" data-toggle="modal">
<i class="fa fa-credit-card text-primary"></i>
Generate Bill
</a>
</li>


<li>
<a  href="<?php if(isset($bill_count["count"]) && $bill_count["count"] > 0) {?> <?=base_url()?>index.php/provider/viewBills/<?php echo $provider["hmo_code"];?> <?php } else echo "#"; ?>" data-toggle="modal">
<span class="badge bg-warning nofication_count" id="order_count"><?php if(isset($bill_count["count"]))echo $bill_count["count"];?></span>
<i class="fa fa-shopping-cart text-primary"></i>
Current Bill(s)
</a>
</li>


<li>
<a  href="<?=base_url()?>index.php/provider/viewPayedBills/<?php echo $provider["hmo_code"];?>">
<i class="fa fa-tags text-primary"></i>
HMO Payed Bills
</a>
</li>



</ul>
</div>
</section>
</div>
</div>
</div>
</div>



<div class="row">
<div class="col-lg-4">
 
    <section class="panel">
        <div class="twt-feed blue-bg">
        <h1><?php echo ucfirst($provider['hmo_name']);?></h1>
        <p><?php echo $provider['hmo_code']; ?></p>
        <a href="#">
            <?php if(isset($pic) && !empty($pic)){?>
        <img src="<?=base_url()?>assets/img/profiles/<?php echo $pic['picture'];?>" alt="">
        <?php }else {?>
        <img src="" alt="">
        <?php }?>
        </a>
        </div>
        <div class="weather-category twt-category">
            <ul>
            <li class="active">
            <h5><?php if(isset($patients) && $patients != "") echo sizeof($patients)?></h5>
            Total Patients
            </li>
           
            
            </ul>
        </div>
        <hr/>

        
        
        <div class="twt-write col-sm-12">
      
        </div>
        <footer class="twt-footer">
        
       
        </footer>
        
       
        
    </section>
    
    
    
 
</div>


<form name="changeFile" id="changeFile" action="<?=base_url()?>index.php/provider/changeHmoToSingle" method="post">

<input type="hidden" name="hmo_code" value="<?php echo $provider['hmo_code']; ?>"/>

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
<select name="new_hmo_code" id="new_hmo_code" class="form-control m-bot15">
        <option></option>
        <?php
        foreach($providers as $hmo)
        {
            echo "<option value='".$hmo['hmo_code']."'>".ucfirst($hmo['hmo_name'])."</option>";
        }
        ?>
        
    
        
    </select></div>

  
  <button type="button" id="save" class="btn btn-default" onclick="javascript:viewProvider();">Change HMO</button>

 <script>
    
    function viewProvider() {
        //code
        var error = false;
        var code = $("select#new_hmo_code").val();
        if (code == "")
        {
            //code
            error = true;
            alert("Select a HMO");
        }
       
       if (!error) {
        //code
		 console.log("Change HMO file to another HMO");
		 $("form[name=changeFile]").attr("action", "<?=base_url()?>index.php/provider/changeHmoToHmo").submit();
       }
       
    }
 </script>
</div>
</div>
</div>
</div>
	
	
<div class="col-lg-8">
    
<aside class="profile-info col-lg-12">

    <section class="panel">
      
        <div class="panel-body bio-graph-info">
             <h3>Registered Patients</h3>
			 <div><a href="#provider_select" id="chghmopatient" class="btn btn-info btn-lg"  data-toggle="modal"><i class="fa fa-check"></i>Change HMO</a>     <a id="chgsingle" class="btn btn-info btn-lg"><i class="fa fa-check"></i>Change To Single FIle </a>  <a id="chgfam" class="btn btn-info btn-lg"><i class="fa fa-check"></i>Change To Family </a></div>
      <table class="display table table-bordered table-striped" id="patients">
<thead>
    




						  
<tr>
<th>#</th>
<th>File Number</th>
    <th>HMO Number</th>
<th>Name</th>
<th>Sex</th>
</tr>
</thead>
<tbody>
<?php foreach($patients as $patient){ ?>
<tr class="gradeX">
  <?php if(isset($return_base)  && $return_base != "")
  { ?>
  <td><input  name="hmopatient[]"  type="checkbox" value="<?php echo $patient['patient_number']; ?>"/></td>
  <td><a href="<?php echo $return_base;?>/<?php echo $patient['patient_number']; ?>"><?php echo $patient['patient_number']; ?></a></td>
  <?php
    }else {
        ?> 
<td><input  name="hmopatient[]"  type="checkbox"  value="<?php echo $patient['patient_number']; ?>"/></td>		
<td><a href="<?=base_url() ?>index.php/patient/number/<?php echo $patient['patient_number']; ?>"><?php echo $patient['patient_number']; ?></a></td>
<?php }?>

    <td><?php if(isset($patient['hmo_enrolee_id']))echo $patient['hmo_enrolee_id'];?></td>
<td><?php echo ucfirst($patient['first_name'])." ".ucfirst($patient['middle_name'])." ".ucfirst($patient['last_name']); ?></td>

<td><?php echo $patient['sex']; ?></td>
</tr>

<?php }?>
</tbody>

</table>

</form>

<script type="application/x-javascript">
    $(document).ready(function(){
            
         				
			$("a#chghmo").click(function () {

                            console.log("Change HMO file to another HMO");
                            $("form[name=changeFile]").attr("action", "<?=base_url()?>index.php/provider/changeHmoToHmo").submit();

                        });
						
			$("a#chgsingle").click(function () {

                            console.log("change HMO file to Single");
                            $("form[name=changeFile]").attr("action", "<?=base_url()?>index.php/provider/changeHmoToSingle").submit();

                        });
						
			$("a#chgfam").click(function () {

                            console.log("Change HMO File to family");
                            $("form[name=changeFile]").attr("action", "<?=base_url()?>index.php/provider/changeHmoToFamily").submit();

                        });
        
        });
 </script>

                        

        </div>
       
    </section>

    
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="datauser" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Hmo data</h4>
</div>
<div class="modal-body">
 <a  id="viewdata" href="#datauser" data-toggle="modal" ></a>
 
<section class="panel">
<header class="panel-heading tab-bg-dark-navy-blue " style="background: #00A8B3; height: 38px;">
<ul class="nav nav-tabs">
<li class="active">
<a data-toggle="tab" href="#home">General</a>

</li>
<li class="">
<a data-toggle="tab" href="#about">Address</a>
</li>
</ul>
</header>
<div class="panel-body">
<div class="tab-content">
<div id="home" class="tab-pane active">

<form name="personal_form" method="post" action="<?= base_url() ?>index.php/provider/updateGeneral">
 
   
<div class="form-group">
    <label for="exampleInputEmail1">Name</label>
    <input type="text" class="form-control" value="<?php echo ucfirst($provider['hmo_name']); ?>" name="hmo_name" id="hmo_name" placeholder="HMO Name" >
     <input type="hidden" name="hmo_id" value="<?php echo $provider['hmo_id'];?>"/>
      <input type="hidden" name="hmo_code" value="<?php echo $provider['hmo_code'];?>"/>
</div>


  <div class="form-group">
    <label for="exampleInputEmail1">Office Number</label>
    <input name="office_number" id="office_number" value="<?php  if(isset($provider['office_number']))echo $provider['office_number']; ?>" type="text" placeholder="" data-mask="(999) 999-9999-999" class="form-control">
    <span class="help-inline">(234) 809-9999-999</span>
</div>
  
  
  <div class="form-group">
    <label for="exampleInputEmail1">Office Number 2</label>
     <input name="mobile_number" id="mobile_number" value="<?php  if(isset($provider['mobile_number']))echo $provider['mobile_number']; ?>" type="text" placeholder="" data-mask="(999) 999-9999-999" class="form-control">
    <span class="help-inline">(234) 809-9999-999</span>
</div>
    
    
    
 <div class="form-group">
    <label for="exampleInputEmail1">Email</label>
    <input type="text" class="form-control" value="<?php if($provider['email'])echo strtolower($provider['email']); ?>" name="email" id="email" placeholder="Email" >
 
</div>
    
    <div class="form-group">
    <label for="exampleInputEmail1">Alternate Email</label>
    <input type="text" class="form-control" value="<?php if(isset($provider['alt_email'])) echo strtolower($provider['alt_email']); ?>" name="alt_email" id="alt_email" placeholder="Alt Email" >
 
</div>
    

    <button type="button" id="update_personal" class="btn btn-default" onclick="javascript:updatePersonal();">Update</button>
  
    <script>
        
        function updatePersonal() {
            
            var error = false; 
            //code
            var name = $.trim($("input#hmo_name").val());
            
            
            if (name == "") {
                //code
                
                error = true;
                alert("Name Can't Be Empty");
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
    <input type="text" class="form-control" value="<?php if(isset($provider['hmo_address'])) echo ucwords($provider['hmo_address']); ?>" name="address_line_1" id="address_line_1" placeholder="Address Line 1">
    <input type="hidden" name="hmo_code" value="<?php echo $provider['hmo_code'];?>"/>
</div>
  

  <div class="form-group">
    <label for="exampleInputEmail1">Address Line 2</label>
    <input type="text" class="form-control" value="<?php if(isset($provider['hmo_address_line_2'])) echo ucwords($provider['hmo_address_line_2']); ?>" name="address_line_2" id="address_line_2" placeholder="Address Line 2">
 
</div>
  
  
    <div class="form-group">
    <label for="exampleInputEmail1">State</label>
    <select class="form-control" name="address_state_code" id="address_state_code" >
    
    <?php foreach($address_states as $u){?>
        <?php if($u['state_code'] == $provider['state_code']){?>
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
        <?php if($u['country_code'] == $provider['country_code']){?>
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
                
                getStatesByCountry2("select#address_state_code");
            });
        });
    
    function getStatesByCountry2(selectid) {
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
    
    
    

  
 

</aside>
   
   
</div>





</div>



<form id="getStates" method="post">
        <input type="hidden" name="country_code" id="get_country_code" value=""/>
     </form>


</section>
</section>
 <script>
    
    
$(document).ready(function(){
    
    
        <?php
        
            $alert = $this->session->userdata("notice");
            $this->session->unset_userdata("notice");
            if(isset($alert) && $alert != "")
            {
                echo "alert('".$alert."');";
            }
            
        
        ?>
    
    });
 </script>
 
<script src="<?=base_url() ?>assets/assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>