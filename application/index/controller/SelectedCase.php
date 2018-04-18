<?php
/**
 * Created by PhpStorm.
 * User: 王恒，qq:924114103。博客：adymilk.cn
 * Date: 2017/12/17
 * Time: 14:33
 */

namespace app\index\controller;


use think\Controller;
use think\Db;

class SelectedCase extends Controller
{
    //精选案例
    public function index()
    {

        //前台案例筛选
        if (isset($_GET['c'])){
            if (isset($_GET['style']) && $_GET['style'] != 'null'){
                $style = $_GET['style'];
                switch ($style){
                    case 'European':
                        $style = '欧式';
                        break;

                    case 'Countryside':
                        $style = '田园';
                        break;

                    case 'village':
                        $style = '乡村';
                        break;

                    case 'modern':
                        $style = '现代';
                        break;

                    case 'mix':
                        $style = '混搭';
                        break;

                    case 'Mediterranean':
                        $style = '地中海';
                        break;

                    case 'other':
                        $style = '其他';
                        break;

                    default:
                        break;
                }
            }
            if (isset($_GET['type']) && $_GET['type'] != 'null'){
                $type = $_GET['type'];
                switch ($type){
                    case '2':
                        $type = '二居室';
                        break;

                    case '3':
                        $type = '三居室';
                        break;

                    case 'other':
                        $type = '其他';
                        break;

                    default:
                        break;
                }
            }
            if (isset($_GET['area']) && $_GET['area'] != 'null'){
                $area = $_GET['area'];
                switch ($area){
                    case '140':
                        $area = '140';
                        break;

                    case '100':
                        $area = '100';
                        break;

                    case 'other':
                        $area = 'other';
                        break;

                    default: break;
                }
            }

            if (isset($style)){
                if ($style == '其他'){
                    $map['style'] = ['not in','欧式,田园,乡村,现代,混搭,地中海'];
                }else{
                    $map['style'] = $style;
                }
                if (isset($type)){
                    if ($type == '其他'){
                        $map['type'] = ['not in','二居室,三居室'];
                    }else{
                        $map['type'] = $type;
                    }
                }
                if (isset($area)){
                    if ($area == '100'){
                        $map['area'] = ['between','0,120'];
                    }elseif ($area == '140'){
                        $map['area'] = ['between','120,220'];
                    }elseif ($area == 'other'){
                        $map['area'] = ['>=',220];
                    }

                }
            }

            elseif (isset($type)){
                if ($type == '其他'){
                    $map['type'] = ['not in','二居室,三居室'];
                }else{
                    $map['type'] = $type;
                }
                if (isset($area)){
                    if ($area == '100'){
                        $map['area'] = ['between','0,120'];
                    }elseif ($area == '140'){
                        $map['area'] = ['between','120,220'];
                    }elseif ($area == 'other'){
                        $map['area'] = ['>=',220];
                    }

                }
                if (isset($style)){
                    if ($style == '其他'){
                        $map['style'] = ['not in','欧式,田园,乡村,现代,混搭,地中海'];
                    }else{
                        $map['style'] = $style;
                    }
                }
            }

            elseif (isset($area)){
                if ($area == '100'){
                    $map['area'] = ['between','0,120'];
                }elseif ($area == '140'){
                    $map['area'] = ['between','120,220'];
                }elseif ($area == 'other'){
                    $map['area'] = ['>=',220];
                }

                if (isset($type)){
                    if ($type == '其他'){
                        $map['type'] = ['not in','二居室,三居室'];
                    }else{
                        $map['type'] = $type;
                    }
                }
                if (isset($style)){
                    if ($style == '其他'){
                        $map['style'] = ['not in','欧式,田园,乡村,现代,混搭,地中海'];
                    }else{
                        $map['style'] = $style;
                    }
                }
            }

                $list = Db::name('decoration_case')
                    ->order('case_create_time desc')
                    ->alias('a')
                    ->join('designer b','a.designer_id = b.id')
                    ->where($map)
                    ->paginate(12);
        }else{
            //查询装修案例表，按时间降序排列，每页显示 12 条
            $list = Db::name('decoration_case')
                ->order('case_create_time desc')
                ->alias('a')
                ->join('designer b','a.designer_id = b.id')
                ->paginate(12);
        }

        $this->assign('list',$list);
        $this->assign('serverMsg',$_SERVER);
        return $this->fetch();
    }

    //案例详情
    public function selected_case_detail(){
        if (!empty($_GET['case_id'])){
            $case_id = $_GET['case_id'];
            $list = Db::name('decoration_case')
                ->where('case_id',$case_id)
                ->alias('a')
                ->join('designer b','a.designer_id = b.id')
                ->join('branch-company c','a.company_id = c.company_id')
                ->select();
            $this->assign('list',$list);
            $this->assign('community_name',$list[0]['community_name']);
            //根据案例风格查询相似案例
            $case_list = Db::name('decoration_case')
                ->where('style',$list[0]['style'])
                ->alias('a')
                ->join('designer b','a.designer_id = b.id')
                ->limit(4)
                ->select();
            $this->assign('case_list',$case_list);
            return $this->fetch();
        }elseif (!empty($_GET['id'])){
            //根据设计师 ID 跳转设计师页面
            $this->redirect('Index/error_404');
        }
        else{
            $this->redirect('Index/error_404');
        }


    }
}