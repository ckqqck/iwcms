<div id="append_parent"></div>

<link href="<?php echo base_url();?>static/common/css/tr.css"
	rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css"
	href="<?php echo base_url();?>static/admin/css/table.css">
<script type="text/javascript">
	var disallowfloat = 'newthread' , SITEURL='<?php echo base_url();?>',IMGDIR = "<?php echo base_url();?>static/common/image";
</script>
<style>
<!--
.caiji p {
	padding: 3px 20px;
}

.caiji li {
	padding: 3px 20px;
}

.caiji span {
	padding: 5px;
	color: red;
}
-->
</style>
<div class="layout_m open_dev_system_message">
	<div class="bodys">
		<div class="main">
			<!-- 消息中心表格 开始 -->
			<form method="post" name="manage_comments" class="operate-form"
				action="<?php echo base_url();?>admin/cj/article/index">
				<div class="mod_message_center_table">
					<div class="inner">
						<div class="bd tab_horizontal2">
							<ul class="tab">
								<li><a href="javascript:;"
									class="j_tab current_tab"><span>文章列表</span></a></li>
							</ul>
						</div>
						<div class="bd tab_horizontal2">
							<div
								style="height: 10px; line-height: 10px; overflow: hidden; border-top: solid 1px #cecece; position: relative; top: -1px;"></div>
							<!-- 工具栏 开始 -->
							<div class="bar">
								<div class="bar_l msg">
									<span class="select_all"> <label for="select_all2"> <input
											name="select_all2" id="select_all2"
											class="checkbox j_select_all"
											onclick="checkAllCK('prefix', this.form, 'article_id')"
											type="checkbox"> 全选
									</label>
									</span>&nbsp;&nbsp;&nbsp;&nbsp;选中项: <input type="radio"
										class="radio" value="dels" id="optype_dels" name="optype"><label
										for="optype_dels">删除</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
										type="submit" value="提交" name="articlesubmit"
										class="btns btn_normal j_delallcheck">
								</div>
								<!-- 翻页 开始 -->
								<div class="mod_pagenav">
									<p class="mod_pagenav_main"></p>
								</div>
								<!-- 翻页 结束 -->
							</div>
							<table class="tb tb2 " style="min-width: 900px; *width: 900px;">
								<tbody>
									<tr class="header">
										<th width="30"></th>
										<th width="350">url</th>
										<th width="350">标题</th>
										<th>包含图片</th>
										<th>作者</th>
										<th>出处</th>
										<th>时间</th>
										<th>预览</th>
										<th width="20%"></th>
									</tr>
								</tbody>
								<?php foreach($result as $row):?>
								<tbody>
									<tr class="hover">
										<td><input type="checkbox" name="id[]"
											value="<?php echo $row->id?>"></td>
										<td><?php echo $row->url?></td>
										<td><?php echo $row->title?></td>
										<td><?php if($row->is_match_pic):?>
											是
										<?php endif;?>
										</td>
										<td><?php echo $row->author?></td>
										<td><?php echo $row->form?></td>
										<td><span><?php echo date("Y/m/d H:i:s",$row->late_date) ?></span></td>
										<td><a
											href="javascript:;" onclick="showWindow('testcj', 'admin/cj/article/cat?id=<?php echo $row->id?>');return false;"
											title="预览">预览</a>&nbsp;&nbsp;&nbsp;&nbsp;<a
											href="javascript:;" onclick="showWindow('testcj', 'admin/cj/article/cat_del?id=<?php echo $row->id?>');return false;"
											title="删除">删除</a></td>
										<td></td>
									</tr>
								</tbody>
							<?php endforeach; ?>
							</table>
							<div class="bar">								
								更多的省略………………
								<!-- 翻页 开始 -->
								<div class="mod_pagenav">
									<p class="mod_pagenav_main"></p>
								</div>
								<!-- 翻页 结束 -->
							</div>
						</div>

					</div>
				</div>
			</form>
			<!-- 消息中心表格 结束 -->
		</div>
	</div>
</div>