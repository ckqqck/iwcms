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
						
						<form action="<?php echo base_url();?>manage/cj/article/update" method="post" class="form-horizontal" role="form">
							<div class="form-group">
					        <label for="name">采集任务名称</label> 
					        <input type="text" class="form-control" id="name" name="title" placeholder="请输入名称">
					       </div>
					      <div class="form-group">
					        <label for="name">地址格式</label> 
					        <input type="text" class="form-control" name="a_www" id="www" value="">
					      </div>
					      <div class="form-group">
						     <div class="col-md-2">
                            <label class="checkbox inline" for="optype_1">
						      <input type="radio" name="a_bi" value="1" id="optype_1" checked="checked">
						     	等差数列
						    </label>
						    </div>
                            <div class="col-md-2">
                                <input class="form-control input-sm" type="text" name="a_chaone" value="1"/>
                            	<p class="help-block">首项</p>
                            </div>
                            <div class="col-md-2">
                                <input class="form-control input-sm" type="text" name="a_chanum" value="10"/>
                            	<p class="help-block">项数</p>
                            </div>
                            <div class="col-md-2">
                                <input class="form-control input-sm" type="text" name="a_chacommon" value="1"/>
                            	<p class="help-block">等差</p>
                            </div>
                            <div class="col-md-2">
                            <label class="checkbox inline" for="a_chacheckbox">
						      <input type="checkbox" name="a_chacheckbox" id="a_chacheckbox" value="1">
						     	 倒序
						    </label>
						    </div>
                        	</div> 
                        	<div class="form-group">
						    <div class="col-md-2">
                            <label class="checkbox inline" for="optype_2">
						      <input type="radio" name="a_bi" id="optype_2" value="2">
						     	等比数列
						    </label>
						    </div>
                            <div class="col-md-2">
                                <input class="form-control input-sm" type="text" value="1"/>
                            	<p class="help-block">首项</p>
                            </div>
                            <div class="col-md-2">
                                <input class="form-control input-sm" type="text" value="10"/>
                            	<p class="help-block">项数</p>
                            </div>
                            <div class="col-md-2">
                                <input class="form-control input-sm" type="text" value="2"/>
                            	<p class="help-block">等比</p>
                            </div>
                            <div class="col-md-2">
                            <label class="checkbox inline" for="click_2">
						      <input type="checkbox" name="a_bicheckbox" id="click_2" value="2">
						     	 倒序
						    </label>
						    </div>
                        	</div> 
                        	<div class="form-group">
					        <label for="name">内容页网址规则</label> 
					        </div>
					        <div class="form-group">
					        <div class="col-md-2">
	                            <label class="checkbox inline" for="dom">
							      <input type="radio" name="dom" id="dom" value="0" checked="checked">
							     	dom采集 
							    </label>
							    </div>
								<div class="col-sm-10">
									<input type="text" name="click_dom" class="form-control">
									<p class="help-block">div.class  div#id div[!id]</p>
								</div>
							</div>
							<div class="form-group">
					        <div class="col-md-2">
	                            <label class="checkbox inline" for="dom-1">
							      <input type="radio" name="dom" id="dom-1" value="1">
							     	字符串采集
							    </label>
							    </div>
								<div class="col-sm-10">
									<input type="text" name="click_str" class="form-control">
									<p class="help-block">插入[click]</p>
								</div>
							</div>
					      <div class="form-group">
                            <div class="col-md-4">
                                <input class="form-control input-sm" type="text"  name="click_bh" value=""/>
                            	<p class="help-block">必须包含</p>
                            </div>
                            <div class="col-md-4">
                                <input class="form-control input-sm" type="text" name="click_nobh" value=""/>
                            	<p class="help-block">不得包含</p>
                            </div>
                            <div class="col-md-4">
                                <input class="form-control input-sm" type="text" name="click_host" value=""/>
                            	<p class="help-block">主 机 名</p>
                            </div>
                        	</div>
					      <input type="hidden" size="30" value="18" name="id">
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