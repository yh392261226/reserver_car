<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;
class AdminlogController extends CommonController {
    //显示管理员登录日志首页
    public function index(){
        $this->mb();
        $where="uniacid=".$this->uniacid;
        $count=M("adminlog")->where($where)->count();
        $this->count=$count;
        $Page=new Page($count,16);
        $this->page=$Page->show();
        $rs=M('adminlog')->where($where)->limit($Page->firstRow.",".$Page->listRows)->order(" nid desc")->select();
        if($rs){
            for($i=0;$i<count($rs);$i++){
                if($rs[$i]["admin_id"]){
                    //这里获取具体的系统管理员账号
                    $rt=M("admin")->where("id=".$rs[$i]["admin_id"]." and uniacid=".$this->uniacid)->find();
                    $rs[$i]["truename"]=$rt["truename"];
                }else{
                    $rs[$i]["truename"]="<font color=red>无</font>";
                }
            }
        }
        $this->rs=$rs;
        $this->display();
    }
    
    //全选删除操作
    public function alldel(){
        $this->mb();
        if(!IS_POST || trim($_POST["allid"])==""){
            $this->error("非法操作");
        }
        $allid=substr(trim($_POST["allid"]), 0,-1);
        if($allid==""){
            $this->error("非法操作");
        }
        if(M("adminlog")->where("nid in(".$allid.") and uniacid=".$this->uniacid)->delete()){
            $data=array(
                "status"=>1,
                "retDesc"=>"删除成功"
            );
        }else{
            $data=array(
                "status"=>0,
                "retDesc"=>"删除失败"
            );            
        }
        $this->ajaxReturn($data);
    }
    
    //单个删除操作
    public function del(){
        
        $this->mb();
        if(!isset($_GET["nid"]) || intval($_GET["nid"])<=0){
            $this->error("非法操作");
        }
        $nid=I("nid",0,"intval");
        if(M("adminlog")->where("nid=".$nid." and uniacid=".$this->uniacid)->delete()){
            $this->success("删除成功");
        }else{
            $this->error("删除失败");
        }
    }
    
    
    //入口验证函数
    public function mb(){
        $mb=new IndexController();
        $mb->moban();
    }
}
?>