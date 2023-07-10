var FormImageCrop=function(){var demo1=function(){$('#demo1').Jcrop();}
var demo2=function(){var jcrop_api;$('#demo2').Jcrop({onChange:showCoords,onSelect:showCoords,onRelease:clearCoords},function(){jcrop_api=this;});$('#coords').on('change','input',function(e){var x1=$('#x1').val(),x2=$('#x2').val(),y1=$('#y1').val(),y2=$('#y2').val();jcrop_api.setSelect([x1,y1,x2,y2]);});function showCoords(c)
{$('#x1').val(c.x);$('#y1').val(c.y);$('#x2').val(c.x2);$('#y2').val(c.y2);$('#w').val(c.w);$('#h').val(c.h);};function clearCoords()
{$('#coords input').val('');};}
var demo3=function(){var jcrop_api,boundx,boundy,$preview=$('#preview-pane'),$pcnt=$('#preview-pane .preview-container'),$pimg=$('#preview-pane .preview-container img'),xsize=$pcnt.width(),ysize=$pcnt.height();console.log('init',[xsize,ysize]);$('#demo3').Jcrop({onChange:updatePreview,onSelect:updatePreview,aspectRatio:xsize/ysize},function(){var bounds=this.getBounds();boundx=bounds[0];boundy=bounds[1];jcrop_api=this;$preview.appendTo(jcrop_api.ui.holder);});function updatePreview(c)
{if(parseInt(c.w)>0)
{var rx=xsize/c.w;var ry=ysize/c.h;$pimg.css({width:Math.round(rx*boundx)+'px',height:Math.round(ry*boundy)+'px',marginLeft:'-'+ Math.round(rx*c.x)+'px',marginTop:'-'+ Math.round(ry*c.y)+'px'});}};}
return{init:function(){if(!jQuery().Jcrop){;return;}
demo1();demo2();demo3();}};}();