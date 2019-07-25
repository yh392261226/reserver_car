<?php
namespace Admin\Controller;
use Think\Controller;
class ConfigureController extends CommonController {
    //显示需要修改的配置信息
    public function index(){
        $this->mb();
        $rs=M("config")->where("uniacid=".$this->uniacid)->find();
        if($rs["gzh_ywym_status"]==1){
            $rs["gzh_ywym_status1"]="没有上传";
        }else{
            $rs["gzh_ywym_status1"]="已上传";
        }
        if($rs["gzh_wysq_status"]==1){
            $rs["gzh_wysq_status1"]="没有上传";
        }else{
            $rs["gzh_wysq_status1"]="已上传";
        }        
        $this->data=$rs;
        $this->display();
    }
    
    //提交修改的配置信息操作
    public function update(){
        $this->mb();
        if(IS_POST){
            $param = I('post.');
            
            $obj = M('config');
            $con = M('config')->where("uniacid=".$this->uniacid)->find();
            
            $hd=new \Vendor\FileHelper();
        
            if($param['wx_pay_sslcert_path']){
        
                $filename ='./ThinkPHP/Library/Vendor/wxpay/cert/apiclient_cert.pem';
                
                $hd::filePutContents($filename,$param['wx_pay_sslcert_path']);
        
            }
        
            if($param['wx_pay_sslkey_path']){
        
                $filename ='./ThinkPHP/Library/Vendor/wxpay/cert/apiclient_key.pem';
                $hd::filePutContents($filename,$param['wx_pay_sslkey_path']);
            }
            
            if($param['gzh_ywym_filename']){
                $filename ='./'.$param['gzh_ywym_filename'];
                $hd::filePutContents($filename,$param['gzh_ywym_filecontent']);
                $param["gzh_ywym_status"]=2;
            }else{
                $param["gzh_ywym_status"]=1;
            }

            if($param['gzh_wysq_filename']){
                $filename ='./'.$param['gzh_wysq_filename'];
                $hd::filePutContents($filename,$param['gzh_wysq_filecontent']);
                $param["gzh_wysq_status"]=2;
            }else{
                $param["gzh_wysq_status"]=1;
            }
            
            if($con){
                $obj->where("id=".$con["id"]." and uniacid=".$this->uniacid)->save($param);
            }else{
                $param["uniacid"]=$this->uniacid;
                $obj->add($param);
            }
            $con = M('config')->where("uniacid=".$this->uniacid)->find();
            S('shopconfig',null);
            $this->getConfig();
        }        
        
        $this->success("操作成功");
    }
    
    public function clearcache(){
        $hd=new \Vendor\FileHelper();
        $filename ='./App/Runtime';
        $hd::deldir($filename);
        $this->success("清除缓存成功");
    }
    
    
    //入口验证函数
    public function mb(){
        $mb=new IndexController();
        $mb->moban();
    }
    
    public function prx($arr){
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
    }
}