<?php
	session_start(); 
	include_once 'inc/config.inc.php';
	include_once 'inc/mysql.inc.php';
	include_once 'inc/tool.inc.php';
	$link=connect();
?>
<?php 
	include_once 'inc/user_header.inc.php';
	include_once 'inc/page.php';
    $userNum=$_SESSION['userNum'];
?>
<div id="main">
<?php
$query1="SELECT * FROM `listtb` WHERE userNum='{$userNum}'";
$result1=execute($link,$query1);
while ($data=mysqli_fetch_assoc($result1))
{
	$goodsNum=$data['goodsNum'];
	//
	/*
	$query_listtb="SELECT * FROM `listtb` WHERE goodsNum='{$goodsNum}'";
	$result2=execute($link,$query_listtb);
	while ($data2=mysqli_fetch_assoc($result2))
	{
	*/
		$htmlTable=<<<EOF
<div>
	<table border="1" style="background-color: #98FB98" width='700px'>
		<tr>
			<th>&nbsp&nbsp&nbsp&nbsp</th>
			<th>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
		</tr>
		<tr>
			<th>商品编号</th>
			<th>{$data['goodsNum']}</th>
		</tr>
		<tr>
			<th>购买数量</th>
			<th>{$data['listAmount']}</th>
		</tr>
	</table>
</div>
EOF;
		echo $htmlTable;
		echo "<div><table border='1' style='background-color: #AFEEEE' width='700px'>";
		$goodsNum=$data['goodsNum'];
	/*
	}
	*/
}
?>
<div class="right-wrapper">
	<div>
		<a class="addbutton" href="user_address.php">确定</a>
	</div>
</div>
</div>
