/**
 * 通用js方法封装处理
 * Copyright (c) 2019 siyucms
 */
(function ($) {
	$.extend({
		btTable: {},  // bootstrapTable

		// 表格封装处理
		table: {
			_option: {},
			// 初始化表格参数
			init: function(options) {
				// 默认参数
				var defaults = {
					id: "bootstrap-table",
                    height: undefined,            // 表格的高度,一般不需要设置
					sidePagination: "server",     // server启用服务端分页client客户端分页
					sortName: "id",               // 排序列名称
					sortOrder: "desc",            // 排序方式  asc 或者 desc
					escape: true,                 // 转义HTML字符串
					pagination: true,             // 是否显示分页
					pageSize: 10,                 // 每页的记录行数
					showRefresh: true,            // 是否显示刷新按钮
					showToggle: true,             // 是否显示详细视图和列表视图的切换按钮
					showFullscreen: true,         // 是否显示全屏按钮
					showColumns: true,            // 是否显示隐藏某列下拉框
					search: false,				  // 是否显示自带的搜索框功能
					showSearchButton: false,      // 是否显示自带的搜索按钮
					pageList: [10, 25, 50, 100],  // 每页显示的数量选择
					toolbar: "toolbar",           // 自定义工具栏
					toolbarAlign: "left",         // 工具栏左对齐
					buttonsClass: "",             // 按钮样式
					showFooter: false,			  // 显示页脚
					showExport: false,			  // 显示导出按钮
                    clickToSelect: false,         // 是否启用点击选中行
                    fixedColumns: false,          // 是否启用固定列功能
                    rowStyle: {},                 // 设置行样式
                    classes: 'table table-hover', // 设置表样式
					queryParams: $.table.queryParams,
				};
				var options = $.extend(defaults, options);

				$.table._option = options;
				$.btTable = $('#' + options.id);
                // 初始化新事件对象的属性
				$.table.initEvent();
				// 构建bootstrap数据
				var option = {
					url: options.url,                                   // 请求后台的URL（*）
					height: options.height,                             // 表格的高度
					sortable: true,                                     // 是否启用排序
					sortName: options.sortName,                         // 排序列名称
					sortOrder: options.sortOrder,                       // 排序方式  asc 或者 desc
					sortStable: true,                                   // 设置为 true 将获得稳定的排序
					method: 'post',                                     // 请求方式（*）
					cache: false,                                       // 是否使用缓存
					contentType: "application/json",   					// 内容类型
					dataType: 'json',                                   // 数据类型
					responseHandler: $.table.responseHandler,           // 在加载服务器发送来的数据之前处理函数
					pagination: options.pagination,                     // 是否显示分页（*）
					paginationLoop: true,                               // 是否禁用分页连续循环模式
					sidePagination: options.sidePagination,             // server启用服务端分页client客户端分页
					pageNumber: 1,                                      // 初始化加载第一页，默认第一页
					pageSize: options.pageSize,                         // 每页的记录行数（*）
					pageList: options.pageList,                         // 可供选择的每页的行数（*）
					search: options.search,                             // 是否显示搜索框功能
					showSearchButton: options.showSearchButton,         // 是否显示检索信息
					showColumns: options.showColumns,                   // 是否显示隐藏某列下拉框
					showRefresh: options.showRefresh,                   // 是否显示刷新按钮
					showToggle: options.showToggle,                     // 是否显示详细视图和列表视图的切换按钮
					showFullscreen: options.showFullscreen,             // 是否显示全屏按钮
					showFooter: options.showFooter,                     // 是否显示页脚
					escape: options.escape,                             // 转义HTML字符串
					clickToSelect: options.clickToSelect,				// 是否启用点击选中行
					toolbar: '#' + options.toolbar,                     // 指定工作栏
					detailView: options.detailView,                     // 是否启用显示细节视图
					iconSize: 'undefined',                              // 图标大小：undefined默认的按钮尺寸 xs超小按钮sm小按钮lg大按钮
					rowStyle: options.rowStyle,                         // 通过自定义函数设置行样式
					showExport: options.showExport,                     // 是否支持导出文件
					uniqueId: options.uniqueId,                         // 唯 一的标识符
					fixedColumns: options.fixedColumns,                 // 是否启用冻结列（左侧）
					detailFormatter: options.detailFormatter,           // 在行下面展示其他数据列表
					columns: options.columns,                           // 显示列信息（*）
					classes: options.classes,                           // 设置表样式
					queryParams: options.queryParams,                   // 传递参数（*）
				};
				// 将tree合并到option[关闭分页且传递父id字段才可以看到tree]
				if (option.pagination == false && $.common.isNotEmpty(options.parentIdField)) {
					// 构建tree
					var tree = {
						idField: options.uniqueId,
						treeShowField: options.uniqueId,
						parentIdField: options.parentIdField,
						rowStyle: function (row, index) {
							return classes = [
								'bg-blue',
								'bg-green',
								'bg-red'
							];
						},
						onPostBody: function onPostBody() {
							var columns = $.btTable.bootstrapTable('getOptions').columns;
							if (columns) {
								$.btTable.treegrid({
									initialState: 'collapsed',// 所有节点都折叠
									//initialState: 'expanded',// 所有节点都展开
									treeColumn: 1, // 默认为第三个
									// expanderExpandedClass: 'glyphicon glyphicon-minus',  //图标样式
									// expanderCollapsedClass: 'glyphicon glyphicon-plus',
									onChange: function () {
										$.btTable.bootstrapTable('resetWidth');
									}
								});
							}
						},
					};
					$.extend(option, tree);
				}
				$.btTable.bootstrapTable(option);
			},

			// 查询条件
			queryParams: function(params) {
				var curParams = {
					// 传递参数查询参数
					pageSize:       params.limit,
					page:           params.offset / params.limit + 1,
					searchValue:    params.search,
					orderByColumn:  params.sort,
					isAsc:          params.order
				};
				var currentId = $.common.isEmpty($.table._option.formId) ? 'search_form' : $.table._option.formId;
				return $.extend(curParams, $.common.formToJSON(currentId));
			},

			// 请求获取数据后处理回调函数
			responseHandler: function(res) {
				if (typeof $.table._option.responseHandler == "function") {
					$.table._option.responseHandler(res);
				}
                return { rows: res.data, total: res.total };
			},

			// 初始化事件
			initEvent: function(data) {
                // 触发行点击事件 加载成功事件
                $.btTable.on("check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table load-success.bs.table", function () {
                    // 工具栏按钮控制
                    var rows = $.common.isEmpty($.table._option.uniqueId) ? $.table.selectFirstColumns() : $.table.selectColumns($.table._option.uniqueId);
                    // 非多个禁用
                    $('#' + $.table._option.toolbar + ' .multiple').toggleClass('disabled', !rows.length);
                    // 非单个禁用
                    $('#' + $.table._option.toolbar + ' .single').toggleClass('disabled', rows.length!=1);
                });
                // 绑定选中事件、取消事件、全部选中、全部取消
                $.btTable.on("check.bs.table check-all.bs.table uncheck.bs.table uncheck-all.bs.table", function (e, rows) {
                    // 复选框分页保留保存选中数组
                    var rowIds = $.table.affectedRowIds(rows);
                    if ($.common.isNotEmpty($.table._option.rememberSelected) && $.table._option.rememberSelected) {
                        func = $.inArray(e.type, ['check', 'check-all']) > -1 ? 'union' : 'difference';
                        selectionIds = _[func](selectionIds, rowIds);
                    }
                });
			},

			// 表格销毁
			destroy: function (tableId) {
				var currentId = $.common.isEmpty(tableId) ? $.table._option.id : tableId;
				$("#" + currentId).bootstrapTable('destroy');
			},

			// 图片预览
			imageView: function (value, height, width, target) {
				if ($.common.isEmpty(width)) {
					width = 'auto';
				}
				if ($.common.isEmpty(height)) {
					height = 'auto';
				}
				// blank or self
				var _target = $.common.isEmpty(target) ? 'self' : target;
				if ($.common.isNotEmpty(value)) {
					return $.common.sprintf("<img class='img-circle img-xs' data-height='%s' data-width='%s' data-target='%s' src='%s'/>", width, height, _target, value);
				} else {
					return $.common.nullToStr(value);
				}
			},

			// 搜索-默认为 search_form
			search: function(formId, data) {
				var currentId = $.common.isEmpty(formId) ? 'search_form' : formId;
				var params = $.btTable.bootstrapTable('getOptions');
				params.queryParams = function(params) {
                    // 获取所有搜索的form元素
					var search = $.common.formToJSON(currentId);

                    // 如传递data则追加进search中
                    if ($.common.isNotEmpty(data)) {
                        $.each(data, function (key) {
                            search[key] = data[key];
                        });
                    }
					search.pageSize = params.limit;
					search.page = params.offset / params.limit + 1;
					search.searchValue = params.search;
					search.orderByColumn = params.sort;
					search.isAsc = params.order;
					return search;
				}
				$.btTable.bootstrapTable('refresh', params);
			},

			// 导出数据
			export: function(formId) {
				$.modal.confirm("确定导出所有数据吗？", function() {
                    var currentId = $.common.isEmpty(formId) ? 'search_form' : formId;
                    window.open($.table._option.exportUrl + '?' +$("#" + currentId).serialize());
				});
			},

            // 设置排序
            sort: function(obj) {
                var url = $.table._option.sortUrl;
                var data = {"id": $(obj).data('id'), "sort": $(obj).val()};
                $.operate.submit(url, "post", "json", data);
            },

			// 刷新表格
			refresh: function() {
				$.btTable.bootstrapTable('refresh', {
					silent: true
				});
			},

			// 显示表格指定列
			showColumn: function(column) {
				$.btTable.bootstrapTable('showColumn', column);
			},

			// 隐藏表格指定列
			hideColumn: function(column) {
				$.btTable.bootstrapTable('hideColumn', column);
			},

            // 查询表格指定列值
            selectColumns: function(column) {
                var rows = $.map($.btTable.bootstrapTable('getSelections'), function (row) {
                    return row[column];
                });
                if ($.common.isNotEmpty($.table._option.rememberSelected) && $.table._option.rememberSelected) {
                    rows = rows.concat(selectionIds);
                }
                return $.common.uniqueFn(rows);
            },

            // 获取当前页选中或者取消的行ID
            affectedRowIds: function(rows) {
                var column = $.common.isEmpty($.table._option.uniqueId) ? $.table._option.columns[1].field : $.table._option.uniqueId;
                var rowIds;
                if ($.isArray(rows)) {
                    rowIds = $.map(rows, function(row) {
                        return row[column];
                    });
                } else {
                    rowIds = [rows[column]];
                }
                return rowIds;
            },

            // 查询表格首列值
            selectFirstColumns: function() {
                var rows = $.map($.btTable.bootstrapTable('getSelections'), function (row) {
                    return row[$.table._option.columns[1].field];
                });
                if ($.common.isNotEmpty($.table._option.rememberSelected) && $.table._option.rememberSelected) {
                    rows = rows.concat(selectionIds);
                }
                return $.common.uniqueFn(rows);
            },

		},

		// 表单封装处理
		form: {
			// 表单重置
			reset: function(formId) {
				var currentId = $.common.isEmpty(formId) ? 'search_form' : formId;
				$("#" + currentId)[0].reset();
				// 重置select2
				$('select.select2').val(null).trigger("change");
				// 刷新表格
				$.btTable.bootstrapTable('refresh');
			},
		},

		// 弹出层封装处理
		modal: {
            // 消息提示前显示图标(通常不会单独前台调用)
            icon: function (type) {
                var icon = "";
                if (type == "warning") {
                    icon = 0;
                } else if (type == "success") {
                    icon = 1;
                } else if (type == "error") {
                    icon = 2;
                } else {
                    icon = 3;
                }
                return icon;
            },
			// 消息提示(第一个参数为内容，第二个为类型，通过类型调用不同的图标效果) [warning/success/error]
			msg: function(content, type) {
				if (type != undefined) {
					layer.msg(content, {icon: $.modal.icon(type), time: 1500, anim: 5, shade: [0.3]});
				} else {
					layer.msg(content);
				}
			},
			// 错误消息
			msgError: function(content) {
				$.modal.msg(content, "error");
			},
			// 成功消息
			msgSuccess: function(content) {
				$.modal.msg(content, "success");
			},
			// 警告消息
			msgWarning: function(content) {
				$.modal.msg(content, "warning");
			},
			// 弹出提示
			alert: function(content, type, callback) {
                layer.alert(content, {
                    icon: $.modal.icon(type),
                    title: "系统提示",
                    btn: ['确认'],
                    btnclass: ['btn btn-primary'],
                }, callback);
			},
			// 错误提示
            alertError: function(content, callback) {
                $.modal.alert(content, "error", callback);
            },
			// 成功提示
			alertSuccess: function(content, callback) {
				$.modal.alert(content, "success", callback);
			},
			// 警告提示
			alertWarning: function(content, callback) {
				$.modal.alert(content, "warning", callback);
			},
			// 确认窗体
			confirm: function (content, callBack) {
				layer.confirm(content, {
					icon: 3,
					title: "系统提示",
					btn: ['确认', '取消']
				}, function (index) {
					layer.close(index);
					callBack(true);
				});
			},
            // 消息提示并刷新父窗体
            msgReload: function(msg, type) {
                layer.msg(msg, {
                        icon: $.modal.icon(type),
                        time: 500,
                        shade: [0.1, '#8F8F8F']
                    },
                    function() {
                        $.modal.reload();
                    });
            },
			// 弹出层指定宽度
			open: function (title, url, width, height, callback) {
				// 如果是移动端，就使用自适应大小弹窗
				if (navigator.userAgent.match(/(iPhone|iPod|Android|ios)/i)) {
					width = 'auto';
					height = 'auto';
				}
				if ($.common.isEmpty(title)) {
					title = false;
				}
				if ($.common.isEmpty(width)) {
					width = 800;
				}
				if ($.common.isEmpty(height)) {
					height = ($(window).height() - 50);
				}
				if ($.common.isEmpty(callback)) {
                    // 当前层索引参数（index）、当前层的DOM对象（layero）
					callback = function(index, layero) {
						var iframeWin = layero.find('iframe')[0];
						iframeWin.contentWindow.submitHandler(index, layero);
                        // 获取弹出层中的form表单元素
                        //var formSubmit=layer.getChildFrame('form', index);
                        // 获取表单中的提交按钮（在我的表单里第一个button按钮就是提交按钮，使用find方法寻找即可）
                        //var submited = formSubmit.find('button')[0];
                        // 触发点击事件，会对表单进行验证，验证成功则提交表单，失败则返回错误信息
                        //submited.click();
                        //window.parent.location.reload();
                        //location.reload();
					}
				}
				layer.open({
                    // iframe层
					type: 2,
                    // 宽高
					area: [width + 'px', height + 'px'],
                    // 固定
					fix: false,
					// 最大最小化
					maxmin: true,
                    // 遮罩
					shade: 0.3,
                    // 标题
					title: title,
                    // 内容
					content: url,
                    // 按钮
					btn: ['确定', '关闭'],
					// 是否点击遮罩关闭
					shadeClose: true,
                    // 确定按钮回调方法
					yes: callback,
                    // 右上角关闭按钮触发的回调
					cancel: function(index) {
						return true;
					}
				});
			},
			// 弹出层指定参数选项
			openOptions: function (options) {
				var _url    = $.common.isEmpty(options.url)    ? "/404.html"               : options.url;
				var _title  = $.common.isEmpty(options.title)  ? "系统窗口"                 : options.title;
				var _width  = $.common.isEmpty(options.width)  ? "800"                     : options.width;
				var _height = $.common.isEmpty(options.height) ? ($(window).height() - 50) : options.height;
				var _btn = ['<i class="fa fa-check"></i> 确认', '<i class="fa fa-close"></i> 关闭'];
				if ($.common.isEmpty(options.yes)) {
					options.yes = function(index, layero) {
						options.callBack(index, layero);
					}
				}
				layer.open({
					type: 2,
					maxmin: true,
					shade: 0.3,
					title: _title,
					fix: false,
					area: [_width + 'px', _height + 'px'],
					content: _url,
					shadeClose: $.common.isEmpty(options.shadeClose) ? true : options.shadeClose,
					skin: options.skin,
					btn: $.common.isEmpty(options.btn) ? _btn : options.btn,
					yes: options.yes,
					cancel: function () {
						return true;
					}
				});
			},
			// 弹出层全屏
			openFull: function (title, url, width, height) {
				//如果是移动端，就使用自适应大小弹窗
				if (navigator.userAgent.match(/(iPhone|iPod|Android|ios)/i)) {
					width = 'auto';
					height = 'auto';
				}
				if ($.common.isEmpty(title)) {
					title = false;
				}
				if ($.common.isEmpty(url)) {
					url = "/404.html";
				}
				if ($.common.isEmpty(width)) {
					width = 800;
				}
				if ($.common.isEmpty(height)) {
					height = ($(window).height() - 50);
				}
				var index = layer.open({
					type: 2,
					area: [width + 'px', height + 'px'],
					fix: false,
					//不固定
					maxmin: true,
					shade: 0.3,
					title: title,
					content: url,
					btn: ['确定', '关闭'],
					// 弹层外区域关闭
					shadeClose: true,
					yes: function(index, layero) {
						var iframeWin = layero.find('iframe')[0];
						iframeWin.contentWindow.submitHandler(index, layero);
					},
					cancel: function(index) {
						return true;
					}
				});
				layer.full(index);
			},
			// 重新加载
			reload: function () {
				parent.location.reload();
			},
            // 关闭窗体
            close: function () {
                var index = parent.layer.getFrameIndex(window.name);
                parent.layer.close(index);
            },
		},

		// 操作封装处理
		operate: {
            // 修改信息
            edit: function(id) {
				// 当前窗口打开要修改的地址
				var url = $.operate.editUrl(id)
				$.common.jump(url);
            },

            // 修改访问的地址
            editUrl: function(id) {
                var url = "";
                if ($.common.isNotEmpty(id)) {
                    url = $.table._option.editUrl.replace("__id__", id);
                } else {
                    var id = $.common.isEmpty($.table._option.uniqueId) ? $.table.selectFirstColumns() : $.table.selectColumns($.table._option.uniqueId);
                    if (id.length == 0) {
                        $.modal.alertWarning("请至少选择一条记录");
                        return;
                    }
                    url = $.table._option.editUrl.replace("__id__", id);
                }
				// 获取搜索信息
				var back = $.common.serializeRemoveNull($("#search_form").serialize());
				back = back ? '&back_url=' + encodeURIComponent(back) : '';
				return url + back;
            },

            // 添加信息
            add: function(id) {
                // 当前窗口打开要添加的地址
                var url = $.operate.addUrl(id)
                $.common.jump(url);
            },

            // 添加访问的地址
			addUrl: function(id) {
				var url = $.common.isEmpty(id) ? $.table._option.addUrl.replace("__id__", "") : $.table._option.addUrl.replace("__id__", id);
				// 获取搜索信息
				var back = $.common.serializeRemoveNull($("#search_form").serialize());
				if (url.indexOf('?') != -1) {
					back = back ? '&back_url=' + encodeURIComponent(back) : '';
				} else {
					back = back ? '?back_url=' + encodeURIComponent(back) : '';
				}
				return url + back;
			},

            // 删除信息
            remove: function(id) {
                $.modal.confirm("确定删除该条数据吗？", function() {
                    var url = $.common.isEmpty(id) ? $.table._option.delUrl : $.table._option.delUrl.replace("__id__", id);
                    var data = { "id": id };
                    $.operate.submit(url, "post", "json", data);
                });
            },

            // 批量删除信息
            removeAll: function() {
                var rows = $.common.isEmpty($.table._option.uniqueId) ? $.table.selectFirstColumns() : $.table.selectColumns($.table._option.uniqueId);
                if (rows.length == 0) {
                    $.modal.alertWarning("请至少选择一条记录");
                    return;
                }
                $.modal.confirm("确认要删除选中的" + rows.length + "条数据吗?", function() {
                    var url = $.table._option.delUrl.replace("__id__", rows.join());
                    var data = { "id": rows.join() };
                    $.operate.submit(url, "post", "json", data);
                });
            },

            // 修改状态
            state: function(id, url) {
                $.modal.confirm("确认要更改状态吗?", function () {
                    var data = {"id": id};
                    $.operate.submit(url, "post", "json", data);
                });
            },

            // 代码生成
            build: function(id, url) {
                $.modal.confirm("确定要生成代码吗？生成代码会覆盖原有的控制器、模型和验证器文件<br>注意：原有文件会被重命名留做备份", function() {
                    if ($.common.isEmpty(id)) {
                        var id = $.common.isEmpty($.table._option.uniqueId) ? $.table.selectFirstColumns() : $.table.selectColumns($.table._option.uniqueId);
                        if (id.length == 0) {
                            $.modal.alertWarning("请至少选择一条记录");
                            return;
                        }
                    }
                    var data = {"id": id[0]};
                    $.operate.submit(url, "post", "json", data);
                });
            },

            // 生成菜单规则
            makeRule: function (url) {
                $.modal.confirm("确定要生成菜单规则吗，我们会根据模块的参数生成列表、新增、新增保存、修改、修改保存、删除、批量删除、导出、状态、排序 等规则", function () {
                    var id = $.table.selectFirstColumns();
                    if (id.length == 0) {
                        $.modal.alertWarning("请至少选择一条记录");
                        return;
                    }
                    var data = {"id": id[0]};
                    $.operate.submit(url, "post", "json", data);
                });
            },

            // 数据库备份+优化+修复
            database: function(url, title) {
                var rows = $.common.isEmpty($.table._option.uniqueId) ? $.table.selectFirstColumns() : $.table.selectColumns($.table._option.uniqueId);
                if (rows.length == 0) {
                    $.modal.alertWarning("请至少选择一条记录");
                    return;
                }
                $.modal.confirm("确认要" + title + "选中的" + rows.length + "条数据吗?", function () {
                    var data = { "id": rows.join() };
                    $.operate.submit(url, "post", "json", data);
                });
            },

            // 提交数据
            submit: function(url, type, dataType, data, callback) {
                var config = {
                    url: url,
                    type: type,
                    dataType: dataType,
                    data: data,
                    beforeSend: function () {
                        // "正在处理中，请稍后..."
                    },
                    success: function(result) {
                        if (typeof callback == "function") {
                            callback(result);
                        }
                        $.operate.ajaxSuccess(result);
                    }
                };
                $.ajax(config)
            },

            // 保存信息 刷新表格
            save: function(url, data, callback) {
                var config = {
                    url: url,
                    type: "post",
                    dataType: "json",
                    data: data,
                    success: function(result) {
                        if (typeof callback == "function") {
                            callback(result);
                        }
                        $.operate.successCallback(result);
                    }
                };
                $.ajax(config)
            },

            // 成功回调执行事件（父窗体静默更新）
            successCallback: function(result) {
                if (result.code == 1) {
                    var parent = window.parent;
                    $.modal.close();
                    parent.$.modal.msgSuccess(result.msg);
                    parent.$.table.refresh();
                } else {
                    $.modal.alertError(result.msg);
                }
            },

            // 保存结果弹出msg刷新table表格
            ajaxSuccess: function (result) {
                if (result.error == 0 || result.code == 1) {
                    $.modal.msgSuccess(result.msg);
                    $.table.refresh();
                } else {
                    $.modal.alertError(result.msg);
                }
            },

			// 展开/折叠列表树
			treeStatus: function (result) {
				if ($('.treeStatus').hasClass('expandAll')) {
					$.btTable.treegrid('collapseAll');
					$('.treeStatus').removeClass('expandAll')
				} else {
					$.btTable.treegrid('expandAll');
					$('.treeStatus').addClass('expandAll')
				}
			},

		},

		// 通用方法封装处理
		common: {
			// 判断字符串是否为空
			isEmpty: function (value) {
				if (value == null || this.trim(value) == "") {
					return true;
				}
				return false;
			},
			// 判断一个字符串是否为非空串
			isNotEmpty: function (value) {
				return !$.common.isEmpty(value);
			},
			// 空格截取
			trim: function (value) {
				if (value == null) {
					return "";
				}
				return value.toString().replace(/(^\s*)|(\s*$)|\r|\n/g, "");
			},
			// 比较两个字符串（大小写敏感）
			equals: function (str, that) {
				return str == that;
			},
			// 比较两个字符串（大小写不敏感）
			equalsIgnoreCase: function (str, that) {
				return String(str).toUpperCase() === String(that).toUpperCase();
			},
			// 将字符串按指定字符分割
			split: function (str, sep, maxLen) {
				if ($.common.isEmpty(str)) {
					return null;
				}
				var value = String(str).split(sep);
				return maxLen ? value.slice(0, maxLen - 1) : value;
			},
			// 字符串格式化(%s )
			sprintf: function (str) {
				var args = arguments, flag = true, i = 1;
				str = str.replace(/%s/g, function () {
					var arg = args[i++];
					if (typeof arg === 'undefined') {
						flag = false;
						return '';
					}
					return arg;
				});
				return flag ? str : '';
			},
			// 数组去重
			uniqueFn: function(array) {
				var result = [];
				var hashObj = {};
				for (var i = 0; i < array.length; i++) {
					if (!hashObj[array[i]]) {
						hashObj[array[i]] = true;
						result.push(array[i]);
					}
				}
				return result;
			},
			// 获取form下所有的字段并转换为json对象
			formToJSON: function(formId) {
				var json = {};
				$.each($("#" + formId).serializeArray(), function(i, field) {
					json[field.name] = field.value;
				});
				return json;
			},
            // pjax跳转页
            jump: function (url) {
                $.pjax({url: url, container: '.content-wrapper'})
                //window.location.href = url;
            },
			// 序列化表单，不含空元素
			serializeRemoveNull: function (serStr) {
				// return serStr.split("&").filter(str => !str.endsWith("=")).join("&"); // 不兼容ie
				return serStr.split("&").filter(function (item) {
						var itemArr = item.split('=');
						if(itemArr[1]){
							return item;
						}
					}
				).join("&");
			},
		}

	});
})(jQuery);