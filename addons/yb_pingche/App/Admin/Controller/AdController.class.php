<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;
class AdController extends CommonController {
    //显示广告列表
    Public function index(){
        
        $this->mb();
        $str=" uniacid=".$this->uniacid;
        if(isset($_GET["btime"]) && trim($_GET["btime"])!=""){
            $str.=" and addtime>='".date("Y-m-d 00:00:00",strtotime($_GET["btime"]))."' ";
        
        }
        if(isset($_GET["etime"]) && trim($_GET["etime"])!=""){
            $str.=" and addtime<='".date("Y-m-d 23:59:59",strtotime($_GET["etime"]))."' ";
        }
        if(isset($_GET["nstatus"]) &&  intval($_GET["nstatus"])>0){
            $str.=" and nstatus='".intval($_GET["nstatus"])."' ";
        }
        if(isset($_GET["name"]) &&  trim($_GET["name"])!=""){
            $str.=" and name='".trim($_GET["name"])."' ";
        }        
        if($str!=""){
            $count=M('ad_seat')->where($str)->count();
        }else{
            $count=M('ad_seat')->count();
        }
        $this->count=$count;
        $Page=new Page($count,10);
        $show=$Page->show();
        
        if($str!=""){
            $ad=M('ad_seat')->where($str)->limit($Page->firstRow.",".$Page->listRows)->order(" nid desc")->select();
        }else{
            $ad=M('ad_seat')->limit($Page->firstRow.",".$Page->listRows)->order(" nid desc")->select();
        }
        if(isset($_GET["btime"])){
            $this->assign("btime",$_GET["btime"]);
        }else{
        	$this->assign("btime","");
        }
        if(isset($_GET["etime"])){
            $this->assign("etime",$_GET["etime"]);
        }else{
        	$this->assign("etime","");
        }
        if(isset($_GET["nstatus"])){
            $this->assign("nstatus",$_GET["nstatus"]);
        }else{
        	$this->assign("nstatus",0);
        }
        if(isset($_GET["name"])){
            $this->assign("name",$_GET["name"]);
        }else{
        	$this->assign("name","");
        }        
        $this->assign('ad',$ad);
        $this->assign('page',$show);
        $this->display();
    }
    
    //全选删除操作
    public function alldel(){
        $this->mb();
        if(!$_POST || trim($_POST["allid"])=="" ){
            $this->error("非法操作");
        }
        $allid=substr(trim($_POST["allid"]),0,-1);
        if($allid==""){
            $this->error("操作失败，必须要选择要删除的记录");
        }
        if($id=M("ad_seat")->where(" nid in (".$allid.")  and uniacid=".$this->uniacid )->delete()){
            $arr=explode(",", $allid);
            for($i=0;$i<count($arr);$i++){
                $rs=M("ad_info")->where(" a_id =".$arr[$i]["nid"]." and uniacid=".$this->uniacid )->select();
                if($rs){
                    for($j=0;$j<count($rs);$j++){
                        @unlink("./Public/Uploads/Ads/".$rs[$j]["file_path"]);
                    }
                }
                M("ad_info")->where(" a_id =".$arr[$i]["nid"]." and uniacid=".$this->uniacid )->delete();
            }
            $data["status"]=1;
            $data["retDesc"]="删除成功";
        }else{
            $data["status"]=0;
            $data["retDesc"]="删除失败";
        }
        $this->ajaxReturn($data);
        
    }
    
    //广告位单个删除
    public function del(){
        $this->mb();
        if(!isset($_GET["nid"]) || intval($_GET["nid"])==0){
            $this->error("非法操作");
        }
        $nid=I("nid",0,"intval");
        if(M("ad_seat")->where(array("nid"=>$nid,"uniacid"=>$this->uniacid))->delete()){
            $rs=M("ad_info")->where(" a_id =".$nid." and uniacid=".$this->uniacid)->select();
            if($rs){
                for($j=0;$j<count($rs);$j++){
                    @unlink("./Public/Uploads/Ads/".$rs[$j]["file_path"]);
                }
            }
            M("ad_info")->where(" a_id =".$nid." and uniacid=".$this->uniacid)->delete();            
            $this->success("删除成功");
        }else{
            $this->error("操作失败");
        }
        
        
    }
    
    //显示添加广告位信息页面
    public function index_add(){
        
        $this->mb();
        $this->display();
        
    }
    
    //上传广告位默认图片
    public function uploads(){
        $this->mb();
        ini_set("date.timezone","Asia/Chongqing");
        $files=$_FILES["file"];//上传图片文件内容
        $name=$_POST["name"];//获取上传的文字内容
        if($files){
            $filename = explode(".",strtolower($files['name']));
            $arr=C("UPTYPE");
            if(!in_array($files["type"], $arr)){
                echo "failed,the format is incorrect";
                exit;
            }
             
            $filename=date("YmdHis").".".$filename[(count($filename)-1)];
            $tmpname =  $files['tmp_name'];
            $folder_tmp='./Public/Uploads/Ads/';
            if(move_uploaded_file($tmpname,$folder_tmp.$filename)){
                echo $filename;
            }else{
                echo "upload fail";
            }
        }else{
            echo "illegal upload";
        }
    }
    
    //广告位信息提交操作
    public function index_addhandle(){
        $this->mb();
        if(!IS_POST || trim($_POST["name"])=="" || trim($_POST["width"])=="" || trim($_POST["height"])=="" || trim($_POST["file_path"])==""){
            $this->error("非法操作");
        }
        $_POST["width"]=intval($_POST["width"]);
        $_POST["height"]=intval($_POST["height"]);
        $_POST["addtime"]=date("Y-m-d H:i:s");
        $_POST["uniacid"]=$this->uniacid;
        unset($_POST["file"]);
        if($id=M("ad_seat")->data($_POST)->add()){
            $this->success("添加成功");
        }else{
            $this->error("添加失败");
        }
    }
    
    //单个广告位修改
    public function index_modi(){
        $this->mb();
        if(!isset($_GET["nid"]) || intval($_GET["nid"])<=0){
            $this->error("非法操作");
        }
        $nid=I("nid",0,"intval");
        $rs=M("ad_seat")->where("nid=".$nid." and uniacid=".$this->uniacid)->find();
        if(!$rs){
            $this->error("广告位记录不存在");
        }else{
            $this->ad=$rs;
            $this->display();
        }
        
    }
    
    //修改广告位信息提交操作
    public function index_modihandle(){
        $this->mb();
        if(!IS_POST || trim($_POST["nid"])=="" || trim($_POST["name"])=="" || trim($_POST["width"])=="" || trim($_POST["height"])=="" || trim($_POST["file_path"])==""){
            $this->error("非法操作");
        }
        $_POST["width"]=intval($_POST["width"]);
        $_POST["height"]=intval($_POST["height"]);
        $nid=I("nid",0,"intval");
        unset($_POST["file"],$_POST["nid"]);
        if($id=M("ad_seat")->where("nid=".$nid." and uniacid=".$this->uniacid)->data($_POST)->save()){
            $this->success("修改成功",U("Admin/Ad/index"));
        }else{
            $this->error("修改失败");
        }        
    }
    
    //显示添加广告位广告页面
    public function add_ad(){
        $this->mb();
        if(!isset($_GET["nid"]) || intval($_GET["nid"])<=0){
            $this->error("非法操作");
        }
        $this->a_id=intval($_GET["nid"]);
        $this->display();
        
    }
    
    //添加广告位广告提交操作
    public function add_adhandle(){
        $this->mb();
        if(!IS_POST || trim($_POST["a_id"])=="" || trim($_POST["hits"])=="" || trim($_POST["nstatus"])=="-1" || trim($_POST["file_path"])==""){
            $this->error("非法操作");
        }
        $_POST["addtime"]=date("Y-m-d H:i:s");
        $_POST["uniacid"]=$this->uniacid;
        unset($_POST["file"]);
        if($id=M("ad_info")->data($_POST)->add()){
            $this->success("添加成功");
        }else{
            $this->error("添加失败");
        }
    }
    
    //显示广告位广告列表页面
    public function ad_list(){
        $this->mb();
        if(!isset($_GET["nid"]) || intval($_GET["nid"])<=0){
            $this->error("非法操作");
        }
        $nid=intval($_GET["nid"]);
        $where="a_id=".$nid." and uniacid=".$this->uniacid;
        $count=M("ad_info")->where($where)->count();
        $this->count=$count;
        $Page=new Page($count,20);
        $show=$Page->show();
        $ad=M('ad_info')->where($where)->limit($Page->firstRow.",".$Page->listRows)->order(" nid desc")->select();
        $this->assign("nid",$_GET["nid"]);
        $this->assign('ad',$ad);
        $this->assign('page',$show);
        $this->display();
    }
    
    //显示广告位的广告信息修改页面
    public function ad_modi(){
        $this->mb();
        if(!isset($_GET["a_id"]) || intval($_GET["a_id"])<=0 || !isset($_GET["nid"])  ||  intval($_GET["nid"])<=0){
            $this->error("操作失败");
        }
        $a_id=I("a_id",0,"intval");
        $nid=I("nid",0,"intval");
        $ad=M("ad_info")->where("nid=".$nid." and uniacid=".$this->uniacid)->find();
        if(!$ad){
            $this->error("记录不存在");
        }else{
            $this->ad=$ad;
            $this->display();
        }
    }
    
    //广告位的广告修改提交操作
    public function ad_modihandle(){
        $this->mb();
        if(!IS_POST || trim($_POST["nid"])=="" || trim($_POST["a_id"])=="" || trim($_POST["hits"])=="" || trim($_POST["nstatus"])=="-1" || trim($_POST["file_path"])==""){
            $this->error("非法操作");
        }
        $nid=intval($_POST["nid"]);
        $n_id=intval($_POST["a_id"]);
		if(intval($_POST["nclass"])<=0){
            $_POST["xcx_path"]="";
            $_POST["xcx_param"]="";
        }
        unset($_POST["nid"],$_POST["a_id"],$_POST["file"]);
        $rs=M("ad_info")->where("nid=".$nid)->find();
		$id=M("ad_info")->where("nid=".$nid." and uniacid=".$this->uniacid)->data($_POST)->save();
        $this->success("修改成功",U("Admin/Ad/ad_list",array("nid"=>$n_id)));
/*        if($id=M("ad_info")->where("nid=".$nid." and uniacid=".$this->uniacid)->data($_POST)->save()){
             if(trim($_POST["file_path"])!=""){
                 @unlink("./Public/Uploads/Ads/".$rs["file_path"]);
             }
            $this->success("修改成功",U("Admin/Ad/ad_list",array("nid"=>$n_id)));
        }else{
            $this->error("修改失败");
        }
*/        
    }
    
    //广告全选删除操作
    public function adalldel(){
        $this->mb();
        if(!$_POST || trim($_POST["allid"])=="" || intval($_POST["a_id"])<=0){
            $this->error("非法操作");
        }
        $allid=substr(trim($_POST["allid"]),0,-1);
        if($allid==""){
            $this->error("操作失败，必须要选择要删除的记录");
        }
        $nid=I("a_id",0,"intval");
        if($arr=M("ad_info")->where(" nid in (".$allid.") and a_id=".$nid." and uniacid=".$this->uniacid)->select()){
            for($i=0;$i<count($arr);$i++){
                @unlink("./Public/Uploads/Ads/".$arr[$i]["file_path"]);
            }
            M("ad_info")->where(" nid in (".$allid.") and a_id=".$nid." and uniacid=".$this->uniacid)->delete();
            $data["status"]=1;
            $data["retDesc"]="删除成功";
        }else{
            $data["status"]=0;
            $data["retDesc"]="删除失败";
        }
        $this->ajaxReturn($data);
    
    }
    
    //显示广告点击日志页面
    public function log_list(){
        $this->mb();
        if(!isset($_GET["nid"]) || intval($_GET["nid"])<=0){
            $this->error("非法操作");
        }
        $nid=I("nid",0,"intval");
        $pid=I("pid",0,"intval");
        $where="ad_img_id=".$nid." and uniacid=".$this->uniacid;
        $count=M("ad_click")->where($where)->count();
        $this->count=$count;
        $Page=new Page($count,20);
        $show=$Page->show();
        $rs=M('ad_click')->where($where)->limit($Page->firstRow.",".$Page->listRows)->order(" nid desc")->select();
        if($rs){
           for($i=0;$i<count($rs);$i++){
               $res=M("member")->where("nid=".$rs[$i]["m_id"]." and uniacid=".$this->uniacid)->find();
               $rs[$i]["mobile"]=$res["mobile"];
           }
        }
        $this->assign('ad',$rs);
        $this->nid=$nid;
        $this->pid=$pid;
        $this->assign('page',$show);
        $this->display();
    }
    
    //广告点击页面单个删除操作
    public function ad_click_del(){
        $this->mb();
        if(!isset($_GET["nid"]) || intval($_GET["nid"])<=0){
            $this->error("非法操作");
        }
        $nid=I("nid",0,"");$pid=I("pid",0,"intval");
        $ad_img_id=I("ad_img_id",0,"");
        if($id=M("ad_click")->where(array("nid"=>$nid,"ad_img_id"=>$ad_img_id,"uniacid"=>$this->uniacid))->delete()){
            $this->success("删除成功",U("Admin/Ad/log_list",array("nid"=>$ad_img_id,"pid"=>$pid)));
        }else{
            $this->error("删除失败");
        }
    }
    
    //全选删除广告点击列表记录
    public function adclickalldel(){
        $this->mb();
        if(!$_POST || trim($_POST["allid"])==""){
            $this->error("非法操作");
        }
        $allid=substr(trim($_POST["allid"]),0,-1);
        if($allid==""){
            $this->error("操作失败，必须要选择要删除的记录");
        }
        if($id=M("ad_click")->where(" nid in(".$allid.") and uniacid=".$this->uniacid)->delete()){
            $data["status"]=1;
            $data["retDesc"]="删除成功";
        }else{
            $data["status"]=0;
            $data["retDesc"]="删除失败";
        }
        $this->ajaxReturn($data);
    }
    
    //入口验证函数
    public function mb(){
        $mb=new IndexController();
        $mb->moban();
    }
}