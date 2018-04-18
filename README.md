# H-UI+TP5 后台管理系统

### Q：遇到的问题
- 1.1 上传图片过大，无法上传

### A:解决方法
1.1 修改 `php.ini` 配置
- upload_max_filesize = 200M
- post_max_size = 200M
- memory_limit = 200M
- 重启apache 

### Q：TP5 官方多图上传文档无法使用
````
public function upload(){
    // 获取表单上传文件
    $files = request()->file('image');
    foreach($files as $file){
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            // 成功上传后 获取上传信息
            // 输出 jpg
            echo $info->getExtension(); 
            // 输出 42a79759f284b767dfcb2a0197904287.jpg
            echo $info->getFilename(); 
        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }    
    }
}
````

### A：可改为如下即可

````
public function upload(){
    // 获取表单上传文件
    $files = request()->file('image');
    foreach($files as $file){
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            //注意此处 echo 会导致循环中断，不可使用
        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }    
    }
}
````

### 数据分组换行输出
````
<div class="row">
        {volist name="list" id="vo" mod="6"}
        <div class="col-sm-6 col-md-4 col-lg-4">
        {eq name="mod" value="2"}</div> <div class="row">{/eq}
        {/volist}
</div>
````
 - 第1行的 mod 是指，你要显示几条记录；
 - 第2行的 value 是到了第几个换行（从0开始，0表示第1个，1表示第2个...），
 - 这里是3，也就是到了第4个就换行。即：第5条记录开始是第2行。
 - [详细介绍](http://www.thinkphp.cn/topic/5890.html)
### Q：图片上传裁剪

### Q：tp5分页 变量名必须是 $list吗？
```
{$list->render()}
```
#### A：

### taskList
- 数据表数据创建时间和修改时间要分开
- 修改上传的图片之前删除旧照片
- 优化新闻修改重复代码

> Q：tp5 如何验证用户是否登录？



> A： - TP提供了一个自动执行的函数_initialize(), 你创建一个公共控制器CommonController.php文件
```php
    public function _initialize()
    {
        if (!Session::has('curUser','think')){
            $this->error('请先登录！','User/login',null,1);
        }
    }
```

- 之后所有的控制器都继承这个公共控制器
```php
    class Index extends Common
    {
       public function index(){
       
        }
    }
```

# tp5 多文件上传问题！只有一张图片
解决办法：修改框架thinkphp\library\think\File.php文件中，大概在348行开始。
[github在此处已经表明修改部分](https://github.com/adymilk/ShengTeng-Group/commit/1aa29add9f6b065c4d1fcad05f6ad0903901698a)
[详情点击这里查看解决方法](https://www.csweigou.com/article/1858.html)

# Q：解决后台添加案例用户可能重复提交的问题。
## A：解决方案
- 用隐藏体按钮，然后弹出一个模态框提示信息：数据真正提交中，请稍等

# url中文传参问题
url直接拼接中文会引起乱码问题，可用此方法解决
```
?c=city&city=<?php echo urlencode('呼和浩特')?>
```

# banner图片上传思路图
选择图片->ajax提交到后台->移动到指定目录