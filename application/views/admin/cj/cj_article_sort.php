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
<script type="text/javascript"
	src="<?php echo base_url();?>static/common/js/caiji.js" charset="utf-8"></script>
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
						<form action="<?php echo base_url();?>admin/cj/article/sort"
							method="post" accept-charset="utf-8" id="myform">	
								<?php echo validation_errors(); ?>
									<div class="rfm">
								<table class="table_message_center msg">
									<tbody>
										<tr>
											<th>选择字段：</th>
											<td><select class="ps vm" name="sort" id="sort">
													<option value="">选择</option>
													<option value="urllist_url">网址项--url地址</option>
													<option value="url">内容--url地址</option>
													<option value="title">内容--标题</option>
													<option value="comment">内容--内容</option>
													<option value="form">内容--出处</option>
													<option value="author">内容--作者</option>
											</select></td>
											<td width="20%"></td>
										</tr>
										<tr>
											<th>字符替换项：</th>
											<td>替换前：<textarea rows="2" name="sort_start"
															id="sort_start" cols="18" class="tarea">/(<div.*?>)/is</textarea><br>替换后：<textarea rows="2" name="sort_end"
															id="sort_end" cols="18" class="tarea"></textarea></td>
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
												<input type="hidden" size="30" value="<?=$id?>" name="uid">
												<button class="pn" type="submit" name="submit"
													onclick="sortsubmit(); return false;" value="替换">
													<em>替换</em>
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