<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/13
 * Time: 16:37
 */

namespace app\admin\controller;

use think\Db;
use think\Session;
use think\Request;
use think\Controller;

class AdminManager extends Common
{
    /**
     * @return mixed角色管理
     */
    public function admin_role(){
        $list = Db::table('tbl_user')->select();
        $this->assign('list',$list);
        $count = Db::table('tbl_user')->count();
        $this->assign('count',$count);
        return $this->fetch();
    }
    //1.1 删除管理员
    public function del_admin(){
        $userId = Request::instance()->post('userId');
        dump($userId);
        if(!empty($userId)){
            $list = Db::table('tbl_user')->where('id',$userId)->delete();
            if ($list!=0){
                return json(['status'=>200,'msg'=>'删除成功']);
            }else{
                return json(['status'=>291,'msg'=>$list]);
            }
        }else{
            return json(['status'=>291,'msg'=>'userId传递错误！']);
        }

    }



    /**
     * @return mixed 管理员列表
     */
    public function admin_list(){
        $list = Db::table('tbl_user')->select();
        $this->assign('list',$list);
        $count = Db::table('tbl_user')->count();
        $this->assign('count',$count);
        return $this->fetch();
    }

    //添加管理员
    public function admin_role_add(){
        return $this->fetch();
    }
}