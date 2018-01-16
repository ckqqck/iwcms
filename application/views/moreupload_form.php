<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title></title>
<base href="<?php echo base_url();?>" />
<script type="text/javascript" charset="utf-8" src="<?php echo base_url();?>static/admin/js/jquery-1.11.1.min.js"></script>
<script src="<?php echo base_url();?>static/layui/layui.js"></script>
<style>
body {
	margin: 0px auto;
}

html {
	font-size: 14px;
	color: #000;
	font-family: '微软雅黑'
}

a, a:hover {
	text-decoration: none;
}

pre {
	font-family: '微软雅黑'
}

.box {
	padding: 20px;
	background-color: #fff;
	margin: 50px 100px;
	border-radius: 5px;
}

.box a {
	padding-right: 15px;
}

#about_hide {
	display: none
}

.layer_text {
	background-color: #fff;
	padding: 20px;
}

.layer_text p {
	margin-bottom: 10px;
	text-indent: 2em;
	line-height: 23px;
}

.button {
	display: inline-block;
	*display: inline;
	*zoom: 1;
	line-height: 30px;
	padding: 0 20px;
	background-color: #56B4DC;
	color: #fff;
	font-size: 14px;
	border-radius: 3px;
	cursor: pointer;
	font-weight: normal;
}

.photos-demo img {
	width: 200px;
}

.layui-upload-button {
	position: relative;
	display: inline-block;
	vertical-align: middle;
	min-width: 60px;
	height: 36px;
	line-height: 36px;
	border: 1px solid #DFDFDF;
	border-radius: 2px;
	overflow: hidden;
	background-color: #fff;
	color: #666;
}

.layui-btn, .layui-input, .layui-textarea, .layui-upload-button {
	outline: 0;
	-webkit-transition: border-color .3s cubic-bezier(.65, .05, .35, .5);
	transition: border-color .3s cubic-bezier(.65, .05, .35, .5);
	-webkit-box-sizing: border-box !important;
	-moz-box-sizing: border-box !important;
	box-sizing: border-box !important;
}

.layui-upload-icon {
	display: block;
	margin: 0 15px;
	text-align: center;
}

.layui-upload-icon i {
	margin-right: 5px;
	vertical-align: top;
	font-size: 20px;
	color: #5FB878;
}

.layui-form-item:after {
	content: '\20';
	clear: both;
	display: block;
	height: 0;
}

.weui-uploader__file_status {
	position: relative; &: before { content : " ";
	position: absolute;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	background-color: rgba(0, 0, 0, .5);
}

.weui-uploader__file-content {
	display: block;
}

}
.weui-uploader__file-content {
	display: none;
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
	color: #FFFFFF;
	.
	weui-icon-warn
	{
	display
	:
	inline-block;
}

}
.weui-uploader__input {
	position: absolute;
	z-index: 1;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	opacity: 0;
	.
	setTapColor
	();
}

.weui-cells {
	background-color: #FFFFFF;
	line-height: 1.47058824;
	font-size: 17px;
	overflow: hidden;
	position: relative;
}

.weui-cells:before {
	content: " ";
	position: absolute;
	left: 0;
	top: 0;
	right: 0;
	height: 1px;
	border-top: 1px solid #e5e5e5;
	color: #e5e5e5;
	-webkit-transform-origin: 0 0;
	transform-origin: 0 0;
	-webkit-transform: scaleY(0.5);
	transform: scaleY(0.5);
	z-index: 2;
}

.weui-cell {
	padding: 10px 15px;
	position: relative;
	display: -webkit-box;
	display: -webkit-flex;
	display: flex;
	-webkit-box-align: center;
	-webkit-align-items: center;
	align-items: center;
}

.weui-cell__bd {
	-webkit-box-flex: 1;
	-webkit-flex: 1;
	flex: 1;
}

.weui-uploader__hd {
	display: -webkit-box;
	display: -webkit-flex;
	display: flex;
	padding-bottom: 10px;
	-webkit-box-align: center;
	-webkit-align-items: center;
	align-items: center;
}

.weui-uploader__bd {
	margin-bottom: -4px;
	margin-right: -9px;
	overflow: hidden;
}

.weui-uploader__files {
	list-style: none;
}

.weui-uploader__file {
	position: relative;
	float: left;
	margin-right: 9px;
	margin-bottom: 9px;
	width: 113px;
	height: 113px;
	background: no-repeat center center;
	background-size: cover;
}

.weui-uploader__file img {
	float: left;
	width: 113px;
	height: 113px;
}

.weui-uploader__input-box {
	float: left;
	position: relative;
	margin-right: 9px;
	margin-bottom: 9px;
	width: 111px;
	height: 111px;
	border: 1px solid #D9D9D9;
}

.weui-uploader__input-box:before {
	width: 2px;
	height: 39.5px;
}

.weui-uploader__input-box:before, .weui-uploader__input-box:after {
	content: " ";
	position: absolute;
	top: 50%;
	left: 50%;
	-webkit-transform: translate(-50%, -50%);
	transform: translate(-50%, -50%);
	background-color: #D9D9D9;
}

.weui-cells_form input, .weui-cells_form textarea, .weui-cells_form label[for]
	{
	-webkit-tap-highlight-color: rgba(0, 0, 0, 0);
}

.weui-uploader__input-box:before, .weui-uploader__input-box:after {
	content: " ";
	position: absolute;
	top: 50%;
	left: 50%;
	-webkit-transform: translate(-50%, -50%);
	transform: translate(-50%, -50%);
	background-color: #D9D9D9;
}

.weui-uploader__input-box:before, .weui-uploader__input-box:after {
	content: " ";
	position: absolute;
	top: 50%;
	left: 50%;
	-webkit-transform: translate(-50%, -50%);
	transform: translate(-50%, -50%);
	background-color: #D9D9D9;
}

.weui-uploader__input {
	position: absolute;
	z-index: 1;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	opacity: 0;
	-webkit-tap-highlight-color: rgba(0, 0, 0, 0);
}

.weui-uploader__input-box:active:before, .weui-uploader__input-box:active:after
	{
	background-color: #999999;
}

.weui-uploader__input-box:after {
	width: 39.5px;
	height: 2px;
}

.weui-uploader__input-box:before, .weui-uploader__input-box:after {
	content: " ";
	position: absolute;
	top: 50%;
	left: 50%;
	-webkit-transform: translate(-50%, -50%);
	transform: translate(-50%, -50%);
	background-color: #D9D9D9;
}

.layui-upload-iframe {
	position: absolute;
	width: 0;
	height: 0;
	border: 0;
	visibility: hidden;
}

.weui-tabbar {
	position: absolute;
	z-index: 500;
	bottom: 0;
	width: 96%;
	background-color: #F7F7FA;
}

#html {
	margin-bottom: 40px;
}

#uploaderFiles li.selected .icon {
	background-image: url(<?php echo base_url();?>static/success.png);
	background-image: url(<?php echo base_url();?>static/success.png) \9;
	background-position: 75px 75px;
}

#uploaderFiles li .icon {
	cursor: pointer;
	width: 113px;
	height: 113px;
	position: absolute;
	top: 0;
	left: 0;
	z-index: 2;
	border: 0;
	background-repeat: no-repeat;
}
</style>
</head>
<body>
	<div class="weui-cells weui-cells_form" id="html">
		<div class="weui-cell">
			<div class="weui-cell__bd">
				<div class="weui-uploader">
					<div class="weui-uploader__bd">
						<ul class="weui-uploader__files" id="uploaderFiles">
							<?php foreach ($result as $v):?>
							<li class="weui-uploader__file">
								 <img data-id="<?=$v['id']?>" src="<?=imgurl($v['imgpath'])?>">
								<span class="icon"></span>
							</li>	
							<?php endforeach;?>
						</ul>
						<div class="weui-uploader__input-box">
							<form target="layui-upload-iframe" method="post" key="set-mine"
								enctype="multipart/form-data" action="">
								<input required type="file" name="userfile[]" lay-ext="gif|jpg|png"  multiple
									class="layui-upload-file weui-uploader__input" value="">
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<script>
var CKEDITORURL = '<?php echo base_url(); ?>';
layui.use(['form','upload', 'jquery', 'layer','flow'], function(){
  var form = layui.form(),
  $=layui.jquery,
  layer=layui.layer,
  upload=layui.upload,
  flow = layui.flow;
  layui.upload({
	  url: '<?php echo base_url();?>manage/upload/layui_moreupload?aid=' + parent.aid
	  ,unwrap:true
	  ,before: function(input){
		//返回的参数item，即为当前的input DOM对象
		console.log('文件上传中');
	  }
	  ,success: function(res){
		  for (key in res){
				if(res[key].code==0){
					$("#uploaderFiles").append('<li class="weui-uploader__file"><img data-id="' + res[key].data.id+ '" src="'+res[key].data.url+'" _src="'+res[key].data.url+'"/><span class="icon"></span></li>');
					parent.top.imgs.put(res[key].data.id,res[key].data.url); 
				}else{
					layer.msg(res.msg);
				}
			}
			console.log('上传完毕');
	  }
  });
});
</script>
<script type="text/javascript">
$('#uploaderFiles').on('click', function (e) {	
		var target = e.target || e.srcElement,
        li = target.parentNode;
    if (li.tagName.toLowerCase() == 'li') {
        if ($(li).hasClass('selected')) {
        	$(li).removeClass('selected'); 
        	var img = $(li).find("img");
    		id = $(img).attr("data-id");
    		parent.imgs.remove(id);       	
        } else {
        	$(li).addClass('selected');
        	if($(li).find("img")){
        		var img = $(li).find("img");
        		id = $(img).attr("data-id");
        		src = $(img).attr("src");
        		parent.imgs.put(id,src);
        	}        	
        }
    }
 });
</script>
</body>
</html>