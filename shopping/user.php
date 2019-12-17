<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" /><!--<meta> 标签提供了 HTML 文档的元数据。元数据不会显示在客户端，但是会被浏览器解析。-->
<title>商品管理</title>
<style>
.error {color: #FF0000}
a.one:link    {color:#ffffff;}  /* 未访问链接 */
a.one:visited {color:#ffffff;}  /* 已访问链接 */
a.one:hover   {color:#FF00FF;}  /* 移到链接上 */
a.one:active  {color:#0000FF;}  /* 鼠标点击时 */
</style>
<link rel="stylesheet" type="text/css" href="style/public.css" /><!--rel定义当前文档与被链接文档之间的关系 type规定被链接文档的 MIME 类型 href定义被链接文档的位置-->
</head>
<body>


<?php

include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';

$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,'');
if (mysqli_connect_errno($con))
{
	echo "连接 MySQL 失败: " . mysqli_connect_error();
}
include('config.php');
session_start();
$order_user=isset($_SESSION['order_user'])?$_SESSION['order_user']:"ASC";
$items_user=isset($_SESSION['items_user'])?$_SESSION['items_user']:"goodsNum";
$searchitems_user=isset($_SESSION['searchitems_user'])?$_SESSION['searchitems_user']:"goodsNum";
$search_content_user=isset($_SESSION['search_content_user'])?$_SESSION['search_content_user']:"";

	$perCount=10;

	$sql="select count(*) as total from goodstb";
	$total=$db->query($sql)->fetch_array(MYSQLI_ASSOC)['total'];

	/* 页码总数 */
	$pageCount=ceil($total/$perCount);

	/* 获取当前page的参数 */
	$page=(int)$input->get('page');
	$page=$page<1?1:$page;

	/* 当前页码的偏移量 */
	$offset=($page-1)*$perCount;
	//echo "<script language=javascript>alert('{$page}');</script>";
    
    $userNum=$_SESSION['userNum'];

if($input->get('do')=='search')
{
	$searchitems_user=$_POST['searchitems_user'];
	$search_content_user=$_POST['search_content_user'];
	$_SESSION['searchitems_user']=$searchitems_user;
	$_SESSION['search_content_user']=$search_content_user;
}	


/* 排序功能 */
if($input->get('do')=='order_user')
{
	$order_user=$_POST['order_user'];
	$items_user=$_POST['items_user'];
	$_SESSION['order_user']=$order_user;
	$_SESSION['items_user']=$items_user;	
	//echo "<script language=javascript>alert('{$order} {$items_user}');</script>";
	header("location:user.php");
}
/* 加入购物车 */ 
if($input->get('do')=='join')
{
	$goodsNum=$input->get('goodsNum');
    $sql="select * from listtb where goodsNum='{$goodsNum}' AND userNum='{$userNum}'";
    //echo $sql."<br>";
    $is=$db->query($sql);
	if($is->num_rows!=0)
	{
        $data=mysqli_fetch_row($is);
        //echo $data[3]."<br>";
        $ls=$data[3]+1;
        $sql="UPDATE `listtb` SET `listAmount`='{$ls}' WHERE goodsNum='{$goodsNum}' AND userNum='{$userNum}'";
        $is=$db->query($sql);
        header("location:user.php");
	}
	else
	{
        $sql="INSERT INTO `listtb` (`listNum`, `userNum`, `goodsNum`, `listAmount`) VALUES ('0', '{$userNum}', '{$goodsNum}', '1')";
        $is=$db->query($sql);
        header("location:user.php");
	}
}


	$perCount=10;

    $sql="select count(*) as total from goodstb  where {$searchitems_user} like '%{$search_content_user}%'";
    $total=$db->query($sql)->fetch_array(MYSQLI_ASSOC)['total'];

	$sql="select * from goodstb  where {$searchitems_user} like '%{$search_content_user}%' order by {$items_user} {$order_user} limit {$offset},{$perCount} ";

	$result=$db->query($sql);
	
    $rows=array();
    
    //echo $sql."<br>";
    //exit();

	while($row=$result->fetch_array(MYSQLI_ASSOC))
	{
		$rows[]=$row;
	}

	/* 页码总数 */
	$pageCount=ceil($total/$perCount);

	/* 获取当前page的参数 */
	$page=(int)$input->get('page');
	$page=$page<1?1:$page;
	
	/* 当前页码的偏移量 */
	$offset=($page-1)*$perCount;


?>
	<!--
	<div id="top">
		<div class="logo">
            <a class="one" href="user.php" target=""></a>
		</div>

		<div class="login_info">
			<a href="#" style="color:#fff;">网站首页</a>&nbsp;|&nbsp;<!--不间断空格
			管理员： root <a href="../rzy/demo.php">[注销]</a>
		</div>
	</div>
	-->
	<?php
	include_once 'inc/user_header.inc.php';
	?>
	<!--
	<div id="sidebar">
		<ul>
			<li>
				<div><a style="color:#333;padding:4px 0 4px 15px;font-weight:bold;background:#ddd;" href="user.php"></a></div>
				<ul class="child">
                    <li><a style="font-weight:bold;"></a><li>
                    <li><a></a><li>
                    <li><a></a><li>
				</ul>
            </li>
			<li>
				<div><a style="color:#333;padding:4px 0 4px 15px;font-weight:bold;background:#ddd;" href="pay.php"></a></div>
				<ul class="child">
					<li><a></a></li>
				</ul>
			</li>
		</ul>
	</div>
	-->
	<div class="right-wrapper">
		<div class="right-wrapper-top">
			<form action="user.php?do=order_user" method="post" class="order">
				<select name="order_user" id="order_user">
					<option value="DESC" <?php if($order_user=="DESC") echo "selected";?>>降序</option>
					<option value="ASC" <?php if($order_user=="ASC") echo "selected";?>>升序</option>
				</select>
				<select name="items_user" id="items">
					<option value="goodsNum" <?php if($items_user=="goodsNum") echo "selected";?>>编号</option>
					<option value="goodsName" <?php if($items_user=="goodsName") echo "selected";?>>名称</option>
					<option value="goodsPri" <?php if($items_user=="goodsPri") echo "selected";?>>价格</option>
					<!--
					<option value="goodsSto" <?php if($items_user=="goodsSto") echo "selected";?>>库存</option>
					-->
				</select>
				<input type="submit" value="排序" class="button">
			</form>
			<form action="user.php?do=search" method="post" class="search">
				<select name="searchitems_user" id="searchitems">
					<option value="goodsNum" <?php if($searchitems_user=="goodsNum") echo "selected";?>>编号</option>
					<option value="goodsName" <?php if($searchitems_user=="goodsName") echo "selected";?>>名称</option>
					<option value="goodsPri" <?php if($searchitems_user=="goodsPri") echo "selected";?>>价格</option>
					<!--
					<option value="goodsSto" <?php if($searchitems_user=="goodsSto") echo "selected";?>>库存</option>
					-->
				</select>
				<input name="search_content_user" type="text" class="searchbar" value="<?php echo $search_content_user; ?>">
				<input type="submit" class="button" value="搜索">
			</form>
			<form action="user.php?do=search" method="post" class="search">
				<select name="searchitems_user" id="searchitems">
					<option value="goodsNum" <?php if($searchitems_user=="goodsNum") echo "selected";?>>编号</option>
					<option value="goodsName" <?php if($searchitems_user=="goodsName") echo "selected";?>>名称</option>
					<option value="goodsPri" <?php if($searchitems_user=="goodsPri") echo "selected";?>>价格</option>
					<!--
					<option value="goodsSto" <?php if($searchitems_user=="goodsSto") echo "selected";?>>库存</option>
					-->
				</select>
				<input name="search_content_user" type="text" class="searchbar" value="<?php echo $search_content_user; ?>">
				<input type="submit" class="button" value="搜索">
			</form>
		</div>
	<div class="showtable">
		<table>
			<thead>
				<tr>
				<th>商品编号</th>
				<th>商品名称</th>
				<th>价格</th>
				<!--
				<th>库存</th>
				-->
				<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($rows as $row) :?>
				<tr>
					<td><?php echo $row['goodsNum'];?></td>
					<td><?php echo $row['goodsName'];?></td>
					<td><?php echo $row['goodsPri'];?></td>
					<!--
					<td><?php echo $row['goodsSto'];?></td>
					-->
					<td>
						<a href="user.php?do=join&&goodsNum=<?php echo $row['goodsNum'];?>">加入购物车</a>
						<!--修改操作传输eid来判断是否是修改操作-->
					</td>
				</tr>
				<?php endforeach;?>
			</tbody>						
		</table>
	</div>
	<div class="pagenav">
		<?php
			$hrefprev = "<a href='user.php?page=%u'><img src=%s ></a>";
			if($page==1)
			{
				$showpage1=$page;
			}
			else
			{
				$showpage1=$page-1;
			}
			$temp1=sprintf( $hrefprev , $showpage1,"images/left.png");
			echo $temp1;
		?>
		<span>&nbsp&nbsp<?php echo $page;?>&nbsp&nbsp</span>
		<?php
			$hrefnext = "<a href='user.php?page=%u'><img src=%s ></a>";
			if($page>=$pageCount)
			{
				$showpage2=$pageCount;
			}
			else
			{
				$showpage2=$page+1;
			}
			$temp2=sprintf( $hrefnext , $showpage2,"images/right.png");
			echo $temp2;
		?>
		<span>&nbsp&nbsp&nbsp&nbsp共<?php echo $pageCount;?>页</span>
	</div>
	<div>
		<?php
			//echo $_SESSION['account'];
			//exit();
		?>
		<a class="addbutton" href="user_list.php">购物车</a>
	</div>
</body>
</html>