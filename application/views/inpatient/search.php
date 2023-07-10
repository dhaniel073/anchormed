
<section id="container" class="">

<section id="main-content">
<section class="wrapper site-min-height">
 
<div class="row">
<div class="col-lg-12">
<section class="panel">
<header class="panel-heading">
In Patients
</header>
<div class="panel-body">
<div class="adv-table">
    
<table class="display table table-bordered table-striped" id="patients">
<thead>
    
    
<tr>
<th>File Number</th>
<th>Name</th>
<th>Admitted By</th>
<th>Ward</th>
<th>Bed</th>
<th style="width:10%; text-align: center;">Pending Task</th>
<th style="width:10%; text-align: center;">New Task</th>
</tr>
</thead>
<tbody>
<?php foreach($patients as $patient){ ?>
<tr class="gradeX">
  <?php if(isset($return_base)  && $return_base != "")
  { ?>
  
  <td><a href="<?php echo $return_base;?>/<?php echo $patient['patient_number']; ?>"><?php echo $patient['patient_number']; ?></a></td>
  <?php
    }else {
        ?>  
<td><a href="#"><?php echo $patient['patient_number']; ?></a></td>
<?php }?>
<td><?php echo ucfirst($patient['first_name'])." ".ucfirst($patient['middle_name'])." ".ucfirst($patient['last_name']); ?></td>
<td><?php echo ucfirst($patient['d_first_name'])." ".ucfirst($patient['d_middle_name'])." ".ucfirst($patient['d_last_name']); ?></td>
<td><?php echo $patient['ward_name']; ?></td>
<td><?php echo $patient['bed_name']; ?></td>
<td style="text-align: center;"><a href="#" patient_number="<?php echo $patient['patient_number']; ?>" class="view-tasks"><i class="fa fa-bell text-danger"> <span class="badge bg-warning"><?php echo $patient["task_count"];?></span></i></a></td>
<td style="text-align: center;"><a id="<?php echo $patient['patient_number']; ?>" class="new-task-link" href="#taskMenu" data-toggle="modal"><i class="fa fa-edit text-primary"></i></a></td>
</tr>

<?php }?>
</tbody>

</table>
</div>
</div>
</section>
</div>
</div>




<form name="getPatientTasksForm" id="getPatientTasksForm">
  <input type="hidden" name="patient_number" id="t_patient_number"/>  
</form>

<form name="getPatientTaskListForm" id="getPatientTaskListForm">
  <input type="hidden" name="task_reference" id="g_task_reference"/>  
</form>

<form name="skipTaskForm" id="skipTaskForm" method="post">
  <input type="hidden" name="task_id" id="s_task_id"/>  
</form>

<!------------------------------------------------ Task menu ---------------------------------------------------------->



<form name="task_perform_form" method="post" action="<?=base_url() ?>index.php/workbench/getOrdersJson">
<a id="task_menu_link" data-toggle="modal" href="#task_menu"></a>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="task_menu" class="modal fade">
<div class="modal-dialog">
<div class="modal-content" style="min-width:950px">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Task Reference : <span id="task_ref_span"></span> </h4>
</div>
<div class="modal-body">

<div class="form-group">
        
<label for="exampleInputEmail1"></label>

                <table class="display table table-bordered table-striped" id="">
                <thead>
                    
                    
                <tr>
                <th>Task</th>
                <th>Scheduled By</th>
                <th>Time Due</th>
                <th>Status</th>
                <th>Carried Out By</th>
                <th>Carried Out On</th>
                <th>Action</th>
                </tr>
                </thead>
                <tbody id='task_list_body'>
                   
                </tbody>
                
                </table>
                
              
        </div>
    


</div>
</div>
</div>
</div>
</form>




<!------------------------------------------------ Patient Pending Tasks---------------------------------------------------------->



<form name="get_orders" method="post" action="<?=base_url() ?>index.php/workbench/getOrdersJson">
<a id="showTaskModal" href="#current_tasks" data-toggle="modal"></a>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="current_tasks" class="modal fade">
<div class="modal-dialog">
<div class="modal-content" style="min-width:900px">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Ongoing Tasks</h4>
</div>
<div class="modal-body">


        <div class="form-group">
        
<label for="exampleInputEmail1"></label>

                <table class="display table table-bordered table-striped" id="">
                <thead>
                    
                    
                <tr>
                <th>Task Reference</th>
                <th>Task</th>
                <th>Scheduled By</th>
                <th>Status</th>
                <th>Completed</th>
                <th>Total Scheduled</th>
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



<form id="createTaskForm" name="createTaskForm" method="post" action="<?=base_url() ?>index.php/inpatient/createPatientRecurringTask">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="taskMenu" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Create InPatient Task</h4>
</div>
<div class="modal-body">
<form role="form" id="add-new-occupation"  name="add-new-occupation" method="post" action="text.php">
  
  
<div class="form-group">
<label for="exampleInputEmail1">Select Task</label>
 <select name="task_id" id="task_id" class="form-control m-bot15">
        <option></option>
        <?php
        foreach($tasks as $task)
        {
            echo "<option value='".$task['task_id']."'>".ucfirst($task['name'])."</option>";
        }
        ?>
  </select>
</div>

<input type="hidden" name="patient_number" id="patient_number" />


<div class="form-group">
  <label for="exampleInputEmail1">Task Start Date</label>
  <input name="date" id="date" class="form-control form-control-inline input-medium default-date-picker" size="16" type="text"
            value="" />
   
</div>



<div class="form-group">
  <label for="exampleInputEmail1">Start time</label>
    <div class="input-group bootstrap-timepicker">
    <input type="text" class="form-control timepicker-24" name="time" >
    <span class="input-group-btn">
    <button class="btn btn-default" type="button"><i class="fa fa-clock-o"></i></button>
    </span>
    </div>
</div>


  
<div class="form-group">
<label for="exampleInputEmail1">Frequency</label>
 <select name="frequency" id="frequency" class="form-control m-bot15">
     <option value="h">Hourly</option>
     <option value="d">Daily</option>
     <option value="m">Monthly</option>
     <option value="y">Yearly</option>
  </select>
</div>



<div class="form-group">
<label for="exampleInputEmail1">Number of Times (<span id="times_holder">Hourly</span>)</label>
 <input class="form-control" name="times" type="number" id="times"/>
</div>


<div class="form-group">
<label for="exampleInputEmail1">Number of Rounds</label>
 <input class="form-control" name="rounds" type="number" id="rounds"/>
</div>

   
<script type="text/javascript">
  
  function createTask() {
    
    var time = $.trim($("input[name=time]").val());
    var date = $.trim($("#date").val());    
    var task_id = $.trim($("#task_id").val());
    var times = $.trim($("#times").val());
    var rounds = $.trim($("#rounds").val());
    
    
    var error = false;
     if (date == "") {
       alert("Select Task Start Date");
       error = true;
    }
    
    
    if (time == "") {
       alert("Select Task Start time");
        error = true;
    }
    
    if (task_id == "") {
      alert("Choose a task");
        error = true;
    }
    
    
    if (times == "") {
        alert("Specify number of times within the frequency");
        error = true;
    }
    else if (!$.isNumeric(times)) {
       alert("Invalid number of times ");
        error = true;
     
    }
    
        if (rounds == "") {
        alert("Specify number of rounds to perform task");
        error = true;
    }
    else if (!$.isNumeric(rounds)) {
       alert("Invalid number of rounds to perform task");
        error = true;
     
    }
    
    if (!error) {
     console.log("about creating task");
     $("form[name=createTaskForm]").submit();
    }
  }
</script>


<script>
  
  function transferTask(task_id) {
    
    $("input#s_task_id").val(task_id);
  
    if (confirm("Do you want to perform task ?")) {
      
      
      var url = "<?= base_url() ?>"+"index.php/inpatient/performTask";
      $('form[name=skipTaskForm]').attr("action", url).submit();    
    }
    
    
  }
  
  function skipTask(task_id) {
    //skipTaskJson
    //skipTaskForm
    //s_task_id
    if (confirm("Do you want to skip this task ?")) {
      
      $("input#s_task_id").val(task_id);
      
      var url = "<?= base_url() ?>"+"index.php/inpatient/skipTaskJson";
      
       $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form[name=skipTaskForm]').serialize(),
		success: function(json){
		try{
                  
                  var obj = jQuery.parseJSON(json);
                  if (obj["status"] == "success") {
                    alert("Task Skipped");
                    $("button.close").click();
                  }
                  else
                  {
                    alert(obj["status"]);
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
  }
  
  
     function performTask(task_reference) {
      //get task lists from server
       $("input#g_task_reference").val(task_reference);
       var url = "<?= base_url() ?>"+"index.php/inpatient/getTaskIndividualItemsJson";
      
      $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form[name=getPatientTaskListForm]').serialize(),
		success: function(json){
		try{
                  
			var obj = jQuery.parseJSON(json);
                        
                        
                         $("tbody#task_list_body").html("");
                         
                        for (var i =0; i < obj.length; i++) {
                            //code
                            $("span#task_ref_span").html(obj[i]['task_reference']);
                            var performed_by = "N/A";
                            var carried_out_on = "N/A";
                            
                            
                            var action = "performed";
                            
                            
                            if (obj[i]['status'] == "Attention Required" || obj[i]['status'] == "Due") {
                               
                               action = "<a onclick=\"javascript:skipTask('"+obj[i]['id']+"');\" class=\"btn btn-xs btn-danger\" href='#'>skip</a>&nbsp;|&nbsp;<a onclick=\"javascript:transferTask('"+obj[i]['id']+"');\" class=\"btn btn-xs btn-success\" href='#'>perform</a>";
                            }
                            else if (obj[i]['status'] == "Upcoming")
                            {
                               action = "perform";
                            }
                            else if (obj[i]['status'] == "Skipped") {
                              action = "skipped";
                            }
                            
                            if (obj[i]['performed_by'] != undefined && obj[i]['performed_by']['first_name'] != undefined) {
                              performed_by = obj[i]['performed_by']['first_name']+" "+obj[i]['performed_by']['middle_name']+" "+obj[i]['performed_by']['last_name'];
                            }
                            
                            if (obj[i]["carried_out_on"] != undefined) {
                              carried_out_on = obj[i]["carried_out_on"];
                            }
                            
                            var newrow = "<tr><td>"+obj[i]['task_data']['name']+"</td><td>"+obj[i]['staff_data']['first_name']+" "+obj[i]['staff_data']['middle_name']+" "+obj[i]['staff_data']['last_name']+"</td><td>"+obj[i]['due_time']+"</td><td>"+obj[i]['status']+"</td><td>"+performed_by+"</td><td>"+carried_out_on+"</td><td>"+action+"</td></tr>";
                            //console.log(newrow);
                            $("tbody#task_list_body").append(newrow);
                            
                            //alert(task_reference);
                          
                        }
                        		
			
		}catch(e) {		
			console.log('Exception while request..'+e);
                        
		}		
		},
		error: function(){						
			console.log('Error while request..');
		}
                
                 });
      
       
        $("button.close").click();
        $("a#task_menu_link").click();
                           
                           
     }
     
     
     
    function getPatientTasks(patient_number) {
        
        $("input#t_patient_number").val(patient_number);
                
        var url = "<?= base_url() ?>"+"index.php/inpatient/getInpatientPendingTaskJson";
     
        
        $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form[name=getPatientTasksForm]').serialize(),
		success: function(json){
		try{
			var obj = jQuery.parseJSON(json);
                        
                         $("tbody#order_body").html("");
                         
                        for (var i =0; i < obj.length; i++) {
                            //code
            
            $("tbody#order_body").append("<tr><td><a href='#' onclick='javascript:performTask(\""+obj[i]['task_reference']+"\");'>"+obj[i]['task_reference']+"</a></td><td>"+obj[i]['task_data']['name']+"</td><td>"+obj[i]['staff_data']['first_name']+" "+obj[i]['staff_data']['middle_name']+" "+obj[i]['staff_data']['last_name']+"</td><td>"+obj[i]['status']+"</td><td>"+obj[i]['summary']['number_done']+"</td><td>"+obj[i]['summary']['number_of_tasks']+"</td></tr>");
                            
                            $("a#showTaskModal").click();
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
    
    
  $(document).ready(function(){
    
        $("a.view-tasks").click(function(){
              getPatientTasks( $(this).attr("patient_number"));
            });
            
            
        $("a.new-task-link").click(function(){
            
              $("input#patient_number").val($(this).attr("id"));
            });
    
        $("select#frequency").change(function(){
            
            var val = $(this).val();
            
            if (val == "h")
            {
              $("span#times_holder").html("Hourly");
            }
            else if (val == "d")
            {
              $("span#times_holder").html("Daily");
            }
            else if (val == "m")
            {
              $("span#times_holder").html("Monthly");
            }
            else if (val == "y")
            {
              $("span#times_holder").html("Yearly");
            }
            
          });
    
    });
</script>


<br/>


  <div class="form-group">
    <label for="exampleInputEmail1">Task Specific Instructions</label>
    <div class="col-md-12">
    <textarea name="notes" id="notes" class="wysihtml5 form-control" rows="10"></textarea>
    </div>
</div>
    
    
    
    

<button type="button" id="create_task" class="btn btn-default" onclick="javascript:createTask();">Create Task</button>
</form>
</div>
</div>
</div>
</div>
</form>



 
</section>
</section>
 
 