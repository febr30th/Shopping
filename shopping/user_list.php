<!listTYPE html>
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
$order_user_list=isset($_SESSION['order_user_list'])?$_SESSION['order_user_list']:"ASC";
$items_user_list=isset($_SESSION['items_user_list'])?$_SESSION['items_user_list']:"listNum";
$searchitems_user_list=isset($_SESSION['searchitems_user_list'])?$_SESSION['searchitems_user_list']:"listNum";
$search_content_user_list=isset($_SESSION['search_content_user_list'])?$_SESSION['search_content_user_list']:"";

	$perCount=10;

	$sql="select count(*) as total from listtb";
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
	
if($input->get('do')=='delete')
{
    $listNum=$input->get('listNum');
    $sql="delete from listtb where listNum='{$listNum}' ";
    $is=$db->query($sql);
    if($is)
    {
        header("location:user_list.php");
    }
    else
    {
        echo "<script language=javascript>alert('删除失败！');</script>";
    }
}

if($input->get('do')=='search')
{
	$searchitems_user_list=$_POST['searchitems_user_list'];
	$search_content_user_list=$_POST['search_content_user_list'];
	$_SESSION['searchitems_user_list']=$searchitems_user_list;
	$_SESSION['search_content_user_list']=$search_content_user_list;
}	


/* 排序功能 */
if($input->get('do')=='order_user_list')
{
	$order_user_list=$_POST['order_user_list'];
	$items_user_list=$_POST['items_user_list'];
	$_SESSION['order_user_list']=$order_user_list;
	$_SESSION['items_user_list']=$items_user_list;	
	//echo "<script language=javascript>alert('{$order} {$items_user_list}');</script>";
	header("location:user.php");
}


	$perCount=10;

	$sql="select count(*) as total from listtb  where {$searchitems_user_list} like '%{$search_content_user_list}%'";
	$total=$db->query($sql)->fetch_array(MYSQLI_ASSOC)['total'];

	$sql="select * from listtb  where {$searchitems_user_list} like '%{$search_content_user_list}%' and userNum='{$userNum}' order by {$items_user_list} {$order_user_list} limit {$offset},{$perCount} ";

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
			<form action="user_list.php?do=order_user_list" method="post" class="order">
				<select name="order_user_list" id="order_user_list">
					<option value="DESC" <?php if($order_user_list=="DESC") echo "selected";?>>降序</option>
					<option value="ASC" <?php if($order_user_list=="ASC") echo "selected";?>>升序</option>
				</select>
				<select name="items_user_list" id="items">
					<option value="listNum" <?php if($items_user_list=="listNum") echo "selected";?>>购物车编号</option>
                    <!--
					<option value="userNum" <?php if($items_user_list=="userNum") echo "selected";?>>用户编号</option>
                    -->
					<option value="goodsNum" <?php if($items_user_list=="goodsNum") echo "selected";?>>商品编号</option>
					<option value="listAmount" <?php if($items_user_list=="listAmount") echo "selected";?>>购买数量</option>
				</select>
				<input type="submit" value="排序" class="button">
			</form>
			<form action="user_list.php?do=search" method="post" class="search">
				<select name="searchitems_user_list" id="searchitems">
					<option value="listNum" <?php if($searchitems_user_list=="listNum") echo "selected";?>>购物车编号</option>
                    <!--
					<option value="userNum" <?php if($searchitems_user_list=="userNum") echo "selected";?>>用户编号</option>
                    -->
					<option value="goodsNum" <?php if($searchitems_user_list=="goodsNum") echo "selected";?>>商品编号</option>
					<option value="listAmount" <?php if($searchitems_user_list=="listAmount") echo "selected";?>>购买数量</option>
				</select>
				<input  name="search_content_user_list" type="text" class="searchbar" value="<?php echo $search_content_user_list; ?>">
				<input type="submit" class="button" value="搜索">
			</form>
			<form action="user_list.php?do=search" method="post" class="search">
				<select name="searchitems_user_list" id="searchitems">
					<option value="listNum" <?php if($searchitems_user_list=="listNum") echo "selected";?>>购物车编号</option>
                    <!--
					<option value="userNum" <?php if($searchitems_user_list=="userNum") echo "selected";?>>用户编号</option>
                    -->
					<option value="goodsNum" <?php if($searchitems_user_list=="goodsNum") echo "selected";?>>商品编号</option>
					<option value="listAmount" <?php if($searchitems_user_list=="listAmount") echo "selected";?>>购买数量</option>
				</select>
				<input name="search_content_user_list" type="text" class="searchbar" value="<?php echo $search_content_user_list; ?>">
				<input type="submit" class="button" value="搜索">
			</form>
		</div>
	<div class="showtable">
		<table>
			<thead>
				<tr>
				<th>购物车编号</th>
                <!--
				<th>用户编号</th>
                -->
				<th>商品编号</th>
				<th>购买数量</th>
				<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($rows as $row) :?>
				<tr>
					<td><?php echo $row['listNum'];?></td>
                    <!--
					<td><?php echo $row['userNum'];?></td>
                    -->
					<td><?php echo $row['goodsNum'];?></td>
					<td><?php echo $row['listAmount'];?></td>
					<td>
						<a href="user_list_modify.php?listNum=<?php echo $row['listNum'];?>&&action=modify">修改</a>
						<a href="user_list.php?do=delete&listNum=<?php echo $row['listNum'];?>">删除</a>
						<!--修改操作传输eid来判断是否是修改操作-->
					</td>
				</tr>
				<?php endforeach;?>
			</tbody>						
		</table>
	</div>
	<div class="pagenav">
		<?php
			$hrefprev = "<a href='user_list.php?page=%u'><img src=%s ></a>";
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
			$hrefnext = "<a href='user_list.php?page=%u'><img src=%s ></a>";
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
		<a class="addbutton" href="user_list_balance.php">结算</a>
	</div>
</body>
</html>