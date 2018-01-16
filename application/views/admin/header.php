<!DOCTYPE HTML>
<html>
<head>
<title><?php echo $pageTitle; ?>-AZcms后台管理系统</title>
<base href="<?php echo base_url(); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Novus Admin Panel Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
SmartPhone Compatible web template, free WebDesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Bootstrap Core CSS -->
<link href="<?php echo base_url(); ?>static/admin/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="<?php echo base_url(); ?>static/admin/css/style.css" rel='stylesheet' type='text/css' />
<!-- font CSS -->
<!-- font-awesome icons -->
<link href="<?php echo base_url(); ?>static/admin/css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons -->
 <!-- js-->
<script src="<?php echo base_url(); ?>static/admin/js/jquery-1.11.1.min.js"></script>
<script src="<?php echo base_url(); ?>static/admin/js/modernizr.custom.js"></script>
<!--webfonts-->
<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
<!--//webfonts--> 
<!--animate-->
<link href="<?php echo base_url(); ?>static/admin/css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="<?php echo base_url(); ?>static/admin/js/wow.min.js"></script>
	<script type="text/javascript">
		 new WOW().init();
	
        var baseURL = "<?php echo base_url(); ?>";
    </script>
<!--//end-animate-->
<!-- chart -->
<script src="<?php echo base_url(); ?>static/admin/js/Chart.js"></script>
<!-- //chart -->

<!-- Metis Menu -->
<script src="<?php echo base_url(); ?>static/admin/js/metisMenu.min.js"></script>
<script src="<?php echo base_url(); ?>static/admin/js/custom.js"></script>
<link href="<?php echo base_url(); ?>static/admin/css/custom.css" rel="stylesheet">
<!--//Metis Menu -->
</head> 
<body class="cbp-spmenu-push cbp-spmenu-push-toright">
	<div class="main-content">
		<!--left-fixed -navigation-->
		<div class=" sidebar" role="navigation">
            <div class="navbar-collapse">
				<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left cbp-spmenu-open" id="cbp-spmenu-s1">
					<ul class="nav" id="side-menu">
						<li>
							<a href="<?php echo base_url(); ?>index.php/user/index"><i class="fa fa-home nav_icon"></i>Dashboard</a>
						</li>
						<li>
							<a href="#"><i class="fa fa-user nav_icon"></i>用户管理 <span class="nav-badge">12</span> <span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li>
									<a href="<?php echo base_url(); ?>index.php/addNew">增加用户</a>
								</li>
								<li>
									<a href="<?php echo base_url(); ?>index.php/userListing">用户管理</a>
								</li>
							</ul>
							<!-- /nav-second-level -->
						</li>
						<li class="">
							<a href="javascript:;"><i class="fa fa-book nav_icon"></i>图文管理 <span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li>
									<a href="<?php echo base_url(); ?>index.php/manage/article/add">增加<span class="nav-badge-btm">08</span></a>
								</li>
								<li>
									<a href="<?php echo base_url(); ?>index.php/manage/article/index">图文列表</a>
								</li>
							</ul>
							<!-- /nav-second-level -->
						</li>
						<li>
							<a href="#"><i class="fa fa-envelope nav_icon"></i>微信投票系统<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li>
									<a href="<?php echo base_url(); ?>index.php/manage/vote/index">投票列表 <span class="nav-badge-btm">05</span></a>
								</li>
								<li>
									<a href="<?php echo base_url(); ?>index.php/manage/vote/add">增加投票</a>
								</li>
								<li>
									<a href="compose.html">API接口设置</a>
								</li>
							</ul>
							<!-- //nav-second-level -->
						</li>
						<li>
							<a href="<?php echo base_url(); ?>index.php/manage/cj/article1"><i class="fa fa-th-large nav_icon"></i>采集1<span class="nav-badge-btm">08</span></a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>index.php/manage/cj/article"><i class="fa fa-th-large nav_icon"></i>采集</a>
						</li>
						<li>
							<a href="tables.html"><i class="fa fa-table nav_icon"></i>Tables <span class="nav-badge">05</span></a>
						</li>
						<li>
							<a href="#"><i class="fa fa-check-square-o nav_icon"></i>Forms<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li>
									<a href="forms.html">Basic Forms <span class="nav-badge-btm">07</span></a>
								</li>
								<li>
									<a href="validation.html">Validation</a>
								</li>
							</ul>
							<!-- //nav-second-level -->
						</li>
						<li>
							<a href="#"><i class="fa fa-file-text-o nav_icon"></i>Pages<span class="nav-badge-btm">02</span><span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li>
									<a href="login.html">Login</a>
								</li>
								<li>
									<a href="signup.html">SignUp</a>
								</li>
								<li>
									<a href="blank-page.html">Blank Page</a>
								</li>
							</ul>
							<!-- //nav-second-level -->
						</li>
						<li>
							<a href="charts.html" class="chart-nav"><i class="fa fa-bar-chart nav_icon"></i>Charts <span class="nav-badge-btm pull-right">new</span></a>
						</li>
					</ul>
					<!-- //sidebar-collapse -->
				</nav>
			</div>
		</div>
		<!--left-fixed -navigation-->
		<!-- header-starts -->
		<div class="sticky-header header-section ">
			<div class="header-left">
				<!--toggle button start-->
				<button id="showLeftPush"><i class="fa fa-bars"></i></button>
				<!--toggle button end-->
				<!--logo -->
				<div class="logo">
					<a href="<?php echo base_url(); ?>" target="_blank">
						<h1>AZCMS1.0</h1>
						<span>AdminPanel</span>
					</a>
				</div>
				<!--//logo-->
				<!--search-box-->
				<div class="search-box">
					<form class="input">
						<input class="sb-search-input input__field--madoka" placeholder="搜索..." type="search" id="input-31" />
						<label class="input__label" for="input-31">
							<svg class="graphic" width="100%" height="100%" viewBox="0 0 404 77" preserveAspectRatio="none">
								<path d="m0,0l404,0l0,77l-404,0l0,-77z"/>
							</svg>
						</label>
					</form>
				</div><!--//end-search-box-->
				<div class="clearfix"> </div>
			</div>
			<div class="header-right">
				<div class="profile_details_left"><!--notifications of menu start -->
					<ul class="nofitications-dropdown">
						<li class="dropdown head-dpdn">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-envelope"></i><span class="badge">3</span></a>
							<ul class="dropdown-menu">
								<li>
									<div class="notification_header">
										<h3>You have 3 new messages</h3>
									</div>
								</li>
								<li><a href="#">
								   <div class="user_img"><img src="<?php echo base_url(); ?>static/admin/images/1.png" alt=""></div>
								   <div class="notification_desc">
									<p>Lorem ipsum dolor amet</p>
									<p><span>1 hour ago</span></p>
									</div>
								   <div class="clearfix"></div>	
								</a></li>
								<li class="odd"><a href="#">
									<div class="user_img"><img src="<?php echo base_url(); ?>static/admin/images/2.png" alt=""></div>
								   <div class="notification_desc">
									<p>Lorem ipsum dolor amet </p>
									<p><span>1 hour ago</span></p>
									</div>
								  <div class="clearfix"></div>	
								</a></li>
								<li><a href="#">
								   <div class="user_img"><img src="<?php echo base_url(); ?>static/admin/images/3.png" alt=""></div>
								   <div class="notification_desc">
									<p>Lorem ipsum dolor amet </p>
									<p><span>1 hour ago</span></p>
									</div>
								   <div class="clearfix"></div>	
								</a></li>
								<li>
									<div class="notification_bottom">
										<a href="#">See all messages</a>
									</div> 
								</li>
							</ul>
						</li>
						<li class="dropdown head-dpdn">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-bell"></i><span class="badge blue">3</span></a>
							<ul class="dropdown-menu">
								<li>
									<div class="notification_header">
										<h3>You have 3 new notification</h3>
									</div>
								</li>
								<li><a href="#">
									<div class="user_img"><img src="<?php echo base_url(); ?>static/admin/images/2.png" alt=""></div>
								   <div class="notification_desc">
									<p>Lorem ipsum dolor amet</p>
									<p><span>1 hour ago</span></p>
									</div>
								  <div class="clearfix"></div>	
								 </a></li>
								 <li class="odd"><a href="#">
									<div class="user_img"><img src="<?php echo base_url(); ?>static/admin/images/1.png" alt=""></div>
								   <div class="notification_desc">
									<p>Lorem ipsum dolor amet </p>
									<p><span>1 hour ago</span></p>
									</div>
								   <div class="clearfix"></div>	
								 </a></li>
								 <li><a href="#">
									<div class="user_img"><img src="<?php echo base_url(); ?>static/admin/images/3.png" alt=""></div>
								   <div class="notification_desc">
									<p>Lorem ipsum dolor amet </p>
									<p><span>1 hour ago</span></p>
									</div>
								   <div class="clearfix"></div>	
								 </a></li>
								 <li>
									<div class="notification_bottom">
										<a href="#">See all notifications</a>
									</div> 
								</li>
							</ul>
						</li>	
						<li class="dropdown head-dpdn">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-tasks"></i><span class="badge blue1">15</span></a>
							<ul class="dropdown-menu">
								<li>
									<div class="notification_header">
										<h3>You have 8 pending task</h3>
									</div>
								</li>
								<li><a href="#">
									<div class="task-info">
										<span class="task-desc">Database update</span><span class="percentage">40%</span>
										<div class="clearfix"></div>	
									</div>
									<div class="progress progress-striped active">
										<div class="bar yellow" style="width:40%;"></div>
									</div>
								</a></li>
								<li><a href="#">
									<div class="task-info">
										<span class="task-desc">Dashboard done</span><span class="percentage">90%</span>
									   <div class="clearfix"></div>	
									</div>
									<div class="progress progress-striped active">
										 <div class="bar green" style="width:90%;"></div>
									</div>
								</a></li>
								<li><a href="#">
									<div class="task-info">
										<span class="task-desc">Mobile App</span><span class="percentage">33%</span>
										<div class="clearfix"></div>	
									</div>
								   <div class="progress progress-striped active">
										 <div class="bar red" style="width: 33%;"></div>
									</div>
								</a></li>
								<li><a href="#">
									<div class="task-info">
										<span class="task-desc">Issues fixed</span><span class="percentage">80%</span>
									   <div class="clearfix"></div>	
									</div>
									<div class="progress progress-striped active">
										 <div class="bar  blue" style="width: 80%;"></div>
									</div>
								</a></li>
								<li>
									<div class="notification_bottom">
										<a href="#">See all pending tasks</a>
									</div> 
								</li>
							</ul>
						</li>	
					</ul>
					<div class="clearfix"> </div>
				</div>
				<!--notification menu end -->
				<div class="profile_details">		
					<ul>
						<li class="dropdown profile_details_drop">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<div class="profile_img">	
									<span class="prfil-img"><img src="<?php echo base_url(); ?>static/admin/images/a.png" alt=""> </span> 
									<div class="user-name">
										<p><?php echo $name; ?></p>
										<span><?php echo $role_text; ?></span>
									</div>
									<i class="fa fa-angle-down lnr"></i>
									<i class="fa fa-angle-up lnr"></i>
									<div class="clearfix"></div>	
								</div>	
							</a>
							<ul class="dropdown-menu drp-mnu">
								<li> <a href="#"><i class="fa fa-cog"></i> Settings</a> </li> 
								<li> <a href="#"><i class="fa fa-user"></i> Profile</a> </li> 
								<li> <a href="<?php echo base_url(); ?>logout"><i class="fa fa-sign-out"></i> Logout</a> </li>
							</ul>
						</li>
					</ul>
				</div>
				<div class="clearfix"> </div>				
			</div>
			<div class="clearfix"> </div>	
		</div>
		<!-- //header-ends -->