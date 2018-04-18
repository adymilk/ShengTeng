<?php
/**
 * Created by PhpStorm.
 * User: 王恒，qq:924114103。博客：adymilk.cn
 * Date: 2017/12/22
 * Time: 11:45
 */

namespace app\index\controller;


use think\Controller;
use think\Db;

/*
 * @index 家装攻略
 */
class DecorationStrategy extends Controller
{

    public function index(){

            $category1 = '家装指南';
            $category2 = '家具配饰';
            $category3 = '家具风水';
            $category4 = '家装设计';
        $list1 = Db::name('news')->where('category',$category1)->order('time DESC')->paginate(5);
        $list2 = Db::name('news')->where('category',$category2)->order('time DESC')->paginate(5);
        $list3 = Db::name('news')->where('category',$category3)->order('time DESC')->paginate(5);
        $list4 = Db::name('news')->where('category',$category4)->order('time DESC')->paginate(5);
        $this->assign('list1',$list1);
        $this->assign('list2',$list2);
        $this->assign('list3',$list3);
        $this->assign('list4',$list4);

        //推荐设计师
        $suggest_designer = Db::name('designer')
            ->order('create_time desc')
            ->limit(1)
            ->select();
        $this->assign('suggest_designer',$suggest_designer);

        //推荐案例
        $suggest_case = Db::name('decoration_case')
            ->order('case_create_time desc')
            ->alias('a')
            ->join('designer b','a.designer_id = b.id')
            ->limit(1)
            ->select();
        $this->assign('suggest_case',$suggest_case);
//        dump($list);
        return $this->fetch();
    }


    //新闻详情页面
    public function news_detail(){
        //推荐设计师
        $suggest_designer = Db::name('designer')
            ->order('create_time desc')
            ->limit(1)
            ->select();
        $this->assign('suggest_designer',$suggest_designer);

        //推荐案例
        $suggest_case = Db::name('decoration_case')
            ->order('case_create_time desc')
            ->alias('a')
            ->join('designer b','a.designer_id = b.id')
            ->limit(1)
            ->select();
        $this->assign('suggest_case',$suggest_case);

        if (!empty($_GET['id'])){
            $id = $_GET['id'];

            Db::name('news')
                ->comment('查询当前id的新闻阅读量 + 1')
                ->where('id',$id)
                ->setInc('views',1);

            $list = Db::name('news')
                ->comment('查询当前id的新闻详情')
                ->where('id',$id)
                ->select();

            $next_list = Db::name('news')
                ->comment('查询下一条新闻')
                ->where('id','>',$id)
                ->field('id,title')
                ->limit(1)
                ->select();

            $previous_list = Db::name('news')
                ->comment('查询上一条新闻')
                ->where('id','<',$id)
                ->limit(1)
                ->field('id,title')
                ->select();

            $this->assign('list',$list);
            $this->assign('next_list',$next_list);
            $this->assign('previous_list',$previous_list);




            return $this->fetch();
        }else{
            redirect('Index/error_404');
        }
    }
}