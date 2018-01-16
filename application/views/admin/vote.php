<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">
				<div class="tables">
					<div class="panel-body widget-shadow">
						<table class="table">
							<thead>
								<tr>
								  <th>#</th>
								  <th>缩略图</th>
								  <th>标题</th>
								  <th>开始时间</th>
								  <th>结束时间</th>
								  <th>设置</th>
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
								  <td scope="row"><?php echo $record['id'] ?></td>
								  <td><span class="prfil-img"><img src="http://127.0.0.1/azcms/static/admin/images/a.png" alt=""> </span></td>
								  <td><?php echo $record['title'] ?></td>
								  <td><?php echo date('Y-m-d',$record['statdate']);?></td>
								  <td><?php echo date('Y-m-d',$record['enddate']);?></td>
								  <td>
									<a href="<?php echo base_url(); ?>manage/vote/update?aid=<?=$record['id']?>"><span class="label label-default">编辑</span></a>
									<?php if ($record['status'] == 1):?>
									<a href="javascript:;"><span class="label label-primary del" data-id="<?=$record['id'] ?>" data-val="0" title="恢复">恢复</span></a>
									<?php else:?>
									<a href="javascript:;"><span   class="label label-danger del" data-id="<?=$record['id'] ?>"  data-val="1" title="冻结">冻结</span></a>
									<?php endif;?>
								  </td>
								  <td>
									<a href="<?php echo base_url(); ?>manage/voteitem/add?aid=<?=$record['id']?>"><span class="label label-success">增加选手</span></a>
									<a href="<?php echo base_url(); ?>manage/voteitem/index?aid=<?=$record['id']?>"><span class="label label-success">选手设置</span></a>
									<a href="<?php echo base_url(); ?>manage/vote/user?vid=<?=$record['id']?>"><span class="label label-success">投票结果</span></a>
									
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
                    <?php echo $pageurl; ?>
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