<?php
/**
 * Created by PhpStorm.
 * User: 王恒，qq:924114103。博客：adymilk.cn
 * Date: 2018/1/3
 * Time: 15:46
 */

namespace app\index\controller;


use think\Controller;

class QualityEngineering extends Controller
{
    //品质工程
    public function index()
    {
        return $this->fetch();
    }
}