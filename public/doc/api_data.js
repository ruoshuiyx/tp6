define({ "api": [
  {
    "type": "post",
    "url": "/User/editInfo",
    "title": "05、修改信息",
    "group": "User",
    "version": "6.0.0",
    "description": "<p>修改用户信息，返回成功或失败提示</p>",
    "parameter": {
      "fields": {
        "请求参数：": [
          {
            "group": "请求参数：",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Token</p>"
          },
          {
            "group": "请求参数：",
            "type": "string",
            "optional": false,
            "field": "sex",
            "description": "<p>性别 [1男/0女]</p>"
          },
          {
            "group": "请求参数：",
            "type": "string",
            "optional": false,
            "field": "qq",
            "description": "<p>qq</p>"
          },
          {
            "group": "请求参数：",
            "type": "string",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功示例",
          "content": "{\"code\":0,\"msg\":\"修改成功\",\"time\":1563507660,\"data\":[]}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败示例",
          "content": "{\"code\":0,\"msg\":\"token已过期\",\"time\":1563527082,\"data\":[]}",
          "type": "json"
        }
      ]
    },
    "filename": "app/api/controller/User.php",
    "groupTitle": "User",
    "name": "PostUserEditinfo"
  },
  {
    "type": "post",
    "url": "/User/editPwd",
    "title": "04、修改密码",
    "group": "User",
    "version": "6.0.0",
    "description": "<p>修改会员密码，返回成功或失败提示</p>",
    "parameter": {
      "fields": {
        "请求参数：": [
          {
            "group": "请求参数：",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Token</p>"
          },
          {
            "group": "请求参数：",
            "type": "string",
            "optional": false,
            "field": "oldPassword",
            "description": "<p>原密码</p>"
          },
          {
            "group": "请求参数：",
            "type": "string",
            "optional": false,
            "field": "newPassword",
            "description": "<p>新密码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功示例",
          "content": "{\"code\":1,\"msg\":\"密码修改成功\",\"time\":1563527107,\"data\":[]}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败示例",
          "content": "{\"code\":0,\"msg\":\"token已过期\",\"time\":1563527082,\"data\":[]}",
          "type": "json"
        }
      ]
    },
    "filename": "app/api/controller/User.php",
    "groupTitle": "User",
    "name": "PostUserEditpwd"
  },
  {
    "type": "post",
    "url": "/User/index",
    "title": "03、会员中心首页",
    "group": "User",
    "version": "6.0.0",
    "description": "<p>会员中心首页，返回用户个人信息</p>",
    "parameter": {
      "fields": {
        "请求参数：": [
          {
            "group": "请求参数：",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Token</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "响应数据样例",
          "content": "{\"code\":1,\"msg\":\"\",\"time\":1563517637,\"data\":{\"id\":13,\"email\":\"test110@qq.com\",\"password\":\"e10adc3949ba59abbe56e057f20f883e\",\"sex\":1,\"last_login_time\":1563517503,\"last_login_ip\":\"127.0.0.1\",\"qq\":\"123455\",\"mobile\":\"\",\"mobile_validated\":0,\"email_validated\":0,\"type_id\":1,\"status\":1,\"create_ip\":\"127.0.0.1\",\"update_time\":1563507130,\"create_time\":1563503991,\"type_name\":\"注册会员\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "app/api/controller/User.php",
    "groupTitle": "User",
    "name": "PostUserIndex"
  },
  {
    "type": "post",
    "url": "/User/login",
    "title": "01、会员登录",
    "group": "User",
    "version": "6.0.0",
    "description": "<p>系统登录接口，返回 token 用于操作需验证身份的接口</p>",
    "parameter": {
      "fields": {
        "请求参数：": [
          {
            "group": "请求参数：",
            "type": "string",
            "optional": false,
            "field": "username",
            "description": "<p>登录用户名</p>"
          },
          {
            "group": "请求参数：",
            "type": "string",
            "optional": false,
            "field": "password",
            "description": "<p>登录密码</p>"
          }
        ],
        "响应字段：": [
          {
            "group": "响应字段：",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Token</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功示例",
          "content": "{\"code\":1,\"msg\":\"登录成功\",\"time\":1563525780,\"data\":{\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhcGkuc2l5dWNtcy5jb20iLCJhdWQiOiJzaXl1Y21zX2FwcCIsImlhdCI6MTU2MzUyNTc4MCwiZXhwIjoxNTYzNTI5MzgwLCJ1aWQiOjEzfQ.prQbqT00DEUbvsA5M14HpNoUqm31aj2JEaWD7ilqXjw\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败示例",
          "content": "{\"code\":0,\"msg\":\"帐号或密码错误\",\"time\":1563525638,\"data\":[]}",
          "type": "json"
        }
      ]
    },
    "filename": "app/api/controller/User.php",
    "groupTitle": "User",
    "name": "PostUserLogin"
  },
  {
    "type": "post",
    "url": "/User/register",
    "title": "02、会员注册",
    "group": "User",
    "version": "6.0.0",
    "description": "<p>系统注册接口，返回是否成功的提示，需再次登录</p>",
    "parameter": {
      "fields": {
        "请求参数：": [
          {
            "group": "请求参数：",
            "type": "string",
            "optional": false,
            "field": "email",
            "description": "<p>邮箱</p>"
          },
          {
            "group": "请求参数：",
            "type": "string",
            "optional": false,
            "field": "password",
            "description": "<p>密码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功示例",
          "content": "{\"code\":1,\"msg\":\"注册成功\",\"time\":1563526721,\"data\":[]}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败示例",
          "content": "{\"code\":0,\"msg\":\"邮箱已被注册\",\"time\":1563526693,\"data\":[]}",
          "type": "json"
        }
      ]
    },
    "filename": "app/api/controller/User.php",
    "groupTitle": "User",
    "name": "PostUserRegister"
  }
] });
