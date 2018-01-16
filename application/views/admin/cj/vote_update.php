<?php $result = $result[0];?>
<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">
				<div class="tables">
					<div class="panel-body widget-shadow">
						<ul id="myTab" class="nav nav-tabs">
							<li class="active"><a href="#tabwww" data-toggle="tab">采集网址规则</a></li>
							<li><a href="#tabcomment" data-toggle="tab">采集内容规则</a></li>
							<li><a href="#tabnew" data-toggle="tab">发布内容设置</a></li>
						</ul>
						<div class="form-body" data-example-id="simple-form-inline">
						<?php
		                    $this->load->helper('form');
		                ?>
						<?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
						<div id="myTabContent" class="tab-content">
						<div class="tab-pane fade in active" id="tabwww">
						<form action="<?php echo base_url();?>manage/cj/article1/update" method="post" class="form-horizontal" role="form">
							<div class="form-group">
					        <label for="name">采集任务名称</label> 
					        <input type="text" class="form-control" id="name" name="title" placeholder="请输入名称" value="<?=$result->title;?>">
					       </div>
					      <div class="form-group">
					        <label for="name">地址格式</label> 
					        <div class="input-group">
						        <input type="text" class="form-control" name="a_www" id="a_www" value="<?=$result->a_www;?>">
						      	<div class="input-group-btn">
			                            <a class="btn btn-default" onclick="insertAtCursor('a_www', '(*)');return false;">(*) </a> 
						    	</div>
					    	</div>
					      </div>
                        	
                        	<div class="form-group">
								<div class="input-group toggle_www">
			                        <div class="input-group-btn">
			                          <button type="button" class="btn btn-danger" aria-label="Bold" data-input="dom">等差</button>
			                          <button type="button" class="btn btn-default" aria-label="Italic" data-input="str">等比</button>
			                        </div>
			                        <div class="form-inline">
					                    <div class="col-md-2">
		                                <input class="form-control" type="text" name="a_chaone" id="a_chaone" value="<?=$result->a_chaone?>"/>
		                            	
			                            </div>
			                            <div class="col-md-2">
			                                <input class="form-control" type="text" name="a_chanum" id="a_chanum" value="<?=$result->a_chanum?>" />
			                            	
			                            </div>
			                            <div class="col-md-2">
			                                <input class="form-control" type="text" name="a_chacommon" id="a_chacommon" value="<?=$result->a_chacommon?>"/>
			                            	
			                            </div>			                            
		                            </div>
			                        <div class="form-inline">
		                            	<div class="col-md-2">
		                                <input class="form-control" type="text"  name="a_bione" id="a_bione" value="<?=$result->a_bione?>"/>
		                            	 </div>
		                            	<div class="col-md-2"><input class="form-control" type="text"  name="a_binum" id="a_binum"  value="<?=$result->a_binum?>"/>
			                             </div>
		                            	<div class="col-md-2"><input class="form-control" type="text"  name="a_bicommon" id="a_bicommon" value="<?=$result->a_bicommon?>"/>
			                             </div>
	                             </div>
	                             <div class="input-group-btn">
		                            <a class="btn btn-default" onclick="cj_test('测试网址规则列表');return false;">测试</a> 
					    		 </div>
	                        	</div>
                        	</div>
                        	<div class="form-group">
							<label>内容页网址规则</label>
							<div class="input-group toggle_click">
		                        <div class="input-group-btn">
		                          <button type="button" class="btn btn-danger" aria-label="Bold" data-input="dom">dom</button>
		                          <button type="button" class="btn btn-default" aria-label="Italic" data-input="str">STR</button>
		                        </div>
		                        <input type="text" class="form-control <?php if ($result->dom == "0") echo 'show'; ?>" name="click_dom" id="db_click_dom" value="<?=$result->click_dom?>">
		                        <input type="text" class="form-control hidden" name="click_str" id="db_click_str" value="<?=$result->click_str?>">
		                      	<div class="input-group-btn">
		                          <a class="btn btn-default"  onclick="insertAtCursor('db_click_str', '[click]');">[click]</a>
		                        </div>
	                     	 </div>
                        	</div>
                        	
					      <div class="form-group">
                            <div class="col-md-4">
                            <div class="input-group">
                                <input class="form-control" type="text"  name="click_bh" value="<?=$result->click_bh?>"/>
                            	<div class="input-group-btn">
		                          <a class="btn btn-default" href="javascript:;">必须包含</a>
		                        </div>
                            </div>
                            </div>
                            <div class="col-md-4">
                            	<div class="input-group">
                                <input class="form-control" type="text" name="click_nobh" value="<?=$result->click_nobh?>"/>
                            	<div class="input-group-btn">
		                          <a class="btn btn-default" href="javascript:;">不包含</a>
		                        </div>
                            </div>
                            </div>
                            <div class="col-md-4">
                            	<div class="input-group">
                                <input class="form-control" type="text" name="click_host" value="<?=$result->click_host?>"/>
                            	<div class="input-group-btn">
		                          <a class="btn btn-default" href="javascript:;">主机名</a>
		                        </div>
                            </div>
                            </div>
                        	</div>
					      <input type="hidden" size="30" value="<?=$result->id?>" name="id">
					      <input type="hidden" value="<?=$result->uid?>" name="uid">
					       <button type="submit" class="btn btn-default">保存</button> <button type="submit" class="btn btn-default">测试</button>
		                </form>
		                </div>
		                
		                
		                <div class="tab-pane fade" id="tabcomment">
						<form action="<?php echo base_url();?>manage/cj/article1/update" method="post" class="form-horizontal" role="form" novalidate="true">
						<div class="form-group">
							<label>标题</label>
							<div class="input-group toggle_title">
		                        <div class="input-group-btn">
		                          <button type="button" class="btn btn-danger" aria-label="Bold" data-input="dom">dom</button>
		                          <button type="button" class="btn btn-default" aria-label="Italic" data-input="str">STR</button>
		                        </div>
		                        <input type="text" class="form-control show" name="db_title_dom" id="db_title_dom" value="dom">
		                        <input type="text" class="form-control hidden" name="db_title_str" id="db_title_str" value="str">
		                      	<div class="input-group-btn">
		                          <a class="btn btn-default"  onclick="insertAtCursor('db_title_str', '[title]');">[title]</a>
		                        </div>
	                      </div>
                        </div>
                        <div class="form-group">
							<label>内容</label>
							<div class="input-group toggle_comment">
		                        <div class="input-group-btn">
		                          <button type="button" class="btn btn-danger" aria-label="Bold" data-input="dom">dom</button>
		                          <button type="button" class="btn btn-default" aria-label="Italic" data-input="str">STR</button>
		                        </div>
		                        <input type="text" class="form-control show" name="db_comment_dom" id="db_comment_dom" value="dom">
		                        <input type="text" class="form-control hidden" name="db_comment_str" id="db_comment_str" value="str">
		                      	<div class="input-group-btn">
		                          <a class="btn btn-default"  onclick="insertAtCursor('db_comment_str', '[comment]');">[comment]</a>
		                        </div>
	                      </div>
                        </div>
                        <div class="form-group">
							<label>时间</label>
							<div class="input-group toggle_time">
		                        <div class="input-group-btn">
		                          <button type="button" class="btn btn-danger" aria-label="Bold" data-input="dom">dom</button>
		                          <button type="button" class="btn btn-default" aria-label="Italic" data-input="str">STR</button>
		                        </div>
		                        <input type="text" class="form-control show" name="db_time_dom" id="db_time_dom" value="dom">
		                        <input type="text" class="form-control hidden" name="db_time_str" id="db_time_str" value="str">
		                      	<div class="input-group-btn">
		                          <a class="btn btn-default"  onclick="insertAtCursor('db_time_str', '[time]');">[time]</a>
		                        </div>
	                      </div>
                        </div>
                        <div class="form-group">
							<label>出处</label>
							<div class="input-group toggle_form">
		                        <div class="input-group-btn">
		                          <button type="button" class="btn btn-danger" aria-label="Bold" data-input="dom">dom</button>
		                          <button type="button" class="btn btn-default" aria-label="Italic" data-input="str">STR</button>
		                        </div>
		                        <input type="text" class="form-control show" name="db_form_dom" id="db_form_dom" value="dom">
		                        <input type="text" class="form-control hidden" name="db_form_str" id="db_form_str" value="str">
		                      	<div class="input-group-btn">
		                          <a class="btn btn-default"  onclick="insertAtCursor('db_form_str', '[form]');">[form]</a>
		                        </div>
	                      </div>
                        </div>
                        <div class="form-group">
							<label>作者</label>
							<div class="input-group toggle_author">
		                        <div class="input-group-btn">
		                          <button type="button" class="btn btn-danger" aria-label="Bold" data-input="dom">dom</button>
		                          <button type="button" class="btn btn-default" aria-label="Italic" data-input="str">STR</button>
		                        </div>
		                        <input type="text" class="form-control show" name="db_author_dom" id="db_author_dom" value="dom">
		                        <input type="text" class="form-control hidden" name="db_author_str" id="db_author_str" value="str">
		                      	<div class="input-group-btn">
		                          <a class="btn btn-default"  onclick="insertAtCursor('db_author_str', '[author]');">[author]</a>
		                        </div>
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
		</div>

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

 <script type="text/javascript">

        $(function () {
        	// toggle form between inline and normal inputs
            var $buttons_click = $(".toggle_click button");
            var $inputs_click = $(".toggle_click input");
            $buttons_click.click(function () {
                var mode = $(this).data("input");
                $buttons_click.removeClass("btn-danger").addClass("btn-default");
                $(this).removeClass("btn-default").addClass("btn-danger");

                $inputs_click.removeClass("show").addClass("hidden");
                $("#db_click_" + mode).removeClass("hidden").addClass("show");
            });
            
            // toggle form between inline and normal inputs
            var $buttons_title = $(".toggle_title button");
            var $inputs_title = $(".toggle_title input");
            $buttons_title.click(function () {
                var mode = $(this).data("input");
                $buttons_title.removeClass("btn-danger").addClass("btn-default");
                $(this).removeClass("btn-default").addClass("btn-danger");

                $inputs_title.removeClass("show").addClass("hidden");
                $("#db_title_" + mode).removeClass("hidden").addClass("show");
            });
         	// toggle form between inline and normal inputs
            var $buttons_comment = $(".toggle_comment button");
            var $inputs_comment = $(".toggle_comment input");
            $buttons_comment.click(function () {
                var mode = $(this).data("input");
                $buttons_comment.removeClass("btn-danger").addClass("btn-default");
                $(this).removeClass("btn-default").addClass("btn-danger");

                $inputs_comment.removeClass("show").addClass("hidden");
                $("#db_comment_" + mode).removeClass("hidden").addClass("show");
            });

         // toggle form between inline and normal inputs
            var $buttons_time = $(".toggle_time button");
            var $inputs_time = $(".toggle_time input");
            $buttons_time.click(function () {
                var mode = $(this).data("input");
                $buttons_time.removeClass("btn-danger").addClass("btn-default");
                $(this).removeClass("btn-default").addClass("btn-danger");

                $inputs_time.removeClass("show").addClass("hidden");
                $("#db_time_" + mode).removeClass("hidden").addClass("show");
            });

         // toggle form between inline and normal inputs
            var $buttons_form = $(".toggle_form button");
            var $inputs_form = $(".toggle_form input");
            $buttons_form.click(function () {
                var mode = $(this).data("input");
                $buttons_form.removeClass("btn-danger").addClass("btn-default");
                $(this).removeClass("btn-default").addClass("btn-danger");

                $inputs_form.removeClass("show").addClass("hidden");
                $("#db_form_" + mode).removeClass("hidden").addClass("show");
            });

         // toggle form between inline and normal inputs
            var $buttons_author = $(".toggle_author button");
            var $inputs_author = $(".toggle_author input");
            $buttons_author.click(function () {
                var mode = $(this).data("input");
                $buttons_author.removeClass("btn-danger").addClass("btn-default");
                $(this).removeClass("btn-default").addClass("btn-danger");

                $inputs_author.removeClass("show").addClass("hidden");
                $("#db_author_" + mode).removeClass("hidden").addClass("show");
            });
        });
</script>

