// [已废弃]全选+取消
$(document).on("click", '#check', function () {
    var is_checked = $(this).prop("checked");
    if(is_checked==true){
        setCheckbox(true);
    }else{
        setCheckbox(false);
    }
})

// [已废弃]设置Checkbox状态
function setCheckbox(flag){
    flag = flag? true : false;
    var checkbox = document.getElementsByName("key[]");
    for(var i=0;i<checkbox.length;i++){
        if (!checkbox[i].disabled) {
            checkbox[i].checked = flag;
        }
    }
}

// [已废弃]通用更改状态
function changeState(url,id){
  	$.post(url,{id:id},function(result){
		if(result.error == 0){
			swal(result.msg,'','success').then(function(){
                //location.reload(true);
                $.pjax.reload('.content-wrapper');
			});
		}else{
			swal(result.msg,'','error');
		}
	},'json')
}

// [已废弃]通用删除单个
function delOne(url, id) {
    swal({
        title: '确定删除?',
        text: "删除后将无法恢复!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3c8dbc',
        cancelButtonColor: '#d33',
        confirmButtonText: '确定',
        cancelButtonText: '取消'
    }).then(function (isConfirm) {
        if (isConfirm) {
            $.post(url, {id: id}, function (result) {
                if (result.error == 0) {
                    swal(result.msg, '', 'success').then(function () {
                        $.pjax.reload('.content-wrapper')
                    });
                } else {
                    swal(result.msg, '', 'error');
                }
            }, 'json');
        }
    })
}

// [已废弃]通用执行确认
function confirmOne(url, id, text, title, confirm_btn, cancel_btn) {
    swal({
        title: title,
        text: text,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3c8dbc',
        cancelButtonColor: '#d33',
        confirmButtonText: confirm_btn,
        cancelButtonText: cancel_btn
    }).then(function (isConfirm) {
        if (isConfirm) {
            $.post(url, {id: id}, function (result) {
                if (result.error == 0) {
                    swal(result.msg, '', 'success').then(function () {
                        $.pjax.reload('.content-wrapper')
                    });
                } else {
                    swal(result.msg, '', 'error');
                }
            }, 'json');
        }
    })
}

// [已废弃]批量删除
function delSelect(url) {
    if (!getCheckboxNum()) {
        swal(
            '请先选择要删除的项目',
            '',
            'error'
        )
    } else {
        swal({
            title: '确定删除?',
            text: "删除后将无法恢复!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3c8dbc',
            cancelButtonColor: '#d33',
            confirmButtonText: '确定',
            cancelButtonText: '取消'
        }).then(function (isConfirm) {
            if (isConfirm) {
                //执行删除操作
                var id = $("input:checkbox[name='key[]']:checked").map(function (index, elem) {
                    return $(elem).val();
                }).get().join(',');
                //ajax
                $.post(url, {id: id}, function (result) {
                    if (result.error == 0) {
                        swal(result.msg, '', 'success').then(function () {
                            //window.location.reload()
                            $.pjax.reload('.content-wrapper')
                        });
                    } else {
                        swal(result.msg, '', 'error');
                    }
                }, 'json');
                //ajax
            }
        })
    }
}

// [已废弃]获取Checkbox被选择个数
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

// [已废弃]通用更改排序
function changeSort(url,id,sort){
  	$.post(url,{id:id,sort:sort},function(result){
		if(result.error == 0){
            //排序后立即重载页面（可去除）
            $.pjax.reload('.content-wrapper')
			//swal(result.msg,'','success');
		}else{
			swal(result.msg,'','error');
		}
	},'json')
}

// [已废弃]数据库备份
function dbBackup(url) {
    if (!getCheckboxNum()) {
        swal(
            '请选择表',
            '',
            'error'
        )
    } else {
        var id = $("input:checkbox[name='key[]']:checked").map(function (index, elem) {
            return $(elem).val();
        }).get().join(',');
        //ajax
        $.post(url, {id: id}, function (result) {
            if (result.error == 0) {
                swal(result.msg, '', 'success').then(function () {
                    $.pjax.reload('.content-wrapper')
                });
            } else {
                swal(result.msg, '', 'error');
            }
        }, 'json');
    }
}

// [已废弃]数据恢复
function dataImport(url, time) {
    swal({
        title: '确定要导入数据?',
        text: "该操作无法撤回!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3c8dbc',
        cancelButtonColor: '#d33',
        confirmButtonText: '确定',
        cancelButtonText: '取消'
    }).then(function (isConfirm) {
        if (isConfirm) {
            $.post(url, {time: time}, function (result) {
                if (result.error == 0) {
                    swal(result.msg, '', 'success').then(function () {
                        $.pjax.reload('.content-wrapper')
                    });
                } else {
                    swal(result.msg, '', 'error');
                }
            }, 'json');
        }
    })
}

// [已废弃]数据删除
function dataDelSql(url, time) {
    swal({
        title: '确定要删除?',
        text: "该操作无法撤回!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3c8dbc',
        cancelButtonColor: '#d33',
        confirmButtonText: '确定',
        cancelButtonText: '取消'
    }).then(function (isConfirm) {
        if (isConfirm) {
            $.post(url, {time: time}, function (result) {
                if (result.error == 0) {
                    swal(result.msg, '', 'success').then(function () {
                        $.pjax.reload('.content-wrapper')
                    });
                } else {
                    swal(result.msg, '', 'error');
                }
            }, 'json');
        }
    })
}

// [已废弃]测试短信发送
function trySendSms(url,mobile){
	$.post(url,{mobile:mobile},function(result){
		if(result.error == 0){
			swal(result.msg,'','success');
		}else{
			swal(result.msg,'','error');
		}
	},'json');
}

// [已废弃]栏目管理页面新增或修改时选择模型的同时更改模版
/*$(document).on('change', "select[name='module_id']", function(e){
    $("select[name='module_id'] option").each(function (i, o) {
        // 升级jq后原attr失效
        // http://blog.csdn.net/ruoshuiyx/article/details/49150119
        var is_checked = $(this).prop("selected");
        if (is_checked == true) {
            var data_name = $(this).attr('data-name');
            setStyleSelect(data_name);
        }
    });
});*/

// [已废弃]更改CMS模块时修改模板默认选中或值
function setStyleSelect(data_name) {
    var template_list = $("select[name='template_list']");
    var template_show = $("select[name='template_show']");
    if (isExistOption(template_list, data_name + "_list.html")) {
        template_list.val(data_name + "_list.html");
    }
    if (isExistOption(template_show, data_name + "_show.html")) {
        template_show.val(data_name + "_show.html");
    }
}

// [已废弃]判断select是否存在某个选项
function isExistOption(id, value) {
    var isExist = false;
    var count = id.find('option').length;

    for (var i = 0; i < count; i++) {
        if (id.get(0).options[i].value == value) {
            isExist = true;
            break;
        }
    }
    return isExist;
}

// =========↑↑↑↑↑↑↑↑↑已废弃↑↑↑↑↑↑↑↑↑=========

// [待确定]daterangepicker 动态元素追加后重新绑定
$(document).on('mouseover', "input[daterange='true']", function(){
    $(this).daterangepicker(
        {
            // autoApply: true,
            autoUpdateInput: false,
            // alwaysShowCalendars: true,
            ranges: {
                '今天': [moment(),moment()],
                '昨天': [moment().subtract(1, 'days'),moment().subtract(1, 'days')],
                '近7天': [moment().subtract(7, 'days'), moment()],
                '这个月': [moment().startOf('month'), moment().endOf('month')],
                '上个月': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            locale: {
                format: "YYYY/MM/DD",
                separator: " - ",
                applyLabel: "确认",
                cancelLabel: "清空",
                fromLabel: "开始时间",
                toLabel: "结束时间",
                customRangeLabel: "自定义",
                daysOfWeek: ["日","一","二","三","四","五","六"],
                monthNames: ["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"]
            }
        }
    ).on('cancel.daterangepicker', function(ev, picker) {
        $(this).val("");
    }).on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD')+" 至 "+picker.endDate.format('YYYY-MM-DD'));
    });
})

// 顶部导航区域全屏功能
$(".fullscreen").click(function () {
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

// 列表图片鼠标移上跟随效果（兼容ajax分页）
$(document).on('mouseover', '.image_preview', function (e) {
    var image = $(this).attr("src");
    if (image != "") {
        var zoomView = $('<img src="' + image + '" id="zoomView" />'); // 建立图片查看框
        $(this).after(zoomView);
        $("#zoomView").fadeIn(100);
        $("#zoomView").css({"top": (e.pageY - 250) + "px", "left": (e.pageX - 210) + "px"});  //注意得在CSS文件中将其设置为绝对定位
    }
})

$(document).on('mousemove', '.image_preview', function (e) {
    var image = $(this).attr("image");
    if (image != "") {
        $("#zoomView").css({"top": (e.pageY - 250) + "px", "left": (e.pageX - 210) + "px"}); //鼠标移动时及时更新图片查看框的坐标
    }
})

$(document).on('mouseout', '.image_preview', function(e){
    var image=$(this).attr("image");
    if(image!=""){
        $("#zoomView").remove();    //鼠标移出时删除之前建立的图片查看框
    }
})

// 常规表单提交转变成ajax
$(document).on("submit", 'form:not([data-pjax])', function () {
	var _this = $(this);
	// 判断是否开启了提交确认
	if(typeof($(this).attr("submit_confirm"))=="undefined")
	{
		// 不需要提交确认,直接提交表单
		formSubmit(_this);
	}else{
        // 需要确认提示
        $.modal.confirm('确定要提交吗？', function () {
            formSubmit(_this);
        })
	}
    return false; // 阻止表单默认提交
})

// 表单提交 
function formSubmit($this) {
    $this.ajaxSubmit(function (result) {
        if (result.code == 1) {
            // 提交成功
            $.modal.alertSuccess(result.msg, function (index) {
                layer.close(index);
                $.common.jump(result.url);
            });
        } else {
            // 提交失败
            $.modal.alertError(result.msg);
        }
    });
}

// 捐赠
$(document).on("click", '.juanzeng', function () {
    $.modal.open('捐赠', "/static/admin/images/shoukuan.png", 450, 533);
})

// 多图删除
$(document).on('click','.remove_images',function(){
    var remove = $(this).parent().parent();
    remove.remove();
})

// 返回顶部显示
$(window).scroll(function() {
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        $('#totop').fadeIn(500)
    } else {
        $('#totop').fadeOut(500)
    }
});

// 返回顶部点击
$(document).on("click", '#totop', function(e) {
    // 防止打开URL
    e.preventDefault();
    $('html,body').animate({
        scrollTop: 0
    }, 300)
});

// pjax 刷新当前页
function pjaxReplace(url){
    $.pjax({url: url, container: '.content-wrapper'})
}

// pjax 执行完成后执行的方法
$(document).on('pjax:complete', function () {
	
    // 首页重新请求远程ad
    if ($(".main_ad").length > 0) {
        $.getScript("http://www.siyucms.com/ad.js");
    }

    // tag 标签
    if ($("#tags").length > 0) {
        $('#tags').tagsInput({
            'width':'auto',
            'height':'auto',
            'placeholderColor' : '#666666',
            'defaultText':'添加标签',
        });
    }

})

// 返回上一页时重新触发pjax，防止加载重复的bootstrap-table
$(function () {
    window.addEventListener("popstate", function (e) {
        $.pjax.reload('.content-wrapper');
    }, false);
})

// tag 标签
if ($("#tags").length > 0) {
	$('#tags').tagsInput({
		'width':'auto',
		'height':'auto',
		'placeholderColor' : '#666666',
		'defaultText':'添加标签',
	});
}

// 转换日期格式(时间戳转换为datetime格式)
function changeDateFormat(cellval) {
    if(cellval != null && cellval != undefined){
        if (cellval.toString().indexOf("-") >= 0) {
            return cellval;
        }
    }
    var dateVal = cellval * 1000;
    if (cellval != null) {
        var date = new Date(dateVal);
        var month = date.getMonth() + 1 < 10 ? "0" + (date.getMonth() + 1) : date.getMonth() + 1;
        var currentDate = date.getDate() < 10 ? "0" + date.getDate() : date.getDate();

        var hours = date.getHours() < 10 ? "0" + date.getHours() : date.getHours();
        var minutes = date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes();
        var seconds = date.getSeconds() < 10 ? "0" + date.getSeconds() : date.getSeconds();

        return date.getFullYear() + "-" + month + "-" + currentDate + " " + hours + ":" + minutes + ":" + seconds;
    }
}