<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/20
 * Time: 12:57
 */

namespace app\front\controller;


use think\Controller;

class wap extends Controller
{
    public function index(){
        return $this->fetch();
    }
}