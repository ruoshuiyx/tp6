// daterangepicker 动态元素追加后重新绑定(列表搜索)
$(document).on('mouseover', "input[daterange='true']", function(){
    $(this).daterangepicker(
        {
            autoUpdateInput: false,  // 自动填充日期
            showDropdowns: true,     // 年月份下拉框
            timePicker: true,        // 显示时间
            timePicker24Hour: true,  // 时间制
            timePickerSeconds: true, // 时间显示到秒
            ranges: {
                '今天': [moment(), moment()],
                '昨天': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '上周': [moment().subtract(6, 'days'), moment()],
                '前30天': [moment().subtract(29, 'days'), moment()],
                '本月': [moment().startOf('month'), moment().endOf('month')],
                '上月': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            locale: {
                format: "YYYY/MM/DD",
                applyLabel: '确定',       // 确定按钮文本
                cancelLabel: '取消',      // 取消按钮文本
                customRangeLabel: '自定义',
            }
        }
    ).on('cancel.daterangepicker', function(ev, picker) {
        $(this).val("");
    }).on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD')+" 至 "+picker.endDate.format('YYYY-MM-DD'));
    });
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

// pjax 执行完成后执行的方法
$(document).on('pjax:complete', function () {
	
    // 首页重新请求远程ad
    if ($(".main_ad").length > 0) {
        $.getScript("https://www.siyucms.com/ad.js");
    }

    // tag 标签
    if ($(".tags").length > 0) {
        $('.tags').tagsInput({
            'width':'auto',
            'height':'auto',
            'placeholderColor' : '#666666',
            'defaultText':'添加标签',
        });
    }

    // tooltip 提示
    $('[data-toggle="tooltip"]').tooltip()

    // 更改网站标题
    changeWebTitle();

})


$(function () {
    // 返回上一页时重新触发pjax，防止加载重复的bootstrap-table
    window.addEventListener("popstate", function (e) {
        $.pjax.reload('.content-wrapper');
    }, false);

    // 左侧菜单点击
    /*$(".main-sidebar .nav .nav-treeview a.nav-link").click(function () {
        if($(this).attr('link') !== '#'){
            $(".main-sidebar .nav .nav-treeview a.nav-link").removeClass('active');
            $(this).addClass('active');
            $(this).parents('.nav-item').last().siblings().children('a').removeClass('active')
            $(this).parents('.nav-item').last().children('a').addClass('active')
        }
    })*/

    // 左侧菜单高亮
    $('.main-sidebar .nav .nav-treeview a.nav-link').on('click', function () {
        if($(this).attr('link') !== '#'){
            $(".main-sidebar .nav .nav-treeview a.nav-link").removeClass('active');
            $(this).addClass('active');
            $(this).parents('.nav-item').last().siblings().children('a').removeClass('active')
            $(this).parents('.nav-item').last().children('a').addClass('active')
        }

        // 小屏幕上点击左边菜单栏按钮，模拟点击 xs: 480,sm: 768,md: 992,lg: 1200
        if ($(window).width() < 992) {
            // 触发左边菜单栏按钮点击事件,关闭菜单栏
            $("[data-widget='pushmenu']").trigger('click');
        }
    });

    // 刷新后匹配当前URL和标题
    $(window).on('load', function(){
        // 获取当前页面面包导航标题
        var _title = $(".content-header").find("h1").clone();
        _title.find(':nth-child(n)').remove();
        if (_title.length>0){
            _title = _title.html().trim();
        }

        // 循环匹配
        $('.sidebar .nav-sidebar a.nav-link').each(function () {
            //$(this).children('p').find(':nth-child(n)').remove()
            var _html = $(this).children('p').html().replace("|—","").replace(" ","").trim()
            if(this.href !== '#' && _html == _title){
                // 打开对应菜单
                $(this).addClass('active')
                    .closest('.nav-treeview').show()                      // 打开二级ul
                    .closest('.has-treeview').addClass('menu-open') // 打开一级li
                    .children('a.nav-link').addClass('active');        // 高亮一级a
                // 判断当前所属的是第几个
                var _index = $(this).parents('.nav-item').last().data('item')

                // 执行点击动作
                $(".js_left_menu li").eq(_index).click();
            }
        });
        // 改变网站标题
        changeWebTitle();
    });

    // tag 标签
    if ($(".tags").length > 0) {
        $('.tags').tagsInput({
            'width': 'auto',
            'height': 'auto',
            'placeholderColor': '#666666',
            'defaultText': '添加标签',
        });
    }

    // tooltip 提示
    $('[data-toggle="tooltip"]').tooltip()

})


// =============================================

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

// pjax 刷新当前页
function pjaxReplace(url){
    $.pjax({url: url, container: '.content-wrapper'})
}

// 转换日期格式(时间戳转换为datetime格式)
function changeDateFormat(cellval) {
    if (cellval == '') {
        return '-';
    }
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

// pjax 改变网站标题
function changeWebTitle() {
    // 获取当前页的名称
    var _title = $(".content-header").find("h1").clone();
    _title.find(':nth-child(n)').remove();
    if (_title.length > 0) {
        _title = _title.html().trim();
    } else {
        _title = '';
    }
    // 获取网站标题
    var title = $(document).attr('title').split(' | ');
    // 设置网站标题
    if (title[1] != _title && $.common.isNotEmpty(_title)) {
        $(document).attr('title', title[0] + ' | ' + _title);
    }
}