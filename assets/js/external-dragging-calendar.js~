var Script=function(){
	$('#external-events div.external-event').each(function(){
		var eventObject={title:$.trim($(this).text())};
		$(this).data('eventObject',eventObject);
		$(this).draggable({zIndex:999,revert:true,revertDuration:0});
	});

	var date=new Date();var d=date.getDate();
	var m=date.getMonth();var y=date.getFullYear();

	$('#calendar').fullCalendar({header:{left:'prev,next today',center:'title',right:'month,basicWeek,basicDay'},editable:true,droppable:true,drop:function(date,allDay){var originalEventObject=$(this).data('eventObject');var copiedEventObject=$.extend({},originalEventObject);copiedEventObject.start=date;copiedEventObject.allDay=allDay;

$('#calendar').fullCalendar('renderEvent',copiedEventObject,true);

if($('#drop-remove').is(':checked')){$(this).remove();}},events:[{title:'All Day Event',start:new Date(y,m,1)},{title:'Click for Google',start:new Date(y,m,28),end:new Date(y,m,29),url:'http://google.com/'}]});}();
