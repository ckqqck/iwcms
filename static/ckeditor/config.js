/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	config.language = 'zh-cn';
	config.extraPlugins = 'ckimage';
	config.height = 200;
	config.toolbarCanCollapse = true;
	/**
	config.toolbar = [
	                  ['Source', '-', 'Bold', 'Italic'], ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord'], '/',
	                  ['Checkbox', 'Radio', 'TextField', 'Textarea', 'Select','Button']
	                  ];
	config.toolbar = 'Basic';
	config.toolbar_Basic =[
	    ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'About']
	    ];
	*/
	config.toolbarGroups = [
	    { name: 'tools' },
	    { name: 'document', groups: [ 'mode'] },
		{ name: 'basicstyles', groups: [ 'Source','basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list',  'align'] },
		{ name: 'styles' },
		{ name: 'colors'},
		{ name: 'others' },
		 { name: 'about' }
	];
	 config.removeButtons = 'Save,Templates,Cut,Undo,Find,Scayt,SelectAll,Paste,Copy,Redo,NewPage,Preview,Print,Form,RemoveFormat,Link,Image,Outdent,BidiLtr,Blockquote,Styles,ShowBlocks,lineheight';
	 
	 //config.filebrowserImageUploadUrl = basePath + "/import/ckeditorUploadFile.action?type=Image"; //待会要上传的action或servlet
	 
};
