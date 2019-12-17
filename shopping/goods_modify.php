<?php
	/*包含一个配置文件*/
	include('config.php');
	session_start();
	/* 判断是添加还是修改操作 */
	$action=isset($_GET['action'])?$_GET['action']:'none';
	$goodsnumtemp=isset($_GET['goodsNum'])?$_GET['goodsNum']:'0000';
	$goodsicine=array(
					'goodsName'=>'',
					'goodsNum'=>'',
					'goodsPri'=>'',
					//'goodsSto'=>'',
				);
				
	$judge = false;
	/* 如果eid>0，则为修改操作 */
	if($action=='modify'){
		$sql="select * from goodstb where goodsNum='{$goodsnumtemp}'";

		//echo $sql."<br>";
		//exit();

		$res=$db->query($sql);
		$goodsicine=$res->fetch_array(MYSQLI_ASSOC);
		$judge = true;
	}

	if($input->get('do')=='add'){

		$goodsNum=$input->post('goodsNum2');
		$goodsName=$input->post('goodsName2');
		$goodsPri=$input->post('goodsPri2');

		//echo $goodsNum."<br>".$goodsName;
		//exit();

		//$goodsSto=$input->post('goodsSto2');
		
		/* 判断 */
		if(empty($goodsNum)||empty($goodsName)){
			echo "<script language=javascript>alert('商品编号和商品名称不能为空！');</script>";
		}

		/* 修改操作 */
		if($action=='modify'){

			$sql="UPDATE goodstb SET goodsName = '{$goodsName}' , goodsPri='{$goodsPri}' WHERE goodsNum = '{$goodsNum}'";
			

			
		}
		/* 修改更新操作 */
		else{
			$sql="UPDATE goodstb SET goodsName = '{$goodsName}' , goodsPri='{$goodsPri}' WHERE goodsNum = '{$goodsNum}'";
			
		}

		/*判断是否有结果*/
		$is=$db->query($sql);
		if($is){

			/* 添加成功 */
			header("location:goods.php");
			
		}else{
			
			echo "<script language=javascript> alert('操作失败！{$goodsName}+{$goodsNum}');location.href='goods.php';</script>";
			//echo "<script language=javascript>alert('操作失败！');</script>";
			//header("location:goods.php");
			
		}

	
	}
?>
<?php
	include_once 'inc/tool.inc.php';
	
	//echo $_SESSION['account'];
	
	$_SESSION['aid']=$_SESSION['account'];
	if(strcmp($_SESSION['aid'],'root')!=0)
	{
		skip('demo.php','error','请登录！');
	}
	
 ?>


<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>管理员页面</title>
  <link rel="stylesheet" href="./css/admin_add.css">
 </head>
 <body>
	<div class="nav">
		<div class="navtitle">
			<h1>商品</h1>
		</div>
		<div class="navchoice">
			
		</div>
	</div>

	<div class="main">

		<div id="main">
			<div class="right-wrapper-top">
				<h2>商品表</h2>
			</div>
			<div class="right-wrapper-content">
				<form action="goods_modify.php?do=add" method="post">

					<label for="" display:none>商品编号:</label>
					<input readonly name="goodsNum2" type="text" value='<?php echo $goodsicine['goodsNum'];?>' readonly>
					<br>
					<label for="">商品名称:</label>
					<input name="goodsName2" type="text" value='<?php echo $goodsicine['goodsName'];?>'>
					<br>
					<label for="">商品价格:</label>
					<input name="goodsPri2" type="text" value='<?php echo $goodsicine['goodsPri'];?>'>
					<!--
					<br>
					<label for="">商品库存:</label>
					<input name="goodsSto2" type="text" value='<?php echo $goodsicine['goodsSto'];?>'>
					-->
					<br><br><br>
					<input type="submit" value="确认" class="button">
				</form>
			</div>

			
		</div>
	</div>
 </body>
</html>