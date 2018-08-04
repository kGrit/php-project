<?php 
header('content-type:text/html;charset=utf-8');
//获取Id 判断是否存在
//获取原来的文件
//进行删除
//在保存文件 
//跳转
//
if(empty($_GET['id'])){
exit("没有这个参数");
 }

$id=$_GET['id'];

$content=json_decode(file_get_contents('data.json'),true);

foreach ($content as $value) {
	if($value['id']!==$id) continue;
	
	$index=array_search($value,$content);
	array_splice($content,$index,1);
	file_put_contents('data.json',json_encode($content));

	header('Location:list.php');

}
