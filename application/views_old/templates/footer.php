
<!------------------------------------------------ view message dialogue ---------------------------------------------------------->

<form name="getMessageDetailForm" id="getMessageDetailForm" method="post" action="<?=base_url() ?>index.php/workbench/getMessageByIdJson">
    <input name="message_id" id="det_message_id" type="hidden"/>
</form>


<form method="post" id="reply_message" action="<?=base_url() ?>index.php/workbench/ReplyMessage">


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="viewmessage" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&#10006;</button>
<h4 class="modal-title">Subject : <span id="preview_message_title">Message</span></h4>
</div>
<div class="modal-body">

<input type="hidden" name="message_id" id="reply_message_id"/>
<!--div class="form-group"-->
    
    
    <div class="col-lg-12">
        <section class="panel">
        <header class="panel-heading">
         Message Preview
       
        </header>
        <div class="panel-body">
        <div class="timeline-messages">
         
       
                   
         
        <div class="msg-time-chat">
            <a href="#" class="message-img"><img id="message_image_preview" class="avatar" src="img/chat-avatar.jpg" alt=""></a>
            <div class="message-body msg-in">
                <span class="arrow"></span>
                <div class="text">
                    <p class="attribution"><a href="#"><span id="preview_sender"></span></a> at <span id="preview_sender_date"></span></p>
                    <p id="message_content"> .. </p> 
                </div>
            </div>
        </div>
        
        
        
         
        </div>
        <div class="chat-form">
        <div class="input-cont ">
        <input type="text" name="reply" id="reply_notes" class="form-control col-lg-12" placeholder="Type a message here...">
        </div>
        <div class="form-group">
        <div class="pull-right chat-features">
        <a href="javascript:;">
        <i class="fa fa-camera"></i>
        </a>
        <a href="javascript:;">
        <i class="fa fa-link"></i>
        </a>
        <a class="btn btn-danger" onclick="javascript:reply_message()">Send</a>
        </div>
        </div>
        </div>
        </div>
        </section>
</div>
<!--/div-->


<!--div class="form-group">
  
    <div class="alert alert-success alert-block fade in" style="padding:40px;">
        
        <p id="message_content"> .. </p> 
        
        
    </div>
</div-->
    
<!--div class="form-group">
    <label class="label_check" for="checkbox-01">Quick Reply</label>
    
    <div id="reply_body" >
        <textarea  name="reply" id="reply_notes" class="wysihtml5 form-control" rows="5"></textarea>
    </div>
</div-->
    
    



 </div>
    
  
 <!--button type="button" id="view_message_btn" class="btn btn-default" onclick="javascript:reply_message()">Quick Reply</button-->
 
 <script>
    
    function reply_message()
    {
        var message_body = $("#reply_notes").val();
        var error = false;
        if ($.trim(message_body) == "")
        {
           error = true;
           alert("Message is empty");
        }
        
        if (!error)
        {
           $("form#reply_message").submit();
        }
    }
 </script>

</div>
</div>
</div>
</div>
</form>

<script>
       
</script>



<footer class="site-footer">
<div class="text-center">
2016 &copy; MEDIPHIX Powered By Phixotech
<a href="#" class="go-top">
<i class="fa fa-angle-up"></i>
</a>
</div>
</footer>
 
</section>
 
 <?php
 if(isset($roaster) && $roaster == true)
 {
    
?>
<script type="text/javascript" src="<?= base_url() ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>

<script src="<?= base_url() ?>assets/assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>

<?php } ?>

<script class="include" type="text/javascript" src="<?= base_url() ?>assets/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.scrollTo.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.nicescroll.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="<?=base_url() ?>assets/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?=base_url() ?>assets/assets/data-tables/DT_bootstrap.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.sparkline.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
<script src="<?= base_url() ?>assets/js/owl.carousel.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.customSelect.min.js"></script>
<script src="<?= base_url() ?>assets/js/respond.min.js"></script>
 
<script src="<?= base_url() ?>assets/js/common-scripts.js"></script>
 <?php
 if(isset($roaster) && $roaster == true)
 {
    
?>

<script>
    
    
    var Script=function(){
	$('#external-events div.external-event').each(function(){
		var eventObject={title:$.trim($(this).text())};
		$(this).data('eventObject',eventObject);
		$(this).draggable({zIndex:999,revert:true,revertDuration:0});
	});

	var date=new Date();var d=date.getDate();
	var m=date.getMonth();var y=date.getFullYear();

	$('#calendar').fullCalendar({header:{left:'prev,next today',center:'title',right:'basicWeek'},editable:true,droppable:true,drop:function(date,allDay){var originalEventObject=$(this).data('eventObject');var copiedEventObject=$.extend({},originalEventObject);copiedEventObject.start=date;copiedEventObject.allDay=allDay;

$('#calendar').fullCalendar('renderEvent',copiedEventObject,true);

if($('#drop-remove').is(':checked')){$(this).remove();}},events:[]});}();
    
    
    
      
    $(document).ready(function(){
        
        //     $("di").css("height","100px");
            $("span.fc-button-basicWeek").click();
          
         
        
            $("div.fc-content div:nth-child(2) table tbody tr td:nth-child(1) div").css("min-height","100px");
            
            $("span.fc-button-content").click(function(){
                   
                   
                    //alert($("div.fc-content div:nth-child(2) table tbody tr td:nth-child(1) div").delay(1000).attr("style"));
                    $("div.fc-content div:nth-child(2) table tbody tr td:nth-child(1) div").delay(1000).css("min-height","100px");
                
                });
            
            
           // $("tr.fc-first").css({"height" : "100px !important"})
            $("td.fc-widget-content").css({"cursor" : "pointer"}).click(function(){
                
                //get the current year
                
               var yearstr =  $("span.fc-header-title h2").text();
               var year = yearstr.substring(yearstr.length - 4, yearstr.length);
               var str = $(this).attr("class");
               var headerClass = "th."+str.substring(0,7);
               var date =  year + "/" +($(headerClass).text()).substring(7,$(headerClass).text().length);
               $("input#add_date").val(date);
              // alert(date);
               $("span#roasterDate").html(date);
               $("input#day").val(date);
               
               getDayRoaster();
               
               $("a#viewday").click();
               
                
                });
            
            
        
        });
</script>
<?php } ?>
<script src="<?= base_url() ?>assets/js/sparkline-chart.js"></script>
<script src="<?= base_url() ?>assets/js/easy-pie-chart.js"></script>
<script src="<?= base_url() ?>assets/js/count.js"></script> 
<script src="<?= base_url() ?>assets/avgrund/jquery.avgrund.js"></script>

<script type="text/javascript" src="<?= base_url() ?>assets/assets/fuelux/js/spinner.min.js"></script>

<script type="text/javascript" src="<?= base_url() ?>assets/assets/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/assets/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/assets/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/assets/jquery-multi-select/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/assets/jquery-multi-select/js/jquery.quicksearch.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/typeahead.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>

<script src="<?= base_url() ?>assets/js/advanced-form-components.js"></script>

<script type="text/javascript" charset="utf-8">
          $(document).ready(function() {
              $('#patients').dataTable( {
                  "aaSorting": [[ 4, "desc" ]]
              } );
              
              <?php if(isset($shifts)){ foreach($shifts as $shift){?>
              
                 $('#<?php echo $shift['shift_id']?>i').dataTable( {
                  "aaSorting": [[ 4, "desc" ]]
              } );
              
             
               $("div#<?php echo $shift['shift_id']?>_filter").hide();
               $("div#<?php echo $shift['shift_id']?>_length").hide();
               <?php }}?>
              
              
              $("div#patients_filter").hide();
          } );
      </script>
<form id="dummy"></form>
<script type="text/javascript" charset="utf-8">
    
       //timer events counter updates
    window.setInterval(function(){
        
        getUserNotificationCount();
        getUserUnReadMessagesCount();
        
        
        }, 10000);
    
    
    function getUserUnReadMessages()
    {
        var url = "<?= base_url() ?>"+"index.php/workbench/getUnreadMessagesPrevJson";
        
        //remove all the existing messages
        
        $("li.message_preview").remove();
        
        $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#dummy').serialize(),
		success: function(json){
		try{
			var obj = jQuery.parseJSON(json);
                        var profile_img_src_base = "<?= base_url() ?>assets/img/profiles/";
                        
			 for (var i =0; i < obj.length; i++)
                         {
                            var message_li = "<li class=\"message_preview\"> ";
                            message_li = message_li + "<a data-toggle=\"modal\" onclick=\"javascript:getMessageDets('"+obj[i]['message_id']+"')\" message_id=\""+obj[i]['message_id']+" \"class=\"message_link\" href=\"#viewmessage\">";
                            message_li = message_li + "<span class=\"photo\"><img alt=\"avatar\" src=\""+profile_img_src_base+obj[i]['picture']+"\"></span>";
                            message_li = message_li + "<span class=\"subject\">";
                            message_li = message_li + "<span class=\"from\">"+obj[i]['from_first_name']+" "+obj[i]['from_last_name']+"</span>";
                            message_li = message_li + " <span style=\"margin-top:36px;\" class=\"time\">"+obj[i]['date_sent']+"</span>";
                            message_li = message_li + "</span>";
                            message_li = message_li + "<span class=\"message\">";
                            message_li = message_li + obj[i]['title'];
                            message_li = message_li + "</span>";
                            message_li = message_li + " </a>";
                            message_li = message_li + " </li>";
                            
                            $(message_li).insertAfter("li#message_preview_header");                
    
   
                         }
            						
                //$("span[message_counter=1]").html(obj["total"]);
                        		
			
		}catch(e) {		
			console.log('Exception while request..:'+e);
                        
		}		
		},
		error: function(){						
			console.log('Error while request..');
		}
                
                 });
    }
 
        function getUserUnReadMessagesCount()
        {
            var url = "<?= base_url() ?>"+"index.php/workbench/getUnreadMessagesCountJson";
        
        //$("tbody.roaster_body").html("");
        
        $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#dummy').serialize(),
		success: function(json){
		try{
			var obj = jQuery.parseJSON(json);
			//alert( obj['STATUS']);
                         
            						
                $("span[message_counter=1]").html(obj["total"]);
                        		
			
		}catch(e) {		
			console.log('Exception while request..:'+e);
                        
		}		
		},
		error: function(){						
			console.log('Error while request..');
		}
                
                 });
        }
        function getUserNotificationCount() {
        
        
        var url = "<?= base_url() ?>"+"index.php/workbench/getNotificationCountJson";
        
        //$("tbody.roaster_body").html("");
        
        $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#dummy').serialize(),
		success: function(json){
		try{
			var obj = jQuery.parseJSON(json);
			//alert( obj['STATUS']);
                         
            						
                $("span#notif_main").html(obj["total"]);
                        		
			
		}catch(e) {		
			console.log('Exception while request..:'+e);
                        
		}		
		},
		error: function(){						
			console.log('Error while request..');
		}
                
                 });
    }
    
    var retval = "start";
    var ref_message_id = "";
    
    
    function getPrevMessageDets(message_id)
    {
         $("input#det_message_id").val(message_id);
         var url = "<?= base_url() ?>"+"index.php/workbench/getMessageByIdJson";
        
         
         $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#getMessageDetailForm').serialize(),
		success: function(json){
		try{
			var obj = jQuery.parseJSON(json);
			var profile_img_src_base = "<?= base_url() ?>assets/img/profiles/";
                       
                   //new message
                   
                   var prev_mail_trail  = " <div class=\"msg-time-chat\">";
                   prev_mail_trail = prev_mail_trail + "<a href=\"#\" class=\"message-img\"><img class=\"avatar\" src=\""+profile_img_src_base+obj['picture']+"\" alt=\"\"></a>";
                   prev_mail_trail = prev_mail_trail + "<div class=\"message-body msg-in\">";
                   prev_mail_trail = prev_mail_trail + "<span class=\"arrow\"></span>";
                   prev_mail_trail = prev_mail_trail + "<div class=\"text\">";
                   prev_mail_trail = prev_mail_trail + "<p class=\"attribution\"><a href=\"#\">"+obj['from_first_name']+ " " + obj['from_last_name']+" </a> at "+obj['date_sent']+" </p>";
                   prev_mail_trail = prev_mail_trail + "<p id=\"message_content\"> "+obj['message']+" </p>";
                   prev_mail_trail = prev_mail_trail + "</div>";
                   prev_mail_trail = prev_mail_trail + "</div>";
                   prev_mail_trail = prev_mail_trail + "</div>";
                   
                   
                   $("div.timeline-messages").prepend(prev_mail_trail);
                  
                                
                    if (obj['reference_id'] != null)
                    {                                             
                        ref_message_id =  obj['reference_id'];
                        console.log("new reference id : " + ref_message_id);                        
                        getPrevMessageDets(ref_message_id);
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
    
    function getMessageDets(message_id)
    {
        
        $("input#det_message_id").val(message_id);
        
         var url = "<?= base_url() ?>"+"index.php/workbench/getMessageByIdJson";
         
          $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#getMessageDetailForm').serialize(),
		success: function(json){
		try{
			var obj = jQuery.parseJSON(json);
			var profile_img_src_base = "<?= base_url() ?>assets/img/profiles/";
                        //console.log(json);
                   //set message title
                   $("span#preview_message_title").html(obj['title']);
                   $("span#preview_sender").html(obj['from_first_name']+ " " + obj['from_last_name']);
                   
                    $("span#preview_sender_date").html(obj['date_sent']);
                    
                    $("p#message_content").html(obj['message']);
                    $("img#message_image_preview").attr("src",profile_img_src_base+obj['picture']);
                    $("input#reply_message_id").val(obj['message_id']);
                    
                                
                    if (obj['reference_id'] != null)
                    {
                        retval = "start";
                        console.log("start the loop since there is a mail trail");
                        ref_message_id = obj['reference_id'];
                    
                    
                     
                         getPrevMessageDets(ref_message_id);
                         
                         
                        
                        
                       
                        
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
    //get all the unread notifications
    function getUserUnreadNotifications() {
        
        
        var url = "<?= base_url() ?>"+"index.php/workbench/getNotificationCountJson";
        
        //$("tbody.roaster_body").html("");
        
        $.ajax({
		type: "post",
		url: url,
		cache: false,				
		data: $('form#dummy').serialize(),
		success: function(json){
		try{
			var obj = jQuery.parseJSON(json);
			//alert( obj['STATUS']);
                         
            						
                $("span.nofication_count").html(obj["total"]);
                        		
			
		}catch(e) {		
			console.log('Exception while request..'+e);
                        
		}		
		},
		error: function(){						
			console.log('Error while request..');
		}
                
                 });
    }
    
    
          $(document).ready(function() {
            
            //initalise the notification count
             getUserNotificationCount();
              getUserUnReadMessagesCount();
              
              
             
              //populate message preview box when clicked
              $("li#header_inbox_bar").click(function(){
                
                    getUserUnReadMessages();
                });
             
             //pupulate notification list when clicked
            $("li#header_notification_bar").click(function(){
                   
                });
            
              $('#queue').dataTable( {
                  "aaSorting": [[ 4, "desc" ]]
              } );
              
                $('#today_appointments').dataTable( {
                  "aaSorting": [[ 4, "desc" ]]
              } );
                
                
          } );
      </script>
</body>

<script>

      //owl carousel
      $(document).ready(function() {
        
        
        
        //prevent back button on browser
        history.pushState(null,null,'');
        window.addEventListener('popstate',function(){
            history.pushState(null,null,'');
            });
            
            
        
        
        <?php $permission_error = $this->session->userdata('permission_error');if(isset($permission_error) && $permission_error != "") {
            $this->session->unset_userdata('permission_error');
         ?>   
            
            alert("<?php echo $permission_error; ?>");
            
            
          <?php  }?>
          
           <?php $notice = $this->session->userdata('notice');if(isset($notice) && $notice != "") {
            $this->session->unset_userdata('notice');
         ?>   
            
            alert("<?php echo $notice; ?>");
            
            
          <?php  }?>
        
       // alert("<?php echo $this->session->userdata('username');?>");
          $("#owl-demo").owlCarousel({
              navigation : true,
              slideSpeed : 300,
              paginationSpeed : 400,
              singleItem : true,
			  autoPlay:true

          });
          
          
          $(".patient-menu").click(function(){
            
                
                    var key = "#"+ $(this).attr("key");
                    $(key).click();
            });
      });
      
      $('div.panel-body form').addClass("form-horizontal").addClass("tasi-form").attr("id","default");

      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

  </script>
</body>

</html>