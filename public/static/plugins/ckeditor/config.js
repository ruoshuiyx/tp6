CKEDITOR.editorConfig = function( config ) {
	config.toolbarGroups = [
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] }
	];

	config.removeButtons = 'Save,NewPage,Preview,Cut,Copy,Paste,PasteText,PasteFromWord,Undo,Redo,Find,Replace,SelectAll,Scayt,Form,Checkbox,TextField,Radio,Textarea,Select,Button,ImageButton,HiddenField,CreateDiv,Blockquote,Language,Anchor,Flash,Smiley,SpecialChar,Iframe,ShowBlocks,About,Styles,Subscript,Superscript';

	// 上传图片路径
    config.filebrowserImageUploadUrl = "../upload/index?from=ckeditor";
	
	// 默认不带高度
	config.disallowedContent = 'img{width,height};img[width,height]';
	
	// 字体
	config.font_names = '微软雅黑/Microsoft YaHei;宋体/SimSun;新宋体/NSimSun;仿宋/FangSong;楷体/KaiTi;黑体/SimHei;' + config.font_names;
	
	// 关闭内容过滤器
	config.allowedContent = true;
	
	// 缩进
	config.indentOffset = 2;
	config.indentUnit = 'em';
	config.getComputedStyle = 2;
	
	//config.fontSize_defaultLabel = '14px';
};