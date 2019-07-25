<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;
class BiddingController extends CommonController {
    
    public function index(){
        
        
        $this->mb();
        $str=" uniacid=".$this->uniacid." ";
        if(isset($_GET["mobile"]) && trim($_GET["mobile"])!=""){
            $mobile=trim($_GET["mobile"]);
            $str.=" and mobile like '%".$mobile."%'";
            $this->mobile=$_GET["mobile"];
        }else{
            $this->mobile="";
        }
        
        if(isset($_GET["flag"]) && intval($_GET["flag"])>0){
        	$flag=intval($_GET["flag"]);
        	$str.=" and flag='".$flag."'";
        	$this->flag=$_GET["flag"];
        }else{
        	$this->flag=0;
        }
        if(isset($_GET["audit"]) && intval($_GET["audit"])>0){
            $audit=intval($_GET["audit"]);
            $str.=" and audit='".$audit."'";
            $this->audit=$_GET["audit"];
        }else{
            $this->audit=0;
        }

        if(isset($_GET["btime"]) && trim($_GET["btime"])!=""){
            $btime=date("Y-m-d 00:00:00",strtotime($_GET["btime"]));
            $str.=" and addtime>='".strtotime($btime)."'";
            $this->btime=$_GET["btime"];
        }else{
            $this->btime="";
        }
        if(isset($_GET["etime"]) && trim($_GET["etime"])!=""){
            $etime=date("Y-m-d 23:59:59",strtotime($_GET["etime"]));
            $str.=" and addtime<='".strtotime($etime)."'";
            $this->etime=$_GET["etime"];
        }else{
            $this->etime="";
        }
        
        $count=M("bidding")->where($str)->count();
        $Page=new Page($count,10);
        $show=$Page->show();
        
        $rs=M("bidding")->where($str)->order("id desc")->limit($Page->firstRow.",".$Page->listRows)->select();        
        $this->page=$show;
        $this->count=$count;
        for($i=0;$i<count($rs);$i++){
        	$rt=M("member")->where("nid=".$rs[$i]["m_id"]." and uniacid=".$this->uniacid)->find();
        	if($rt){
        		$rs[$i]["wx_headimg"]=$rt["wx_headimg"];
        		$rs[$i]["wx_nickname"]=$rt["wx_nickname"];
        	}else{
        		$rs[$i]["wx_headimg"]="";
        		$rs[$i]["wx_nickname"]=$rt["truename"];
        	}
        }
        $this->rs=$rs;
        $this->display();
    }
    
    //批量审核通过车主竟价操作
    public function isaudit(){
        $this->mb();
        if(!IS_POST || trim($_POST["allid"])==""){
            $this->error("非法操作");
        }
        $allid=substr(trim($_POST["allid"]), 0,-1);
        if($allid==""){
            $this->error("非法操作");
        }
        //审核通过要发送模板消息
        $this->getConfig();
        $rt=M("bidding")->where(" id in (".$allid.") and uniacid=".$this->uniacid)->select();
        if($rt){
            foreach($rt as $k=>$v){
                $overdue=$v["put_time"]*86400+time();//过期时间
                $brr=array(
                    "audit"=>2,
                    "reason"=>"已支付，审核通过",
                    "operate_time"=>time(),
                    "overdue"=>$overdue
                );
                M("bidding")->where("id=".$v["id"]." and uniacid=".$this->uniacid)->data($brr)->save();
                $res=M("member")->where("nid=".$v["m_id"]." and uniacid=".$this->uniacid)->find();
                if($res["unionid"]!="0"){
                    //发送模板消息
                    $data=array(
                        "title"=>'车主竟价审核通知',
                        "truename"=>$res["truename"],
                        "mobile"=>$res["mobile"],
                        "wx"=>$v["weixin"],
                        "date"=>date("Y-m-d H:i:s"),
                        "remark"=>"祝贺您！车主[".$res["truename"]."]竟价成功,线路信息已上线。"
                    );
                    send_carownermb_bidding_msg($v["mobile"],$v["m_id"],$res["unionid"],C("gzh_template2"),$data,"审核通过");
                }else{
                    //发送短信开始
                    Vendor('alisms.Alisms');
                    $alisms = new \Alisms(C('ali_sms.key_id'),C('ali_sms.key_secret'));
                    $temp_code   = C('ali_sms.sms16');
                    
                    $alisms->signName = C('ali_sms.signname');
                    $rt=M("member")->where("uniacid=".$this->uniacid)->find($v["m_id"]);
                    $paramString = '{"truename":"'.$rt["truename"].'","flag":"审核通过"}';
                    $alisms->smsend($v["mobile"],$temp_code,$paramString);
                }
            }
            $data=array(
                "status"=>1,
                "retDesc"=>"操作成功"
            );
        }else{
            $data=array(
                "status"=>0,
                "retDesc"=>"操作失败"
            );
        }
        $this->ajaxReturn($data);        
    }
    
    //批量拒绝审核车主竟价操作
    public function refused(){
        $this->mb();
        if(!IS_POST || trim($_POST["allid"])==""){
            $this->error("非法操作");
        }
        $allid=substr(trim($_POST["allid"]), 0,-1);
        if($allid==""){
            $this->error("非法操作");
        }
        $brr=array(
            "audit"=>3,
            "reason"=>"已拒绝，请联系客服,询问详情。",
            "operate_time"=>time()
        );
        M("bidding")->where(" id in (".$allid.") and uniacid=".$this->uniacid)->data($brr)->save();
        //审核通过要发送模板消息
        $this->getConfig();
        $rt=M("bidding")->where(" id in (".$allid.") and uniacid=".$this->uniacid)->select();
        if($rt){
            foreach($rt as $k=>$v){
                $res=M("member")->where("nid=".$v["m_id"]." and uniacid=".$this->uniacid)->find();
                if($res["unionid"]!="0"){
                    //发送模板消息
                    $data=array(
                        "title"=>'车主竟价审核通知',
                        "truename"=>$res["truename"],
                        "mobile"=>$res["mobile"],
                        "wx"=>$v["weixin"],
                        "date"=>date("Y-m-d H:i:s"),
                        "remark"=>"尊敬的车主[".$res["truename"]."]:你竟价信息审核已拒绝，请联系客服,询问详情。"
                    );
                    send_carownermb_bidding_msg($v["m_id"],$res["unionid"],C("gzh_template2"),$data);
                }else{
                    //发送短信开始
                    Vendor('alisms.Alisms');
                    $alisms = new \Alisms(C('ali_sms.key_id'),C('ali_sms.key_secret'));
                    $temp_code   = C('ali_sms.sms16');
                    $alisms->signName = C('ali_sms.signname');
                    $rt=M("member")->find($v["m_id"]);
                    $paramString = '{"truename":"'.$rt["truename"].'","flag":"拒绝"}';
                    $re = $alisms->smsend($rt["mobile"],$temp_code,$paramString);
                }
            }
            $data=array(
                "status"=>1,
                "retDesc"=>"操作成功"
            );
        }else{
            $data=array(
                "status"=>0,
                "retDesc"=>"操作失败"
            );
        }
        $this->ajaxReturn($data);
    }
    
    public function start(){
        $this->mb();
        $id=I("id");
        $rs=M("bidding")->find($id);
        if($rs["nstatus"]==0){
            $nstatus=1 ;
        }else{
            $nstatus=0 ;
        }
    
        M("bidding")->where("id=".$id)->setField("nstatus",$nstatus);
        $this->success("操作成功");
    }
    
    public function pricelist(){
        $this->mb();
        $str=" uniacid=".$this->uniacid." ";
        if(trim($_GET["btime"])!=""){
            $btime=date("Y-m-d 00:00:00",strtotime($_GET["btime"]));
            $str.=" and addtime>='".$btime."'";
            $this->btime=$_GET["btime"];
        }else{
            $this->btime="";
        }
        if(trim($_GET["etime"])!=""){
            $etime=date("Y-m-d 23:59:59",strtotime($_GET["etime"]));
            $str.=" and addtime<='".$etime."'";
            $this->etime=$_GET["etime"];
        }else{
            $this->etime="";
        }
        if(isset($_GET["nstatus"]) && intval($_GET["nstatus"])>0){
            $nstatus=intval($_GET["nstatus"]);
            $str.=" and nstatus='".$nstatus."'";
            $this->nstatus=$_GET["nstatus"];
        }else{
            $this->nstatus=0;
        }
    
        $count=M("bidding_price")->where($str)->count();
        $Page=new Page($count,10);
        $show=$Page->show();
    
        $rs=M("bidding_price")->where($str)->order("id desc")->limit($Page->firstRow.",".$Page->listRows)->select();
        $this->page=$show;
        $this->count=$count;
        for($i=0;$i<count($rs);$i++){
            if($rs[$i]["nstatus"]==1){
                $rs[$i]["nstatus1"]="启用";
            }else{
                $rs[$i]["nstatus1"]="停用";
            }
        }
    
        $this->rs=$rs;
        $this->display();
    }
    
    public function price_add(){
    
        $this->mb();
        $this->display();
    
    }
    
    public function price_addhandle(){
    
        $this->mb();
        if(!IS_POST){
            $this->error("非法操作");
        }
        $param=I("post.");
		if(M("bidding_price")->where('daynum='.$param["daynum"]." and uniacid=".$this->uniacid)->find()){
           $this->error("投放天数重复操作");
        }
        $param["addtime"]=date("Y-m-d H:i:s");
        $param["uniacid"]=$this->uniacid;
        M("bidding_price")->add($param);
        $this->success("操作成功",U('Bidding/pricelist'));
    }
    //价格批量启用
    public function isprice_start(){
        $this->mb();
        if(!IS_POST || trim($_POST["allid"])==""){
            $this->error("非法操作");
        }
        $allid=substr(trim($_POST["allid"]), 0,-1);
        if($allid==""){
            $this->error("非法操作");
        }
        M("bidding_price")->where(" id in (".$allid.")")->data(array("nstatus"=>1))->save();
        $data=array(
            "status"=>1,
            "retDesc"=>"操作成功"
        );
        $this->ajaxReturn($data);
    }
    
    //价格批量停用
    public function isprice_stop(){
        $this->mb();
        if(!IS_POST || trim($_POST["allid"])==""){
            $this->error("非法操作");
        }
        $allid=substr(trim($_POST["allid"]), 0,-1);
        if($allid==""){
            $this->error("非法操作");
        }
        M("bidding_price")->where(" id in (".$allid.")")->data(array("nstatus"=>2))->save();
        $data=array(
            "status"=>1,
            "retDesc"=>"操作成功"
        );
        $this->ajaxReturn($data);
    }    
    //入口检验函数
    public function mb(){
        $mb=new IndexController();
        $mb->moban();
    }  
}