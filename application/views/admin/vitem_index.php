<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">
			<ol class="breadcrumb">
						<li><a href="javascript:window.history.back();">返回投票列表</a></li>
					</ol>
				<div class="tables">
					<div class="panel-body widget-shadow">
						<table class="table">
							<thead>
								<tr>
								  <th>排序</th>
								  <th>封面照片</th>
								  <th>名称</th>
								  <th>票数</th>
								  <th>电话</th>
								  <th>报名时间</th>
								  <th>操作</th>
								</tr>
							</thead>
							<tbody>
							<?php
		                    if(!empty($article))
		                    {
		                        foreach($article as $record)
		                        {
		                    ?>
								<tr>
								  <td scope="row"><?php echo $record['rank'] ?></td>
								  <td><span class="prfil-img"><img src="http://127.0.0.1/azcms/static/admin/images/a.png" alt=""> </span></td>
								  <td><?php echo $record['item'] ?></td>
								  <td><?php echo $record['vcount'] ?></td>
								  <td><?php echo $record['tourl'] ?></td>
								  <td><?php echo date('Y-m-d',$record['addtime']);?></td>
								  <td>
									<a href="<?php echo base_url(); ?>manage/voteitem/update?id=<?=$record['id']?>&aid=<?=$aid?>"><span class="label label-default">编辑</span></a>
									<a href="<?php echo base_url(); ?>manage/vote/update?aid=<?=$record['id']?>"><span class="label label-danger">锁定</span></a>
								  </td>
								</tr>
							<?php
                        }
                    }
                    ?>
							</tbody>
						</table>
					</div>
				</div>
                <div class="box-footer clearfix">
                    <?php //echo $pageurl; ?>
                </div>
			</div>
		</div>		
<script src="<?php echo base_url(); ?>static/layui/layui.js?t=<?php echo time()?>" charset="utf-8"></script>
<script type="text/javascript">
layui.use(['layer'], function() {
		var layer = layui.layer;
});
$('.ui-grid-halve-img').on('click', function() {
		var li = $(this).parent("li");
		li.remove();
});

$('.del').on('click', function (e) {
	var es = this;
		//询问框
	layer.confirm('您确定要冻结吗？', {
		btn : ['冻结', '取消'] 
	}, function(index) {
		var target = e.target || e.srcElement,
        tr = target.parentNode.parentNode.parentNode;
    	if (tr.tagName.toLowerCase() == 'tr') {
       	var aid = target.getAttribute("data-id"); 
       	var val = target.getAttribute("data-val");
       	
        //Ajax调用处理
        $.ajax({
               type: "POST",
               url: "<?php echo base_url(); ?>manage/vote/del_bak",
               data: {aid:aid*1,val:val*1,type:"del"},
               success: function(data){
               		data = eval("("+data+")");
               		if(data.state == "sess"){
               			if($(es).hasClass("label-primary") == true){
 	           			   $(es).removeClass("label-primary");
 	           			   $(es).addClass("label-danger");
 	           			   $(es).attr("title","冻结");
 	           			   $(es).attr("data-val","1");
 	           			   $(es).html("冻结");
 	           		   }else{
 	           			   $(es).removeClass("label-danger");
 	           			   $(es).addClass("label-primary");
 	           			   $(es).attr("title","恢复");
 	           			   $(es).attr("data-val", "0");
 	           			   $(es).html("恢复");
 	           		   }
       					//tr.remove();
       					layer.close(index);
               		}else{
               			layer.msg(data.message);
               		}
               }
         });
    	}
	}, function() {
	});	
 });
</script>		