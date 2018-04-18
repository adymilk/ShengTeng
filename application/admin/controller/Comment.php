<?php
/**
 * Created by PhpStorm.
 * User: 王恒，qq:924114103。博客：adymilk.cn
 * Date: 2018/1/7
 * Time: 10:46
 */

namespace app\admin\controller;


use think\Db;

class Comment extends Common
{
    //评论列表
    public function index()
    {
        //查询所有评论
        $list = Db::name('comment')->select();
        //统计评论总数
        $nums = Db::name('comment')->count();

        $this->assign('nums', $nums);
        $this->assign('list', $list);

        return $this->fetch();
    }

    public function change_comment_status()
    {
        if (!empty($_POST['id'])) {

            $id = $_POST['id'];
            $status = $_POST['status'];
            if ($status == 1){
                $list = Db::name('comment')->where('id', $id)->setField('status', 1);
                if ($list == 1) {
                    return json(['status' => 200, 'msg' => '发布成功！']);
                }
            }elseif ($status == 0){
                $list = Db::name('comment')->where('id', $id)->setField('status', 0);
                if ($list == 1) {
                    return json(['status' => 200, 'msg' => '下架成功！']);
                }
            }

        }else{
            return json(['status'=>500,'msg'=>'发布失败！未接收到ID']);
        }
    }

}