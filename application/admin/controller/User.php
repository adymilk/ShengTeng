<?php
/**
 * Created by PhpStorm.
 * User: 王恒，qq:924114103。博客：adymilk.cn
 * Date: 2017/12/24
 * Time: 10:35
 */

namespace app\admin\controller;


use think\Controller;
use think\Db;
use think\Session;

class User extends Controller
{
    /**
     * 用户登陆
     */
    public function login(){
        return $this->fetch();
    }

    //处理用户登陆
    public function doLogin(){
        if (isset($_POST['submit'])){
            $id = $_POST['id'];
            $pass = $_POST['pass'];
            $list = Db::table('tbl_user')->field('id,userPass,userName')->where('id',$id)->select();

            if (!empty($list)){
                if($list[0]['id'] == $id && $list[0]['userPass'] == $pass){
                    Session::set('curUser',$list[0]['userName'],'think');
                    Session::set('curUid',$list[0]['id'],'think');
                    $this->redirect('Index/index');
                }else{
                    $this->error('登陆失败！账号或密码错误！');
                }
            }else{
                $this->error('用户不存在，请与管理员联系！tel:17601322524');
            }
        }else{
            redirect('index/Index/error_404');
        }
    }

    //注销登录

    public function logout(){
        //获取当前用户的session
        if (Session::has('curUser','think')){
            Session::clear('think');
        }
        return $this->fetch('login');
    }
}