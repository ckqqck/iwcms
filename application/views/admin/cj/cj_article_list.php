<div id="append_parent"></div>

<link href="<?php echo base_url();?>static/cj/common/css/tr.css"
	rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css"
	href="<?php echo base_url();?>static/cj/admin/css/table.css">
<script type="text/javascript">
	var disallowfloat = 'newthread' , SITEURL='<?php echo base_url();?>',IMGDIR = "<?php echo base_url();?>static/common/image";
</script>
<link href="<?php echo base_url();?>static/cj/common/css/tr.css"
	rel="stylesheet" type="text/css">

<script type="text/javascript"
	src="<?php echo base_url();?>static/cj/common/js/caiji.js" charset="utf-8"></script>
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
				action="<?php echo base_url();?>manage/cj/article/index">
				<div class="mod_message_center_table">
					<div class="inner">
						<div class="bd tab_horizontal2">
							<ul class="tab">
								<li><a href="<?php echo base_url();?>manage/cj/article/index"
									class="j_tab current_tab"><span>采集任务列表</span></a></li>
								<li><a
									href="<?php echo base_url();?>manage/cj/article/insert_title"
									name="drafts" class="j_tab"><span>新增采集任务</span></a></li>
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
											onclick="checkall('prefix', this.form, 'cj_id')"
											type="checkbox"> 全选
									</label>
									</span>&nbsp;&nbsp;&nbsp;&nbsp;选中项: <input type="radio"
										class="radio" value="dels" id="optype_dels" name="del"><label
										for="optype_dels">删除</label>&nbsp;&nbsp;&nbsp;<input
										type="radio" class="radio" value="update" id="optype_update"
										name="del"><label for="optype_update">更新</label>&nbsp;&nbsp;<input
										type="submit" value="提交" name="submit"
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
										<th width="100">任务名称</th>
										<th>采集类型</th>
										<th>采集网址条数</th>
										<th>采集文章条数</th>
										<th>采集图片条数</th>
										<th>已发布文章数</th>
										<th>发布至栏目</th>
										<th width="450">操作</th>
										<th width="10%">发布</th>
									</tr>
								</tbody>
								<?php foreach($result as $row):?>
								<tbody>
									<tr class="hover">
										<td><input type="checkbox" name="cj_id[]"
											value="<?php echo $row->id?>"></td>
										<td><?php echo $row->title?></td>
										<td>
											<?php if($row->uid == 1):?>
												单条网址
											<?php elseif ($row->uid == 2):?>
											<?php else:?>
												规则网址
											<?php endif;?>
										</td>
										<td>
										<?php if($row->url_num_new == 0):?>
												0
											<?php else:?>
												<?php echo $row->url_num_new?>条&nbsp;&nbsp;<a
											href="<?php echo base_url();?>manage/cj/article/url_list?id=<?php echo $row->id?>"
											title="查看数据">查看数据</a>
											<?php endif;?>
										
										</td>
										<td>
										<?php if($row->comment_num_new == 0):?>
												0
											<?php else:?>
												<?php echo $row->comment_num_new?>条&nbsp;&nbsp;<a
											href="<?php echo base_url();?>manage/cj/article/cat_list?id=<?php echo $row->id?>"
											title="查看数据">查看数据</a>
											<?php endif;?>
										</td>	
										<td>
										<?php if($row->img_num_new == 0):?>
												0
											<?php else:?>
												<?php echo $row->img_num_new?>条(采集<?php echo $row->caiimg_num_new?>条，失败<?php echo $row->shicaiimg_num_new?>条)&nbsp;&nbsp;<a
											href="<?php echo base_url();?>manage/cj/article/img_list?id=<?php echo $row->id?>"
											title="查看数据">查看数据</a>
											<?php endif;?>
										</td>									
										<td><?php echo $row->comment_num_in?>条</td>
										<td></td>
										<td><a href="javascript:;"
											onclick="showWindow('testcj', 'manage/cj/caiji/www?id=<?php echo $row->id?>&test=true');return false;">测试网址</a>&nbsp;&nbsp;<a
											href="javascript:;"
											onclick="showWindow('testcj', '<?php echo base_url();?>manage/cj/caiji/www?id=<?php echo $row->id?>');return false;"
											title="采集">采集网址</a>&nbsp;&nbsp;<a href="javascript:;"
											onclick="showWindow('testcj', 'manage/cj/caiji/www_comment?id=<?php echo $row->id?>&test=true');return false;">测试内容</a>&nbsp;&nbsp;<a
											href="javascript:;"
											onclick="showWindow('testcj', 'manage/cj/caiji/www_comment?id=<?php echo $row->id?>');return false;"
											title="采集">采集内容</a>&nbsp;&nbsp;<a href="javascript:;"
											onclick="showWindow('testcj', 'manage/cj/caiji/download_img?id=<?php echo $row->id?>');return false;"
											title="采集图片">采集图片</a>&nbsp;&nbsp;<a href="javascript:;"
											onclick="showWindow('testcj', 'manage/cj/caiji/macth_img?id=<?php echo $row->id?>');return false;"
											title="替换图片">替换图片</a>&nbsp;&nbsp;<a
											href="<?php echo base_url();?>manage/cj/article/sort?id=<?php echo $row->id?>"
											title="整理数据">整理数据</a>&nbsp;&nbsp;<a
											href="<?php echo base_url();?>manage/cj/article/update?id=<?php echo $row->id?>"
											title="编辑">编辑</a></td>
										<td>&nbsp;&nbsp;<a href="javascript:;"
											onclick="showWindow('testcj', 'manage/cj/caiji/post?id=<?php echo $row->id?>');return false;"
											title="发布">发布</a>&nbsp;&nbsp;<a
											href="javascript:;" title="清空数据" onclick="cj_del_db('<?php echo $row->id?>','清空数据');return false;">清空数据</a></td>
									</tr>
								</tbody>
							<?php endforeach; ?>
							</table>
							<div class="bar">
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