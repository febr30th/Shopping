<?php
/*
һ���������ļ�
 */ 
	/*������input*/
	class input{
		/*�෽��get����get������ȡҳ��д�������*/
		function get($key=false){
			if($key === false){
				return $_GET;
			}
			if(isset($_GET[ $key ])){
				return $_GET[ $key ];
			}else{
				return false;
			}
		}
		/*�෽��post����post������ȡҳ��д�������*/
		function post($key=false){
			if($key === false){
				return $_POST;
			}
			if(isset($_POST[ $key ])){
				return $_POST[ $key ];
			}else{
				return false;
			}
		}
		/*�෽��session��Ŀ����Ϊ����֤session�Ƿ�������*/
		function session($key=false){
			if($key === false){
				return $_SESSION;
			}
			if(isset($_SESSION[ $key ])){
				return $_SESSION[ $key ];
			}else{
				return false;
			}
		}
	}
?>