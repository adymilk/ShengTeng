<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class Activity extends Controller
{
	//最新活动

    public function pc()
    {
        return $this->fetch();
    }

    public function mobile()
    {
        return $this->fetch();
    }
}