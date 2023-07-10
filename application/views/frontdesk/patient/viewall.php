
<section id="container" class="">

<section id="main-content">
<section class="wrapper site-min-height">
 
<div class="row">
<div class="col-lg-12">
<section class="panel">
<header class="panel-heading">
View All Previous Visit
</header>
<div class="panel-body">
<div class="adv-table">
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

</div>
</div>
</section>
</div>
</div>
 
</section>
</section>

<form method="post" action="<?=base_url() ?>index.php/patient/viewall">

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




 
 