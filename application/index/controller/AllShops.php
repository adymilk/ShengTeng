<?php
/**
 * Created by PhpStorm.
 * User: 王恒，qq:924114103。博客：adymilk.cn
 * Date: 2018/1/3
 * Time: 16:19
 */

namespace app\index\controller;


use think\Controller;
use think\Db;

class AllShops extends Controller
{
    //各大工厂店
    public function index()
    {

        if (!empty($_GET['city'])) {
            $city = $_GET['city'];
            $list = Db::name('branch-company')->where('city',$city)->paginate(5);

        }else{
        $list = Db::name('branch-company')->paginate(5);
    }
        //前台右侧推荐案例
        //推荐设计师
        $suggest_designer = Db::name('designer')
            ->order('create_time desc')
            ->limit(1)
            ->select();
        $this->assign('suggest_designer', $suggest_designer);

        //右侧推荐案例
        $suggest_case = Db::name('decoration_case')
            ->order('case_create_time desc')
            ->alias('a')
            ->join('designer b', 'a.designer_id = b.id')
            ->limit(1)
            ->select();
        $this->assign('suggest_case', $suggest_case);




//        $this->assign('case_list',$case_list);
        $this->assign('list', $list);
        return $this->fetch();
    }
}


