$(function(){
	//刷新验证码操作
	$(".layadmin-user-login-codeimg").click(function(){
		$(this).attr("src",$(this).attr("src")+'?'+Math.random());
	})	
	//后台登录
	$(".login").click(function(){
		var username = $("input[name='username']").val();	
		var password = $("input[name='password']").val();	
		var vercode = $("input[name='vercode']").val();	
		$.ajax({
                type: "post",
                url: "/index.php/admin/Login/checkLogin",
                data: {username:username,password:password,vercode:vercode},
                dataType: "json",
                success: function(data){
					console.log(data);
					if(data.error == 1){
						alert(data.msg);
					}else{
						window.location.href = data.href;
					}
                    
                },
                error :function (xhr) {

                }
            });

	})
})
