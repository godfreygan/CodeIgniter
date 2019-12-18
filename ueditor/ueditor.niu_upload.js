/*阿牛原创插件 2014-08-01 QQ:363462227 MOBILE:15050400520*/
;(function(){
	$.setDefault=function(obj)
	{
		var i = obj.index();		
		$('#istop').val(i);
		$('.upload-pics').css({'border-color':'#ddd'});
		obj.css({'border-color':'#ff0000'});
	}	
	
	$.fn.niu_upload=function(savepath,pic)
	{
		var div=this.attr('id');
		this.after('<div id="'+div+'-box" style="width:1px;display:none;overflow:hidden;"></div><div id="'+div+'-pic" style="width:100%;float:left;margin-top:10px;"></div>');	
		if(pic && pic != 0)
		{
			var str='';	
			str = '<div style="padding:2px;border:1px #ddd solid;margin-bottom:10px;background:#fff;width:100px;height:100px;position:relative;"><input type="hidden" name="'+div+'" id="" value="'+pic+'"><img src="'+pic+'" style="width:94px;height:94px;"><div style="position:absolute;right:-5px;top:-5px;width:12px;height:12px;line-height:12px;text-align:center;background:#ff0000;color:#fff;cursor:pointer;border-radius:50%;font-size:12px;" onclick="$(this).parent().remove();">×</div></div>';								
			$('#'+div+'-pic').html(str);
		};		
		if(savepath)
		{	
			var __u=new UE.ui.Editor({isShow:false,savePath:[savepath]});		
		}
		else
		{
			var __u=new UE.ui.Editor({isShow:false});
		}
		__u.render(div+'-box');			
		__u.addListener('beforeInsertImage',function(t, arg)
		{
			__u.setDisabled();
			var str='';
			if(arg.src)
			{
				str = '<div style="padding:2px;border:1px #ddd solid;margin-bottom:10px;background:#fff;width:100px;height:100px;position:relative;"><input type="hidden" name="'+div+'" id="" value="'+arg.src+'"><img src="'+arg.src+'" style="width:94px;height:94px;"><div style="position:absolute;right:-5px;top:-5px;width:12px;height:12px;line-height:12px;text-align:center;background:#ff0000;color:#fff;cursor:pointer;border-radius:50%;font-size:12px;" onclick="$(this).parent().remove();">×</div></div>';
			}
			else
			{
			str = '<div style="padding:2px;border:1px #ddd solid;margin-bottom:10px;background:#fff;width:100px;height:100px;position:relative;"><input type="hidden" name="'+div+'" id="" value="'+arg[0].src+'"><img src="'+arg[0].src+'" style="width:94px;height:94px;"><div style="position:absolute;right:-5px;top:-5px;width:12px;height:12px;line-height:12px;text-align:center;background:#ff0000;color:#fff;cursor:pointer;border-radius:50%;font-size:12px;" onclick="$(this).parent().remove();">×</div></div>';	
			}
			$('#'+div+'-pic').html(str);
			return;				
		});
				
		this.bind('click',function()
		{
			var __e=__u.getDialog("insertimage");		
			__e.open();				
		});
	}
		
	$.fn.niu_uploads=function(savepath,pics)
	{
		var div=this.attr('id');		
		this.after('<div id="'+div+'-box" style="width:1px;display:none;overflow:hidden;"></div><input id="istop" name="istop" type="hidden" value="0"><div id="'+div+'-pic" style="width:100%;float:left;margin-top:10px;"></div>');		
		if(savepath)
		{	
			var __u=new UE.ui.Editor({isShow:false,savePath:[savepath]});		
		}
		else
		{
			var __u=new UE.ui.Editor({isShow:false});
		}
		__u.render(div+'-box');
		if(pics)
		{
		  if(pics.length > 0)
		  {	
		  	  var str = '';		  		
			  $.each(pics,function(n,value) 
			  {
				  str += '<div style="padding:2px;border:1px #ddd solid;background:#fff;width:100px;height:100px;float:left;margin-right:10px;margin-bottom:10px;position:relative;"><input type="hidden" name="'+div+'[]" value="'+value+'"><img src="'+value+'" style="width:94px;height:94px;"><div style="position:absolute;right:-5px;top:-5px;width:12px;height:12px;line-height:12px;text-align:center;background:#ff0000;color:#fff;cursor:pointer;border-radius:50%;font-size:12px;" onclick="$(this).parent().remove();">×</div></div>';	
			  });
			  $('#'+div+'-pic').html(str);
		  }
		}
		
		__u.addListener('beforeInsertImage',function(t, arg)
		{
			__u.setDisabled();
			var str='';			
			for(i=0; i<arg.length; i++)
			{
				str += '<div style="padding:2px;border:1px #ddd solid;background:#fff;width:100px;height:100px;float:left;margin-right:10px;margin-bottom:10px;position:relative;"><input type="hidden" name="'+div+'[]" value="'+arg[i].src+'"><img src="'+arg[i].src+'" style="width:94px;height:94px;"><div style="position:absolute;right:-5px;top:-5px;width:12px;height:12px;line-height:12px;text-align:center;background:#ff0000;color:#fff;cursor:pointer;border-radius:50%;font-size:12px;" onclick="$(this).parent().remove();">×</div></div>';					
			};
			$('#'+div+'-pic').append(str);
			return;
		});	
					
		this.bind('click',function()
		{
			var __e=__u.getDialog("insertimage");		
			__e.open();		
	
		});
	}
	
	//多图点击可选择默认
	$.fn.niu_uploads2=function(savepath,pics,istop)
	{
		if(!istop) istop = 0;
		var div=this.attr('id');		
		this.after('<div id="'+div+'-box" style="width:1px;display:none;overflow:hidden;"></div><input id="istop" name="istop" type="hidden" value="'+istop+'"><div id="'+div+'-pic" style="width:100%;float:left;margin-top:10px;"></div>');		
		if(savepath)
		{	
			var __u=new UE.ui.Editor({isShow:false,savePath:[savepath]});		
		}
		else
		{
			var __u=new UE.ui.Editor({isShow:false});
		}
		__u.render(div+'-box');
		if(pics)
		{
		  if(pics.length > 0)
		  {	
		  	  var str = '';		  		
			  $.each(pics,function(n,value) 
			  {
				  str += '<div class="upload-pics" onclick="$.setDefault($(this))" style="padding:2px;border:1px #ddd solid;background:#fff;width:100px;height:100px;float:left;margin-right:10px;margin-bottom:10px;position:relative;"><input type="hidden" name="'+div+'[]" value="'+value+'"><img src="'+value+'" style="width:94px;height:94px;"><div style="position:absolute;right:-5px;top:-5px;width:12px;height:12px;line-height:12px;text-align:center;background:#ff0000;color:#fff;cursor:pointer;border-radius:50%;font-size:12px;" onclick="$(this).parent().remove();">×</div></div>';	
			  });
			  $('#'+div+'-pic').html(str);
			  $('.upload-pics').eq(istop).trigger('click');
		  }
		}
		
		__u.addListener('beforeInsertImage',function(t, arg)
		{
			__u.setDisabled();
			var str='';			
			for(i=0; i<arg.length; i++)
			{
				str += '<div class="upload-pics" onclick="$.setDefault($(this))" style="padding:2px;border:1px #ddd solid;background:#fff;width:100px;height:100px;float:left;margin-right:10px;margin-bottom:10px;position:relative;"><input type="hidden" name="'+div+'[]" value="'+arg[i].src+'"><img src="'+arg[i].src+'" style="width:94px;height:94px;"><div style="position:absolute;right:-5px;top:-5px;width:12px;height:12px;line-height:12px;text-align:center;background:#ff0000;color:#fff;cursor:pointer;border-radius:50%;font-size:12px;" onclick="$(this).parent().remove();">×</div></div>';					
			};
			$('#'+div+'-pic').append(str);
			return;
		});	
					
		this.bind('click',function()
		{
			var __e=__u.getDialog("insertimage");		
			__e.open();	
		});
	}
	
})(jQuery);