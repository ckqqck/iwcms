<style>
<!--
.profile-btm ul li {
    width: 49.3%;
}
.profile-btm ul li:nth-child(1) {
    border-left: 1px solid #CACACA;
}
-->
</style>

<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">
			<ol class="breadcrumb">
						<li><a href="javascript:window.history.back();">返回列表</a></li>
						<li class="active">只显示前50名</li>
					</ol>
					<div class="form-group">
						<div class="row">
						<?php
		                    if(!empty($article))
		                    {
		                        foreach($article as $k => $record)
		                        {
		                    ?>
							<div class="col-md-3 grid_box1">
								<div class="profile-top">
									<img src="http://127.0.0.1/azcms/static/admin/images/a.png" alt="">
									<h4><?php echo $record['item'] ?></h4>
									<h5>编号：<?php echo $record['id'] ?></h5>
								</div>
								<div class="profile-btm">
									<ul>
										<li>
											<h4 style="color:red"><?php echo ($k + 1);?></h4>
											<h5 style="color:red">名次</h5>
										</li>
										<li>
											<h4><?php echo ($record['vcount']);?></h4>
											<h5 style="color:#6164C1">票数</h5>
										</li>
									</ul>
								</div>
							</div>
						<?php
                        }
                    }
                    ?>
							<div class="clearfix"> </div>
						</div>
					</div>
                <div class="box-footer clearfix">
                    <?php echo $pageurl; ?>
                </div>
			</div>
		</div>		
