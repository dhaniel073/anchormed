

 
 
 
<section id="main-content" >
<section class="wrapper">
    
    <div class="row">
<div class="col-lg-12">
 
<ul class="breadcrumb">
<li><a href="<?=base_url()?>index.php/pharmacy"><i class="fa fa-home"></i> Pharmacy</a></li>
<li><a href="<?=base_url()?>index.php/pharmacy/search">search</a></li>
<li class="active">view</li>


</ul>
</div>

</div>



 
<div class="row" >
    
    
<div class="col-lg-12" style="margin-top:20px;margin-bottom:20px;">
<section class="panel">
<header class="panel-heading">
    <?php echo ucfirst($drug['name'])." (Inventory Details)" ; ?>
<span class="tools pull-right">
<a href="javascript:;" class="fa fa-chevron-down"></a>
<a href="javascript:;" class="fa fa-times"></a>
</span>
</header>


    <div class="panel-body" style="margin-top:10px; min-height: 400px;">
    
        <div style="float:left; margin: 20px; width:30%;" >
            <img width="300px" height="300px" src="<?=base_url()?>assets/drugs/<?php echo $drug['picture'];?>" alt="preview"/>
        </div>
        
          <div style="float:left; margin: 20px; width:60%;">
            
           <div class="form-group">
            
                <label class="col-lg-2 control-label" style="top:+10px;">Name</label>
                <div class="col-lg-10"> 
                <input name="name" disabled="disabled" value="<?php  if(isset($drug['name']))echo $drug['name']; ?>" id="name" type="text" class="form-control" placeholder="Name">
                <br/>
                </div>
            </div>
           
             <div class="form-group" >
            
                <label class="col-lg-2 control-label" style="top:+10px;">Manufacturer</label>
                <div class="col-lg-10"> 
                <input name="manufacturer" disabled="disabled" value="<?php  if(isset($drug['manufacturer']))echo $drug['manufacturer']; ?>" id="manufacturer" type="text" class="form-control" placeholder="Manufacturer">
                <br/>
                </div>
            </div>
             
              <div class="form-group" >
            
                <label class="col-lg-2 control-label" style="top:+10px;">Packaging Info</label>
                <div class="col-lg-10"> 
                <input name="packaging_description" disabled="disabled" value="<?php  if(isset($drug['packaging_description']))echo $drug['packaging_description']; ?>" id="packaging_description" type="text" class="form-control" placeholder="Packaging Description">
                <br/>
                </div>
            </div>
              
              
               <div class="form-group" >
            
                <label class="col-lg-2 control-label" style="top:+10px;">Dosage Form</label>
                <div class="col-lg-10">
                    
                    <select disabled="disabled" name="drug_presentation_id"  class="form-control">
                        <option value=""></option>
                        <?php foreach($drug_presentations as $presentation){ ?>
                            <option  <?php if($presentation['drug_presentation_id'] == $drug['drug_presentation_id'] ){ echo "selected='selected'";}?> value="<?php echo $presentation['drug_presentation_id']; ?>"> <?php echo $presentation['name']; ?></option>
                        <?php } ?>
                    </select>
               <br/>
                </div>
            </div>
               
                 <div class="form-group" >
                  <label class="col-lg-2 control-label" style="top:+10px;">Drug Stock</label>
                <div class="col-lg-10">
                    
                    <?php if($rules && sizeof($rules) > 0){?>
                    <p>Please note</p>
                    <?php }?>
                    <?php foreach($rules as $rule) {?>
                    <p><?php echo $rule["rule_desc"];?></p>
                    <?php } ?>
                           <br/><br/><br/>
                </div>
                 </div>
                 
                  <?php if($qty_in_stock < 1){?>
                  
                  <div class="form-group" >
            
                <label class="col-lg-2 control-label" style="top:+10px;">Initial Stock</label>
                <div class="col-lg-10">
                   
                   
                   <a href="#updateStock" data-toggle="modal" helper="stock_helper"
                      id="<?php if(isset($stock['stock_id']))
                      echo $stock['stock_id'];?>" style="font:20px"
                                class="has-helper btn btn-shadow btn-lg btn-danger href=""><i class="fa fa-shopping-cart"></i> Create</a>
                        
                        <span class="helper-span" style="color: #FC0022;" id="stock_helper"> Click to edit stock</span>
                   <br/><br/><br/>
                </div>
                
            </div>
                  
                  
                  
                  <?php } ?>
               
               <?php foreach($drug['stock'] as $stock){?>
             <div class="form-group" >
            
                <label class="col-lg-2 control-label" style="top:+10px;">Batch No: <?php echo $stock['batch_no'] ;?></label>
                <div class="col-lg-10">
                   
                   <?php
                   
                    $date = new DateTime($stock["expiry_date"]);
                    date_timezone_set($date, timezone_open('Africa/Lagos'));
                    $expiryDate =  date_format($date, 'd-m-Y') ;
                    
                    $today = new DateTIme();
                    $style = "color:#78CD51;";
                    if($date <  $today)
                    {
                        $style = "color:#FF0000;";
                    }
                    
                   ?>
                   <a href="#updateStock" data-toggle="modal" helper="stock_helper"
                      id="<?php if(isset($stock['stock_id']))
                      echo $stock['stock_id'];?>" style="font:20px"
                                class="has-helper btn btn-shadow btn-lg btn-<?php if(isset($stock['qty_in_stock']) && $stock['qty_in_stock'] > 0){$stock_text = "In Stock ( ".$stock['qty_in_stock']." ) "; if(isset($drug_bill_form['name'])){ $stock_text = $stock_text.$drug_bill_form['name']."(s)";}; echo "success";} else{$stock_text = "Out Of Stock";echo "danger";} ?>"
                        href=""><i class="fa fa-shopping-cart"></i> <?php echo $stock_text; ?></a>
                        <span style="<?php echo $style;?>">Expires on <?php echo $expiryDate;?></span>
                        <span class="helper-span" style="color: #FC0022;" id="stock_helper"> Click to edit stock</span>
                   <br/><br/><br/>
                </div>
                
            </div>
             
             
             
             <?php }?>
             
              <div class="form-group" >
            
                <label class="col-lg-2 control-label" style="top:+10px;">Total: </label>
                <div class="col-lg-10">
                   
                  
                 <h4><?php echo $qty_in_stock." ".$drug_bill_form['name']."(s)";?>   </h4>    
                     
                   <br/><br/><br/>
                </div>
                
            </div>
             
             
             
             <script>
                $(document).ready(function(){
                    
                            $("span.helper-span").hide();
                            $("a.has-helper").hover(function(){
                                
                                var helper_span = "span#" + $(this).attr("helper");
                                
                                $(helper_span).stop().fadeIn("slow");
                                
                                }, function(){
                                    
                                       $("span.helper-span").hide();
                                      
                                    });
                    });
                
             </script>
            
            
             <div class="form-group" >
            
                <label class="col-lg-2 control-label" style="top:+10px;">Billing</label>
                <div class="col-lg-10">
                   
                   <a  href="#updateBilling" data-toggle="modal"  helper="bill_helper" style="font:20px" class="has-helper btn btn-shadow btn-lg btn-success" href=""><i class="fa fa-shopping-cart"></i> Billing</a>
                        
                        <span class="helper-span" style="color: #FC0022;" id="bill_helper"> Click to edit Billing info</span>
                   <br/>
                </div>
                
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





<!------------------------------------------------ drug stock update form ------------------------------------------------------->

<form name="updateBills" method="post" action="<?=base_url() ?>index.php/pharmacy/updateDrugBill">

<a id="viewday" href="#user_appointment" data-toggle="modal"></a>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="updateBilling" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Update Billing Info</h4>
</div>


<div class="modal-body">
  
  <?php foreach($billing_points as $bill_point){ ?>
  
     <div class="form-group">
                    <label for="exampleInputEmail1">A <?php echo ucfirst($bill_point['bill_package_info']['name']);?> of <?php echo ucfirst($drug['name']);?> is sold for </label>
                    <input type="number" value="<?php echo $bill_point['unit_price']; ?>" class="form-control" name="price_<?php echo $bill_point['drug_price_id']; ?>" id="price_<?php echo $bill_point['drug_price_id']; ?>" placeholder="Price">
          </div>
            
  
  
  
  <?php }?>
           
            
          
            
     <button type="submit" id="update_stock_btn" class="btn btn-default" >Update Billing Info</button>

     <input type="hidden" name="drug_id" value="<?php echo $drug['drug_id'];?>"/>
     <script>
       
     </script>

</div>



</div>
</div>
</div>
</form>



<!------------------------------------------------ drug stock update form ------------------------------------------------------->

<form name="updateStockForm" method="post" action="<?=base_url() ?>index.php/pharmacy/updateStock">

<a id="viewday" href="#user_appointment" data-toggle="modal"></a>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="updateStock" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Update Stock</h4>
</div>


<div class="modal-body">
  
            <div class="form-group">
                    <label for="exampleInputEmail1">Batch Number </label>
                    <input type="text" class="form-control" name="batch_number" id="batch_number" placeholder="Batch Number">
           </div>
   
   
            <div class="form-group">
                    <label for="exampleInputEmail1">Quantity </label>
                    <input type="number" class="form-control" name="qty" id="qty" placeholder="Quantity">
           </div>
            
            <div class="form-group">
            <label for="manufacture_date">Manufacture Date</label>
             <input name="manufacture_date" id="manufacture_date" class="form-control form-control-inline input-medium default-date-picker" size="16" type="text"
                        value="" />
               
            </div>
            
            
            <div class="form-group">
            <label for="expiry_date">Expiry Date</label>
             <input name="expiry_date" id="expiry_date" class="form-control form-control-inline input-medium default-date-picker" size="16" type="text"
                        value="" />
               
            </div>
            
            
            
            <div class="form-group">
                    <label for="exampleInputEmail1">Supplier Name </label>
                    <input type="text" class="form-control" name="sup_name" id="sup_name" placeholder="Supplier Name">
          </div>
            
            
            
            <div class="form-group">
                    <label for="exampleInputEmail1">Details </label>
                    <input type="text" class="form-control" name="details" id="details" placeholder="Addtional Details">
          </div>
            
     <button type="button" id="update_stock_btn" class="btn btn-default" onclick="javascript:updateStock();">Update Stock</button>

     <input type="hidden" name="drug_id" value="<?php echo $drug['drug_id'];?>"/>
     <script>
        
        function updateStock() {
           
           var qty = $("input#qty").val();
           
           var manufacture_date  = $("input#manufacture_date").val();
           
           var expiry_date  = $("input#expiry_date").val();
            
            
           <?php 
           
            $qty = 0;
            
            if(isset($drug['stock']['qty_in_stock']) && $drug['stock']['qty_in_stock'] > 0)
            {
                $qty = $drug['stock']['qty_in_stock'] ;
            }
           ?>          
           
           if ($.trim(qty) != "" && $.isNumeric(qty)) {
                
                            
                 if($.trim(manufacture_date) == ""){
                    
                    alert("Please Fill in the manufacture date of the batch");
                 }
                 else if ($.trim(expiry_date) == "") {
                    
                    //code
                    
                    alert("Please Fill in the expiry date of the batch");
                 }else{
                    
                    $("form[name=updateStockForm]").submit();
                 }
                 
               
           }
           else
           {
                alert("Invalid quantity");
           }
        }
     </script>

</div>



</div>
</div>
</div>
</form>

