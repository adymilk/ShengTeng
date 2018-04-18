<?php
/**
 * Created by PhpStorm.
 * User: ${王恒，qq:924114103}
 * Date: 2017/12/14
 * Time: 16:50
 */

namespace app\admin\controller;


use think\Controller;
use think\Request;
use think\Db;

class WebsiteSetting extends Common
{
    /**
     * 网站设置
     */
    //1、网站 seo 信息
    function website_seo()
    {
        if (isset($_GET['submit'])) {
            $website_name = $_GET['website_name'];
            $website_url = $_GET['website_url'];
            $website_desc = $_GET['website_desc'];
            $website_keywords = $_GET['website_keywords'];

            //更新数据
            $data = ['name' => $website_name, 'url' => $website_url, 'desc' => $website_desc, 'keywords' => $website_keywords];
            $query_state = Db::table("tbl_website_seo")->where('id', 1)->update($data);
            if ($query_state != 0) {
                $this->success("修改成功！", null, null, 1);
            } else {
                $this->success("未做任何修改！", null, null, 1);
            }
        } else {
            $list = Db::table('tbl_website_seo')->select();
            if ($list != 0) {
                $this->assign('list', $list);
            } else {
                $this->assign('list', null);
            }
            return $this->fetch();
        }


    }


    //全国门店（全国分公司）
    public function all_shops_list()
    {
        $list = Db::table('tbl_branch-company')->select();
        $count = Db::table('tbl_branch-company')->count();
        $this->assign('list', $list);
        $this->assign('count', $count);
        return $this->fetch();
    }

    //新增门店（分公司）
    public function add_shop()
    {
        if (isset($_POST['submit'])) {
            $company_name = $_POST['company_name'];
            $address = $_POST['address'];
            $tel = $_POST['tel'];
            $city = $_POST['city'];
            $file = request()->file('thumbnail');
            if (!empty($file)){
               $info =  $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                if ($info){
                    $path = $info->getSaveName();
                    $data = ['company_name' => $company_name, 'thumbnail'=>$path,'address' => $address, 'tel' => $tel, 'city' => $city];
                    $rs = Db::table('tbl_branch-company')->insert($data);
                    if ($rs == 1) {
                        $this->success('添加成功！', 'WebsiteSetting/all_shops_list', null, 1);
                    } else {
                        $this->error('添加失败，请联系管理员！');
                    }
                }else{
                    $this->error('文件移动到指定目录失败！');
                }

            }else{
//                $this->error('门头照片上传失败！');
                dump($file);
            }
        } else {
            return $this->fetch();
        }
    }

    //修改门店信息

    public function edit_shop_information()
    {
        if (isset($_POST['submit'])) {
            $company_name = $_POST['company_name'];
            $address = $_POST['address'];
            $tel = $_POST['tel'];
            $city = $_POST['city'];
            $company_id = $_POST['company_id'];
            $file = request()->file('thumbnail');
            //替换文件
            if (!empty($file)){
                $list = Db::name('branch-company')->where('company_id',$company_id)->field('thumbnail')->select();
                $dir = $list[0]['thumbnail'];
                $path = strstr($dir, "\\", true);
                $saveName = trim(strrchr($dir, "\\"), "\\");
                $file->move(ROOT_PATH . 'public' . DS . 'uploads'.'\\'.$path,$saveName);

            }


            $data = ['company_name' => $company_name, 'address' => $address, 'tel' => $tel, 'city' => $city];
            $list = Db::name('branch-company')->where('company_id', $company_id)->update($data);
            $this->success('修改成功！','all_shops_list');
        } else {
            if (!empty($_GET['company_id'])) {
                $company_id = $_GET['company_id'];
                $list = Db::name('branch-company')->where('company_id', $company_id)->select();
                $this->assign('list', $list);
                return $this->fetch();
            }
        }


    }


    //装修案例列表
    public function decoration_case_list()
    {
        $count = Db::name('decoration_case')->count();
        $list = Db::table('tbl_decoration_case')
            ->alias('a')
            ->join('tbl_designer b', 'b.id =a.designer_id ')
            ->select();


        $this->assign('list', $list);
        $this->assign('count', $count);
        return $this->fetch();
    }



    /**
     *finish: 如果是修改图片，则需要把之前上传的图片删除
     *///添加或修改装修案例
    public function add_decoration_case()
    {
        if (isset($_POST['submit'])) {
            //获取表单传递的数据
            $style = $_POST['style'];
            $type = $_POST['type'];
            $area = $_POST['area'];
            $community_name = $_POST['community_name'];
            $city = $_POST['city'];
            $price = $_POST['price'];
            $company = $_POST['company'];
            $designer = $_POST['designer'];
            $construction_captain = $_POST['construction_captain'];
            $design_concept = $_POST['design_concept'];

            //查询设计师表中 $designer 的ID, 写入装修案例表中
            $list = Db::name('designer')->where('name', $designer)->select();
            $designerId = $list[0]['id'];
            //查询分公司表中 $company 的ID, 写入装修案例表中
            $list = Db::name('branch-company')->where('company_name', $company)->select();
            $company_id = $list[0]['company_id'];

            //如果是新增案例
            if ($_POST['action'] == 'do_add') {
                // 获取表单上传文件
                $files = request()->file('case_photo');
                foreach ($files as $file) {
                    // 移动到框架应用根目录/public/uploads/ 目录下
                    $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                    if ($info) {
                        //把图片路径存到数组
                        $filesPathArr[] = $info->getSaveName();
                    } else {
                        $this->error('系统错误，联系管理员！tel:17601322524', 'decoration_case_list', $info, 10);
                    }
                }
                //接收表单传递过来的图片数据
                $case_photo1 = $filesPathArr[0];
                $case_photo2 = $filesPathArr[1];
                $case_photo3 = $filesPathArr[2];
                $case_photo4 = $filesPathArr[3];

                $data = [
                    'style' => $style,
                    'type' => $type,
                    'area' => $area,
                    'community_name' => $community_name,
                    'case_city' => $city,
                    'price' => $price,
                    'construction_captain' => $construction_captain,
                    'design_concept' => $design_concept,
                    'case_photo1' => $case_photo1,
                    'case_photo2' => $case_photo2,
                    'case_photo3' => $case_photo3,
                    'case_photo4' => $case_photo4,
                    'company_id' => $company_id,
                    'designer_id' => $designerId,

                ];
                $list = Db::name('decoration_case')->insert($data);

//>>>>>>>>>>>>>>>>>>>>>>>  案例新增成功！ >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
                if ($list == 1) {
                    //设计师作品数字段 +1
                    Db::name('designer')->where('id', $designerId)->setInc('numbers', 1);
                    //作品所属店面作品总数字段 +1

                    Db::name('branch-company')->where('company_id', $company_id)->setInc('count_case', 1);

                    $this->success('发布成功！','decoration_case_list',null,1);
                } else {
//                    return json(['status' => 200, 'msg' => '发布成功！']);
                    $this->error('系统错误，联系管理员！tel:17601322524', 'decoration_case_list', $list, 10);
                }
            }
            //如果是修改案例
            elseif ($_POST['action'] == 'do_edit') {
                $case_id = $_POST['case_id'];
                if (!empty($case_id)){
                    // 获取表单上传文件
                    $case_photo1 = request()->file('case_photo1');
                    $case_photo2 = request()->file('case_photo2');
                    $case_photo3= request()->file('case_photo3');
                    $case_photo4 = request()->file('case_photo4');
                    $photos = array("",$case_photo1,$case_photo2,$case_photo3,$case_photo4);

                    //查询当前要修改的案例
                    $list = Db::name('decoration_case')->where('case_id', $case_id)->select();

                    for ($i = 1; $i < count($photos);$i++){
                        if ($photos[$i] != null){
                            $path_case_photo = $list[0]["case_photo".$i];
                            $path = strstr($path_case_photo, "\\", true);
                            $saveName = trim(strrchr($path_case_photo, "\\"), "\\");
                            $photos[$i]->move(ROOT_PATH . 'public' . DS . 'uploads'.'\\'.$path,$saveName);
                        }
                    }
                }

                $data = [
                    'style' => $style,
                    'type' => $type,
                    'area' => $area,
                    'community_name' => $community_name,
                    'case_city' => $city,
                    'price' => $price,
                    'construction_captain' => $construction_captain,
                    'design_concept' => $design_concept,
                    'company_id' => $company_id,
                    'designer_id' => $designerId,
                ];
                $list = Db::name('decoration_case')->where('case_id',$case_id)->update($data);
                $this->redirect('decoration_case_list');
                }


        } else {
            //设计师列表
            $designer_list = Db::name('designer')->select();
            $company_list = Db::name('branch-company')->select();
            $this->assign('designer_list', $designer_list);
            $this->assign('company_list', $company_list);
            return $this->fetch();
        }
    }

    //编辑装修案例界面
    public function edit_decoration_case()
    {
        if (!empty($_GET['case_id'])) {
            $case_id = $_GET['case_id'];
            $list = Db::name('decoration_case')
                ->where('case_id', $case_id)
                ->alias('a')
                ->join('designer b', 'a.designer_id = b.id')
                ->join('branch-company c', 'a.company_id = c.company_id')
                ->select();
            $designer_list = Db::name('designer')->field('name')->select();
            $company_list = Db::name('branch-company')->field('company_name')->select();
            $this->assign('list', $list);
            $this->assign('designer_list', $designer_list);
            $this->assign('company_list', $company_list);
            return $this->fetch();
        } else {
            $this->error('系统故障，请联系管理员。电话：17601322524', 'designer_list', null, 8);
        }

    }

    //删除装修案例
    public function del_decoration_case()
    {
        if (!empty($_POST['case_id'])) {
            $case_id = $_POST['case_id'];
            $list = Db::name('decoration_case')
                ->where('case_id', $case_id)
                ->select();
            $del_rs = Db::name('decoration_case')->where('case_id', $case_id)->delete();

// >>>>>>>>>>>>>>>>>>>>>>> 案例删除成功！>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

            if ($del_rs == 1) {
                dump($list);
                //设计师作品数 -1
                Db::name('designer')->where('id',$list[0]['designer_id'])->setDec('numbers',1);
                //店面案例总数 -1
                Db::name('branch-company')->where('company_id',$list[0]['company_id'])->setDec('count_case',1);

                return json(['status' => 200, 'msg' => '删除成功']);
            } else {
                return json(['status' => 500, 'msg' => '删除失败']);
            }
        } else {
            $this->error('系统错误！请联系管理员,tel:17601322524', null, 8);
        }
    }


     // 判断用户输入的设计师是否存在

    public function is_Exist_Designer()
    {
        $designer = $_POST['designer'];
        $list = Db::name('designer')->where('name', $designer)->select();
        if (!empty($list)) {
            return json(['status' => 200, 'msg' => "设计师已存在", 'isExist' => "是" ,'company' => $list[0]['company']]);
        } else {
            return json(['status' => 200, 'msg' => "设计师不存在", 'isExist' => "否"]);
        }

    }


    //设计师列表
    public function designer_list()
    {
        $list = Db::name('designer')->select();
        $count = Db::name('designer')->count();
        $this->assign('list', $list);
        $this->assign('count', $count);
        return $this->fetch();
    }

    //添加设计师
    public function add_designer()
    {
        if (isset($_POST['submit'])) {
            // 获取表单上传文件 例如上传了001.jpg
            $file = request()->file('avatar');

            // 移动到框架应用根目录/public/uploads/ 目录下
            if ($file) {
                $info = $file->validate(['size' => 524288, 'ext' => 'jpg,png,jpeg'])->move(ROOT_PATH . 'public' . DS . 'uploads');
                $avatarPath = $info->getSaveName();
            }

            $name = $_POST['name'];
            $position = $_POST['position'];
            $company = $_POST['company'];
            $years = $_POST['years'];
            $avatar = $avatarPath;
            $introduction = $_POST['introduction'];
            $motto = $_POST['motto'];
            $action = $_POST['action'];

            $data = ['name' => $name, 'position' => $position, 'company' => $company, 'years' => $years, 'avatar' => $avatar, 'introduction' => $introduction, 'motto' => $motto];
            if ($action == 'do_add') {
                $rs = Db::name('designer')->insert($data);
                if ($rs == 1) {
                    $company_id = Db::name('branch-company')
                        ->where('company_name',$company)
                        ->select();

//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>    添加成功      >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

                    //设计师所属店面的设计师总数 +1
                    Db::name('branch-company')
                        ->where('company_id',$company_id[0]['company_id'])
                        ->setInc('count_designers',1);

                    $this->redirect('designer_list');
                } else {
                    $this->error('系统错误，联系管理员！tel:17601322524', 'designer_list', $rs, 10);
                }
            } elseif ($action == 'do_modify') {
                $id = $_POST['id'];
                $rs = Db::name('designer')->where('id', $id)->update($data);
                if ($rs == 1) {
                    $this->success('修改成功！','designer_list',null,2);
                } else {
                    $this->error('修改系统错误，联系管理员！tel:17601322524', 'designer_list', $rs, 10);
                }
            }
        } else {
            //查询门店列表
            $company_list = Db::name('branch-company')->select();
            $this->assign('company_list', $company_list);
            return $this->fetch();
        }
    }

    //修改设计师信息
    public function edit_designer()
    {
        if (!empty($_GET['id'])) {
            $id = $_GET['id'];
            $list = Db::name('designer')->where('id', $id)->select();
            //查询门店列表
            $company_list = Db::name('branch-company')->select();
            $this->assign('company_list', $company_list);
            $this->assign('list', $list);
            return $this->fetch();
        } else {
            $this->error('系统故障，请联系管理员。电话：17601322524', 'designer_list', null, 8);
        }
    }

    //删除设计师
    public function del_designer()
    {
        if (!empty($_POST['designer_id'])) {
            $designer_id = $_POST['designer_id'];
            //设计师作品总数
            $count = Db::name('decoration_case')->where('designer_id', $designer_id)->count();

            //由设计师id 查询公司id
            $company_id = Db::name('decoration_case')
                ->where('designer_id',$designer_id)
                ->value('company_id');

            //删除设计师
            $rs1 = Db::name('designer')->where('id', $designer_id)->delete();
            //删除设计师所有的案例
            $rs2 = Db::name('decoration_case')->where('designer_id', $designer_id)->delete();
            if ($rs1 == 1 && $rs2 >= 0) {
//>>>>>>>>>>>>>>>>>>>>  设计师所属店面设计师总数 -1 && 案例总数减去设计师作品总数 >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

                //店面案例总数减去设计师案例总数
                Db::name('branch-company')
                    ->where('company_id',$company_id)
                    ->setDec('count_case',$count);

                //店面设计师总数减一
                Db::name('branch-company')
                    ->where('company_id',$company_id)
                    ->setDec('count_designers',1);

                return json(['status' => 200, 'msg' => '删除成功']);
            } else {
                return json(['status' => 500, 'msg' => '删除失败']);
            }
        } else {
            $this->error('系统错误！请联系管理员,tel:17601322524', null, 8);
        }
    }

    //修改前台banner图片
    public function modify_banner(){
        if (isset($_POST['submit'])){
            // 获取表单上传文件
            $banner1 = request()->file('banner1');
            $banner2 = request()->file('banner2');
            $banner3= request()->file('banner3');
            $banner4 = request()->file('banner4');
            $banners = array("",$banner1,$banner2,$banner3,$banner4);
            //查询当前要修改的banner
            $list = Db::name('website_seo')->where('id', 1)->select();
            for ($i = 1; $i < count($banners);$i++){
                if ($banners[$i] != null){
                    $banner = $list[0]["banner".$i];
                    $path = strstr($banner, "\\", true);
                    $saveName = trim(strrchr($banner, "\\"), "\\");
                    $info =  $banners[$i]->move(ROOT_PATH . 'public' . DS . 'uploads'.'\\'.$path,$saveName);
                }
            }
            if (isset($info)) {
                if ($info){
                    $this->success('修改成功！','Index/index','null','2');
                }
            }else{
                $this->error('未做任何修改！','Index/index','null','2');
            }
        }else{
            $this->error('程序异常',null,'$_POST[\'submit\'] == false');
        }
    }
}