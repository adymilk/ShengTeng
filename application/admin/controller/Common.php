<?php
/**
 * Created by PhpStorm.
 * User: 王恒，qq:924114103。博客：adymilk.cn
 * Date: 2017/12/24
 * Time: 10:22
 */

namespace app\admin\controller;



use think\auth\Auth;
use think\Controller;
use think\Db;
use think\Session;

class Common extends Controller
{

    //自动加载
    public function _initialize()
    {

//        判断用户是否登录
        if (!Session::has('curUser','think')){
            $this->error('请先登录！','User/login',null,1);
        }else{
            //权限认证
            $controller = request()->controller();
            $action = request()->action();
            $uid = Session::get('curUid');
            $auth = new Auth();

            if (!$auth->check($controller . '-' . $action,$uid)){
                $this->error('没有权限访问！');
            }
        }


    }




}