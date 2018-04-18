<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Index extends Common
{
    //后台首页
    public function index()
    {
        $request = Request::instance();
        $ip = $request->ip();
        $this->assign('ip',$ip);
        $curTime = time();
        $this->assign('curTime',$curTime);
        $this->assign('serverMsg',$_SERVER);

        //显示banner图片
        $banners_list = Db::name('website_seo')->where('id',1)->select();
        $this->assign('banners_list',$banners_list);

        //统计文章总数
        $news_count = Db::name('news')->count();
        $designer_count = Db::name('designer')->count();
        $order_count = Db::name('order')->count();
        $decoration_case_count = Db::name('decoration_case')->count();
        $this->assign('news_count',$news_count);
        $this->assign('designer_count',$designer_count);
        $this->assign('order_count',$order_count);
        $this->assign('decoration_case_count',$decoration_case_count);

        return $this->fetch();
    }

//    测试上传
    function upload_test(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');

        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file) {
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            Db::name('branch-company')->where('company_id',6)->setField('thumbnail',$info->getSaveName());
            dump($info->getSaveName());
            $this->success('上传成功！');
        }
        return $this->fetch();
    }







}
