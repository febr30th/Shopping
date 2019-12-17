<?php
	/*包含一个配置文件*/
	include('config.php');
	session_start();
	/* 判断是添加还是修改操作 */
	$action=isset($_GET['action'])?$_GET['action']:'none';
	$listnumtemp=isset($_GET['listNum'])?$_GET['listNum']:'0000';
	$listicine=array(
					'listNum'=>'',
					'userNum'=>'',
					'goodsNum'=>'',
					'listAmount'=>'',
				);
				
	$judge = false;
	/* 如果eid>0，则为修改操作 */
	if($action=='modify'){
		$sql="select * from listtb where listNum='{$listnumtemp}'";

		//echo $sql."<br>";
		//exit();

		$res=$db->query($sql);
		$goodsicine=$res->fetch_array(MYSQLI_ASSOC);
		$judge = true;
	}

	if($input->get('do')=='add'){

		$listNum=$input->post('listNum2');
		$userNum=$input->post('userNum2');
		$goodsNum=$input->post('goodsNum2');
		$listAmount=$input->post('listAmount2');
		
		/* 判断 */
		if(empty($listNum)){
			echo "<script language=javascript>alert('商品编号和商品名称不能为空！');</script>";
		}

		/* 修改操作 */
		if($action=='modify'){

			$sql="UPDATE listtb SET userNum = '{$userNum}' , goodsNum='{$goodsNum}',listAmount= '{$listAmount}' WHERE listNum = '{$listNum}'";
			

			
		}
		/* 修改更新操作 */
		else{
			$sql="UPDATE listtb SET userNum = '{$userNum}' , goodsNum='{$goodsNum}',listAmount= '{$listAmount}' WHERE listNum = '{$listNum}'";
			
		}



		/*判断是否有结果*/
		$is=$db->query($sql);
		if($is){

			/* 添加成功 */
			header("location:user_list.php");
			
		}else{
			
			echo "<script language=javascript> alert('操作失败！');location.href='user_list.php';</script>";
			//echo "<script language=javascript>alert('操作失败！');</script>";
			//header("location:goods.php");
			
		}

	
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
				<form action="user_list_modify.php?do=add" method="post">
					<label for="">订单编号:</label>
					<input readonly name="listNum2" type="text" value='<?php echo $goodsicine['listNum'];?>' readonly>
					<br>
					<label for="">用户编号:</label>
					<input readonly name="userNum2" type="text" value='<?php echo $goodsicine['userNum'];?>'>
					<br>
					<label for="">商品编号:</label>
					<input readonly name="goodsNum2" type="text" value='<?php echo $goodsicine['goodsNum'];?>'>
					<br>
					<label for="">购买数量:</label>
					<input name="listAmount2" type="text" value='<?php echo $goodsicine['listAmount'];?>'>
					<br><br><br>
					<input type="submit" value="确认" class="button">
				</form>
			</div>

			
		</div>
	</div>
 </body>
</html>