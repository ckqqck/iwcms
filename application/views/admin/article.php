<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">
				<div class="tables">
					<div class="panel-body widget-shadow">
						<table class="table table-striped">
						
							<thead>
								<tr>
								  <th>#</th>
								  <th>缩略图</th>
								  <th>标题/简介</th>
								  <th>发布时间</th>
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

								  <td><div>
								<h4><?php echo $record['title'] ?></h4>
								<h6><?php echo $record['summary'] ?></h6></div></td>
								  <td><?php echo date('Y-m-d H:m:s',$record['created_at']);?></td>
								  <td>
									<a href="<?php echo base_url(); ?>manage/article/update?aid=<?=$record['id']?>"><span class="label label-default">编辑</span></a>
									<?php if ($record['click'] == 1):?>
									<a href="javascript:;"><span class="label label-primary click" data-id="<?=$record['id'] ?>" data-val="0" title="取消推荐">取消推荐</span></a>
									<?php else:?>
									<a href="javascript:;"><span   class="label label-danger click" data-id="<?=$record['id'] ?>"  data-val="1" title="推荐">推荐</span></a>
									<?php endif;?>
									<?php if($record['del'] == 1):?>
									<a href="javascript:;"><span  class="label label-success del" data-id="<?=$record['id'] ?>" data-val="0">恢复</span></a>
									<?php else:?>
									<a href="javascript:;"><span class="label label-danger del" data-id="<?=$record['id'] ?>" data-val="1">删除</span></a>
									<?php endif;?></td>
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
<script src="<?php echo base_url(); ?>static/layui/layui.js?t=1493937721544" charset="utf-8"></script>
<script type="text/javascript">
layui.use(['layer'], function() {
		var layer = layui.layer;
});
$('.ui-grid-halve-img').on('click', function() {
		var li = $(this).parent("li");
		li.remove();
});
$('.click').on('click', function (e) {
	var target = e.target || e.srcElement,
    tr = target.parentNode.parentNode;
	if (tr.tagName.toLowerCase() == 'td') {
	   	var aid = target.getAttribute("data-id"); 
	   	var val = target.getAttribute("data-val"); 
	    var e = this;
	    //Ajax调用处理
	    $.ajax({
	           type: "POST",
	           url: "<?php echo base_url(); ?>manage/article/del_bak",
	           data: {aid:aid*1,val:val,type:"click"},
	           success: function(data){
	           		data = eval("("+data+")");
	           		if(data.state == "sess"){
	           			if($(e).hasClass("label-primary") == true){
	           			   $(e).removeClass("label-primary");
	           			   $(e).addClass("label-danger");
	           			   $(e).attr("title","推荐");
	           			   $(e).attr("data-val",1);
	           			   $(e).html("推荐");
	           		   }else{
	           			   $(e).removeClass("label-danger");
	           			   $(e).addClass("label-primary");
	           			   $(e).attr("title","取消推荐");
	           			   $(e).attr("data-val",0);
	           			   $(e).html("取消推荐");
	           		   }
	   					layer.msg(data.message);
	           		}else{
	           			layer.msg(data.message);
	           		}
	           }
	     });
	}	
});
$('.del').on('click', function (e) {
	var es = this;
		//询问框
	layer.confirm('您确定要删除吗？', {
		btn : ['删除', '取消'] 
	}, function(index) {
		var target = e.target || e.srcElement,
        tr = target.parentNode.parentNode.parentNode;
    	if (tr.tagName.toLowerCase() == 'tr') {
       	var aid = target.getAttribute("data-id"); 
       	var val = target.getAttribute("data-val");
       	
        //Ajax调用处理
        $.ajax({
               type: "POST",
               url: "<?php echo base_url(); ?>manage/article/del_bak",
               data: {aid:aid*1,val:val*1,type:"del"},
               success: function(data){
               		data = eval("("+data+")");
               		if(data.state == "sess"){
               			if($(es).hasClass("label-success") == true){
 	           			   $(es).removeClass("label-success");
 	           			   $(es).addClass("label-danger");
 	           			   $(es).attr("title","删除");
 	           			   $(es).attr("data-val","1");
 	           			   $(es).html("删除");
 	           		   }else{
 	           			   $(es).removeClass("label-danger");
 	           			   $(es).addClass("label-success");
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