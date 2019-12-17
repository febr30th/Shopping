<?php
	session_start(); 
	include_once 'inc/config.inc.php';
	include_once 'inc/mysql.inc.php';
	include_once 'inc/tool.inc.php';
	$link=connect();
?>
<?php 
	include_once 'inc/header.inc.php';
	include_once 'inc/page.php';
?>
<div id="main">
<?php
//1.查询病人对应的挂号编号
//?.查询商品对应的编号
$query1="SELECT * FROM `buytb` WHERE goodsNum='{$_GET['goodsNum']}'";
$result1=execute($link,$query1);
while ($data=mysqli_fetch_assoc($result1))
{
	$goodsNum=$data['goodsNum'];
	//2.查询挂号编号对应的处方编号+查询处方编号对应的医生信息
	/*
	$query_buytb="SELECT * FROM `buytb` WHERE goodsNum='{$goodsNum}'";
	$result2=execute($link,$query_buytb);
	while ($data2=mysqli_fetch_assoc($result2))
	{
	*/
		$htmlTable=<<<EOF
<div>
	<table border="1" style="background-color: #98FB98" width='700px'>
		<tr>
			<th>购买编号{$data['buyNum']}</th>
			<th>购买时间{$data['buyTime']}</th>
    	</tr>
		<tr>
			<td>商品编号</td>
			<td>{$data['goodsNum']}</td>
		</tr>
		<tr>
			<td>用户编号</td>
			<td>{$data['userNum']}</td>
		</tr>
		<tr>
			<td>购买数量</td>
			<td>{$data['amount']}</td>
		</tr>
		<tr>
			<td>购买地址</td>
			<td>{$data['buyAddress']}</td>
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
</div>
<?php
	include_once 'inc/tool.inc.php';
	
	//echo $_SESSION['account'];
	
	$_SESSION['aid']=$_SESSION['account'];
	if(strcmp($_SESSION['aid'],'root')!=0)
	{
		skip('demo.php','error','请登录！');
	}
	
 ?>

