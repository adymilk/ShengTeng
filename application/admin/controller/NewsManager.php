<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/7
 * Time: 10:09
 */

namespace app\admin\controller;

use think\Db;
use think\Request;
use think\Controller;

// 新闻管理模块
class NewsManager extends Common
{

    // 1、news = 新闻动态列表
    public function menu_manager_news(){
        $list = Db::table('tbl_news')->select();
        if ($list != 0){
            $this->assign('list',$list);
            $nums = Db::table('tbl_news')->count();
            $this->assign('nums',$nums);
            //分类去重
            $category = Db::table('tbl_news')
                ->field('category')
                ->group('category')
                ->select();
            $this->assign('category',$category);
        }else{
            $this->assign('list',null);
        }
        return $this->fetch();
    }


    /**
     * 资讯管理->新闻动态
     */
    //1、添加新闻 OR 百科 页面
    function article_add_page(){
        if ($_GET['action'] == 'add_decoration'){
            //声明一个变量用来表示数据要添加到何处
            $this->assign('insertTo','tbl_baike');
            $this->assign('curAction','添加百科');
            $this->assign('menuId',1);

        }elseif ($_GET['action'] == 'add_news'){
            $this->assign('insertTo','tbl_news');
            $this->assign('curAction','添加新闻');
            $this->assign('menuId',0);
        }
        return $this->fetch();
    }

    //1.1 写入新闻 OR 百科 到数据库
    function insert_news(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');
        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->validate(['size'=>524288,'ext'=>'jpg,png,jpeg'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                // 成功上传后 获取上传信息
                // 输出 文件路径
                $path =  $info->getSaveName();
            }else{
                // 上传失败获取错误信息
                $path = '$file->getError()';
            }
        }else{
            $path = '没有上传过图片';
            //文件上传失败
        }

        if ($_POST['insertTo'] == 'tbl_baike'){
            $title = $_POST['title'];
            $description = $_POST['description'];
            $author = $_POST['author'];
            $content = $_POST['content'];
            $category = $_POST['category'];
            $data = ['thumbnail'=> $path,'title'=> $title,'author'=> $author,'description'=>$description,'content'=> $content,'category'=>$category];
            $list = Db::table('tbl_baike')->insert($data);
            if ($list != 0){
                $this->success("发布百科成功！",'NewsManager/menu_manager_decoration',null,1);
            }else{
                $this->success("发布百科失败！",null,$list,1);
            }
        }elseif ($_POST['insertTo'] == 'tbl_news'){
            $title = $_POST['title'];
            $description = $_POST['description'];
            $author = $_POST['author'];
            $content = $_POST['content'];
            $category = $_POST['category'];
            $data = ['thumbnail'=> $path,'title'=> $title,'author'=> $author,'description'=>$description,'content'=> $content,'category'=>$category];
            $list = Db::table('tbl_news')->insert($data);
            if ($list != 0){
                $this->success("发布新闻成功！",'NewsManager/menu_manager_news',null,1);
            }else{
                $this->success("发布新闻失败！",null,$list,1);
            }
        }

    }

    //2、删除新闻 OR 百科
    function delNewsById(){
        if ($_POST['whereTable'] == 'tbl_baike'){
            $newsId = Request::instance()->post('newsId');
            $list = Db::table('tbl_baike')->where('id',$newsId)->delete();
            if ($list!=0){
                return json(['status'=>200,'msg'=>'删除成功！']);
            }else{
                return json(['status'=>291,'msg'=>$newsId.'删除失败！']);
            }
        }elseif ($_POST['whereTable'] == 'tbl_news'){
            $newsId = Request::instance()->post('newsId');
            $list = Db::table('tbl_news')->where('id',$newsId)->delete();
            if ($list!=0){
                return json(['status'=>200,'msg'=>'删除成功！']);
            }else{
                return json(['status'=>291,'msg'=>'删除失败！']);
            }
        }

    }

    //3、修改新闻页面
    function article_edit_page(){
        $this->assign('updateTo',$_GET['from']);
        if ($_GET['from'] == 'tbl_baike'){
            $id = $_GET['id'];
            $list = Db::table('tbl_baike')->where('id',$id)->select();
            if ($list != 0){
                $this->assign('list',$list);
                $this->assign('menuId',1);
                $this->assign('curAction','编辑百科');
            }else{
                $this->error('文章ID不存在！');
            }
        }elseif ($_GET['from'] == 'tbl_news'){
            $id = $_GET['id'];
            $list = Db::table('tbl_news')->where('id',$id)->select();
            if ($list != 0){
                $this->assign('list',$list);
                $this->assign('menuId',0);
                $this->assign('curAction','编辑新闻');
            }else{
                $this->error('文章ID不存在！');
            }
        }

        return $this->fetch();
      }
      //3.1 处理新闻修改
    function update_news(){
        if (isset($_POST['submit'])){
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $author = $_POST['author'];
            $content = $_POST['content'];
            $category = $_POST['category'];

            // 获取表单上传文件 例如上传了001.jpg
            $file = request()->file('image');




            if ($_POST['updateTo'] == 'tbl_news'){
                /*
                 * 如何前台重新上传了图片，则需要替换之前的图片，不需要改数据库路径
                 */

                if (!empty($file)){
                    $list = Db::name('news')->where('id',$id)->field('thumbnail')->select();
                    $dir = $list[0]['thumbnail'];
                    $path = strstr($dir, "\\", true);
                    $saveName = trim(strrchr($dir, "\\"), "\\");
                    $file->move(ROOT_PATH . 'public' . DS . 'uploads'.'\\'.$path,$saveName);
                }
                $data = ['title'=>$title,'author'=>$author,'description'=>$description,'content'=>$content,'category'=>$category];
                $list = Db::table('tbl_news')->where('id',$id)->update($data);
                $this->success('修改成功','NewsManager/menu_manager_news',null,1);
            }

        }
    }
}