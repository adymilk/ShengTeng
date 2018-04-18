<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/7
 * Time: 14:41
 */

namespace app\admin\controller;


use think\Controller;
use think\Db;
use think\View;

class DataCenter extends Common
{

    //预约订单列表
    function order_manager(){
        $list = Db::table('tbl_order')->select();
        if ($list !=0){
            $this->assign('list',$list);
            $nums = Db::table('tbl_order')->count();
            $this->assign('nums',$nums);
        }else{
            $this->error('数据查询异常!',$list);
        }
        return $this->fetch();
    }


    //客户预约订单删除
    function delOrderById(){
        if (!empty($_POST['orderId'])){
            $id = $_POST['orderId'];
            $list = Db::table('tbl_order')->where('id',$id)->delete();
            if ($list != 0){
                return json(['status' => 200,'msg'=>'删除成功']);
            }else{
                return json(['status' => 291,'msg'=>'删除失败']);
            }
        }else{
            return json(['status' => 400,'msg'=>'ID为空']);
        }
    }
}