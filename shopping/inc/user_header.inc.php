<?php
    include_once 'inc/tool.inc.php';

	$_SESSION['aid']=$_SESSION['account'];
	if(strcmp($_SESSION['aid'],$_SESSION['userNum'])!=0)
	{
		skip('demo.php','error','请登录！');
    }
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title>商品管理</title>
<meta name="keywords" content="商品管理" />
<meta name="description" content="商品管理" />
<link rel="stylesheet" type="text/css" href="style/public.css" />
</head>
<body>
<div id="top" style="background: #24557E">
	<div class="logo">
		商品管理
	</div>
	<ul class="nav">
<!-- 		<li><a href="#" target="_blank">导航栏</a></li>
		<li><a href="#" target="_blank">导航栏</a></li> -->
	</ul>
	<div class="login_info">
		<a href="selfinfo_module.php" style="color:#fff;"></a>&nbsp;|&nbsp;
		账号： <?php echo $_SESSION['aid'] ?> <a href="demo.php">[注销]</a>
	</div>
</div>
<div id="sidebar">
	<ul>
<!-- 		<li>
			<div class="small_title">系统</div>
			<ul class="child">
				<li><a class="current" href="#">系统信息</a></li>
				<li><a href="#">？管理员</a></li>
				<li><a href="#">？添加管理员</a></li>
				<li><a href="#">？站点设置</a></li>
			</ul>
		</li> -->
		<li><!--  class="current" -->
			<div class="small_title">内容管理</div>
			<ul class="child">
				<li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='father_module.php'){echo 'class="current"';}?> href="user.php">商品列表</a></li>
				<li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='father_module.php'){echo 'class="current"';}?> href="user_list.php">购物车</a></li>
				<li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='father_module.php'){echo 'class="current"';}?> href="user_list_balance.php">结账付款</a></li>
			</ul>
		</li>
<!-- 		<li>
			<div class="small_title">？用户管理</div>
			<ul class="child">
				<li><a href="#">？用户列表</a></li>
			</ul>
		</li> -->
	</ul>
</div>