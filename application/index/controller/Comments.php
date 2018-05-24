<?php
/**
 * Created by PhpStorm.
 * User: 王恒，qq:924114103。博客：adymilk.cn
 * Date: 2017/12/29
 * Time: 14:33
 */

namespace app\index\controller;


use think\Controller;
use think\Db;
use think\Request;

//业主评价

class Comments extends Controller
{
    public function index(){
        if (isset($_POST['submit'])){
            $captcha = $_POST['code'];
            if(!captcha_check($captcha)){
                //验证失败
                $this->error('验证码错误！');
            }else{
                $name = $_POST['name'];
                $community_name = $_POST['community_name'];
                $tel = $_POST['tel'];
                $comment = $_POST['comment'];
                $data = [
                    'name' =>$name,
                    'community_name' =>$community_name,
                    'tel' =>$tel,
                    'comment' =>$comment
                ];

                $id = Db::name('comment')->insertGetId($data);

                $pic1 = request()->file('pic1');
                $pic2 = request()->file('pic2');
                $pic3 = request()->file('pic3');
                $pic = array("",$pic1,$pic2,$pic3);
                for ($i=1; $i< count($pic); $i++){
                    if (!empty($pic[$i])){
                        $info = $pic[$i]->move(ROOT_PATH . 'public' . DS . 'uploads'. DS .'comment');
                        if ($info){
                            $path = $info->getSaveName();
                            Db::name('comment')->where('id',$id)->setField("pic$i",$path);
                        }
                    }
                }

                $this->success('感谢您的评价，祝您生活愉快','index',null,2);
            }

        }else{
            $list = Db::name('comment')->where('status',1)->order('time','desc')->paginate('8');
            if (!empty($_GET['type'])){
                $type = $_GET['type'];
                // $this->assign('activeIsPic','pic');
                switch ($type){
                    case $type == 'all':
                        $list = Db::name('comment')->where('status',1)->order('time','desc')->paginate(10);
                        break;

                    case $type == 'pic':
                        // $this->assign('activeIsPic','pic');
                        $list = Db::name('comment')->where('status',1)->order('time','desc')->where('pic1|pic2|pic3','not null')->paginate(10);
                        break;

                    case $type == 'video':
                            $list = Db::name('comment')->where('status',1)->order('time','desc')->where('video','not null')->paginate(10);
                        break;   

                    default:
                        break;
                }
            }
                $this->assign('list',$list);


            //总评价
            $countAll = Db::name('comment')->where('status',1)->count();
            //带图的评价
            $countPic = Db::name('comment')->where('status',1)->where('pic1|pic2|pic3','not null')->count();

            $countvideo = Db::name('comment')->where('status',1)->where('video','not null')->count();
            $this->assign('countAll',$countAll);
            $this->assign('countPic',$countPic);
            $this->assign('countvideo',$countvideo);


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
        }

    }

    //点赞
    public function zan(){
        if (!empty($_POST['id'])){
            $id = $_POST['id'];
            Db::name('comment')->where('id',$id)->setInc('zan',1);
            $zan = Db::name('comment')->where('id',$id)->value('zan');
            return json(['status'=>200,'msg'=>'点赞成功！','num'=>$zan]);
        }else{
            return json(['status'=>200,'msg'=>'点赞失败！']);
        }
    }
}