<style>
<!--
.news_box {
	width:800px;
	padding: 30px 40px;
	border: 1px solid #d6d6d6;
	background-color: #fafbf9;
}
.news_box img {
	width:100px;
}
.news_box h1 {
	font-size: 28px;
	font-weight: 700;
	text-align: center;
}

.news_box .add_time {
	padding: 0 0 20px;
	font-size: 14px;
	text-align: center;
	border-bottom: 1px solid #dfdfdf;
}

.news_box .info {
	padding: 20px 0 10px;
	font-size: 14px;
}
-->
</style>
<?php foreach($result as $row):?>
<div class="news_box">
	<h1><?php echo $row->title?></h1>
	<div class="add_time"><strong>作者：</strong><?php echo $row->author?>&nbsp;&nbsp;<strong>出处：</strong><?php echo $row->form?>&nbsp;&nbsp;<strong>发表时间：</strong><?php echo date("Y/m/d H:i:s",$row->late_date) ?></div>
	<div class="info">
		<?php echo subStrs($row->comment,600)?>
	</div>
</div>
<?php endforeach; ?>