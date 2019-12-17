<?php
	/*包含一个配置文件*/
	include('config.php');
	//$conn = mysqli_connect("localhost", "root","","admin");
	if($input->get('do')=='check'){

		/*获取用户页面注册传来的用户名和密码数据*/
		//$userid=$input->post('userid');
		$password=$input->post('password');
		$confirmpassword=$input->post('confirmpassword');
		/*注册时的处理*/
		if($password!=$confirmpassword){
			echo "<script language=javascript>

						document.getElementById(\"password\").value=\"\";
						document.getElementById(\"confirmpassword\").value=\"\";

				  </script>";
			echo "<h2 align=center>前后两次输入的密码不一致!三秒后自动跳转~~~</h2>  ";
			header("refresh:3;url=register.php");
			exit;
		}else{

			/*获取用户页面注册传来的数据*/
			$userName=$input->post('userName');
			$userBrithday=$input->post('userBrithday');
			$usersex=$input->post('userSex');
			$userIDCard=$input->post('userIDCard');
			$userPassword=$input->post('password');
			
			if($input->post('usersex')=='男')
				{
					$userSex=1;
				}
			else
				{
					$userSex=0;
				}

			$sqluserient="INSERT INTO `usertb` (`userPassword`, `userName`, `userSex`, `userIDCard`) 
			VALUES ('$userPassword', '$userName', '$userSex', '$userIDCard')";
			//$sqlpuser="INSERT INTO users(`aid`,`apassword`,`aidentify`) values ('$pid','$password','2')";
			/*提交sql语句到数据库处理*/
			$isuserient=$db->query($sqluserient);
			//$ispuser=$db->query($sqlpuser);
			//echo "<br>";
			//echo "$sqluserient";
			/*判断是否注册成功*/
			//if($isuserient&&$ispuser){
			//var_dump($isuserient);
			if($isuserient)
			{
				$sql = "select userNum from usertb where userIDCard=$userIDCard"; //Sql语句
				$mysqli_result=$db->query($sql);
				$row=$mysqli_result->fetch_array(MYSQLI_ASSOC);
				echo "<script language=javascript>
							alert(\"注册成功，您的账号为：{$row['userNum']}\");
							location.href=\"demo.php\";
						</script>";

			}
			else
			{
				echo "<h2 align=center>注册失败!三秒后自动跳转~~~</h2>";
				header("refresh:3;url=register.php");
			}
			exit();
		}

	}
 
 
?>

<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Author" content="kkim">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>注册页</title>
	<style>
	  body{
		margin:0;
		background:url(login_bg.jpg);
		background-size: cover;
		background-repeat: no-repeat;
	  }
	  .input_bg{
		width:30%;
		height:630px;
		min-height:360px;
		margin:100px auto;
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
		font-size:16px;
		text-indent:0.5em;
		border: none;
		color:#000;
	  }

	  .button{
		width:30%;
		margin-top:20px;
		border-radius:20px;
		background-color: #fff;
		color:rgba(74,165,255,1);
		font-size:18px;
		border: none;
		text-indent:0em;
	  }
	  form{
	  	width: 70%;
		margin:2px auto;
		text-align:left;
	  }
	  label{
		font-weight:bold;
	  }
	  input+span{
		color:#f00;
	  }
	</style>
 </head>
 <body>
	<div class="input_bg">
		<h1>-- 购物系统 --</h1>
		<form action="register.php?do=check" method="post">   
				<label for="">姓&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp名：</label>
				<input type="text" name="userName">
				<br>
				<label for="">性&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp别：</label>
				<input type="radio" name="userSex" class="radioinput" value="男">男
                <input type="radio" name="userSex" class="radioinput" value="女">女
                <br>
				<label for="">身份证号：</label>
				<input type="number" name="userIDCard">
				<br>

				<label for="">密&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp码：</label>
				<input type="password" name="password" id="password">
				<br>
				<label for="">确认密码：</label>
				<input type="password" name="confirmpassword" id="confirmpassword">
				<p>
					注：姓名、身份证号填写后不可修改
				</p>
				<br>
				<center><input type="submit" value="注&nbsp&nbsp&nbsp册" class="button"></center>
				<br>
		</form>
	</div>

 </body>
</html>
