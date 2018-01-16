<style>
<!--
.form-control1, .form-control_2.input-sm {
    height: 32px;
}

.th {
    font-size: 16px;
    font-weight: bold;
    line-height: 1.5;
    margin-left: 14px
}
-->
</style>
<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">
				<div class="forms">
					<div class="widget-shadow">
						<?php
                    $this->load->helper('form');
                ?>
						<?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
						<div class="form-body" data-example-id="simple-form-inline">
						<form role="form" action="<?php echo base_url() ?>manage/vote/update" method="post" id="addvote" role="form">
						<div class="row">
							<div class="col-md-5 grid_box1">
								<div class="form-group"> <label for="ftitle">标题</label> 
								<input type="text" class="form-control" id="title" placeholder="" name="title" required lay-verify="required"  value="<?php echo $article['title']?>"> </div>
								<div class="form-group"> <label for="date">开始日期</label> <input name="statdate" placeholder="自定义日期格式" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})"
					type="text" class="form-control"  required lay-verify="required" id="date" value="<?php echo date('Y-m-d H:m:s',$article['statdate']);?>"></div>
							</div>
							<div class="col-md-7">
								<div class="form-group"> <label for="role">分类</label> 
									<select id="catid" name="catid" class="form-control1">
		                                <option value="1"  <?php if ($article['catid'] === '1'): ?>selected="selected"<?php endif; ?>>2014</option>
		                                <option value="2" <?php if ($article['catid'] === '2'): ?>selected="selected"<?php endif; ?>>2015</option>
									</select> </div>
								<div class="form-group"> <label for="date">结束日期</label> <input name="enddate" placeholder="自定义日期格式" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})"
					type="text" class="form-control"  required lay-verify="required" id="date" value="<?php echo date('Y-m-d H:m:s',$article['enddate']);?>"></div>									
							</div>
						</div>
						<div class="weui_cell">
								<div class="weui_cell_bd weui_cell_primary">
									<div class="weui_uploader">
										<div class="weui_uploader_bd">
											<ul class="weui_uploader_files" id="img">
											<?php 
										$img = explode(",", $article['imgurl']);
									?>
									<?php foreach($img as $v):?>
									<li class="weui_uploader_file weui_uploader_status">
										<div class="ui-grid-halve-img fa fa-file-pdf-o">
											<img src="<?php echo $v; ?>">
										</div>
										<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
									</li>
									<?php endforeach;?>
											</ul>
											<div class="weui_uploader_input_wrp"></div>
									    </div>
								     </div>
							    </div>
						</div>
						<label for="role" class="th">投票简介</label>
						<textarea cols="40" rows="10" name="info" id="info" required lay-verify="required" verify="info"><?php echo $article['info']?></textarea>
						<div class="clearfix"> </div>
						<label for="role" class="th">投票说明</label>
						<textarea cols="40" rows="3" name="infosm" id="infosm" lay-verify="contact" verify="infosm"><?php echo $article['infosm']?></textarea>
						<div class="clearfix"> </div>
						<label for="role"  class="th">奖品说明</label>
						<textarea cols="40" rows="3" name="infojp" id="infojp" lay-verify="contact" verify="infojp"><?php echo $article['infojp']?></textarea>
						
								<div class="form-group"> <label for="gender"></label> 
										<div class="radio">
											<label style="padding-right: 5px">
											  <input type="radio" name="cknums" value="0" <?php if ($article['cknums'] === '0'): ?>checked="checked"<?php endif; ?>>
											 单人投票
											</label>
											<label  style="padding-right: 40px">
											<input type="radio" name="cknums" value="1" <?php if ($article['cknums'] === '1'): ?>checked="checked"<?php endif; ?>>
											多人投票
											</label>
											<label style="padding-right: 5px">
											  <input type="radio" name="votelimit" value="0" <?php if ($article['votelimit'] === '0'): ?>checked="checked"<?php endif; ?>>
											 每天投一票
											</label>
											<label>
											<input type="radio" name="votelimit"value="1" <?php if ($article['votelimit'] === '1'): ?>checked="checked"<?php endif; ?>>
											每小时投一票
											</label>
										</div>
								</div>
								<input type="hidden" id="goods_pic" name="imgurl" required lay-verify="required" value="<?=$article['imgurl']?>">
								<input name="id" type="hidden" required lay-verify="required" value="<?=$article['id']?>">
								<div class="col-sm-offset-2"> <button type="submit" class="btn btn-default">提交</button> </div>
							
						</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--footer-->
		<div class="footer">
		   <p>Copyright &copy; 2017.Company name All rights reserved.More Templates <a href="http://www.cssmoban.com/" target="_blank" title="模板之家">模板之家</a> - Collect from <a href="http://www.cssmoban.com/" title="网页模板" target="_blank">网页模板</a></p>
		</div>
        <!--//footer-->
	<!-- Classie -->

<script src="<?php echo base_url(); ?>static/ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url(); ?>static/layui/layui.js" charset="utf-8"></script>
<script type="text/javascript">
	var aid = 3;
	var CKEDITORURL = '<?php echo base_url(); ?>';
	$('.ui-grid-halve-img').on('click', function(){
		var li = $(this).parent("li");
		li.remove();
	});
	layui.use(['layer', 'laydate'], function(){
		var $ = layui.jquery
  		,layer = layui.layer
		,laydate = layui.laydate;
	$("form").submit(function(e){
		var imgsrc = "";
		$('#img').find("img").each(function(){
        	imgsrc += $(this).attr("src") + ",";
    	});
		$("#goods_pic").val(imgsrc.substring(0,imgsrc.length-1));
	});
	$('.weui_uploader_input_wrp').on('click', function(){
	layer.open({
		type: 2,
		title: '图片管理',
		maxmin: true,
		shadeClose: true, //点击遮罩关闭层
		area : ['600px' , '420px'],
		content: '<?php echo base_url(); ?>manage/upload/img_list'
			});
		});
	});
</script>
<script type="text/JavaScript" language="javascript">
	var filebrowserUploadUrl = "<?php echo base_url(); ?>manage/upload/more_upload";
	CKEDITOR.replace( 'info', {
		uiColor: '#CCEAEE'
	} );
	CKEDITOR.replace( 'infosm', {
		uiColor: '#CCEAEE'
	} );
	CKEDITOR.replace( 'infojp', {
		uiColor: '#CCEAEE'
	} );
	//自定义字典对象
	function Dictionary() {
		this.data = new Array();

		this.put = function(key, value) {
			this.data[key] = value;
		};

		this.get = function(key) {
			return this.data[key];
		};
		this.getAll = function() {
			return this.data;
		};
		this.remove = function(key) {
			this.data[key] = null;
		};

		this.isEmpty = function() {
			return this.data.length == 0;
		};

		this.size = function() {
			return this.data.length;
		};
	}

	//使用 例子
	var imgs = new Dictionary(); 
</script>
<!-- main 开始 -->
<style>
	.weui_cell {
		padding: 10px 15px;
		position: relative;
		display: -webkit-box;
		display: -webkit-flex;
		display: flex;
		-webkit-box-align: center;
		-webkit-align-items: center;
		align-items: center;
	}

	.weui_cells {
		background-color: #fff;
		line-height: 1.41176471;
		font-size: 17px;
		overflow: hidden;
		position: relative;
	}

	.weui_cell_primary {
		-webkit-box-flex: 1;
		-webkit-flex: 1;
		flex: 1;
	}

	.weui_uploader_hd {
		padding-top: 0;
		padding-right: 0;
		padding-left: 0;
	}

	.weui_uploader_bd {
		margin-bottom: -4px;
		margin-right: -9px;
		overflow: hidden;
	}

	.weui_uploader_files {
		list-style: none;
	}

	.weui_uploader_file {
		float: left;
		margin-right: 9px;
		margin-bottom: 9px;
		width: 79px;
		height: 79px;
		background: no-repeat 50%;
		background-size: cover;
	}

	.weui_uploader_file img {
		float: left;
		margin-right: 9px;
		margin-bottom: 9px;
		width: 79px;
		height: 79px;
		background: no-repeat 50%;
		background-size: cover;
	}

	.weui_uploader_status .weui_uploader_status_content {
		position: absolute;
		top: 50%;
		left: 50%;
		-webkit-transform: translate(-50%, -50%);
		transform: translate(-50%, -50%);
		color: #fff;
	}

	.weui_cells_form input, .weui_cells_form label[for], .weui_cells_form textarea {
		-webkit-tap-highlight-color: rgba(0, 0, 0, 0);
	}

	.weui_uploader_input {
		position: absolute;
		z-index: 1;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		opacity: 0;
		-webkit-tap-highlight-color: rgba(0, 0, 0, 0);
	}
	.weui_uploader_input_wrp {
		float: left;
		position: relative;
		margin-right: 9px;
		margin-bottom: 9px;
		width: 77px;
		height: 77px;
		border: 1px solid #d9d9d9;
	}
	.weui_uploader_input_wrp:before, .weui_uploader_input_wrp:after {
		content: " ";
		position: absolute;
		top: 50%;
		left: 50%;
		-webkit-transform: translate(-50%, -50%);
		transform: translate(-50%, -50%);
		background-color: #D9D9D9;
	}

	.weui_uploader_input_wrp:before {
		width: 2px;
		height: 39.5px;
	}

	.weui_uploader_input_wrp:active:before, .weui_uploader_input_wrp:active:after {
		background-color: #999999;
	}

	.weui_uploader_input_wrp:after {
		width: 39.5px;
		height: 2px;
	}
	.ui-grid-trisect-img, .ui-grid-halve-img {
    position: relative;
    width: 100%;
	}
	.ui-tag-selected:after {
		font-family: iconfont !important;
		font-size: 22px;
		line-height: 20px;
		font-style: normal;
		-webkit-font-smoothing: antialiased;
		-webkit-text-stroke-width: .2px;
		display: block;
		color: rgba(0,0,0,.5);
		position: absolute;
	}
	.ui-tag-selected:after {
		content: "+";
		color: #ef380d;
		right: -5px;
		top: -1px;
		z-index: 9;
		width: 20px;
		height: 20px;
		background: #fff;
		border-radius: 13px;
		line-height: 20px;
		text-indent: -3px;
	}
</style>
