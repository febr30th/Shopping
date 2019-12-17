<?php
/*
�������ݿ���
 */ 
	class db{
		/*һ����construct����������ע�����ǰ����˫�»��ߣ�����construct����������Զ�ִ��*/		
		function __construct(){
			/*�������ݿ����*/
			$this->mysqli=new mysqli('localhost','root','123456','shopping');
			/*������ӳ��ִ�����ô��*/
			if ($this->mysqli->connect_error) {
	    		die('Connect Error (' . $this->mysqli->connect_errno . ') '
	            		. $this->mysqli->connect_error);
			}
			/*�������ݿ⴫���ĺ������������*/
			$this->query("SET NAMES UTF8");
		}
		/*һ����query����*/
		function query( $sql ){
			/*��query�෽����ִ�����ݿ����query*/
			return $this->mysqli->query( $sql );
		}
	}
?>