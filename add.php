<?php 
header('content-type:text/html; charset=utf-8');
function add() {



//TODO:判断标题、歌手名是否存在并保存
if(empty($_POST['title'])){
  $GLOBALS['error_message']='请输入音乐标题';
  return;
}
if(empty($_POST['artist'])){
  $GLOBALS['error_message']='请输入歌手名称';
  return;
}

$title=$_POST['title'];
$artist=$_POST['artist'];

$data=array();
$data['id']=uniqid();
$data['title']=$title;
$data['artist']=$artist;



//TODO:判断图片是否存在，上传错误，大小，类型，将其保存到文件中，再将地址保存在数组中
//?如果没有切掉文本域还是提示这个 呢就死enctype属性写错了


if(empty($_FILES['images'])){
  $GLOBALS['error_message']='请正确使用图片表单';
  return;
}

$images=$_FILES['images'];
// var_dump($images);

for($i=0; $i<count($images['name']); $i++){
  if($images['error'][$i]!==UPLOAD_ERR_OK){
    $GLOBALS['error_message']='上传图片有误';
    return;
  }
  if($images['size'][$i] > 1*1024*1024){
    $GLOBALS['error_message']='图片过大';
    return;
  }
  //？strpos--------字符串在文件中出现的位置
  if(strpos($images['type'][$i],'image/')!==0){
    $GLOBALS['error_message']='图片类型错误';
    return;
  }
//?图片的临时目录tem_name总是忘记
//?目录的判断
  $target='./uploads/' . uniqid() . $images['name'][$i];
  if(!move_uploaded_file($images['tmp_name'][$i],$target)){
    $GLOBALS['error_message']='文件移动失败';
    return;
  }

  //保存绝对目录
  $catalog='music'.substr($target,1);
  $data['images'][]=$catalog;
}


  
 

//TODO:判断音乐是否存在，上传错误，大小，类型，将其保存到文件中，再将地址保存在数组中
//
//
if(empty($_FILES['source'])){
  $GLOBALS['error_message']='请正确使用音乐表单';
  return;
}

$source=$_FILES['source'];
// var_dump($source);


  if($source['error']!==UPLOAD_ERR_OK){
    $GLOBALS['error_message']='上传音乐有误';
    return;
  }
  if($source['size'] > 5*1024*1024){
    $GLOBALS['error_message']='音乐过大';
    return;
  }
  
  $arr=array('audio/mp3,audio/mwa');
  if(in_array($source,$arr)){
    $GLOBALS['error_message']='音乐文件类型不识别';
    return;
  }
//?图片的临时目录tem_name总是忘记
  $target='./uploads/' . uniqid() . $source['name'];
  if(!move_uploaded_file($source['tmp_name'],$target)){
    $GLOBALS['error_message']='文件移动失败';
    return;
  }

  //保存绝对目录
  $catalog='music'.substr($target,1);
  $data['source']=$catalog;

  // 将数据保存到json文件中
  // ?如果提示说push数组那就要检查一下json文件
  $content=json_decode(file_get_contents('data.json'),true);
  //将data数组追加进来
  //?追加arr_push
  array_push($content,$data);
  // $new=array_push($content,$data);
  // var_dump($new);
  // var_dump($content);


  //?为什么这里用$new不合适
  file_put_contents('data.json',json_encode($content));

// $json = file_get_contents('data.json');
//   $old = json_decode($json, true);
//   array_push($old, $data);
//   $new_json = json_encode($old);
//   file_put_contents('data.json', $new_json);
  header('Location:list.php');


}
//TODO:判断POST提交来的表单是否存在

if($_SERVER['REQUEST_METHOD']==='POST'){
 add();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>添加新音乐</title>
  <link rel="stylesheet" href="bootstrap.css">
</head>
<body>
  <div class="container py-5">
    <h1 class="display-4">添加新音乐</h1>
    <hr>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
      <div class="form-group">
        <label for="title">标题</label>
        <input type="text" class="form-control" id="title" name="title">
      </div>
      <div class="form-group">
        <label for="artist">歌手</label>
        <input type="text" class="form-control" id="artist" name="artist">
      </div>
      <div class="form-group">
        <label for="images">海报</label>
        <input type="file" class="form-control" id="images" name="images[]" accept="image/*" multiple>
      </div>
      <div class="form-group">
        <label for="source">音乐</label>
        <input type="file" class="form-control" id="source" name="source" accept="audio/*">
      </div>
      <button class="btn btn-primary btn-block">保存</button>
      <div>
      <?php if(isset($error_message)){
        echo $error_message;
        }
        ?>
      </div>
    </form>
  </div>
</body>
</html>
