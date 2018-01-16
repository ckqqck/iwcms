<style type="text/css">
ul.tabContent {
	
}

ul.tabContent.hide {
	display: none;
}

#container {
	word-break: break-all;
	word-wrap: break-word;
}

.container_l {
	width: 1212px;
}

#content_right {
	width: 384px;
	float: right;
}

#content_left {
	width: 740px;
	padding-top: 5px;
}

#content_left {
	float: left;
	padding-left: 35px;
}

.table_message_center tbody th {
	background-color: #fff;
	text-align: right;
	padding-right: 10px;
	border-top: 0px dashed #DDD;
	border-bottom: 1px dashed #DDD;
	width: 110px;
}

.rfms.table_message_center tbody td {
	background-color: #fff;
	border-top: 0px dashed #DDD;
	border-bottom: 1px dashed #DDD;
	width: 150px;
	padding: 10px 0;
}

.tarea {
	font-family: Lucida Grande, Verdana, Geneva, Sans-serif;
	font-size: 14px;
	color: #143270;
	background-color: #f9f9f9;
	border: 1px solid #B3B4BD;
	padding: 6px;
	margin: 0;
}
</style>
<div class="bodys">
	<!-- main 开始 -->
	<div class="main">
		<div class="mod_message_center_table">
			<div class="inner">
				<div class="bd tab_horizontal2">
					<ul class="tab" id="tabs">
						<li><a href="ajaxscript:;" class="j_tab current_tab"><span>采集名称</span></a></li>
					</ul>
					<div
						style="height: 10px; line-height: 10px; overflow: hidden; border-top: solid 1px #cecece; position: relative; top: -1px;"></div>
					<!--加载开始-->
					<div id="mod-ltgd" class="gb_con">						
								<form action="<?php echo base_url();?>admin/cj/article/insert_title" method="post" accept-charset="utf-8">	
								<?php echo validation_errors(); ?>
									<div class="rfm">
										<table class="table_message_center msg">
											<tbody>
												<tr>
													<th>任务名称：</th>
													<td><input type="text" class="px p_fre" size="20"
														name="title" value="<?php echo set_value('title'); ?>" /><span
														style="color: red"> * </span> 如：采集新浪新闻，采集昵图网图片</td>
													<td width="10%"></td>
												</tr>
												
												<tr>
													<th>网址编码：</th>
													<td><ul class="nofloat">
													<li class=""><input class="radio" type="radio" name="charset" id= "charset1" value="1" checked="">&nbsp;<label
														for="charset1">自动</label></li>
													<li class=""><input class="radio" type="radio" name="charset" id= "charset2" value="2">&nbsp;<label
														for="charset2">UTF-8</label></li>
													<li class=""><input class="radio" type="radio" name="charset" id= "charset3" value="3">&nbsp;<label
														for="charset3">GBK</label></li>
												</ul></td>
													<td width="20%"></td>
												</tr>
											</tbody>
										</table>
									</div>
									<div class="rfm">
										<table class="table_message_center msg">
											<tr>
												<th></th>
												<td colspan="2">
													<div class="opt">
														<button class="pn" type="submit" name="submit"  onclick="submit(); return false;" value="下一步">
															<em>下一步</em>
														</button>
													</div>
												</td>
											</tr>
											</tbody>
										</table>
									</div>								
						</form>								
					</div>
					<!--加载结束-->
				</div>
			</div>
		</div>
	</div>
</div>