<section id="main-content">
<section class="wrapper">
 
<div class="row">

<section class="panel" >
<div class="panel-body" style="height:470px;">
<div id="calendar" class="has-toolbar" ></div>
</div>
</section>
</div>
<form name="addToShift" action="<?=base_url() ?>index.php/dailyroaster/addToRoaster" method="post">
    
    <input type="hidden" name="shift_id" id="add_shift_id" value=""/>
    <input type="hidden" name="add_date" id="add_date" value=""/>
</form>

<form method="post" name="remFrmShift" id="remFrmShift" action="<?=base_url() ?>index.php/dailyroaster/removeFromRoaster">

<a id="viewday" href="#viewdaySchedule" data-toggle="modal"></a>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="second_option" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title"><span id="doc-title"></span></h4>
</div>
<div class="modal-body">
<input type="hidden" name="roaster_id" id="roaster_id"/>

<div class="form-group">
</div>

<button type="button" id="find_patient" class="btn btn-default" onclick="javascript:remFromShift();">Remove From Shift</button>

  
<script>
    
    function remFromShift() {
        
        var retval =  confirm("Are You Sure you want to remove staff roaster");
                   if (retval) {
                    //code
                    
                      $("form#remFrmShift").submit();
                   }
       
       
    }
    
</script>
</div>
</div>
</div>
</div>
</form>







<form id="view-group" method="post" action="<?=base_url() ?>index.php/patient/number">

<a id="viewday" href="#viewdaySchedule" data-toggle="modal"></a>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="viewdaySchedule" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Roaster for (<span id="roasterDate"></span>)</h4>
</div>
<div class="modal-body">


<?php
    foreach($shifts as $shift)
    {
    ?>
        <div class="form-group">
        
<label for="exampleInputEmail1"><?php echo ucfirst($shift['shift_name'])." (".substr($shift['shift_start_time'],0,5)." - ".substr($shift['shift_end_time'],0,5).")";?></label>

                <table class="display table table-bordered table-striped" id="<?php echo ($shift['shift_id']);?>">
                <thead>
                    
                    
                <tr>
                <th>Name</th>
                <th>Department</th>
                
                </tr>
                </thead>
                <tbody class='roaster_body' id="<?php echo ($shift['shift_id']);?>_body">
                    
                </tbody>
                
                </table>
                <?php if($can_edit){ ?>
                <button type="button" shift_id="<?php echo ($shift['shift_id'])?>" id="add_mem_to_shift" class="btn btn-default" >Add Staff To Shift</button>
                <?php }?>
        </div>
    
  <?php      
    }
?>



  
<script>
    
    $(document).ready(function(){
        
       
          
        
        <?php if($this->session->userdata('notice')){ $notice = $this->session->userdata('notice');  $this->session->unset_userdata('notice');?>
            alert("<?php echo($notice)?>");
        <?php } ?>
        $("button#add_mem_to_shift").click(function(){
            addToShift($(this).attr("shift_id"));
           
            });
        });
    function addToShift(shift_id) {
        
    $("input#add_shift_id").val(shift_id);
     $("form[name=addToShift]").submit();
       
    }
    
</script>


</div>
</div>
</div>
</div>
</form>
 
 
 
 


</section>
</section>

<form name="dayJsonRoaster" id="dayJsonRoaster" method="post" action="">
    <input type="hidden" value="" name="day" id="day"/>
</form>

<a href="#second_option" id="other_option" data-toggle="modal"></a>

<script>
    
    $(document).ready(function(){
        
         $("a.staff_in_roaster").click(function(){
            alert($(this).attr("staff"));
            
            });
        });
    
    function getDepartmentName(dept) {
        //code
        var index;
        var result = "Department";
        var ids = [<?php $counter = 0;  foreach($departments as $dept){ if($counter > 0){echo ',';} echo '"'.$dept['dept_id'].'"';$counter++;}?>];
        
        var names = [<?php $counter = 0;  foreach($departments as $dept){ if($counter > 0){echo ',';} echo '"'.$dept['name'].'"';$counter++;}?>];
        
        for (var i =0;i<ids.length;i++) {
            if (ids[i] == dept) {
                //code
                result = names[i];
                break;
            }
                        
        }
        
        return result;
    }
    
    function showOption(id,name) {
        //code
        $("span#doc-title").html(name);
        $("input#roaster_id").val(id);
        $("button.close").click();
        $("a#other_option").click();
    }
     function getDayRoaster() {
        
        
        var url = "<?= base_url() ?>"+"index.php/dailyroaster/getRoasterByDayJson";
        
        $("tbody.roaster_body").html("");
        
        $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#dayJsonRoaster').serialize(),
		success: function(json){						
		try{
			var obj = jQuery.parseJSON(json);
			//alert( obj['STATUS']);
                         
            
                var arrayLength = obj.length;
                for (var i = 0; i < arrayLength; i++) {
                   // var newoption = "<option  style='text-transform: capitalize' value='"+obj[i]['religion_id']+"'>"+obj[i]['religion_name']+"</option>";
                    
                    //    $('#religion_id').append(newoption).val(obj[i]['religion_id']);
                 
                var middle = obj[i]['middle_name'];
                if (middle == null) {
                    middle = "";
                }
                
                var first = obj[i]['first_name'];
                if (first == null) {
                    first = "";
                }
                
                 var last = obj[i]['last_name'];
                if (last == null) {
                    last = "";
                }
                  var name = first + " " +middle+ " "+last;
                  var dept = getDepartmentName(obj[i]['dept_id']);
                 
                  
                  var selector = "tbody#"+obj[i]['shift_id']+"_body";
                  $(selector).append("<tr><td ><a onclick='javascript:showOption("+'"'+obj[i]['id']+'","'+name+'"'+")' href='#' class='staff_in_roaster' staff='"+obj[i]['staff_no']+"'>"+name+"</a></td><td>"+dept+"</td></tr>");
               
               
               
               
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



