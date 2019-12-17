<?php 
$lifeTime = 24 * 3600;
session_set_cookie_params($lifeTime);
session_start();?>
<?php

/*
登录窗口
 */ 
	
	/*包含一个配置文件*/
	include('config.php');
	

	if($input->get('do')=='check'){
		 /*获取页面提交的用户名和密码数据*/
		$chioce=$input->post('identify');
		if($chioce==1)
			{
	 			$goodsNum=$input->post('Num');
	 			$goodsPassword=$input->post('Password');

				 /*查询页面提交的数据是否在数据库提供的数据存在的sql语句*/
	 	 		$sql=" select * from goodstb where goodsNum='{$goodsNum}' and goodsPassword='{$goodsPassword}' ";
	 	 		/*数据库查询语句返回结果*/
	 	 		$mysqli_result=$db->query($sql);

				if($mysqli_result)
					{

						/*以数组形式存储数据库查询语句的返回结果*/
						$row=$mysqli_result->fetch_array(MYSQLI_ASSOC);

						if(is_array($row))
						{
							$_SESSION['goodsNum']=$goodsNum;
							$_SESSION['userNum']=null;//只能是医生或病人一个不为空
							echo("账户密码正确");
							//header("location:goodsCheck.php");
							header("location:goodsient_dep.php?pid=$aid");
							//header("location:zhixuanTest.html");
						}
						else
				{
					echo "<script language=javascript>
							alert(\"账号或密码错误！\");
				  		</script>";
				}
					}
		  		
			}
		else if($chioce==0)
		{
				$userNum=$input->post('Num');
	 			$userPassword=$input->post('Password');

				 /*查询页面提交的数据是否在数据库提供的数据存在的sql语句*/
	 	 		$sql=" select * from usertb where userNum='{$userNum}' and userPassword='{$userPassword}' ";
	 	 		/*数据库查询语句返回结果*/
	 	 		$mysqli_result=$db->query($sql);
				if($mysqli_result)
				{

						/*以数组形式存储数据库查询语句的返回结果*/
						$row=$mysqli_result->fetch_array(MYSQLI_ASSOC);

						if(is_array($row))
						{
							$_SESSION['userNum']=$userNum;
							$_SESSION['account']=$userNum;
							$_SESSION['$goodsNum']=null;
							echo("账户密码正确");
							header("location:user.php");//看医生需要进什么页面还是什么的,可以整合时修改
						}
						else
					{
						echo "<script language=javascript>
							alert(\"账号或密码错误！\");
				  		</script>";
					}
						

				}
				
		  		
		}
		else if($chioce==2)
		{
				$yaofangNum=$input->post('Num');
	 			$yaofangPassword=$input->post('Password');
				if($yaofangNum=="admin"&&$yaofangPassword=="123456")
				{
					echo("账户密码正确");
					header("location:../jiang/medicine.php");//药房管理员
				}
				else
				{
					echo "<script language=javascript>
							alert(\"账号或密码错误！\");
				  		</script>";

				}
		  		
		}
		else if($chioce==3)
		{
			$qiantaiNum=$input->post('Num');
			$qiantaiPassword=$input->post('Password');
		   if($qiantaiNum=="root"&&$qiantaiPassword=="123456")
		   {
			   echo("账户密码正确");
			   $_SESSION['account']='root';
			   //echo $_SESSION['account'];
			   //exit();
			   header("location:goods.php");//管理员
		   }
		   else
		   {
			   echo "<script language=javascript>
					   alert(\"账号或密码错误！\");
					 </script>";
		   }
		  		
		}
	}

?>

<!usertype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Author" content="kkim">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>购物系统登录页</title>
  <!-- 内联样式 -->
  <style>
  body{
	margin:0;
	background:url(images/login_bg.jpg);
	background-size: cover;
	background-repeat: no-repeat;
  }
  .input_bg{
	width:30%;
	height:30%;
	min-height:360px;
	margin:120px auto;
	padding:20px;
	background-color: rgba(74,165,255,0.8);
	border-radius:20px;
	color:#fff;
	text-align:center;
	
  }
  .input_bg label+input{
	margin-top:20px;
  }
  input{
	border-radius:20px;
	font-size:18px;
	text-indent:0.5em;
	border: none;
  }

  .button{
  	width:25%;
	margin-top:20px;
	border-radius:20px;
	background-color: #fff;
	color:rgba(74,165,255,1);
	font-size:18px;
	border: none;
	text-indent:0em;
  }
 
  </style>
 </head>
 <body>
	<div class="input_bg">
		<h1>-- 购物系统 --</h1>
		<form action="demo.php?do=check" method="post">
			<label>账号： </label>
			<input type="text" name="Num"><br><br>
			<label>密码： </label>
			<input type="password" name="Password"><br><br>

			<input name="identify" type="radio" id="user_nur" value="0" checked><label for="user_nur">用户</label>
  			<!--
			<input name="identify" type="radio" id="goodsient" value="1"><label for="goodsient">就诊患者</label>
			<input name="identify" type="radio" id="goodsient" value="2"><label for="goodsient">库房/财务管理员</label>
			-->
			<input name="identify" type="radio" id="goodsient" value="3"><label for="goodsient">管理员</label>
			<br><br>
			<input type="submit" value="登录" class="button">
			<a href="register.php"><input type="button" value="注册" class="button"></a>
		</form>
	</div>

 </body>
</html>