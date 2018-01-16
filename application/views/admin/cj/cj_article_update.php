<div id="append_parent"></div>
<script type="text/javascript">
var cookiepre = 'WuXn_2132_', IMGDIR = "http://127.0.0.1/wjhxzf/static/common/image";
var disallowfloat = 'newthread', JSPATHS = 'static/diy/js', SITEURL = 'http://127.0.0.1/wjhxzf/';
</script>

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
	width: 10px;
	float: right;
}

#content_left {
	width: 960px;
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

.art tbody td {
	background-color: #fff;
	border-top: 0px dashed #DDD;
	border-bottom: 1px dashed #DDD;
	width: 285px;
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

.dom_to_str tbody td {
	border-bottom: 0px dashed #DDD;
	text-align: left;
	padding: 5px 0;
}
</style>
<link href="<?php echo base_url();?>static/cj/common/css/tr.css"
	rel="stylesheet" type="text/css">

<script type="text/javascript"
	src="<?php echo base_url();?>static/cj/common/js/caiji.js" charset="utf-8"></script>

<div class="bodys">
	<!-- main 开始 -->
	<?php foreach($result as $row):?>
	<div class="main">
		<div class="mod_message_center_table">
			<div class="inner">
				<div class="bd tab_horizontal2">
					<ul class="tab" id="tabs">
						<li><a href="#lists" class="j_tab  current_tab" ><span>采集网址规则</span></a></li>
						<li><a href="#conment"><span>采集内容规则</span></a></li>
						<li><a href="#testfa"><span>发布内容设置</span></a></li>
					</ul>
					<div
						style="height: 10px; line-height: 10px; overflow: hidden; border-top: solid 1px #cecece; position: relative; top: -1px;"></div>
					<!--加载开始-->
					<div id="mod-ltgd" class="gb_con">
						<div id="container" class="container_l">
							<div id="content_right"></div>
							<div id="content_left">
								<ul class="tabContent" id="lists">
									<form action="<?php echo base_url();?>admin/cj/article/update"
										method="post" accept-charset="utf-8">	
								<?php echo validation_errors(); ?>
									<div class="rfm">
											<table class="table_message_center msg">
												<tbody>
													<tr>
														<th>采集任务名称：</th>
														<td><input type="text" class="px p_fre" size="40"
															name="title" value="<?=$row->title?>"><span
															style="color: red"> * </span> 如：采集新浪新闻</td>
														<td width="10%"></td>
													</tr>
													<tr>
														<th>图片本地化：</th>
														<td><ul class="nofloat">
																<li class=""><input type="radio" class="radio"
																	id="is_img1" name="is_img" value="0"
																	<?php if ($row->is_img == "0"){ echo 'checked="checked"';} ?>><label
																	for="is_img1">是</label></li>
																<li class=""><input type="radio" class="radio"
																	id="is_img2" name="is_img" value="1"
																	<?php if ($row->is_img == "1"){ echo 'checked="checked"';} ?>><label
																	for="is_img2">否</label></li></td>
														<td width="10%"></td>
													</tr>
													<tr>
														<th>采集类型：</th>
														<td>
															<ul class="nofloat">
																<li class=""><input type="radio" class="radio"
																	name="uid" id="uid1" value="1"
																	<?php if ($row->uid == "1"){ echo 'checked="checked"';} ?>
																	onclick="$('style_code').style.display = 'none';$('style_text').style.display = 'none';$('style_image').style.display = '';"><label
																	for="uid1">单条网址输入</label></li>
																<li class="checked"><input type="radio" class="radio"
																	name="uid" id="uid2" value="2"
																	<?php if ($row->uid == "2"){ echo 'checked="checked"';} ?>
																	onclick="$('style_code').style.display = 'none';$('style_text').style.display = '';$('style_image').style.display = 'none';"><label
																	for="uid2">导入网址</label></li>
																<li class=""><input type="radio" class="radio"
																	name="uid" id="uid3" value="3"
																	<?php if ($row->uid == "3"){ echo 'checked="checked"';} ?>
																	onclick="$('style_code').style.display = '';$('style_text').style.display = 'none';$('style_image').style.display = 'none';"><label
																	for="uid3">多条网址</label>
															
															</ul>
														</td>
														<td width="10%"></td>
													</tr>
													<tr id="style_image"
														<?php if ($row->uid != "1"){ echo 'style="display: none;"';} ?>>
														<th>单条网址输入：</th>
														<td><textarea rows="6" name="b_listconment"
																id="listconment" cols="50" class="tarea"
																onblur="uper(this.value);return false;"><?=$row->b_listconment?></textarea><span
															style="color: red">*</span>一行一个</td>
														<td width="20%"></td>
													</tr>
													<tr id="style_text"
														<?php if ($row->uid != "2"){ echo 'style="display: none;"';} ?>>
														<th>导入网址：</th>
														<td><input type="text" class="px p_fre" size="70"
															name="c_wwwsss" value="<?=$row->c_wwwsss?>"><span
															style="color: red">*</span>后缀.txt</td>
														<td width="20%"></td>
													</tr>
													<tr id="style_code"
														<?php if ($row->uid != "3"){ echo 'style="display: none;"';} ?>>
														<th>多条网址规则：</th>
														<td>地址格式：<input type="text" class="px p_fre" size="70"
															name="a_www" id="www" value="<?=$row->a_www?>" /><a
															href="javascript:void(0);"
															onclick="insertAtCursor('www', '(*)');"><span
																style="color: red"> 插入(*) </span></a><br> <br> <input
															type="radio" class="radio" id="optype_dengcha"
															name="a_bi" value="1"
															<?php if ($row->a_bi == "1"){ echo 'checked="checked"';} ?>><label
															for="optype_dengcha">等差数列</label>：首项<input type="text"
															class="px p_fre" size="3" id="chaone" name="a_chaone"
															value="<?=$row->a_chaone?>" /> 项数<input type="text"
															class="px p_fre" size="3" id="chanum" name="a_chanum"
															value="<?=$row->a_chanum?>" /> 公差<input type="text"
															class="px p_fre" size="3" id="chacommon"
															name="a_chacommon" value="<?=$row->a_chacommon?>" />&nbsp;&nbsp;<input
															id="click_1" class="pc" type="checkbox"
															name="a_chacheckbox" value="1"><label class="lb"
															for="click_1">倒序</label><br> <br> <input type="radio"
															class="radio" id="optype_1" name="a_bi" value="2"
															<?php if ($row->a_bi == "2"){ echo 'checked="checked"';} ?>><label
															for="optype_1">等比数列</label>：首项<input type="text"
															class="px p_fre" size="3" id="bione" name="a_bione"
															value="<?=$row->a_bione?>" /> 项数<input type="text"
															class="px p_fre" size="3" id="binum" name="a_binum"
															value="<?=$row->a_binum?>" /> 公比<input type="text"
															class="px p_fre" size="3" id="bicommon" name="a_bicommon"
															value="<?=$row->a_bicommon?>" />&nbsp;&nbsp;<input
															id="click_2" class="pc" type="checkbox"
															name="a_bicheckbox" value="2"><label class="lb"
															for="click_2">倒序</label></td>
														<td width="20%"><a href="javascript:;"
															onclick="cj_test('测试网址规则列表');return false;">测试网址规则列表</a></td>
													</tr>
													<tr>
														<th>内容页网址获取：</th>
														<td><table class="dom_to_str">
																<tbody>
																	<tr>
																		<td><input type="radio" class="radio" name="dom"
																			id="uid4" value="0"
																			<?php if ($row->dom == "0"){ echo 'checked="checked"';} ?>
																			onclick="$('str_to_dom').style.display = 'none';$('dom_to_str').style.display = '';"><label
																			for="uid4">dom采集</label>&nbsp;&nbsp;&nbsp;&nbsp;<input
																			type="radio" class="radio" name="dom" id="uid5"
																			value="1"
																			<?php if ($row->dom == "1"){ echo 'checked="checked"';} ?>
																			onclick="$('str_to_dom').style.display = '';$('dom_to_str').style.display = 'none';"><label
																			for="uid5">字符串采集</label></td>
																		<td></td>
																		<td width="20%"></td>
																	</tr>
																	<tr id="str_to_dom"
																		<?php if ($row->dom != "1"){ echo 'style="display: none;"';} ?>>
																		<td><textarea rows="3" name="click_str" id="click_str"
																				cols="38" class="tarea"><?=$row->click_str?></textarea>
																		</td>
																		<td><a href="javascript:void(0);"
																			onclick="insertAtCursor('click_str', '[click]');"><span
																				style="color: red"> 插入[click] </span></a></td>
																		<td></td>
																	</tr>
																	<tr id="dom_to_str"
																		<?php if ($row->dom != "0"){ echo 'style="display: none;"';} ?>>
																		<td>DOM标签 <textarea rows="3" name="click_dom"
																				id="listconment" cols="38" class="tarea"><?=$row->click_dom?></textarea>
																		</td>
																		<td><p>div.class</p>
																			<p>div#id</p>
																			<p>div[!id]</p></td>
																		<td></td>
																	</tr>
																	<tr>
																		<td>必须包含<textarea rows="2" name="click_bh"
																				id="listconment" cols="28" class="tarea"><?=$row->click_bh?></textarea></td>
																		<td>不得包含<textarea rows="2" name="click_nobh"
																				id="listconment" cols="28" class="tarea"><?=$row->click_nobh?></textarea></td>
																		<td></td>
																	</tr>
																	<tr>
																		<td>&nbsp;&nbsp;主&nbsp;机&nbsp;名<textarea rows="2"
																				name="click_host" id="listconment" cols="28"
																				class="tarea"><?=$row->click_host?></textarea></td>
																		<td></td>
																		<td></td>
																	</tr>
																</tbody>
															</table></td>
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
															<input type="hidden" size="30" value="<?=$row->id?>"
																name="id">
															<button class="pn" type="submit" name="submit"
																onclick="onsubmitz(); return false;" value="保存">
																<em>保存</em>
															</button>
															<button class="pn" type="button"
																onclick="cj_wwwtest(); return false;" value="测试采集">
																<em>测试采集</em>
															</button>
														</div>
													</td>
												</tr>
												</tbody>
											</table>
										</div>
									</form>
								</ul>

								<ul class="tabContent" id="conment">
									<form action="<?php echo base_url();?>admin/cj/article/insert_comment"
										method="post" accept-charset="utf-8">	
								<?php echo validation_errors(); ?>
									<div class="rfms">
											<table class="table_message_center msg art">
												<tbody>
													<tr>
														<th>标签名</th>
														<td>字符串</td>
														<td>插入标签</td>
														<td>DOM && 自定义</td>
														<td width="5%"></td>
													</tr>
													<tr>
														<th>标题：[标题]</th>
														<td><textarea rows="3" name="db_title_str"
																id="db_title_str" cols="28" class="tarea"><?=$row->db_title_str?></textarea></td>
														<td><a href="javascript:void(0);"
															onclick="insertAtCursor('db_title_str', '[title]');"> 插入<span
																style="color: red"> [title] </span></a></td>
														<td><textarea rows="3" name="db_title_dom"
																id="listconment" cols="18" class="tarea"><?=$row->db_title_dom?></textarea></td>
														<td><input id="db_title_dom_on" class="pc" type="checkbox"
															name="db_title_dom_on"
															<?php if ($row->db_title_dom_on == "on"){ echo 'checked="checked"';} ?>><label
															class="lb" for="db_title_dom_on">DOM</label></td>
													</tr>
													<tr>
														<th>内容：[内容]</th>
														<td><textarea rows="3" name="db_comment_str"
																id="db_comment_str" cols="28" class="tarea"><?=$row->db_comment_str?></textarea></td>
														<td><a href="javascript:void(0);"
															onclick="insertAtCursor('db_comment_str', '[comment]');">
																插入<span style="color: red"> [comment] </span>
														</a><br><br>采集分页：<input id="db_page_1"
															class="pc" type="radio" name="db_page" value="1"
															<?php if ($row->db_page == "1"){ echo 'checked="checked"';} ?> 
															 onclick="$('page_0').style.display = '';"><label
																class="lb" for="db_page_1" style="color: red">是</label>&nbsp;&nbsp;&nbsp;&nbsp;
															<input id="db_page_0"
															class="pc" type="radio" name="db_page" value="0"
															<?php if ($row->db_page == "0"){ echo 'checked="checked"';} ?>
															onclick="$('page_0').style.display = 'none';"><label
																class="lb" for="db_page_0" style="color: red">否</label>
														</td>
														<td><textarea rows="3" name="db_comment_dom"
																id="listconment" cols="18" class="tarea"><?=$row->db_comment_dom?></textarea></td>
														<td><input id="db_comment_dom_on" class="pc"
															type="checkbox" name="db_comment_dom_on"
															<?php if ($row->db_comment_dom_on == "on"){ echo 'checked="checked"';} ?>><label
															class="lb" for="db_comment_dom_on">DOM</label></td>
													</tr>
													<tr id="page_0" <?php if ($row->db_page != "1"){ echo 'style="display: none;"';} ?>>
														<th>分页规则：</th>
														<td><table class="dom_to_str">
																<tbody>
																	<tr>
																		<td><input type="radio" class="radio" name="db_page_type"
																			id="page1" value="0" <?php if ($row->db_page_type == "0"){ echo 'checked="checked"';} ?>
																			onclick="$('page_to_dom').style.display = '';$('page_to_str').style.display = 'none';"><label
																			for="page1">dom采集</label>&nbsp;&nbsp;&nbsp;&nbsp;<input
																			type="radio" class="radio" name="db_page_type" id="page2" <?php if ($row->db_page_type == "1"){ echo 'checked="checked"';} ?>
																			value="1" onclick="$('page_to_dom').style.display = 'none';$('page_to_str').style.display = '';"><label
																			for="page2">字符串采集</label></td>
																		<td></td>
																		<td width="20%"></td>
																	</tr>
																	<tr id="page_to_str" style="display: none;">																	
																		<td><textarea rows="3" name="db_page_str" id="page_str"
																				cols="38" class="tarea"><?=$row->db_page_str?></textarea></td>
																		<td><a href="javascript:void(0);"
																			onclick="insertAtCursor('page_str', '[page]');"><span
																				style="color: red"> 插入[page] </span></a></td>
																		<td></td>
																	</tr>
																	<tr id="page_to_dom">
																		<td><textarea rows="3" name="db_page_dom"
																				id="listconment" cols="38" class="tarea"><?=$row->db_page_dom?></textarea>
																		</td>
																		<td><p>div.class</p>
																			<p>div#id</p>
																			<p>div[!id]</p></td>
																		<td></td>
																	</tr>
																	<tr>
																		<td>必须包含<br><textarea rows="2" name="db_page_bh"
																				id="listconment" cols="28" class="tarea"><?=$row->db_page_bh?></textarea></td>
																		<td>不得包含<br><textarea rows="2" name="db_page_nobh"
																				id="listconment" cols="28" class="tarea"><?=$row->db_page_nobh?></textarea></td>
																		<td></td>
																	</tr>
																	<tr>
																		<td>&nbsp;&nbsp;主&nbsp;机&nbsp;名<br><textarea rows="2"
																				name="db_page_host" cols="28"
																				class="tarea"><?=$row->db_page_host?></textarea></td>
																		<td></td>
																		<td></td>
																	</tr>
																</tbody>
															</table></td>
														<td width="20%"></td>
													</tr>
													<tr>
														<th>时间：[时间]</th>
														<td><textarea rows="3" name="db_time_str" id="db_time_str"
																cols="28" class="tarea"><?=$row->db_time_str?></textarea></td>
														<td><a href="javascript:void(0);"
															onclick="insertAtCursor('db_time_str', '[time]');"> 插入<span
																style="color: red"> [time] </span></a></td>
														<td><textarea rows="3" name="db_time_dom" id="listconment"
																cols="18" class="tarea"><?=$row->db_time_dom?></textarea></td>
														<td><input id="db_time_dom_on" class="pc" type="checkbox"
															name="db_time_dom_on"
															<?php if ($row->db_time_dom_on == "on"){ echo 'checked="checked"';} ?>><label
															class="lb" for="db_time_dom_on">DOM</label></td>
													</tr>
													<tr>
														<th>出处：[出处]</th>
														<td><textarea rows="3" name="db_form_str" id="db_form_str"
																cols="28" class="tarea"><?=$row->db_form_str?></textarea></td>
														<td><a href="javascript:void(0);"
															onclick="insertAtCursor('db_form_str', '[form]');"> 插入<span
																style="color: red"> [form] </span></a></td>
														<td><textarea rows="3" name="db_form_var" id="listconment"
																cols="18" class="tarea"><?=$row->db_form_var?></textarea></td>
														<td>自定义</td>
													</tr>
													<tr>
														<th>作者：[作者]</th>
														<td><textarea rows="3" name="db_author_str"
																id="db_author_str" cols="28" class="tarea"><?=$row->db_author_str?></textarea></td>
														<td><a href="javascript:void(0);"
															onclick="insertAtCursor('db_author_str', '[author]');">
																插入<span style="color: red"> [author] </span>
														</a></td>
														<td><textarea rows="3" name="db_author_var"
																id="listconment" cols="18" class="tarea"><?=$row->db_author_var?></textarea></td>
														<td>自定义</td>
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
															<input type="hidden" size="30" value="<?=$row->id?>"
																name="id">
															<button class="pn" type="submit" name="submit" value="保存">
																<em>保存</em>
															</button>
															<button class="pn" type="button"
																onclick="cj_wwwtest(); return false;" value="测试采集">
																<em>测试采集</em>
															</button>
														</div>
													</td>
												</tr>
												</tbody>
											</table>
										</div>
									</form>
								</ul>
								<ul class="tabContent" id="testfa">
									<div class="rfms">
										<table class="table_message_center msg">
											<tbody>
												<tr>
													<th>本站发布规则</th>
													<td width="40%"><span style="color: red"> * </span>其它网站请购买商业版</td>
												</tr>
												<tr>
													<th>标题：[标题]</th>
													<td></td>
												</tr>
												<tr>
													<th>内容：[内容]</th>
													<td></td>
												</tr>
												<tr>
													<th>时间：[时间]</th>
													<td></td>
												</tr>
												<tr>
													<th>出处：[出处]</th>
													<td></td>
												</tr>
												<tr>
													<th>作者：[作者]</th>
													<td></td>
												</tr>
											</tbody>
										</table>
									</div>
								</ul>
							</div>
						</div>

					</div>
					<?php endforeach; ?>
					<!--加载结束-->
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
init();
</script>