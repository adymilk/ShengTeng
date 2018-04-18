<?php
/**
 * Created by PhpStorm.
 * User: 王恒，qq:924114103。博客：adymilk.cn
 * Date: 2017/12/20
 * Time: 15:05
 */

namespace app\index\controller;


use think\Controller;
use think\Db;
use think\Request;

class TeamServices extends Controller
{
    /**
     * @group 字段去重
     * @style_list：装修案例表中所有的装修风格
     * @type_list：装修案例表中所有的装修户型
     * @city_list: 装修案例表中所有的服务门店所在城市
     */
    public function index(){

// 筛选设计师功能
        if (isset($_GET['c']) && !empty($_GET['c'])){
            switch ($_GET['c']){
                case 'style':
                    $map['style'] = $_GET['style'];
                    break;

                case 'type':
                    $map['type'] = $_GET['type'];
                    break;

                case 'city':
                    $city = $_GET['city'];
                    $company_name = Db::name('branch-company')
                        ->where('city',$city)
                        ->value('company_name');

                    $map['company'] = $company_name;
                    break;
            }

            $list = Db::name('designer')
                ->order('create_time DESC')
                ->where($map)
                ->paginate(12);
        } else{
            $list = Db::name('designer')
                ->order('create_time DESC')
                ->paginate(12);
        }

        $this->assign('list',$list);
        return $this->fetch();
    }

    //设计师详情
    public function designer_info(){
        if (!empty($_GET['id'])){
            $designer_id = $_GET['id'];

            //查询设计师是否发布过案例
            $count = Db::name('decoration_case')->where('designer_id',$designer_id)->count();
            if ($count != 0){
                //查询设计师相关信息
                $designer = Db::name('designer')->where('id',$designer_id)->select();
                $this->assign('designer',$designer);

                //根据ID查询设计师案例
                $list = Db::name('decoration_case')
                    ->where('designer_id',$designer_id)
                    ->alias('a')
                    ->join('designer b','a.designer_id = b.id')
                    //分页时候保持查询条件
                    ->paginate(6,false,['query' => Request::instance()->param()]);
                $this->assign('list',$list);

            }else{
                $this->error('该设计师还未发布过作品！',null,null,2);

            }


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
            return $this->fetch();
        }else{
            $this->redirect('Index/error_404');
        }

    }
}