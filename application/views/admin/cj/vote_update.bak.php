<?php $result = $result[0];?>
<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">
				<div class="tables">
					<div class="panel-body widget-shadow">
						<ul id="myTab" class="nav nav-tabs">
							<li class="active"><a href="#home" data-toggle="tab">采集网址规则</a></li>
							<li><a href="#ios" data-toggle="tab">采集内容规则</a></li>
							<li><a href="#" data-toggle="tab">发布内容设置</a></li>
						</ul>
						<div class="form-body" data-example-id="simple-form-inline">
						<?php
		                    $this->load->helper('form');
		                ?>
						<?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
						
						<form action="<?php echo base_url();?>manage/cj/article1/update" method="post" class="form-horizontal" role="form">
							<div class="form-group">
					        <label for="name">采集任务名称</label> 
					        <input type="text" class="form-control" id="name" name="title" placeholder="请输入名称" value="<?=$result->title;?>">
					       </div>
					      <div class="form-group">
					        <label for="name">地址格式 <a href="javascript:void(0);" onclick="insertAtCursor('a_www', '(*)');">
					        <span style="color: red"> 插入(*) </span></a></label> 
					        <input type="text" class="form-control" name="a_www" id="a_www" value="<?=$result->a_www;?>">
					      </div>
					      <div class="form-group">
						     <div class="col-md-2">
                            <label class="checkbox inline" for="optype_1">
						      <input type="radio" name="a_bi" value="1" id="optype_1" <?php if ($result->a_bi == "1"){ echo 'checked="checked"';} ?>>
						     	等差数列
						    </label>
						    </div>
                            <div class="col-md-2">
                                <input class="form-control input-sm" type="text" name="a_chaone" id="a_chaone" value="<?=$result->a_chaone?>"/>
                            	<p class="help-block">首项</p>
                            </div>
                            <div class="col-md-2">
                                <input class="form-control input-sm" type="text" name="a_chanum" id="a_chanum" value="<?=$result->a_chanum?>" />
                            	<p class="help-block">项数</p>
                            </div>
                            <div class="col-md-2">
                                <input class="form-control input-sm" type="text" name="a_chacommon" id="a_chacommon" value="<?=$result->a_chacommon?>"/>
                            	<p class="help-block">等差</p>
                            </div>
                            <div class="col-md-2">
                            <label class="checkbox inline" for="a_chacheckbox">
						      <input type="checkbox" name="a_chacheckbox" id="a_chacheckbox" value="1" <?php //if ($result->a_chacheckbox == "1"){ echo 'checked="checked"';} ?>>
						     	 倒序
						    </label>
						    </div>
                        	</div> 
                        	<div class="form-group">
						    <div class="col-md-2">
                            <label class="checkbox inline" for="optype_2">
						      <input type="radio" name="a_bi" value="2" id="optype_2" <?php if ($result->a_bi == "2"){ echo 'checked="checked"';} ?>>
						     	等比数列
						    </label>
						    </div>
                            <div class="col-md-2">
                                <input class="form-control input-sm" type="text"  name="a_bione" id="a_bione" value="<?=$result->a_bione?>"/>
                            	<p class="help-block">首项</p>
                            </div>
                            <div class="col-md-2">
                                <input class="form-control input-sm" type="text"  name="a_binum" id="a_binum"  value="<?=$result->a_binum?>"/>
                            	<p class="help-block">项数</p>
                            </div>
                            <div class="col-md-2">
                                <input class="form-control input-sm" type="text"  name="a_bicommon" id="a_bicommon" value="<?=$result->a_bicommon?>"/>
                            	<p class="help-block">等比</p>
                            </div>
                            <div class="col-md-2">
                            <label class="checkbox inline" for="click_2">
						      <input type="checkbox" name="a_bicheckbox" id="click_2" value="2" <?php //if ($result->a_bicheckbox == "2"){ echo 'checked="checked"';} ?>>
						     	 倒序
						    <button type="button" class="btn btn-default" onclick="cj_test('测试网址规则列表');return false;">测试</button> 
						    </label>
						    </div>
                        	</div>
                        	
                        	<div class="form-group">
					        <label for="name">内容页网址规则</label> 
					        </div>
					        <div class="form-group">
					        <div class="col-md-2">
	                            <label class="checkbox inline" for="dom">
							      <input type="radio" name="dom" id="dom" value="0" <?php if ($result->dom == "0"){ echo 'checked="checked"';} ?>>
							     	dom采集 
							    </label>
							    </div>
								<div class="col-sm-10">
									<input type="text" name="click_dom" class="form-control" value="<?=$result->click_dom?>">
									<p class="help-block">div.class  div#id div[!id]</p>
								</div>
							</div>
							<div class="form-group">
					        <div class="col-md-2">
	                            <label class="checkbox inline" for="dom-1">
							      <input type="radio" name="dom" id="dom-1" value="1"  <?php if ($result->dom == "1"){ echo 'checked="checked"';} ?>>
							     	字符串采集
							    </label>
							    </div>
								<div class="col-sm-10">
									<input type="text" name="click_str" id="click_str" class="form-control" value="<?=$result->click_str?>">
									<p class="help-block" onclick="insertAtCursor('click_str', '[click]');">插入[click]</p>
								</div>
							</div>
					      <div class="form-group">
                            <div class="col-md-4">
                                <input class="form-control input-sm" type="text"  name="click_bh" value="<?=$result->click_bh?>"/>
                            	<p class="help-block">必须包含</p>
                            </div>
                            <div class="col-md-4">
                                <input class="form-control input-sm" type="text" name="click_nobh" value="<?=$result->click_nobh?>"/>
                            	<p class="help-block">不得包含</p>
                            </div>
                            <div class="col-md-4">
                                <input class="form-control input-sm" type="text" name="click_host" value="<?=$result->click_host?>"/>
                            	<p class="help-block">主 机 名</p>
                            </div>
                        	</div>
					      <input type="hidden" size="30" value="<?=$result->id?>" name="id">
					      <input type="hidden" value="<?=$result->uid?>" name="uid">
					       <button type="submit" class="btn btn-default">保存</button> <button type="submit" class="btn btn-default">测试</button>
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
<script type="text/javascript"
	src="<?php echo base_url();?>static/cj/common/js/caiji.js" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>static/layui/layui.js" charset="utf-8"></script>
<script>
layui.use(['layer', 'laydate'], function(){
	var $ = layui.jquery
		,layer = layui.layer
	,laydate = layui.laydate;
});
</script>
