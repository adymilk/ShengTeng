<?php
/**
 * Created by PhpStorm.
 * User: 王恒，qq:924114103。博客：adymilk.cn
 * Date: 2017/12/17
 * Time: 14:31
 */

namespace app\index\controller;


use think\Controller;
use think\Db;

class AboutUs extends Controller
{
    //联系我们
    public function contact_us()
    {
        $list = Db::table('tbl_branch-company')->select();
        $count = Db::table('tbl_branch-company')->count();
        $this->assign('list',$list);
        $this->assign('count',$count);
        return $this->fetch();
    }

    public function about_us(){
        return $this->fetch();
    }


}