<?php 
header('Content-type:text/html;charset=utf-8');
define('DB_HOST','127.0.0.1');
define('DB_USER','root');
define('DB_PASSWORD','123456');
define('DB_DATABASE','shopping');

?>

<?php 
//数据库连接
function connect($host=DB_HOST,$user=DB_USER,$password=DB_PASSWORD,$database=DB_DATABASE)
{
    $link=mysqli_connect($host, $user, $password, $database);
    mysqli_set_charset($link,'utf8');
	if(mysqli_connect_errno())
    {
		exit(mysqli_connect_error());
	}
	mysqli_set_charset($link,'utf8');
	return $link;
}

//执行一条SQL语句,返回结果集对象或者返回布尔值
function execute($link,$query)
{
	$result=mysqli_query($link,$query);
    if(mysqli_errno($link))
    {
		exit(mysqli_error($link));
	}
	return $result;
}

//执行一条SQL语句，只会返回布尔值
function execute_bool($link,$query)
{
	$bool=mysqli_real_query($link,$query);
	if(mysqli_errno($link))
	{
		exit(mysqli_error($link));
	}
	return $bool;
}

//一次性执行多条SQL语句
function execute_multi($link,$arr_sqls,&$error)
{
	$sqls=implode(';',$arr_sqls).';';
    if(mysqli_multi_query($link,$sqls))
    {
		$data=array();
		$i=0;//计数
        do 
        {
            if($result=mysqli_store_result($link))
            {
				$data[$i]=mysqli_fetch_all($result);
				mysqli_free_result($result);
            }
            else
            {
				$data[$i]=null;
			}
			$i++;
            if(!mysqli_more_results($link))
                break;
		}while (mysqli_next_result($link));
        if($i==count($arr_sqls))
        {
			return $data;
        }
        else
        {
			$error="sql语句执行失败：<br />&nbsp;数组下标为{$i}的语句:{$arr_sqls[$i]}执行错误<br />&nbsp;错误原因：".mysqli_error($link);
			return false;
		}
    }
    else
    {
		$error='执行失败！请检查首条语句是否正确！<br />可能的错误原因：'.mysqli_error($link);
		return false;
	}
}

//获取记录数
function num($link,$sql_count)
{
	$result=execute($link,$sql_count);
	$count=mysqli_fetch_row($result);
	return $count[0];
}

//数据入库之前进行转义，确保，数据能够顺利的入库
function escape($link,$data)
{
	if(is_string($data))
	{
		return mysqli_real_escape_string($link,$data);
	}
	if(is_array($data))
	{
		foreach ($data as $key=>$val)
		{
			$data[$key]=escape($link,$val);
		}
	}
	return $data;
	//mysqli_real_escape_string($link,$data);
}

//关闭与数据库的连接
function close($link)
{
	mysqli_close($link);
}

?>


<?php
    
	include 'PHPMailer/email.php';

    $link=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,'');
    mysqli_set_charset($link,'utf8');

    mysqli_select_db($link,DB_DATABASE);

    connect();
    
    session_start();
    
	/*包含一个配置文件*/
	include('config.php');
    
    if($input->get('do')=='check')
    {
        $Add=$input->post('Add');
        $Mail=$input->post('Mail');
        $userNum=$_SESSION['userNum'];
        $query1="SELECT * FROM `listtb` WHERE userNum='{$userNum}'";
        $result1=execute($link,$query1);
        $text='';
        while ($data=mysqli_fetch_assoc($result1))
        {

            //设置当前时间
            date_default_timezone_set("Asia/Shanghai");
            $da=date("Y-m-d ").date("G:i:s");


            $goodsNum=$data['goodsNum'];
            $amount=$data['listAmount'];
            //echo " ";

            $sql="INSERT INTO buytb(buyNum, userNum, goodsNum, amount, buyTime, buyAddress) VALUES ('0','$userNum','$goodsNum','$amount','$da','$Add')";
            //echo $sql."<br>";
            $bool_3=execute_bool($link,$sql);

            $sql="DELETE FROM `listtb` WHERE goodsNum='$goodsNum' and userNum='$userNum'";
            //echo $sql."<br>";
            $bool_4=execute_bool($link,$sql);

            if($bool_3==1 and $bool_4==1)
            {
                echo "成功写入数据库"."<br>";
            }
            else
            {
                echo "未成功写入"."<br>";
            }
            //echo "<br>";
            $text=$text."\n"."商品编号：".$goodsNum." 购买数量：".$amount;
        }
        $text=$text."\n"."购买时间：".$da."\n"."收货地址：".$Add;
        echo $text."\n";
        //echo $Mail;
        //sendMail('694848614@qq.com','会议主题','今天下午开会');
        //sendMail('694848614@qq.com','订单','确认');
        sendMail($Mail,"订单",$text);
        header("location:user.php");
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
		<h1>-- 请输入收货地址 --</h1>
		<form action="user_address.php?do=check" method="post">
			<label>地址：</label>
			<input type="text" name="Add"><br><br>
			<label>邮箱：</label>
			<input type="text" name="Mail"><br><br>


			<br><br>
			<input type="submit" value="确定" class="button">
			<a href="user_list_balance.php"><input type="button" value="取消" class="button"></a>
		</form>
	</div>

 </body>
</html>