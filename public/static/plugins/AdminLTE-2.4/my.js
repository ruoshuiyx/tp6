//全选+取消
$(function(){
    $("#check").click(function(){
        var is_checked = $(this).prop("checked"); 
        if(is_checked==true){
            setCheckbox(true);
        }else{
            setCheckbox(false);
        }
    });
});

//设置Checkbox状态
function setCheckbox(flag){
    flag = flag? true : false;
    var checkbox = document.getElementsByName("key[]");
    for(var i=0;i<checkbox.length;i++){
        if (!checkbox[i].disabled) {        
            checkbox[i].checked = flag;
        }
    }
}

//通用更改状态
function changeState(url,id){
  	$.post(url,{id:id},function(result){
		if(result.error == 0){
			swal(result.msg,'','success').then(function(){
                location.reload(true);
			});
		}else{
			swal(result.msg,'','error');
		}
	},'json')
}

//通用删除单个
function delOne(url,id){
	swal({
	  title: '确定删除?',
	  text: "删除后将无法恢复!",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3c8dbc',
	  cancelButtonColor: '#d33',
	  confirmButtonText: '确定',
	  cancelButtonText: '取消'
	}).then(function(isConfirm) {
	  if (isConfirm) {
		$.post(url,{id:id},function(result){
			if(result.error == 0){
				swal(result.msg,'','success').then(function(){window.location.reload()});
			}else{
				swal(result.msg,'','error');
			}
		  },'json');
	  }
	})	
}

//批量删除
function delSelect(url){
	if (!getCheckboxNum()){
		  swal(
			  '请先选择要删除的项目',
			  '',
			  'error'
			)
	 }else{
			swal({
			  title: '确定删除?',
			  text: "删除后将无法恢复!",
			  type: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3c8dbc',
			  cancelButtonColor: '#d33',
			  confirmButtonText: '确定',
			  cancelButtonText: '取消'
			}).then(function(isConfirm) {
			  if (isConfirm) {
				//执行删除操作
				var id = $("input:checkbox[name='key[]']:checked").map(function(index,elem) {
					return $(elem).val();
				}).get().join(',');
				//ajax 
				$.post(url,{id:id},function(result){
						if(result.error == 0){
							swal(result.msg,'','success').then(function(){window.location.reload()});
						}else{
							swal(result.msg,'','error');
						}
					  },'json');
				//ajax
			  }
			})	
	 }
}

//获取Checkbox被选择个数
function getCheckboxNum(){
   var checkbox = document.getElementsByName("key[]");
   var j = 0; // 用户选中的选项个数
   for(var i=0;i<checkbox.length;i++){
      if(checkbox[i].checked){
          j++;
      }
   }
   return j;
}

//通用更改排序
function changeSort(url,id,sort){
  	$.post(url,{id:id,sort:sort},function(result){
		if(result.error == 0){
			//swal(result.msg,'','success');
		}else{
			swal(result.msg,'','error');
		}
	},'json')
}


//数据库备份
function dbBackup(url){
	if (!getCheckboxNum()){
		  swal(
			  '请选择表',
			  '',
			  'error'
			)
	 }else{
			var id = $("input:checkbox[name='key[]']:checked").map(function(index,elem) {
				return $(elem).val();
			}).get().join(',');
			//ajax 
			$.post(url,{id:id},function(result){
				if(result.error == 0){
					swal(result.msg,'','success').then(function(){window.location.reload()});
				}else{
					swal(result.msg,'','error');
				}
			  },'json');
	 }
}

//数据恢复
function dataImport(url,time){
	swal({
	  title: '确定要导入数据?',
	  text: "该操作无法撤回!",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3c8dbc',
	  cancelButtonColor: '#d33',
	  confirmButtonText: '确定',
	  cancelButtonText: '取消'
	}).then(function(isConfirm) {
	  if (isConfirm) {
		$.post(url,{time:time},function(result){
			if(result.error == 0){
				swal(result.msg,'','success').then(function(){window.location.reload()});
			}else{
				swal(result.msg,'','error');
			}
		  },'json');
	  }
	})	
}

//数据删除
function dataDelSql(url,time){
	swal({
	  title: '确定要删除?',
	  text: "该操作无法撤回!",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3c8dbc',
	  cancelButtonColor: '#d33',
	  confirmButtonText: '确定',
	  cancelButtonText: '取消'
	}).then(function(isConfirm) {
	  if (isConfirm) {
		$.post(url,{time:time},function(result){
			if(result.error == 0){
				swal(result.msg,'','success').then(function(){window.location.reload()});
			}else{
				swal(result.msg,'','error');
			}
		  },'json');
	  }
	})	
}

//测试邮件发送
function trySend(url,email){
	$.post(url,{email:email},function(result){
		if(result.error == 0){
			swal(result.msg,'','success');
		}else{
			swal(result.msg,'','error');
		}
	  },'json');
}

//测试短信发送
function trySendSms(url,mobile){
	$.post(url,{mobile:mobile},function(result){
		if(result.error == 0){
			swal(result.msg,'','success');
		}else{
			swal(result.msg,'','error');
		}
	},'json');
}

//选择模型的同时更改模版
	$(function(){
        $("select[name='moduleid']").change(function(){
            $("select[name='moduleid'] option").each(function(i,o){
                //升级jq后原attr失效
                //http://blog.csdn.net/ruoshuiyx/article/details/49150119
                var is_checked = $(this).prop("selected");   
                if(is_checked==true){
                    var data_name = $(this).attr('data-name');
                    setStyleSelect(data_name);
                    
                }
            });
        });
        
        function setStyleSelect(data_name){
            var template_list = $("select[name='template_list']");
            var template_show = $("select[name='template_show']");
			if(isExistOption(template_list,data_name+"_list.html")){
				template_list.val(data_name+"_list.html");
			}
			if(isExistOption(template_show,data_name+"_show.html")){
				 template_show.val(data_name+"_show.html");
			}
        }
		//判断select是否存在某个选项
		function isExistOption(id,value) {  
		var isExist = false;  
		var count = id.find('option').length;  
	
		  for(var i=0;i<count;i++)     
		  {     
			 if(id.get(0).options[i].value == value)     
				 {     
					   isExist = true;     
							break;     
					  }     
			}     
			return isExist;  
	}  

    });

//全屏按钮点击效果
$(".fullscreen").click(function(){
	if ($(this).hasClass('full')) {
		$(this).removeClass('full');
        if (document.exitFullscreen) { 
            document.exitFullscreen(); 
        } else if (document.msExitFullscreen) { 
            document.msExitFullscreen(); 
        } else if (document.mozCancelFullScreen) { 
            document.mozCancelFullScreen(); 
        } else if (document.webkitCancelFullScreen) { 
            document.webkitCancelFullScreen(); 
        } 
    } else {
        $(this).addClass('full');
        var docElm = document.documentElement; 
        if (docElm.requestFullscreen) { 
            docElm.requestFullscreen(); 
        } else if (docElm.msRequestFullscreen) { 
            docElm.msRequestFullscreen(); 
        } else if (docElm.mozRequestFullScreen) { 
            docElm.mozRequestFullScreen(); 
        } else if (docElm.webkitRequestFullScreen) { 
            docElm.webkitRequestFullScreen(); 
        } 
    }
})
//捐赠
$(".juanzeng").click(function(){
	swal({
	  imageUrl: '/static/admin/images/shoukuan.png',
	  showCloseButton: true,
	  showConfirmButton: false,
	})
})
