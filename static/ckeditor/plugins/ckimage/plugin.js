CKEDITOR.plugins.add('ckimage', {

	init : function(editor)

	{

		// plugin code goes here
		var pluginName = 'ckimage';
		CKEDITOR.dialog.add(pluginName, this.path + 'dialogs/image.js');

		editor.addCommand(pluginName, new CKEDITOR.dialogCommand(pluginName));

		editor.ui.addButton('Ckimage',
		{
			label : '图片在线管理',
			command : pluginName,
			icon: this.path + 'images/noimage.png'
		});

	}
});