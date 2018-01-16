<div id="append_parent"></div>

<link href="<?php echo base_url();?>static/common/css/tr.css"
	rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css"
	href="<?php echo base_url();?>static/admin/css/table.css">
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
			<div class="mod_message_center_table">
				<div class="inner">
					<div class="bd tab_horizontal2">
						<ul class="tab">
							<li><a href="javascript:;" class="j_tab current_tab"><span>文章列表</span></a></li>
						</ul>
					</div>
					<div class="bd tab_horizontal2">
						<div
							style="height: 10px; line-height: 10px; overflow: hidden; border-top: solid 1px #cecece; position: relative; top: -1px;"></div>
						<!-- 工具栏 开始 -->
						<table class="tb tb2 " style="min-width: 900px; *width: 900px;">
							<tbody>
								<tr class="header">
									<th width="30"></th>
									<td>uid</td>
									<th width="350">url</th>
									<th>时间</th>
									<th width="60%"></th>
								</tr>
							</tbody>
								<?php foreach($result as $row):?>
								<tbody>
								<tr class="hover">
									<td><input type="checkbox" name="id[]" value="<?php echo $row->id?>"></td>
									<td><?php echo $row->uid?></td>
									<td><?php echo $row->url?></td>
									<td><span><?php echo date("Y/m/d H:i:s",$row->late_date) ?></span></td>
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
			<!-- 消息中心表格 结束 -->
		</div>
	</div>
</div>