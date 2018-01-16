<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">
				<div class="tables">
					<div class="panel-body widget-shadow">
						<table class="table">
							<thead>
								<tr>
								  <th><input type="checkbox">全选</th>
								  <th>采集类型</th>
								  <th>采集网址条数</th>
								  <th>采集文章条数</th>
								  <th>采集图片条数</th>
								  <th>已发布文章数</th>
								  <th>发布至栏目</th>
								  <th>操作</th>
								  <th>发布</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($result as $row):?>
								<tr>
								  <td scope="row"><input type="checkbox" name="cj_id[]"
											value="<?php echo $row->id?>"></td>
								  <td><?php echo $row->title?></td>
								  <td><?php if($row->uid == 1):?>
												单条网址
											<?php elseif ($row->uid == 2):?>
											<?php else:?>
												规则网址
											<?php endif;?></td>
								  <td><?php if($row->url_num_new == 0):?>
												0
											<?php else:?>
												<?php echo $row->url_num_new?>条
											<?php endif;?></td>
								  <td><?php if($row->comment_num_new == 0):?>
												0
											<?php else:?>
												<?php echo $row->comment_num_new?>条&nbsp;&nbsp;<a
											href="<?php echo base_url();?>manage/cj/article/cat_list?id=<?php echo $row->id?>"
											title="查看数据">查看数据</a>
											<?php endif;?></td>
								  <td><?php if($row->img_num_new == 0):?>
												0
											<?php else:?>
												<?php echo $row->img_num_new?>条(采集<?php echo $row->caiimg_num_new?>条，失败<?php echo $row->shicaiimg_num_new?>条)&nbsp;&nbsp;<a
											href="<?php echo base_url();?>manage/cj/article/img_list?id=<?php echo $row->id?>"
											title="查看数据">查看数据</a>
											<?php endif;?></td>
								  <td><?php echo $row->comment_num_in?>条</td>
								  <td>
								    <a href="javascript:;" onclick="showWindow('manage/cj/caiji/www?id=<?php echo $row->id?>&test=true','采集网站');return false;"
										title="采集"><span class="label label-success">采集网站</span></a>
									<a href="javascript:;"><span class="label label-success">采集内容</span></a>
									<a href="javascript:;"><span class="label label-success">采集图片</span></a>
									<a href="javascript:;"><span class="label label-success">整理数据</span></a>
									<a href="<?php echo base_url();?>manage/cj/article1/update?id=<?php echo $row->id?>"><span class="label label-default">编辑</span></a>
								 </td>
								  <td>
									<a href="javascript:;"><span class="label label-danger">发布</span></a>
									<a href="javascript:;"><span class="label label-danger">清空数据</span></a>
								</td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
                <div class="box-footer clearfix">
                    <?php //echo $pageurl; ?>
                </div>
			</div>
		</div>	
<input type="hidden" value="0" id="handle_status" >
<script type="text/javascript"
	src="<?php echo base_url();?>static/cj/common/js/caiji.js" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>static/layui/layui.js" charset="utf-8"></script>

<script>
var SITEURL = "<?php echo base_url(); ?>";
layui.use(['layer', 'laydate'], function(){
	var $ = layui.jquery
		,layer = layui.layer
	,laydate = layui.laydate;
});
</script>
