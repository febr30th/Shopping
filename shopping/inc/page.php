<?php 
header("content-type:text/html;charset:utf-8");
function page($count,$page_size,$num_btn=10,$page='page')
{

  if(!isset($_GET[$page]) || !is_numeric($_GET[$page]) || $_GET[$page]<1||$count==0)
  {
    $_GET[$page]=1;
  }

  //总页数
  $page_num_all=ceil($count/$page_size);
//若页数大于总页数
  if($_GET[$page]>$page_num_all)
  {
    $_GET[$page]=$page_num_all;
  }
//当前页开始数据
  $start=($_GET[$page]-1)*$page_size;
  if($count==0)
    $start=0;
  $limit="limit {$start},{$page_size}";
//  echo "当前页".$_GET[$page]."<br>";

  //获取并解析URL地址
  $current_url=$_SERVER['REQUEST_URI'];
  $arr_current=parse_url($current_url);

  //得到path部分
  $current_path=$arr_current['path'];
  $url='';
  if(isset($arr_current['query']))
  {
    parse_str($arr_current['query'],$arr_query);
    unset($arr_query[$page]);
    if(empty($arr_query)){
      $url="{$current_path}?{$page}=";
    }
    else
    {
      $other=http_build_query($arr_query);
      $url="{$current_path}?{$other}&{$page}=";
    }
  }
  else
  {
    $url="{$current_path}?{$page}=";
  }

 // echo $url.'<br>';

  




  //开始编写html部分
  $html=array();


  //当显示按钮数大于大于总页数是，全部显示
  if($num_btn>=$page_num_all){
    //把所有的页码按钮全部显示
    for($i=1;$i<=$page_num_all;$i++){//这边的$page_num_all是限制循环次数以控制显示按钮数目的变量,$i是记录页码号
      if($_GET[$page]==$i){
        $htm[$i]="<span>{$i}</span> ";
      }else{
        $html[$i]="<a href='{$url}{$i}'>{$i}</a> ";
      }
    }
  }
  else //显示一部分
  {
    $num_left=floor(($num_btn-1)/2);   
    $start=$_GET[$page]-$num_left;   //起始页数
    $end=$start+($num_btn-1);
   
    if($start<1){
      $start=1;
    }
    if($end>$page_num_all){
      $start=$page_num_all-($num_btn-1);  
    }
   // echo "开始按钮号".$start."<br>";
   // echo '结束按钮号'.$end.'<br />';

    //开始工具start的值显示
    for($i=0;$i<$num_btn;$i++){
   //   echo $i.'<br>';
      if($_GET[$page]==$start){
        $html[$i]="<span>{$start}</span> ";
      }else{
        $html[$i]="<a href='{$url}{$start}'>{$start}</a> ";
      }
      $start++;
    }

    if(count($html)>=3)
    {
      reset($html);
      $key_first=key($html);
      end($html);
      $key_end=key($html);
      if($key_first!=1)
      {
        array_shift($html);
        array_unshift($html,"<a href='{$url}1'>1...</a>");
      }
      if($key_end!=$page_num_all)
      {
        array_pop($html);
        array_push($html,"<a href='{$url}{$page_num_all}'>...{$page_num_all}</a>");
      }
    }
  }
if($_GET[$page]!=1){
    $prev=$_GET[$page]-1;
    array_unshift($html,"<a href='{$url}{$prev}'>« 上一页</a>");
  }
  if($_GET[$page]!=$page_num_all){
    $next=$_GET[$page]+1;
    array_push($html,"<a href='{$url}{$next}'>下一页 »</a>");
  }
  $html=implode(' ',$html);

  $data=array(
    'limit'=>$limit,
    'html'=>$html
  );
  return $data;
}
// $page=page(12,2,4,'page');
// echo $page['html'];
 ?>
