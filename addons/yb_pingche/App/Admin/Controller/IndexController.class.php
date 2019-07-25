<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController{
	        
        public function index(){
            session_start();
            //$this->moban();
            $this->top();
            $this->welcome();
        }
        
        public function moban(){
            //isset($_SESSION['nid'])||redirect(U('Admin/Login/index'));
            //$this->getConfig();
        }
        
        public function top(){
            //$result=M("admin")->where(array("id"=>$_SESSION["nid"]))->find();
            $this->assign("top_name","管理员");
            $this->assign("title","拼车管理系统后台v1.0 ");
            $this->assign("url","javascript:void(0);");
        }
        
        public function left(){
        }
        public function welcome(){
        	//进入后台显示后台中心页面
            $summenoy1=M("car_owner_order_details")->where("ispay!=1 and uniacid=".$this->uniacid)->sum("ntotal");
            $summenoy2=M("passenger_order")->where("ispay!=1 and uniacid=".$this->uniacid)->sum("money");
            $this->summenoy=round($summenoy1+$summenoy2,2);
             
            $sumcount1=M("car_owner_order_details")->where("ispay!=1 and uniacid=".$this->uniacid)->count();
            $sumcount2=M("passenger_order")->where("ispay!=1 and uniacid=".$this->uniacid)->count();
            $this->sumcount=$sumcount1+$sumcount2;
            
            $bdate=date("Y-m-d 00:00:01",time()-24*3600);
            $edate=date("Y-m-d 23:59:59",time()-24*3600);
            
            
            $yessummenoy1=M("car_owner_order_details")->where("ispay!=1 and transaction_time>='".$bdate."' and transaction_time<='".$edate."'  and uniacid=".$this->uniacid)->sum("ntotal");
            $yessummenoy2=M("passenger_order")->where("ispay!=1 and transaction_time>='".$bdate."' and transaction_time<='".$edate."' and uniacid=".$this->uniacid)->sum("money");
            $this->yessummenoy=round($yessummenoy1+$yessummenoy2,2);
            $yessumcount1=M("car_owner_order_details")->where("ispay!=1 and transaction_time>='".$bdate."' and transaction_time<='".$edate."' and uniacid=".$this->uniacid)->count();
            $yessumcount2=M("passenger_order")->where("ispay!=1 and transaction_time>='".$bdate."' and transaction_time<='".$edate."' and uniacid=".$this->uniacid)->count();
            $this->yessumcount=$yessumcount1+$yessumcount2;
        	$this->display();
        }
}