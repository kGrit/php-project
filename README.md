# php-project
通过JSON文件实现音乐列表的增删改

# 音乐表单增删改项目
- 整体目标：通过执行代码将用户在表单上输入的内容保存起来
## list表单
- 将JSON文件放入list中   
- 将JSON文件反序列化
- 判断解析的数据是否存在
- 通过循环遍历将得到的数据放进Html格式中
    * 因为图片可以多个上传，还要嵌套一层循环
        - 易错：图片放在image标签中 音乐放入rudio中 

## add表单
- 目标 ：将用户提交的数据保存在json文件中
- 步骤 
    * 接收并校验
    * 持久化（进行保存）
    * 响应
#### 具体步骤
- 修改FORM表单的属性，添加文件域的name属性
    * action--提交表单
    * method--提交方式（有文本域用POST）
    * **enctype**--编码方式（有文本域用下列方式）
    * autocomplete--提示输入过的信息
    ```html
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
     ```
- 判断FORM表单的提交方式是否为POST
    * 设置并保存随机id值
    * 接收并保存文本文件
    * 接收并保存图片文件（单个文件域多文件上传）
        * **name里的值后面加[ ]**
        * 客户端判断图片文件--`accept="image/*"`
        * 多选文件属性---multiple
    * 接收并保存音乐文件
    * 将保存的数据加入到原有的文件中
        + 保存数据的路径**绝对路径**
    * 输出错误信息（*要先判断是否存在*）
- 网页重定向跳转


## delete表单
- 把删除链接通过url传参
- 判断id值是否存在
- 接收URL中不同的id
- 找到要删除的数据进行删除
    * `array_search()  array_splice()`
- 保存删除后的内容
- 网页重定向到List页面


### 注意点

- 当网页乱码时加上(**charset和=中间不能有空格**)
    `header('content-type:text/html;charset=utf-8');`

- 文件的读入，写入，移动
    * 读：file_get_contents('要读入的文件');
    * 写：file_put_contents('要写入数据的文件',要写入的数据)
    * 移：move_uploaded_file('文件的存储目录','移动的目录')

- 序列化和反序列化
    * decode--反序列化
        * 反序列化：把JSON格式的字符串转化为对象,json文件解析之后是对象的形式，想用关联数组的格式，要加**true**
          `jspn_decode(,true)`
    * encode--序列化

- 一些方法
    * `uniqid()`  ----生成随机数；
    * `strpos(字符串，要查找的字符串)`----返回被查找的字符串首次出现的位置
    * `substr(要返回的内容，从几返回,返回的个数)`---返回字符串的一部分；
    * `array_search('数组','键值')`---从数组中搜素键值，并返回键名(获得数组的下标)
    * `array_splic('数组','从哪里开始删除',删除的个数,要添加的新元素)`;
    * `array_push('原来的数组','要追加的数组)'`

- 文件域
    * 临时文件 `tmp_name`
    * `error`
        * 0 <=> UPLOAD_ERR_OK 文件上传成功
        * 1，2 PHP配置文件最大值
        * 4 没有文件被上传

- 路径
    * "../"表示上一级目录开始。

    * "./"表示当前同级目录开始。

    * "/"表示根目录开始。



- 关于循环结构中break、continue、return和exit的区别
   * [链接地址](https://blog.csdn.net/hunanchenxingyu/article/details/8101795)







