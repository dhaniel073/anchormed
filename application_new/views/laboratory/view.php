

 
 
 
<section id="main-content" >
<section class="wrapper">
    
    <div class="row">
<div class="col-lg-12">
 
<ul class="breadcrumb">
<li><a href="<?=base_url()?>index.php/laboratory"><i class="fa fa-home"></i> Laboratory</a></li>
<li><a href="<?=base_url()?>index.php/laboratory/search">search</a></li>
<li class="active">view</li>


</ul>
</div>

</div>



 
<div class="row" >
    
    
<div class="col-lg-12" style="margin-top:20px;margin-bottom:20px;">
<section class="panel">
<header class="panel-heading">
    <?php echo ucfirst($lab['name']); ?>
<span class="tools pull-right">
<a href="#" id="edit">edit</a>
<a href="javascript:;" class="fa fa-chevron-down"></a>
<a href="javascript:;" class="fa fa-times"></a>
</span>
</header>

<script>
    
    $(document).ready(function(){
            
            $("a#edit").click(function(){
                
                    $("input[editable=yes]").removeAttr("disabled");
                    $("div#update_btn").show();
                });
            
            $("div#update_btn").hide();
        
        });
</script>




    <div class="panel-body" style="margin-top:10px; min-height: 400px;">
    
       
        
          <div style="float:left; margin: 20px; width:60%;">
            
           <div class="form-group">
            
                <label class="col-lg-2 control-label" style="top:+10px;">Name</label>
                <div class="col-lg-10"> 
                <input name="name" disabled="disabled" value="<?php  if(isset($lab['name']))echo $lab['name']; ?>" id="name" type="text" class="form-control" placeholder="Name">
                <br/>
                </div>
            </div>
           
           <form name="updateform" id="updateform" action="<?=base_url()?>index.php/laboratory/updateTest" method="post">
           <input name="lab" value="<?php echo $lab["lab_id"]; ?>" type="hidden"/>
             <div class="form-group" >
            
                <label class="col-lg-2 control-label" style="top:+10px;">Description</label>
                <div class="col-lg-10"> 
                <input editable="yes" name="description" disabled="disabled" value="<?php  if(isset($lab['description']))echo $lab['description']; ?>" id="description" type="text" class="form-control" placeholder="Description">
                <br/>
                </div>
            </div>
             </form>
               
              
             
             <script>
                
                 function updateSampleType() {
                    //
                     $("form[name=updateform]").submit();
                }
                
                
                
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
            
            
             <div class="form-group" id="update_btn">
            
                <label class="col-lg-2 control-label" style="top:+10px;">--></label>
                <div class="col-lg-10">
                   
                   <a  id="link_update" onclick="javascript:updateSampleType();" href="#"  helper="update_helper" style="font:20px" class="has-helper btn btn-shadow btn-md btn-success"><i class="fa fa-edit-o"></i> Update</a>
                        
                        <span class="helper-span" style="color: #FC0022;" id="update_helper"> Update Sample Type</span>
                   <br/><br/>
                </div>
                
            </div>
             
             
             <div class="form-group" >
                
                
            
                <label class="col-lg-2 control-label" style="top:+10px;">Billing</label>
                <div class="col-lg-10">
                   
                   <a  href="#updateBilling" data-toggle="modal"  helper="bill_helper" style="font:20px" class="has-helper btn btn-shadow btn-lg btn-success" href=""><i class="fa fa-shopping-cart"></i> Billing</a>
                        
                        <span class="helper-span" style="color: #FC0022;" id="bill_helper"> Click to edit Price info</span>
                        
                   <br/><br/>
                </div>
                
            </div>
            
             
             
              <div class="form-group">
            
                <label class="col-lg-2 control-label" style="top:+10px;">--></label>
                <div class="col-lg-10">
                   
                   <a  id="link_delete" href="#"  helper="delete_helper" style="font:20px" class="has-helper btn btn-shadow btn-md btn-danger"><i class="fa fa-trash-o"></i> Delete</a>
                        
                        <span class="helper-span" style="color: #FC0022;" id="delete_helper"> Delete Test</span>
                   <br/>
                </div>
                
            </div>
             
            
             
             <script>
                
               $(document).ready(function(){
                   $("#link_delete").click(function(){
                    
                        var confirmDelete = confirm("are you sure you want to delete this type ?");
                        if (confirmDelete)
                        {
                            $("form#deleteTest").submit();
                        }
                    });
                });
             </script>
             

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

<form name="updateBills" method="post" action="<?=base_url() ?>index.php/laboratory/updateLabBill">

<a id="viewday" href="#user_appointment" data-toggle="modal"></a>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="updateBilling" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Update Billing Info</h4>
</div>


<div class="modal-body">
  

     <div class="form-group">
                    <label for="exampleInputEmail1">Price </label>
                    <input type="text" value="<?php echo $lab_price['lab_price']; ?>" class="form-control" name="lab_price" id="lab_price" placeholder="Price">
          </div>
            
  
  
          
            
     <button type="submit" id="update_stock_btn" class="btn btn-default" >Update Billing Info</button>

     <input type="hidden" name="lab_price_id" value="<?php echo $lab_price['lab_price_id'];?>"/>
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
                    <label for="exampleInputEmail1">Add to Stock </label>
                    <input type="number" class="form-control" name="qty" id="qty" placeholder="Quantity">
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
           
           <?php 
           
            $qty = 0;
            
            if(isset($drug['stock']['qty_in_stock']) && $drug['stock']['qty_in_stock'] > 0)
            {
                $qty = $drug['stock']['qty_in_stock'] ;
            }
           ?>          
           
           if ($.trim(qty) != "" && $.isNumeric(qty)) {
                
                               
                 $("form[name=updateStockForm]").submit();
               
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


<form name="deleteTest" id="deleteTest" method="POST" action="<?=base_url()?>index.php/laboratory/deleteTestType">
                <input name="lab" value="<?php echo $lab["lab_id"]; ?>" type="hidden"/>
</form>

