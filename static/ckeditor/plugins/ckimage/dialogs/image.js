CKEDITOR.dialog.add( 'ckimage', 
	function(a) { 
    return {  
        title: "图片在线管理",  
        minWidth: "660px",  
        minHeight:"400px",  
        contents: [{  
            id: "tab1",  
            label: "",  
            title: "",  
            expand: true,  
            width: "420px",  
            height: "300px",  
            padding: 0,  
            elements: [{  
                type: "html",  
                style: "width:660px;height:400px",  
                html: '<iframe id="uploadFrame" src="" frameborder="0"></iframe>'  
            }]  
        }],  
        onLoad: function () {
            //alert('onLoad');
        },
        onHide: function () {
            //alert('onHide');
        },
        // when the dialog ended width ensure,"onOK" will be executed.
        onOk: function() {
        	var ins = a;  
            var num = window.imgs.size();
            var imgHtml = "";
           img = window.imgs.getAll();
           var x;
           for (x in img)
           {
        	   if(img[x]){
        		   imgHtml += "<p><img src=\"" + img[x] + "\"/></p>"; 
        	   } 
           }
           ins.insertHtml(imgHtml);  
        },
        onCancel: function () {
            //alert('onCancel');
        },  
        onShow: function () {  
            document.getElementById("uploadFrame").setAttribute("src",CKEDITORURL + "manage/upload/more_upload?v=" +new Date().getSeconds());  
        }  
    }  
});  