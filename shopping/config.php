<?php
/*
整体配置文件
 */
	/*将当前文件所在的路径赋值于PATH这个变量，这里注意的是FILE前后是双下划线*/
	/*包含数据库连接类这个文件*/
	include('./core/db.class.php');
	/*生成一个db的对象*/
	$db = new db();
   
   	/*包含一个输入类一个文件*/
    include('./core/input.class.php');
    /*生成一个input对象*/
    $input = new input();
?>