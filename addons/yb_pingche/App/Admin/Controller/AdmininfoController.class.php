<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;
class AdmininfoController extends CommonController {
    
    //显示管理员列表 
    public function index(){
        $this->mb();

        $where=" uniacid=".$this->uniacid;
        $count=M("admin")->where($where)->count();
        $Page=new Page($count,20);
        $show=$Page->show();
        $rs=M('admin')->where($where)->limit($Page->firstRow.",".$Page->listRows)->order(" id desc")->select();
        $this->rs=$rs;
        $this->count=$count;
        $this->assign('page',$show);
        $this->snid=session("nid");
        $this->display();
    }
    
    //删除系统管理员账号
    public function del(){
        $this->mb();
        if(!isset($_GET["nid"]) || intval($_GET["nid"])<=0){
            $this->error("非法操作");
        }
        $nid=intval($_GET["nid"]);
        if(M("admin")->where("id=".$nid." and uniacid=".$this->uniacid)->delete()){
            M("adminlog")->where("admin_id=".$nid." and uniacid=".$this->uniacid)->delete();
            $this->success("删除成功");
        }else{
            $this->error("删除失败");
        }
    }
    
    //批量删除系统管理员账号
    public function alldel(){
        $this->mb();
        if(!$_POST || trim($_POST["allid"])=="" ){
            $this->error("非法操作");
        }
        $allid=substr(trim($_POST["allid"]),0,-1);
        if($allid==""){
            $this->error("操作失败，必须要选择要删除的记录");
        }
        if($id=M("admin")->where(" id in (".$allid.")  and uniacid=".$this->uniacid)->delete()){
            M("adminlog")->where("admin_id in (".$allid.")  and uniacid=".$this->uniacid)->delete();
            $data["status"]=1;
            $data["retDesc"]="删除成功";
        }else{
            $data["status"]=0;
            $data["retDesc"]="删除失败";
        }
        $this->ajaxReturn($data);        
    }
    
    //显示修改系统管理员账号页面
    public function index_modi(){
        $this->mb();
        if(!isset($_GET["nid"]) || intval($_GET["nid"])<=0){
            $this->error("非法操作");
        }
        $nid=I("nid",0,"intval");
        $rs=M("admin")->where("id=".$nid."  and uniacid=".$this->uniacid)->find();
        if(!$rs){
            $this->error("记录不存在");
        }
        $this->rs=$rs;
        $this->display();
    }
    
    //修改系统管理员账号信息提交操作
    public function index_modihandle(){
        $this->mb();
        if(!IS_POST || intval($_POST["nid"])<=0 || trim($_POST["username"])=="" ){
            $this->error("非法操作");
        }
        $nid=intval($_POST["nid"]);
        $username=I("username");
        $rs=M("admin")->where("id!=".$nid." and username='".$username."'  and uniacid=".$this->uniacid)->find();
        if($rs){
            $this->error("账号已存在");
        }
        
        if(trim($_POST["password"])==""){
            unset($_POST["password"]);
        }else{
            $_POST["password"]=md5(trim($_POST["password"]));
        }
        if(I("reason")==""){
            unset($_POST["reason"]);
        }
        unset($_POST["nid"],$_POST["group"]);
        M("admin")->where("id=".$nid)->data($_POST)->save();
        session("truename",$_POST["truename"]);
        $this->success("修改成功",U("Admin/Admininfo/index"));
    }
    
    //显示添加管理员账号页面
    public function index_add(){
        $this->mb();
        $this->display();
    }
    
    //添加管理员账号信息提交操作
    public function index_addhandle(){
        $this->mb();
        if(!IS_POST || trim($_POST["username"])==""  || trim($_POST["password"])==""  || trim($_POST["truename"])==""){
            $this->error("非法操作");
        }
        $username=I("username");
        unset($_POST["repassword"],$_POST["group"]);
        $rs=M("admin")->where("username='".$username."' and uniacid=".$this->uniacid)->find();
        if($rs){
           $this->error("账号已存在"); 
        }
        $_POST["password"]=md5(trim($_POST["password"]));
        $_POST["regtime"]=date("Y-m-d H:i:s");
        $_POST["uniacid"]=$this->uniacid;
        if($nid=M("admin")->data($_POST)->add()){
            $this->success("添加成功",U("Admin/Admininfo/index"));
        }else{
            $this->error("添加失败");
        }
        
    }
    
    //入口验证函数
    public function mb(){
        $mb=new IndexController();
        $mb->moban();
    }
    
}

?>