
 
 
 
<section id="main-content">
<section class="wrapper">
  
<div class="row" style="min-height: 600px;">
    
    
<div class="col-lg-12">
<section class="panel">
<header class="panel-heading">
Drug Creation Form
<span class="tools pull-right">
<a href="javascript:;" class="fa fa-chevron-down"></a>
<a href="javascript:;" class="fa fa-times"></a>
</span>
</header>
<div class="panel-body">
 
  <!-- begining of form section-->
<section class="panel">

<div class="panel-body">
<div class="stepy-tab">
<ul id="default-titles" class="stepy-titles clearfix">
<li id="default-title-0" class="current-step">
<div>Step 1</div>
</li>
<li id="default-title-1" class="">
<div>Step 2</div>
</li>
<li id="default-title-2" class="">
<div>Step 3</div>
</li>
</ul>
</div>
<!--form class="form-horizontal" id="default"-->

<?php echo validation_errors(); ?>

<?php echo form_open('pharmacy/add') ?>
    
<script>
    
    $(document).ready(function(){
            $("form#default").attr("enctype","multipart/form-data");
        });
</script>

<fieldset title="Drug Info" class="step" id="default-step-0">
    
<legend> </legend>
<div class="form-group">
    <label class="col-lg-2 control-label">Name</label>
    <div class="col-lg-10"> 
    <input name="name" value="<?php  if(isset($name))echo $name; ?>" id="name" type="text" class="form-control" placeholder="Name">
    </div>
</div>

<div class="form-group">
    <label class="col-lg-2 control-label">Manufacturer</label>
    <div class="col-lg-10">
    <input name="manufacturer" value="<?php  if(isset($manufacturer))echo $manufacturer; ?>" id="manufacturer" type="text" class="form-control" placeholder="Manufacturer">
    </div>
</div>


<div class="form-group">
    <label class="col-lg-2 control-label">Packaging Description(Optional)</label>
    <div class="col-lg-10">
    <input name="description" value="<?php  if(isset($description))echo $description; ?>" id="description" type="text" class="form-control" placeholder="Packaging Description">
    </div>
</div>


<div class="form-group">
    <label class="col-lg-2 control-label">Dosage Form</label>
    <div class="col-lg-10">
    <select name="drug_presentation_id" id="drug_presentation_id" class="form-control" >
        <?php foreach($drug_presentations as $presentation){?>
        
            <option value = "<?php echo $presentation['drug_presentation_id'];?>"><?php echo ucfirst($presentation['name']);?></option>
        <?php } ?>
    </select>
    
    </div>
</div>


<div class="form-group">
    <label class="col-lg-2 control-label">Preview Image(Optional)</label>
    <div class="col-lg-10">
        <input id="pic" type="file" class="form-control" name="userfile" size="20"  class="default"/>
   </div>
</div>

<input type="hidden" id="isPicSet" name="isPicSet" value = "false"/>

<script>
    $(document).ready(function(){
                $("input#pic").change(function(){
                        if($.trim($(this).val()) != "" )
                        {
                            $("input#isPicSet").val("true");
                        }
                        else
                        {
                            $("input#isPicSet").val("false");
                        }
                    });
                
                $("label.checkfields").hide();
                
                 $("input#initial_stock").change(function(){
                        var value = $(this).val();
                        if ($.trim(value) == "" || !$.isNumeric(value)) {
                           
                            $(this).val(0);
                            
                        }
                    });
        });
</script>

</fieldset>




<fieldset title="Inventory" class="step" id="default-step-1">
<legend> </legend>


<div class="form-group">
    <label class="col-lg-2 control-label">Billing Forms<br/><a data-toggle="modal" helper="bill_helper" style="font:10px" class="btn btn-shadow btn-md btn-success" href="#select_bill_form"><i class="fa fa-plus"></i> Add Billing Form</a></label>
    <div class="col-lg-10">
          
        
         <div class="checkboxes">
        <?php foreach($drug_bill_forms as $form){ ?>
        
        
           
                <label class="label_check c_off checkfields" for="form_1" details="sub_<?php echo $form['drug_bill_package_id'];?>">
                     <input display="<?php echo ucfirst($form['name']);?>" class="bill_forms" sub="sub_<?php echo $form['drug_bill_package_id'];?>" name="drug_bill_form[]" id="form_<?php echo $form['drug_bill_package_id']; ?>" value="<?php echo $form['drug_bill_package_id'];?>" type="checkbox"/> <?php echo ucfirst($form['name']); ?>
                </label>
                
                <div class="form-group sub-forms" id="sub_<?php echo $form['drug_bill_package_id'];?>">
                    <label class="col-lg-2 control-label">Price</label>
                    <div class="col-lg-10">                
                        <label class="label_check c_off" for="form_1">
                       <input name="price_<?php echo $form['drug_bill_package_id'];?>" value="" id="price_<?php echo $form['drug_bill_package_id'];?>" type="number" class="form-control" placeholder="Price">
                      </label>
                   </div>
                                       
                </div>
         
         
          <div class="form-group sub-forms" id="sub_<?php echo $form['drug_bill_package_id'];?>_2">
                    <label class="col-lg-2 control-label">Default Store Package</label>
                    <div class="col-lg-10">                
                        <select checkId ="form_<?php echo $form['drug_bill_package_id']; ?>"  name="def_<?php echo $form['drug_bill_package_id'];?>" class="form-control default_indicator" >
                            <option value='no'>No</option>
                            <option value='yes'>Yes</option>
                        </select>
                   </div>
                                       
                </div>
    
      <div class="form-group sub-forms" id="sub_<?php echo $form['drug_bill_package_id'];?>_3">
                    <label class="col-lg-2 control-label">Measurement</label>
                    <div class="col-lg-10">                
                      
                       <input name="value_<?php echo $form['drug_bill_package_id'];?>" value="" id="value_<?php echo $form['drug_bill_package_id'];?>" type="number" class="form-control" placeholder="Value">
                       <select name="unit_<?php echo $form['drug_bill_package_id'];?>" class="form-control">
                            <?php foreach($units as $unit){ ?>
                                 <option value="<?php echo $unit['id']; ?>"><?php echo ucfirst($unit['unit_name']); ?></option>
                            <?php } ?>
                           
                       </select>
                   </div>
                                       
                </div>
    
        
        <?php }// print_r($drug_bill_forms);?>
      </div>
    </div>
</div>




<script>
    
    var noDefaultFormSelected = " <p style=\"padding:20px; margin-right:auto; margin-left:auto; position: relative; text-align: center;\">To Proceed, Select a Default Billing form in Inventory </p>";
  
    function showNoDefaultError() {
        
        $("div#stock_rules").html(noDefaultFormSelected);
    }
  
    function createStockRules(defaultForm) {
        
        console.log("creating stock rules");
        
        if (defaultForm != "")
        {
            console.log("default stock form found");
             var ruledivcreated = "";
                //create a relationship to each form that is checked in relation to the main form
                var count = 0;
                $(".bill_forms").each(function(){
                    
                    
                        if ($(this).is(":checked")) {
                            ruledivcreated += "<div class=\"form-group\">";
                             ruledivcreated += "<label class=\"col-lg-2 control-label\">1 "+$("input#"+defaultForm).attr("display")+" = </label>";
                            ruledivcreated += "<div class=\"col-lg-10\">";
                            if (defaultForm == $(this).attr("id"))
                            {                                
                                ruledivcreated += "<input name=\"default_rule\" disabled=\"disabled\" value=\"1\" type=\"text\" class=\"form-control\" >";
                                ruledivcreated += "<input name=\"rule_"+count+"\" value=\"1\" type=\"hidden\" class=\"form-control\" >";
                             }
                             else
                             {
                                ruledivcreated += "<input name=\"rule_"+count+"\" value=\"1\" type=\"number\" class=\"form-control\" >";
                             }
                            
                            ruledivcreated += $(this).attr("display") + "(s)</div>";
                            ruledivcreated += "</div>";
                            ruledivcreated += "<input name=\"rule_ref_"+count+"\" value=\""+$(this).val()+"\" type=\"hidden\" class=\"form-control\" >";
                            count++;
                        }
                    });
                
                ruledivcreated += "<input name=\"rule_count\" value=\""+count+"\" type=\"hidden\" class=\"form-control\" >";
                
                
                 $("div#stock_rules").html(ruledivcreated); 
        }
        
        else
        {
            console.log("no default stock will show default form error");         
             showNoDefaultError();
        }
       
 
    }
    
    function getDefaultStockFormId() {
         var defaultid = "";
         
                     var isDefaultSelected = false;
                     
         $(".default_indicator").each(function(){
                        
            if($(this).val() == 'yes'){
                defaultid = $(this).attr("checkId");
                isDefaultSelected = true;
                }                           
                                                           
                               
            });
                     
                     
        return defaultid;
    }
    
    
    $(document).ready(function(){
        
                showNoDefaultError();
                
                
                $("div.sub-forms").hide();
                
             
                $(".default_indicator").change(function(){
                        
                        var name = $(this).attr("name");
                       
                        //check if selected yes then turn all others to no
                    if($(this).val() == 'yes'){
                        
                        createStockRules($(this).attr("checkId"));
                        
                         $(".default_indicator").each(function(){
                              
                                if (name !=  $(this).attr("name")) {
                                         
                                          // alert($(this).attr("name"));                             
                                        $(this).val("no");
                                }   
                            });
                        
                    }
                   else{
                    
                        createStockRules(getDefaultStockFormId());
                    
                   
                     
                   }
                    
                    });
                
               $(".bill_forms").click(function(){
                    
                     $("div.sub-forms").hide();
                     
                    $(".bill_forms").each(function(){
                        
                            var selector = "div#" + $(this).attr("sub");
                             var selector2 = "div#" + $(this).attr("sub")+"_2";
                             var selector3 = "div#" + $(this).attr("sub")+"_3";
                            var def = "select[name=def_"+ $(this).val()+"]";
                            
                            if ($(this).is(":checked")) {
                                
                                $(selector).show();
                                $(selector2).show();
                                $(selector3).show();
                            }
                            else
                            {
                                $(def).val("no");
                                $("label[details="+$(this).attr("sub")+"]").hide();
                            }
                        });
                    
                    
                    createStockRules(getDefaultStockFormId());
                });        
            
        });
</script>

<div class="form-group">
    <label class="col-lg-2 control-label">Initial Stock</label>
    <div class="col-lg-10">
    <input name="initial_stock"  value="<?php  if(isset($initial_stock)){echo $initial_stock;}else{echo "0";} ?>" id="initial_stock" type="number" class="form-control" placeholder="Initial Stock">
    </div>
</div>

 <div class="form-group">
                    <label  class="col-lg-2 control-label" for="exampleInputEmail1">Batch Number </label>
                    <div class="col-lg-10">
                   
                    <input type="text" value="<?php  if(isset($batch_number))echo $batch_number; ?>"
                           class="form-control" name="batch_number" id="batch_number" placeholder="Batch Number">
           
                    </div>
                    </div>
   
            
            <div class="form-group">
            <label  class="col-lg-2 control-label" for="manufacture_date">Manufacture Date</label>
             
              <div class="col-lg-10">
             <input name="manufacture_date"
                    value="<?php  if(isset($manufacture_date))echo $manufacture_date; ?>"
                    id="manufacture_date" class="form-control form-control-inline input-medium default-date-picker" size="16" type="text"
             
                        />
             
              </div>
               
            </div>
            
            
            <div class="form-group">
            <label  class="col-lg-2 control-label" for="expiry_date">Expiry Date</label>
            
              <div class="col-lg-10">
             <input name="expiry_date" id="expiry_date"
                    value="<?php  if(isset($expiry_date))echo $expiry_date; ?>"
                    class="form-control form-control-inline input-medium default-date-picker" size="16" type="text"
                        />
              </div>
            </div>
            
            <div class="form-group">
            <label  class="col-lg-2 control-label" for="supplier">Supplier</label>
            
              <div class="col-lg-10">
             <input name="supplier" id="supplier"
                    value="<?php  if(isset($supplier))echo $supplier; ?>"
                    class="form-control size="16" type="text"
                    placeholder="Supplier"
                        />
              </div>
            </div>


<div class="form-group">
    <label class="col-lg-2 control-label">Currency</label>
    <div class="col-lg-10">
    <select name="currency_code" id="currency_code" class="form-control" >
        <?php foreach($currencies as $currency){?>
        
            <option value = "<?php echo $currency['currency_code'];?>"><?php echo ucfirst($currency['description']);?></option>
        <?php } ?>
    </select>
    
    </div>
</div>


</fieldset>



<fieldset title="Stock Rules" class="step" id="default-step-2">
<legend> </legend>

<div id="stock_rules">
    
    <p style="padding:20px; margin-right:auto; margin-left:auto; position: relative; text-align: center;">Please Select a Default Billing form in Inventory ,to proceed </p>
       
        <!--div class="form-group">
            <label class="col-lg-2 control-label">1 Bottle = </label>
            <div class="col-lg-10">
            <input name="initial_stock" value="<?php  if(isset($initial_stock)){echo $initial_stock;}else{echo "0";} ?>" id="initial_stock" type="text" class="form-control" placeholder="Initial Stock">
            Bags</div>
        </div-->
    
</div>


</fieldset>


<input type="button" class="finish btn btn-success"  value="Create"/>


</form>
</div>
</section>
 <!-- end of form section-->
</div>
</section>
</div>




</div>



 
</section>
</section>



<!------------------------------------------------ bill form selection ------------------------------------------------------->

<form>

<a id="viewday" href="#user_appointment" data-toggle="modal"></a>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="select_bill_form" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Choose a Bill Form</h4>
</div>


<div class="modal-body">
  
            <div class="form-group">
                    <label for="exampleInputEmail1">Bill Forms</label>
                    <select class="form-control" name="Sbill_form" id="Sbill_form" placeholder="Bill Form">
                        
                        
                      <?php foreach($drug_bill_forms as $form){ ?>
                            <option value="sub_<?php echo $form['drug_bill_package_id'];?>"> <?php echo ucfirst($form['name']); ?> </option>
                     <?php } ?>
                    </select>
          </div>
            
            
     <button type="button" id="add_form" class="btn btn-default" onclick="javascript:addBillForm();">Add</button>


<script>
  
  function addBillForm()
  {
    var val  = $("select#Sbill_form").val();
   
    $("label[details="+val+"]").show();
    
     $("input[sub="+val+"]").prop("checked", true);
    
    $("div#"+val).show();
    $("div#"+val+"_2").show();
     $("div#"+val+"_3").show();
    
    $("button.close").click();
    
     createStockRules(getDefaultStockFormId());
  }
    
</script>
</div>



</div>
</div>
</div>
</form>

<script src="<?= base_url() ?>assets/js/jquery.stepy.js"></script>



<script>

    //step wizard

    $(function() {
        $('#default').stepy({
            backLabel: 'Previous',
            block: true,
            nextLabel: 'Next',
            titleClick: true,
            titleTarget: '.stepy-tab'
        });
    });
</script>