<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class Index extends Controller
{
    //首页
    public function index()
    {
        //    手机端家装新闻
        $list1 = Db::name('news')->order('time DESC')->limit(5)->paginate(5);
        $this->assign('list1',$list1);
        return $this->fetch();
    }

    //各大工厂店
    public function all_shops()
    {
        return $this->fetch();
    }


    //错误404页面
    public function error_404(){
        return $this->fetch();
    }

    //来自客户预约报名
    function orderAdd(){
        $name = $_POST['name'];
        $tel = $_POST['tel'];
        $area = $_POST['area'];
        $addr = $_POST['address'];
        $from = $_POST['from'];
        $remark = $_POST['remark'];
        $data = ['name'=> $name,'tel'=>$tel,'area'=>$area,'addr'=>$addr,'from'=>$from,'remark'=>$remark];
        $list = Db::table('tbl_order')->insert($data);
        if ($list!=0){
            return json(['msg'=>"预约成功,稍后会有设计师与您联系！"]);
        }else{
            return json(['msg'=>"预约失败！"]);
        }
    }


//  手机端免费设计
    public function free_design(){
        return $this->fetch();
    }

    //招商合作
    public function business_cooperation()
    {
        return $this->fetch();
    }

    //最新活动
    public function mobile()
    {
        //    手机端家装新闻
        $list1 = Db::name('news')->order('time DESC')->limit(5)->paginate(5);
        $this->assign('list1',$list1);
        return $this->fetch();
    }

}
