<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;
class AreaController extends CommonController{
    
    //首页
    public function index(){
        
        $this->mb();
        $this->display();
    }

    
    //读取城市列表信息
    public function list_index(){
        
        $this->mb();
        $where=" uniacid=".$this->uniacid;
        
        $count=M("area_price")->where($where)->count();
        $this->count=$count;
        $page=new Page($count,10);
        $this->page=$page->show();
        $limit=$page->firstRow.",".$page->listRows;
        $rs=M("area_price")->where($where)->limit($limit)->order("nid desc")->select();
        foreach($rs as $k=>$v){
            $rt=M("area_price")->find($v["p_id"]);
            if($rt){
                $rs[$k]["nclass1"]=$rt["name"];
            }else{
                $rs[$k]["nclass1"]="顶级";
            }
        }
        $this->rs=$rs;
        $this->display();
    }
    
    //显示添加城市信息页面
    public function list_add(){
        
        $this->mb();
        $this->rs=M("area_price")->where("p_id=0 and nstatus=1 and uniacid=".$this->uniacid)->order("nid desc")->select();
        
        $this->display();
        
    }
    
    //提交城市信息操作
    public function list_addhandle(){
        
        $this->mb();
        $param=I("post.");
        if(I("name")!=""){
            $rs=M("area_price")->where("name='".I("name")."' and uniacid=".$this->uniacid)->find();
            if($rs){
                $this->error("城市名称重复，操作失败");
            }
            $param["addtime"]=date("Y-m-d H:i:s");
            $param["word"]=strtoupper($param["word"]);
            $param["uniacid"]=$this->uniacid;
            if(M("area_price")->add($param)){
                $this->success("操作成功",U('Area/list_index'));
            } else{
                $this->error("操作失败");
            }
        }else{
            $this->error("城市名称不能为空");
        }
        
    }
    
    //显示修改城市信息页面
    public function list_modi(){
        
        $this->mb();
        $id=I("nid",0,"intval");
        if($id){
            $rt=M("area_price")->find($id);
            if($rt){
                $this->rt=$rt;
                $this->rs=M("area_price")->where("p_id=0 and nstatus=1 and uniacid=".$this->uniacid)->order("nid desc")->select();
                $this->display();
            }else{
                $this->error("记录不存在");
            }
        }else{
            $this->error("记录不存在");
        }
    }
    
    //提交修改城市信息操作
    public function list_modihandle(){
        
        $this->mb();
        $param=I("post.");
        $id=I("id",0,"intval");
        if($id){
            unset($param["id"]);
            $param["word"]=strtoupper($param["word"]);
            M("area_price")->where("nid=".$id)->save($param);
            $this->success("操作成功",U("list_index"));
        }else{
            $this->error("非法操作");
        }
    }
    
    //常见内容停用和正常
    public function list_status(){
        
        $this->mb();
        $id=intval(I("nid"));
        if($id){
            $rs=M("area_price")->find($id);
            $nstatus=$rs["nstatus"]==1?2:1;
            M("area_price")->where("nid=".$id)->setField("nstatus",$nstatus);
            $this->success("操作成功");
        
        }else{
            $this->error("操作失败");
        }
        
    }
    
    //常见内容单个删除
    public function list_del(){
        
        $this->mb();
        $id=I("nid",0,"intval");
        if($id){
            M("area_price")->where("nid=".$id)->delete();
            $this->success("操作成功");
        }else{
            $this->error("非法操作");
        }
        
    }
    //常见内容全选删除
    public function list_alldel(){
        
        $this->mb();
        if(!IS_POST || I("allid")==""){
            $data=array(
                "retCode"=>"0001",
                "retDesc"=>"非法操作"
            );
            exit(json_encode($data));
        }
        $str=substr(I("allid"),0,-1);
        M("area_price")->where(" nid in (".$str.")")->delete();
        $data=array(
            "retCode"=>"0000",
            "retDesc"=>"操作成功"
        );
        exit(json_encode($data));
    }
    
    
    
    //入口验证函数
    public function mb(){
        $mb=new IndexController();
        $mb->moban();
    }
}