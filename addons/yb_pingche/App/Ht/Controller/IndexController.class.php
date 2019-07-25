<?php

namespace Ht\Controller;

use Think\Controller;
use Think\Page;
use Think\Model;
class IndexController extends MemberController
{
    private $token = '';
    private $openid = '';
    private $curr_time = 0;
    public function index()
    {
        $this->getConfig();
        if (C("is_web") == 2) {
            $data = array("retCode" => "0001", "retDesc" => "小程序暂停服务", "piansheng_title" => C("piansheng_title"), "piansheng_email" => C("piansheng_email"), "piansheng_qq" => C("piansheng_qq"), "piansheng_content" => htmlspecialchars_decode(C("piansheng_content")));
        } else {
            $data = array("retCode" => "0000", "appname" => C("appname"), "retDesc" => "小程序开启中");
        }
        exit(json_encode($data));
    }
    public function memberlogin()
    {
        if (!isset($_GET["code"]) || trim($_GET["code"]) == '') {
            $data = array("retCode" => "0001", "retDesc" => "非法操作");
            exit(json_encode($data));
        }
        $code = I("code");
        $referee_id = isset($_GET["nid"]) ? intval($_GET["nid"]) : 0;
        $ntype = isset($_GET["ntype"]) ? intval($_GET["ntype"]) : 0;
        $this->getConfig();
        $json = "https://api.weixin.qq.com/sns/jscode2session?appid=" . trim(C("pingche_xcx.appid")) . "&secret=" . trim(C("pingche_xcx.secret")) . "&js_code=" . $code . "&grant_type=authorization_code";
        $json = file_get_contents($json);
        $arr = json_decode($json, true);
        if (!isset($arr["session_key"]) || !isset($arr["openid"])) {
            $data = array("retCode" => "0001", "retDesc" => "获取异常");
            exit(json_encode($data));
        } else {
            $this->openid = $arr["openid"];
            $arr["expires_in"] = 7200;
            if (!isset($arr["unionid"])) {
                $arr["unionid"] = 0;
            }
            if (!($res = M("member")->where("openid='" . $this->openid . "'")->find())) {
                $result = array("regtime" => date("Y-m-d H:i:s"), "openid" => $this->openid, "session_key" => $arr["session_key"], "expires_in" => $arr["expires_in"], "session3r" => md5(mt_rand(1, 9) . $this->openid), "unionid" => $arr["unionid"], "uniacid" => $this->uniacid, "referee_id" => $referee_id);
                if ($nid = M("member")->data($result)->add()) {
                    if ($referee_id) {
                        if ($ntype == 1) {
                            $brr = array("referee_id" => $referee_id, "m_id" => $nid, "share_time" => date("Y-m-d H:i:s"), "addtime" => date("Y-m-d H:i:s"), "nstatus" => 0, "ntype" => $ntype, "uniacid" => $this->uniacid, "reason" => "会员分享");
                            M("car_owner_share")->data($brr)->add();
                        }
                        if ($ntype == 2) {
                            $brr = array("referee_id" => $referee_id, "m_id" => $nid, "share_time" => date("Y-m-d H:i:s"), "addtime" => date("Y-m-d H:i:s"), "nstatus" => 0, "ntype" => $ntype, "uniacid" => $this->uniacid, "reason" => "车主分享");
                            M("car_owner_share")->data($brr)->add();
                        }
                        if ($ntype == 3) {
                            $brr = array("referee_id" => $referee_id, "m_id" => $nid, "share_time" => date("Y-m-d H:i:s"), "addtime" => date("Y-m-d H:i:s"), "nstatus" => 0, "ntype" => $ntype, "uniacid" => $this->uniacid, "reason" => "订单分享");
                            M("car_owner_share")->data($brr)->add();
                            $brr = array("orderid" => I("orderid"), "nclass" => I("nclass"), "nstatus" => 1, "referee_id" => $referee_id, "addtime" => date("Y-m-d H:i:s"), "uniacid" => $this->uniacid, "m_id" => $nid);
                            M("invitation")->data($brr)->add();
                        }
                    }
                    $brr = array("ip" => get_client_ip(), "m_id" => $nid, "addtime" => date("Y-m-d H:i:s"), "uniacid" => $this->uniacid, "mobile" => '');
                    M("member_log")->data($brr)->add();
                    $res = M("member")->where("openid='" . $this->openid . "'")->find();
                    $data = array("retCode" => "0000", "retDesc" => "登录成功", "wx_headimg" => $res["wx_headimg"], "logintag" => $result["session3r"], "nclass" => 0, "isoldmember" => 0);
                } else {
                    $data = array("retCode" => "0001", "retDesc" => "创建失败");
                }
            } else {
                if ($res["nstatus"] == 2) {
                    $data = array("retCode" => "0001", "retDesc" => "账号已冻结");
                    echo json_encode($data);
                    exit;
                }
                if ($res["nstatus"] == 3) {
                    $data = array("retCode" => "0001", "retDesc" => "账号已删除");
                    echo json_encode($data);
                    exit;
                }
                if (empty($res["wx_headimg"]) && empty($res["wx_nickname"])) {
                    $data = array("retCode" => "0001", "retDesc" => "账号没有注册", "wx_headimg" => $res["wx_headimg"], "nclass" => 0, "isoldmember" => 1, "logintag" => $res["session3r"]);
                    echo json_encode($data);
                    exit;
                }
                $result = array("login_time" => date("Y-m-d H:i:s"), "num" => $res["num"] + 1, "openid" => $this->openid, "session_key" => $arr["session_key"], "expires_in" => $arr["expires_in"], "unionid" => $arr["unionid"], "session3r" => md5(mt_rand(1, 9) . $this->openid));
                if (M("member")->where("nid=" . $res["nid"])->data($result)->save()) {
                    $brr = array("ip" => get_client_ip(), "m_id" => $res["nid"], "addtime" => date("Y-m-d H:i:s"), "uniacid" => $this->uniacid, "mobile" => $res["mobile"]);
                    M("member_log")->data($brr)->add();
                    $data = array("retCode" => "0000", "retDesc" => "登录成功", "wx_headimg" => $res["wx_headimg"], "logintag" => $result["session3r"], "nclass" => $res["nclass"], "isoldmember" => 1);
                } else {
                    $data = array("retCode" => "0001", "retDesc" => "操作失败");
                }
            }
        }
        exit(json_encode($data));
    }
    public function getweixininfo()
    {
        if (!isset($_GET["city"]) || !isset($_GET["country"]) || !isset($_GET["gender"]) || !isset($_GET["nickName"]) || !isset($_GET["province"])) {
            $data = array("retCode" => "0001", "retDesc" => "非法操作");
        } else {
            $logintag = trim($_GET["logintag"]);
            $res = M("member")->where("session3r='" . $logintag . "'")->find();
            if ($res["nstatus"] == 2) {
                $data = array("retCode" => "0001", "retDesc" => "账号已冻结");
                echo json_encode($data);
                exit;
            }
            if ($res["nstatus"] == 3) {
                $data = array("retCode" => "0001", "retDesc" => "账号已删除");
                echo json_encode($data);
                exit;
            }
            $nickName = I("nickName");
            $brr = array("wx_city" => I("city"), "wx_country" => I("country"), "wx_gender" => I("gender"), "wx_nickname" => $nickName, "wx_province" => I("province"), "wx_headimg" => I("wx_headimg"), "login_time" => date("Y-m-d H:i:s"));
            M("member")->where("session3r='" . $logintag . "'")->data($brr)->save();
            $brr = array("ip" => get_client_ip(), "m_id" => $res["nid"], "addtime" => date("Y-m-d H:i:s"), "uniacid" => $this->uniacid, "mobile" => $res["mobile"]);
            M("member_log")->data($brr)->add();
            $data = array("retCode" => "0000", "retDesc" => "操作成功", "nclass" => $res["nclass"], "loginopen" => md5(mt_rand(1, 9) . $logintag));
        }
        exit(json_encode($data));
    }
    public function getsms()
    {
        $data = array("retCode" => "0001", "retDesc" => "非法操作");
        if (!IS_GET || !isset($_GET["mobile"]) || trim($_GET["mobile"]) == '' || $_GET["data"] == '') {
            exit(json_encode($data));
        }
        $logintag = I("logintag");
        $mobile = I("mobile");
        $getcode = mt_rand(1, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9);
        $_GET["smscode"] = $getcode;
        $_GET["totime"] = time() + 30 * 60;
        $_GET["status"] = 1;
        $_GET["addtime"] = date("Y-m-d H:i:s");
        $_GET["uniacid"] = $this->uniacid;
        unset($_GET["data"], $_GET["logintag"]);
        $this->getConfig();
        M("member_verycode_log")->data($_GET)->add();
        $temp_code = C("ali_sms.templatecode");
        $paramString = "{\"code\":\"" . $getcode . "\"}";
        $re = send_aliyun_msg($mobile, $temp_code, $paramString);
        $data = array();
        if ($re) {
            $data["retCode"] = "0000";
            $data["retDesc"] = "已发送";
        } else {
            $data["retCode"] = "0001";
            $data["retDesc"] = "获取失败";
        }
        exit(json_encode($data));
    }
    public function login_veri()
    {
        $data = array("retCode" => "0001", "retDesc" => "非法操作");
        if (!IS_GET || trim($_GET["mobile"]) == '' || trim($_GET["smscode"]) == '') {
            exit(json_encode($data));
        }
        $mobile = I("mobile");
        $smscode = I("smscode");
        $this->getConfig();
        $where = " uniacid=" . $this->uniacid . " and mobile='" . $mobile . "' and smscode='" . $smscode . "' and status=1 and totime>=" . time();
        if (!($rs = M("member_verycode_log")->where($where)->find())) {
            $data = array("retCode" => "0001", "retDesc" => "验证码过期或者不存在");
            exit(json_encode($data));
        } else {
            $result = array("veri_time" => date("Y-m-d H:i:s"), "status" => 2);
            if (!M("member_verycode_log")->where("nid=" . $rs["nid"])->data($result)->save()) {
                $data = array("retCode" => "0001", "retDesc" => "修改验证码记录失败");
                exit(json_encode($data));
            }
        }
    }
    public function choose_identity()
    {
        $this->mb();
        if (!isset($_GET["nclass"]) || intval($_GET["nclass"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "非法操作");
            exit(json_encode($data));
        }
        $nclass = intval($_GET["nclass"]);
        $logintag = I("logintag");
        $rs = M("member")->where("session3r='" . $logintag . "'")->find();
        M("member")->where("session3r='" . $logintag . "'")->setField("nclass", $nclass);
        $data = array("retCode" => "0000", "retDesc" => "操作成功");
        exit(json_encode($data));
    }

    //用户发布乘车需求
    public function passenger_add_task()
    {
        $this->mb();
        $logintag = I("logintag");
        $rt = M("member")->where("session3r='" . $logintag . "'")->find();
        $m_id = $rt["nid"];
        $redpacked = $rt["redpacked"];
        if (empty($rt["mobile"])) {
            $data = array("retCode" => "0001", "retDesc" => "请完善手机号");
            exit(json_encode($data));
        }
        $this->getConfig();
        $starting_place = I("starting_place");
        $end_place = I("end_place");
        $begin_time = strtotime($_GET["begin_time"]);
        $end_time = strtotime($_GET["end_time"]);
        $number = I("number", 0, "intval");
        $money = I("money");
        $area_name = I("area_name");
        $b_lnglat = I("b_lnglat");
        $e_lnglat = I("e_lnglat");
        if ($area_name == '') {
            $data = array("retCode" => "0001", "retDesc" => "定位没有成功");
            exit(json_encode($data));
        }
        if ($starting_place == '') {
            $data = array("retCode" => "0001", "retDesc" => "请填写出发地址");
            exit(json_encode($data));
        }
        if ($end_place == '') {
            $data = array("retCode" => "0001", "retDesc" => "请填写目的地址");
            exit(json_encode($data));
        }
        if ($begin_time == '') {
            $data = array("retCode" => "0001", "retDesc" => "请输入最早时间");
            exit(json_encode($data));
        }
        if ($end_time == '') {
            $data = array("retCode" => "0001", "retDesc" => "请输入最迟时间");
            exit(json_encode($data));
        }
        if ($number <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "请选择人数");
            exit(json_encode($data));
        }
        if ($money < C("member.jine")) {
            $data = array("retCode" => "0001", "retDesc" => "总价不能小于" . C("member.jine") . "元");
            exit(json_encode($data));
        }
        if ($end_time <= $begin_time) {
            $data = array("retCode" => "0001", "retDesc" => "时间不正确");
            exit(json_encode($data));
        }
        $ST = "HT" . date("YmdHis") . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9);
        $_GET["m_id"] = $m_id;
        $_GET["ordernum"] = $ST;
        $_GET["addtime"] = date("Y-m-d H:i:s");
        $form_id = $_GET["form_id"];
        unset($_GET["logintag"], $_GET["loginopen"], $_GET["form_id"]);
        $x = explode(",", $b_lnglat);
        $_GET["lng"] = $x[0];
        $_GET["lat"] = $x[1];
        if ($nid = M("passenger_order")->data($_GET)->add()) {
            if ($redpacked > $_GET["money"]) {
                $brr = array("m_id" => $m_id, "money" => $_GET["money"], "ntype" => 2, "addtime" => date("Y-m-d H:i:s"), "uniacid" => $this->uniacid, "note" => "支出");
                M("redpacked_detail")->data($brr)->add();
                $arr = array("ispay" => 2, "nstatus" => 2, "redpacked" => $_GET["money"], "paytype" => 2);
                M("passenger_order")->where("nid=" . $nid)->setField($arr);
                M("member")->where("nid=" . $m_id)->setDec("redpacked", $_GET["money"]);
                $where = "uniacid=" . $this->uniacid . " and isreceipt<>3 and nstatus=2 and isdel=0 and area_name='" . I("area_name") . "'";
                $where .= " and starting_place like '%" . I("starting_place") . "%' and end_place like '%" . I("end_place") . "%'";
                $where .= " and  ((begin_time >= '" . I("begin_time") . "' and begin_time<='" . I("end_time") . "') or (end_time >= '" . I("begin_time") . "' and end_time<='" . I("end_time") . "') )";
                $where .= " and number>=" . I("number");
                $rt = M("car_owner_order")->where($where)->order("nid desc")->select();
                if ($rt) {
                    $i = 0;
                    while ($i < count($rt)) {
                        $rm = M("member")->where("nid=" . $rt[$i]["co_id"])->find();
                        $paramString = "{\"starting_place\":\"" . I("starting_place") . "\",\"end_place\":\"" . I("end_place") . "\"}";
                        send_aliyun_msg($rm["mobile"], C("ali_sms.sms2"), $paramString);
                        $i++;
                    }
                }
                $data = array("retCode" => "0000", "retDesc" => "红包支付成功", "nid" => $nid, "paytype" => 2);
                exit(json_encode($data));
            }
            $data = array("retCode" => "0000", "retDesc" => "操作成功", "nid" => $nid, "paytype" => 1);
        } else {
            $data = array("retCode" => "0001", "retDesc" => "发布失败");
        }
        exit(json_encode($data));
    }
    public function passenger_modi_task()
    {
        $this->mb();
        $logintag = I("logintag");
        $nid = intval($_GET["nid"]);
        $rs = M("passenger_order")->where("nid=" . $nid)->find();
        if (!$rs) {
            $data = array("retCode" => "0001", "retDesc" => "记录不存在");
            exit(json_encode($data));
        }
        if ($rs["ispay"] == 3 || $rs["isreceipt"] > 1) {
            $data = array("retCode" => "0001", "retDesc" => "记录不可修改");
            exit(json_encode($data));
        }
        $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
        exit(json_encode($data));
    }
    public function passenger_modi_task_handle()
    {
        $this->mb();
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $starting_place = I("starting_place");
        $end_place = I("end_place");
        $begin_time = strtotime($_GET["begin_time"]);
        $end_time = strtotime($_GET["end_time"]);
        $number = I("number", 0, "intval");
        $money = I("money");
        $area_name = I("area_name");
        if ($area_name == '') {
            $data = array("retCode" => "0001", "retDesc" => "定位没有成功");
            exit(json_encode($data));
        }
        if ($starting_place == '') {
            $data = array("retCode" => "0001", "retDesc" => "请填写出发地址");
            exit(json_encode($data));
        }
        if ($end_place == '') {
            $data = array("retCode" => "0001", "retDesc" => "请填写目的地址");
            exit(json_encode($data));
        }
        if ($begin_time == '') {
            $data = array("retCode" => "0001", "retDesc" => "请输入最早时间");
            exit(json_encode($data));
        }
        if ($end_time == '') {
            $data = array("retCode" => "0001", "retDesc" => "请输入最迟时间");
            exit(json_encode($data));
        }
        if ($end_time <= $begin_time) {
            $data = array("retCode" => "0001", "retDesc" => "时间不正确");
            exit(json_encode($data));
        }
        if ($number <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "请选择人数");
            exit(json_encode($data));
        }
        $this->getConfig();
        if ($money < C("member.jine")) {
            $data = array("retCode" => "0001", "retDesc" => "总价不能小于" . C("member.jine") . "元");
            exit(json_encode($data));
        }
        $logintag = I("logintag");
        $form_id = I("form_id");
        $nid = intval($_GET["nid"]);
        $rs = M("passenger_order")->where("nid=" . $nid)->find();
        $m_id = $rs["m_id"];
        unset($_GET["logintag"], $_GET["loginopen"], $_GET["form_id"], $_GET["nid"]);
        M("passenger_order")->where("nid=" . $nid)->data($_GET)->save();
        $data = array("retCode" => "0000", "retDesc" => "操作成功");
        exit(json_encode($data));
    }
    public function passenger_cancal_task()
    {
        $this->mb();
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不全");
            exit(json_encode($data));
        }
        $nid = I("nid");
        $rs = M("passenger_order")->where("nid=" . $nid)->find();
        if ($rs["paytype"] == 2) {
            if ($rs["ispay"] == 2 && $rs["isreceipt"] == 1) {
                $data = array("ispay" => 3, "nstatus" => 1, "isstart" => 3, "isreceipt" => 3, "istransfer" => 2, "isdel1" => 1);
                M("passenger_order")->where("nid=" . $nid)->data($data)->save();
                if ($rs["redpacked"] > 0) {
                    M("member")->where("nid=" . $rs["m_id"])->setInc("redpacked", $rs["redpacked"]);
                    $brr = array("m_id" => $rs["m_id"], "money" => $rs["redpacked"], "ntype" => 1, "note" => "退款", "uniacid" => $this->uniacid, "addtime" => date("Y-m-d H:i:s"));
                    M("redpacked_detail")->data($brr)->add();
                }
                $data = array("retCode" => "0000", "retDesc" => "取消成功");
            } else {
                $data = array("retCode" => "0001", "retDesc" => "不能取消");
            }
        } else {
            if ($rs["ispay"] == 2 && $rs["isreceipt"] == 1) {
                if ($rs["money"] > $rs["redpacked"]) {
                    $arr = pc_passenger_task_refund($rs["ordernum"], $rs["transaction_id"], ($rs["money"] - $rs["redpacked"]) * 100);
                    if ($arr["result_code"] == "SUCCESS" && $arr["return_code"] == "SUCCESS") {
                        $data = array("ispay" => 3, "nstatus" => 1, "isstart" => 3, "isreceipt" => 3, "istransfer" => 2, "isdel1" => 1);
                        M("passenger_order")->where("nid=" . $nid)->data($data)->save();
                        if ($rs["redpacked"] > 0) {
                            M("member")->where("nid=" . $rs["m_id"])->setInc("redpacked", $rs["redpacked"]);
                            $brr = array("m_id" => $rs["m_id"], "money" => $rs["redpacked"], "ntype" => 1, "note" => "退款", "uniacid" => $this->uniacid, "addtime" => date("Y-m-d H:i:s"));
                            M("redpacked_detail")->data($brr)->add();
                        }
                        $data = array("retCode" => "0000", "retDesc" => "取消成功");
                    } else {
                        $data = array("retCode" => "0001", "retDesc" => "退款失败");
                    }
                } else {
                    $data = array("ispay" => 3, "nstatus" => 1, "isstart" => 3, "isreceipt" => 3, "istransfer" => 2, "isdel1" => 1);
                    M("passenger_order")->where("nid=" . $nid)->data($data)->save();
                    if ($rs["redpacked"] > 0) {
                        M("member")->where("nid=" . $rs["m_id"])->setInc("redpacked", $rs["redpacked"]);
                        $brr = array("m_id" => $rs["m_id"], "money" => $rs["redpacked"], "ntype" => 1, "note" => "退款", "uniacid" => $this->uniacid, "addtime" => date("Y-m-d H:i:s"));
                        M("redpacked_detail")->data($brr)->add();
                    }
                    $data = array("retCode" => "0000", "retDesc" => "取消成功");
                }
            } else {
                $data = array("retCode" => "0001", "retDesc" => "不能取消");
            }
        }
        exit(json_encode($data));
    }
    public function passenger_del_task()
    {
        $this->mb();
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $nid = I("nid");
        M("car_owner_order_details")->where("nid=" . $nid)->setField("isdel", 1);
        $data = array("retCode" => "0000", "retDesc" => "删除成功");
        exit(json_encode($data));
    }
    public function passenger_del_order()
    {
        $this->mb();
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $nid = I("nid");
        $rs = M("passenger_order")->where("nid=" . $nid)->find();
        if ($rs["paytype"] == 2) {
            if ($rs["ispay"] == 3 || $rs["ispay"] == 2 && $rs["isstart"] == 3) {
                M("passenger_order")->where("nid=" . $nid)->setField("isdel1", 1);
            }
            if ($rs["ispay"] == 2 && $rs["isstart"] == 1 && $rs["isreceipt"] == 1) {
                $data = array("ispay" => 3, "nstatus" => 1, "isstart" => 3, "isreceipt" => 3, "istransfer" => 2, "isdel1" => 1);
                M("passenger_order")->where("nid=" . $nid)->data($data)->save();
                if ($rs["redpacked"] > 0) {
                    M("member")->where("nid=" . $rs["m_id"])->setInc("redpacked", $rs["redpacked"]);
                    $brr = array("m_id" => $rs["m_id"], "money" => $rs["redpacked"], "ntype" => 1, "note" => "退款", "uniacid" => $this->uniacid, "addtime" => date("Y-m-d H:i:s"));
                    M("redpacked_detail")->data($brr)->add();
                }
            }
        } else {
            if ($rs["ispay"] == 3 || $rs["ispay"] == 2 && $rs["isstart"] == 3) {
                M("passenger_order")->where("nid=" . $nid)->setField("isdel1", 1);
            }
            if ($rs["ispay"] == 2 && $rs["isstart"] == 1 && $rs["isreceipt"] == 1) {
                $arr = pc_passenger_task_refund($rs["ordernum"], $rs["transaction_id"], $rs["money"] * 100);
                if ($arr["result_code"] == "SUCCESS" && $arr["return_code"] == "SUCCESS") {
                    $data = array("ispay" => 3, "nstatus" => 1, "isstart" => 3, "isreceipt" => 3, "istransfer" => 2, "isdel1" => 1);
                    M("passenger_order")->where("nid=" . $nid)->data($data)->save();
                    if ($rs["redpacked"] > 0) {
                        M("member")->where("nid=" . $rs["m_id"])->setInc("redpacked", $rs["redpacked"]);
                        $brr = array("m_id" => $rs["m_id"], "money" => $rs["redpacked"], "ntype" => 1, "note" => "退款", "uniacid" => $this->uniacid, "addtime" => date("Y-m-d H:i:s"));
                        M("redpacked_detail")->data($brr)->add();
                    }
                    $data = array("retCode" => "0000", "retDesc" => "删除成功");
                } else {
                    $data = array("retCode" => "0001", "retDesc" => "退款失败");
                }
            }
        }
        $data = array("retCode" => "0000", "retDesc" => "删除成功");
        exit(json_encode($data));
    }
    public function car_owner_del_order()
    {
        $this->mb();
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $nid = I("nid");
        $rs = M("passenger_order")->where("nid=" . $nid)->find();
        if (M("passenger_order")->where("nid=" . $nid . " and isreceipt=3")->setField("isdel2", 1)) {
            $data = array("retCode" => "0000", "retDesc" => "删除成功");
        } else {
            $data = array("retCode" => "0001", "retDesc" => "进行中不可删除");
        }
        exit(json_encode($data));
    }
    public function passenger_task_pay()
    {
        $this->mb();
        $logintag = I("logintag");
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不全");
            exit(json_encode($data));
        }
        $nid = intval($_GET["nid"]);
        $rs = M("passenger_order")->where("nid=" . $nid . " and ispay=1")->find();
        if (!$rs) {
            $data = array("retCode" => "0001", "retDesc" => "任务不存在");
            exit(json_encode($data));
        }
        $result = M("member")->where("session3r='" . $logintag . "'")->find();
        if ($result["redpacked"] > 0) {
            if ($rs["money"] > $result["redpacked"]) {
                $rs["money"] = round($rs["money"] - $result["redpacked"], 2);
                M("passenger_order")->where("nid=" . $nid . " and ispay=1")->setField("redpacked", $result["redpacked"]);
            }
        }
        $arr = array("openid" => $result["openid"], "body" => "拼车系统乘客任务支付", "attach" => $result["mobile"], "out_trade_no" => $rs["ordernum"], "total_fee" => $rs["money"] * 100, "tag" => "乘客任务");
        $tmp = pc_passenger_task_pay($arr);
        exit($tmp);
    }
    public function get_access_token()
    {
        $this->getConfig();
        $rs = M("access_token")->where("uniacid=" . $this->uniacid)->select();
        if ($rs) {
            if ($rs[0]["expires_in"] > time()) {
                return $rs[0]["access_token"];
            } else {
                $result = file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . C("pingche_xcx.appid") . "&secret=" . C("pingche_xcx.secret"));
                $crr = json_decode($result, true);
                $expires_in = time() + 7200;
                M("access_token")->data(array("access_token" => $crr["access_token"], "expires_in" => $expires_in))->where("uniacid=" . $this->uniacid)->save();
                return $crr["access_token"];
            }
        } else {
            $result = file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . C("pingche_xcx.appid") . "&secret=" . C("pingche_xcx.secret"));
            $crr = json_decode($result, true);
            $expires_in = time() + 7200;
            M("access_token")->data(array("access_token" => $crr["access_token"], "expires_in" => $expires_in, "uniacid" => $this->uniacid))->add();
            return $crr["access_token"];
        }
    }

    //乘客发布任务支付回调
    public function ht_passenger_task_pay()
    {
        $this->getConfig();
        libxml_disable_entity_loader(true);
        $str = file_get_contents("php://input");
        if (trim($str) != '') {
            $arr = xmlToArray($str);
            if ($arr["result_code"] != "SUCCESS" || $arr["return_code"] != "SUCCESS") {
                echo "<xml><return_code><![CDATA[FAIL]]></return_code>";
                echo "<return_msg><![CDATA[支付失败]]></return_msg></xml>";
                exit;
            }
            if ($rs = M("passenger_order")->where("ordernum='" . $arr["out_trade_no"] . "'")->find()) {
                if ($rs["ispay"] == 1) {
                    if (!M("passenger_order")->where("ordernum='" . $arr["out_trade_no"] . "' and ispay=1")->setField(array("transaction_id" => $arr["transaction_id"], "ispay" => 2, "nstatus" => 2, "transaction_time" => date("Y-m-d H:i:s")))) {
                        echo "<xml><return_code><![CDATA[FAIL]]></return_code>";
                        echo "<return_msg><![CDATA[OK]]></return_msg></xml>";
                        exit;
                    } else {
                        if ($rs["redpacked"] > 0) {
                            M("member")->where("nid=" . $rs["m_id"])->setDec("redpacked", $rs["redpacked"]);
                            $brr = array("m_id" => $rs["m_id"], "money" => $rs["redpacked"], "ntype" => 1, "note" => "支出", "uniacid" => $this->uniacid, "addtime" => date("Y-m-d H:i:s"));
                            M("redpacked_detail")->data($brr)->add();
                        }
                        $where = "uniacid=" . $this->uniacid . " and isreceipt<>3 and nstatus=2 and isdel=0 and area_name='" . $rs["area_name"] . "'";
                        $where .= " and starting_place like '%" . $rs["starting_place"] . "%' and end_place like '%" . $rs["end_place"] . "%'";
                        $where .= " and  ((begin_time >= '" . $rs["begin_time"] . "' and begin_time<='" . $rs["end_time"] . "') or (end_time >= '" . $rs["begin_time"] . "' and end_time<='" . $rs["end_time"] . "') )";
                        $where .= " and number>=" . $rs["number"];
                        $rt = M("car_owner_order")->where($where)->order("nid desc")->select();
                        if ($rt) {
                            $i = 0;
                            while ($i < count($rt)) {
                                $rm = M("member")->where("nid=" . $rt[$i]["co_id"])->find();
                                $paramString = "{\"starting_place\":\"" . $rs["starting_place"] . "\",\"end_place\":\"" . $rs["end_place"] . "\"}";
                                send_aliyun_msg($rm["mobile"], C("ali_sms.sms2"), $paramString);
                                $i++;
                            }
                        }
                        echo "<xml><return_code><![CDATA[SUCCESS]]></return_code>";
                        echo "<return_msg><![CDATA[OK]]></return_msg></xml>";
                        exit;
                    }
                } else {
                    echo "<xml><return_code><![CDATA[FAIL]]></return_code>";
                    echo "<return_msg><![CDATA[订单不存在]]></return_msg></xml>";
                    exit;
                }
            } else {
                echo "<xml><return_code><![CDATA[FAIL]]></return_code>";
                echo "<return_msg><![CDATA[订单不存在]]></return_msg></xml>";
                exit;
            }
        } else {
            $data = array("retCode" => "0001", "retDesc" => "非法操作");
            echo json_encode($data);
        }
    }
    public function member_isexist_mobile()
    {
        $this->mb();
        $logintag = I("logintag");
        $rs = M("member")->where("session3r='" . $logintag . "'")->find();
        if ($rs) {
            if (!empty($rs["mobile"])) {
                $data = array("retCode" => "0000", "retDesc" => "操作成功", "mobile" => $rs["mobile"]);
            } else {
                $data = array("retCode" => "0001", "retDesc" => "不存在");
            }
        } else {
            $data = array("retCode" => "0001", "retDesc" => "不存在");
        }
        exit(json_encode($data));
    }
    public function member_binding_mobile_send_sms()
    {
        $this->mb();
        $logintag = I("logintag");
        if (!isset($_GET["mobile"]) || trim($_GET["mobile"]) == '') {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $mobile = I("mobile");
        $rs = M("member")->where("session3r='" . $logintag . "'")->find();
        $m_id = $rs["nid"];
        $getcode = mt_rand(1, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9);
        $_GET["smscode"] = $getcode;
        $_GET["totime"] = time() + 30 * 60;
        $_GET["nstatus"] = 1;
        $_GET["addtime"] = date("Y-m-d H:i:s");
        $_GET["m_id"] = $m_id;
        $_GET["uniacid"] = $this->uniacid;
        unset($_GET["loginopen"], $_GET["logintag"]);
        M("member_binding_mobile")->data($_GET)->add();
        $temp_code = C("ali_sms.templatecode");
        $paramString = "{\"code\":\"" . $getcode . "\"}";
        $re = send_aliyun_msg($mobile, $temp_code, $paramString);
        $data = array();
        if ($re) {
            $data["retCode"] = "0000";
            $data["retDesc"] = "已发送";
        } else {
            $data["retCode"] = "0001";
            $data["retDesc"] = "获取失败";
        }
        exit(json_encode($data));
    }
    public function member_perfect_mobile()
    {
        $this->mb();
        if (!isset($_GET["mobile"]) || trim($_GET["mobile"]) == '' || !isset($_GET["smscode"]) || trim($_GET["smscode"]) == '') {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $mobile = I("mobile");
        $logintag = I("logintag");
        $smscode = I("smscode");
        $rs = M("member")->where("session3r='" . $logintag . "'")->find();
        $m_id = $rs["nid"];
        $where = "mobile='" . $mobile . "' and smscode='" . $smscode . "' and nstatus=1 and m_id='" . $m_id . "'";
        if (M("member_binding_mobile")->where($where)->find()) {
            M("member_binding_mobile")->where($where)->setField("nstatus", 2);
            M("member")->where("nid=" . $m_id)->setField("mobile", $mobile);
            $data = array("retCode" => "0000", "retDesc" => "操作成功");
        } else {
            $data = array("retCode" => "0001", "retDesc" => "验证失败");
        }
        exit(json_encode($data));
    }
    public function passenger_search_car_owner_task()
    {
        $this->mb();
        if (trim($_GET["area_name"]) == '' || trim($_GET["starting_place"]) == '' || trim($_GET["end_place"]) == '' || trim($_GET["begin_time"]) == '' || trim($_GET["end_time"]) == '') {
            $data = array("retCode" => "0001", "retDesc" => "参数不能为空");
            exit(json_encode($data));
        }
        $logintag = I("logintag");
        $rs = M("member")->where("session3r='" . $logintag . "'")->find();
        if (empty($rs["mobile"])) {
            $data = array("retCode" => "0001", "retDesc" => "请完善手机号");
            exit(json_encode($data));
        }
        $starting_place = I("starting_place");
        $end_place = I("end_place");
        $begin_time = I("begin_time");
        $end_time = I("end_time");
        $area_name = I("area_name");
        $xval = floatval($_GET["xval"]);
        $yval = floatval($_GET["yval"]);
        $where = "uniacid=" . $this->uniacid . " and nstatus=2 and isdel=0 and area_name='" . $area_name . "' and end_time>'" . date("Y-m-d H:i:s") . "'";
        if ($starting_place != '' && $end_place != '') {
            $where .= " and starting_place like '%" . $starting_place . "%' and end_place like '%" . $end_place . "%'";
        } else {
            if ($starting_place != '') {
                $where .= " and starting_place like '%" . $starting_place . "%'";
            } else {
                if ($end_place != '') {
                    $where .= " and end_place like '%" . $end_place . "%'";
                }
            }
        }
        if ($begin_time != '' && $end_time != '') {
            $where .= " and ((begin_time >= '" . $begin_time . "' and begin_time<='" . $end_time . "') or (end_time >= '" . $begin_time . "' and end_time<='" . $end_time . "') )";
        } else {
            $data = array("retCode" => "0001", "retDesc" => "时间不能为空");
            exit(json_encode($data));
        }
        $where .= " and surplus_seat >0";
        $tmp = "ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN((" . $yval . " * PI() / 180 - lng * PI() / 180) / 2),2)+ COS(" . $yval . " * PI() / 180) * COS(lng * PI() / 180) * POW( SIN((" . $xval . " * PI() / 180 - lat * PI() / 180) / 2),2))) * 1000) AS juli";
        $field = "nid,co_id,starting_place,end_place,begin_time,end_time,nstatus,number,note,money,now_num,ordernum,surplus_seat,b_lnglat,e_lnglat,lng,lat,begin_addr,end_addr," . $tmp;
        $count = M("car_owner_order")->where($where)->count();
        $Page = new Page($count, 10);
        $limit = $Page->firstRow . "," . $Page->listRows;
        $rs = M("car_owner_order")->field($field)->where($where)->order("juli asc,nid desc")->limit($limit)->select();
        if ($rs) {
            $i = 0;
            while ($i < count($rs)) {
                if (intval($rs[$i]["juli"]) > 1000) {
                    $rs[$i]["juli"] = round($rs[$i]["juli"] / 1000, 2) . "Km";
                } else {
                    $rs[$i]["juli"] .= "m";
                }
                $rt = M("member")->where("nid=" . $rs[$i]["co_id"])->find();
                $rs[$i]["mobile"] = $rt["mobile"];
                $rs[$i]["x_mobile"] = $rt["mobile"];
                $rs[$i]["wx_headimg"] = $rt["wx_headimg"];
                $rs[$i]["nowseat"] = $rs[$i]["surplus_seat"];
                $rs[$i]["wx_nickname"] = $rt["wx_nickname"];
                $rs[$i]["wx_gender"] = $rt["wx_gender"];
                $i++;
            }
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
        } else {
            $data = array("retCode" => "0001", "retDesc" => "没有数据");
        }
        exit(json_encode($data));
    }
    public function passenger_search_ad_show()
    {
        $this->mb();
        $rs = M("ad_seat")->where("ntype=1 and uniacid=" . $this->uniacid)->order("nid desc")->field("nid,nstatus,file_path")->find();
        $arr[] = $rs;
        if ($rs["nstatus"] == 1) {
            $rt = M("ad_info")->where("a_id=" . $rs["nid"] . " and nstatus=1 and isdel=1 and uniacid=" . $this->uniacid)->select();
            if ($rt) {
                $data = array("retCode" => "0000", "retDesc" => "获取成功", "nclass" => 2, "info" => $rt);
            } else {
                $data = array("retCode" => "0000", "retDesc" => "获取成功", "nclass" => 1, "info" => $arr);
            }
        } else {
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "nclass" => 1, "info" => $arr);
        }
        exit(json_encode($data));
    }
    public function passenger_enter_home_task()
    {
        $this->mb();
        if (!isset($_GET["area_name"]) || trim($_GET["area_name"]) == '') {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $area_name = I("area_name");
        $xval = floatval($_GET["xval"]);
        $yval = floatval($_GET["yval"]);
        $tmp = "ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN((" . $yval . " * PI() / 180 - lng * PI() / 180) / 2),2)+ COS(" . $yval . " * PI() / 180) * COS(lng * PI() / 180) * POW( SIN((" . $xval . " * PI() / 180 - lat * PI() / 180) / 2),2))) * 1000) AS juli";
        $where = "uniacid=" . $this->uniacid . " and nstatus=2 and end_time>='" . date("Y-m-d H:i:s") . "' and isreceipt!=3 and isdel=0 and area_name='" . $area_name . "'";
        $count = M("car_owner_order")->where($where)->count();
        $Page = new Page($count, 10);
        $limit = $Page->firstRow . "," . $Page->listRows;
        $field = "nid,co_id,starting_place,end_place,begin_time,end_time,nstatus,number,note,money,now_num,ordernum,surplus_seat,b_lnglat,e_lnglat,lng,lat,begin_addr,end_addr," . $tmp;
        $rs = M("car_owner_order")->field($field)->where($where)->order("juli asc,nid desc")->limit($limit)->select();
        if ($rs) {
            $i = 0;
            while ($i < count($rs)) {
                if (intval($rs[$i]["juli"]) > 1000) {
                    $rs[$i]["juli"] = round($rs[$i]["juli"] / 1000, 2) . "Km";
                } else {
                    $rs[$i]["juli"] .= "m";
                }
                $rt = M("member")->where("nid=" . $rs[$i]["co_id"])->find();
                $rs[$i]["mobile"] = $rt["mobile"];
                $rs[$i]["x_mobile"] = substr($rt["mobile"], 0, 3) . "****" . substr($rt["mobile"], 7, 4);
                $rs[$i]["wx_gender"] = $rt["wx_gender"];
                $rs[$i]["wx_headimg"] = $rt["wx_headimg"];
                $rs[$i]["wx_nickname"] = $rt["wx_nickname"];
                $rs[$i]["nowseat"] = $rs[$i]["number"] - $rs[$i]["now_num"];
                $field = "starting_place,end_place,b_lnglat,e_lnglat,begin_addr,end_addr,money";
                $tp = M("car_owner_order_station")->field($field)->where("coo_id=" . $rs[$i]["nid"])->order("id desc")->select();
                $cou = count($tp);
                if ($cou > 1) {
                    unset($tp[$cou - 1]);
                    $rs[$i]["station"] = $tp;
                } else {
                    $rs[$i]["station"] = array();
                }
                $i++;
            }
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs, "ntype" => 1);
        } else {
            $data = array("retCode" => "0001", "retDesc" => "没有记录", "ntype" => 2);
        }
        exit(json_encode($data));
    }
    public function car_owner_task_info()
    {
        $this->mb();
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $flag = isset($_GET["flag"]) ? intval($_GET["flag"]) : 0;
        $nid = intval($_GET["nid"]);
        $xval = floatval($_GET["xval"]);
        $yval = floatval($_GET["yval"]);
        if ($flag > 0) {
            if ($flag == 1) {
                $tmp = "ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN((" . $yval . " * PI() / 180 - lng * PI() / 180) / 2),2)+ COS(" . $yval . " * PI() / 180) * COS(lng * PI() / 180) * POW( SIN((" . $xval . " * PI() / 180 - lat * PI() / 180) / 2),2))) * 1000) AS juli";
                $field = "nid,m_id,starting_place,end_place,begin_time,end_time,ispay,addtime,isreceipt,number,note,money,co_id,area_name,ordernum,isstart,b_lnglat,e_lnglat,lng,lat,begin_addr,end_addr," . $tmp;
                if ($rs = M("passenger_order")->field($field)->where("nid=" . $nid)->find()) {
                    if ($rs["isreceipt"] > 1) {
                        $data = array("retCode" => "0001", "retDesc" => "已被抢了");
                    } else {
                        if (intval($rs["juli"]) > 1000) {
                            $rs["juli"] = round($rs["juli"] / 1000, 2) . "Km";
                        } else {
                            $rs["juli"] .= "m";
                        }
                        $rt = M("member")->where("nid=" . $rs["m_id"])->find();
                        $rs["wx_nickname"] = $rt["wx_nickname"];
                        $rs["wx_headimg"] = $rt["wx_headimg"];
                        $rs["mobile"] = $rt["mobile"];
                        $rs["x_mobile"] = substr($rt["mobile"], 0, 3) . "****" . substr($rt["mobile"], 7, 4);
                        $rs["truename"] = $rt["truename"];
                        $rs["wx_gender"] = $rt["wx_gender"];
                        $rs["car_number"] = $rt["car_number"];
                        $rs["car_model"] = $rt["car_model"];
                        $rs["car_color"] = $rt["car_color"];
                        $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
                    }
                } else {
                    $data = array("retCode" => "0001", "retDesc" => "记录不存在");
                }
            } else {
                $tmp = "ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN((" . $yval . " * PI() / 180 - lng * PI() / 180) / 2),2)+ COS(" . $yval . " * PI() / 180) * COS(lng * PI() / 180) * POW( SIN((" . $xval . " * PI() / 180 - lat * PI() / 180) / 2),2))) * 1000) AS juli";
                $field = "nid,co_id,starting_place,end_place,begin_time,end_time,nstatus,addtime,number,note,money,area_name,isreceipt,now_num,ordernum,ismatching,surplus_seat,b_lnglat,e_lnglat,lng,lat,begin_addr,end_addr," . $tmp;
                $rs = M("car_owner_order")->field($field)->where("nid=" . $nid)->find();
                if ($rs) {
                    if (intval($rs["juli"]) > 1000) {
                        $rs["juli"] = round($rs["juli"] / 1000, 2) . "Km";
                    } else {
                        $rs["juli"] .= "m";
                    }
                    $rt = M("member")->where("nid=" . $rs["co_id"])->find();
                    $rs["wx_nickname"] = $rt["wx_nickname"];
                    $rs["wx_headimg"] = $rt["wx_headimg"];
                    $rs["mobile"] = $rt["mobile"];
                    $rs["x_mobile"] = substr($rt["mobile"], 0, 3) . "****" . substr($rt["mobile"], 7, 4);
                    $rs["truename"] = $rt["truename"];
                    $rs["wx_gender"] = $rt["wx_gender"];
                    $rs["car_number"] = $rt["car_number"];
                    $rs["car_model"] = $rt["car_model"];
                    $rs["car_color"] = $rt["car_color"];
                    $rs["nowseat"] = $rs["number"] - $rs["now_num"];
                    $field = "id,coo_id,starting_place,end_place,b_lnglat,e_lnglat,lng,lat,begin_addr,end_addr,money,addtime,nstatus,number,isreceipt,isdel,area_name,uniacid," . $tmp;
                    $tp = M("car_owner_order_station")->field($field)->where("coo_id=" . $nid)->order("id desc")->select();
                    $cou = count($tp);
                    if ($cou > 1) {
                        foreach ($tp as $k => $v) {
                            if ($v["juli"] > 1000) {
                                $tp[$k]["juli"] = round($v["juli"] / 1000, 2) . "Km";
                            } else {
                                $tp[$k]["juli"] .= "m";
                            }
                        }
                        unset($tp[$cou - 1]);
                        $rs["station"] = $tp;
                    } else {
                        $rs["station"] = array();
                    }
                    $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
                } else {
                    $data = array("retCode" => "0001", "retDesc" => "没有记录");
                }
            }
        } else {
            $tmp = "ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN((" . $yval . " * PI() / 180 - lng * PI() / 180) / 2),2)+ COS(" . $yval . " * PI() / 180) * COS(lng * PI() / 180) * POW( SIN((" . $xval . " * PI() / 180 - lat * PI() / 180) / 2),2))) * 1000) AS juli";
            $field = "nid,co_id,starting_place,end_place,begin_time,end_time,nstatus,addtime,number,note,money,area_name,isreceipt,now_num,ordernum,ismatching,surplus_seat,b_lnglat,e_lnglat,lng,lat,begin_addr,end_addr," . $tmp;
            $rs = M("car_owner_order")->field($field)->where("nid=" . $nid)->find();
            if ($rs) {
                if (intval($rs["juli"]) > 1000) {
                    $rs["juli"] = round($rs["juli"] / 1000, 2) . "Km";
                } else {
                    $rs["juli"] .= "m";
                }
                $rt = M("member")->where("nid=" . $rs["co_id"])->find();
                $rs["wx_nickname"] = $rt["wx_nickname"];
                $rs["wx_headimg"] = $rt["wx_headimg"];
                $rs["mobile"] = $rt["mobile"];
                $rs["x_mobile"] = substr($rt["mobile"], 0, 3) . "****" . substr($rt["mobile"], 7, 4);
                $rs["truename"] = $rt["truename"];
                $rs["wx_gender"] = $rt["wx_gender"];
                $rs["car_number"] = $rt["car_number"];
                $rs["car_model"] = $rt["car_model"];
                $rs["car_color"] = $rt["car_color"];
                $rs["nowseat"] = $rs["number"] - $rs["now_num"];
                $field = "id,coo_id,starting_place,end_place,b_lnglat,e_lnglat,lng,lat,begin_addr,end_addr,money,addtime,nstatus,number,isreceipt,isdel,area_name,uniacid," . $tmp;
                $tp = M("car_owner_order_station")->where("coo_id=" . $nid)->order("id desc")->select();
                $cou = count($tp);
                if ($cou > 1) {
                    foreach ($tp as $k => $v) {
                        if ($v["juli"] > 1000) {
                            $tp[$k]["juli"] = round($v["juli"] / 1000, 2) . "Km";
                        } else {
                            $tp[$k]["juli"] .= "m";
                        }
                    }
                    unset($tp[$cou - 1]);
                    $rs["station"] = $tp;
                } else {
                    $rs["station"] = array();
                }
                $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
            } else {
                $data = array("retCode" => "0001", "retDesc" => "没有记录");
            }
        }
        exit(json_encode($data));
    }
    public function passenger_buy_car_owner_seat()
    {
        $this->mb();
        if (!isset($_GET["seatnum"]) || intval($_GET["seatnum"]) <= 0 || !isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $logintag = I("logintag");
        $rs = M("member")->where("session3r='" . $logintag . "'")->find();
        $m_id = $rs["nid"];
        $redpacked = $rs["redpacked"];
        if (empty($rs["mobile"])) {
            $data = array("retCode" => "0001", "retDesc" => "请完善手机号");
            exit(json_encode($data));
        }
        $seatnum = intval($_GET["seatnum"]);
        $nid = intval($_GET["nid"]);
        $coos_id = I("coos_id", 0, "intval");
        $rs = M("car_owner_order")->where("nid=" . $nid)->find();
        if (!$rs) {
            $data = array("retCode" => "0001", "retDesc" => "记录不存在");
            exit(json_encode($data));
        }
        if ($rs["surplus_seat"] < $seatnum) {
            $data = array("retCode" => "0001", "retDesc" => "座位不够");
            exit(json_encode($data));
        }
        if ($coos_id) {
            $coos_rs = M("car_owner_order_station")->where("id=" . $coos_id)->find();
        } else {
            $coos_rs = M("car_owner_order_station")->where(" coo_id =" . $nid)->order("id asc")->find();
        }
        $crr = array("coo_id" => $nid, "m_id" => $m_id, "menoy" => $coos_rs["money"], "seat_num" => $seatnum, "ntotal" => $coos_rs["money"], "ispay" => 1, "addtime" => date("Y-m-d H:i:s"), "ordernum" => "HT" . date("YmdHis") . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9), "uniacid" => $this->uniacid, "coos_id" => $coos_rs["id"]);
        if ($bs = M("car_owner_order_details")->data($crr)->add()) {
            if ($redpacked >= $crr["ntotal"]) {
                M("member")->where("nid=" . $m_id)->setDec("redpacked", $crr["ntotal"]);
                $brr = array("m_id" => $m_id, "money" => $crr["ntotal"], "ntype" => 2, "note" => "支出", "uniacid" => $this->uniacid, "addtime" => date("Y-m-d H:i:s"));
                M("redpacked_detail")->data($brr)->add();
                $brr = array("isreceipt" => 2);
                M("car_owner_order")->where("nid=" . $nid)->setField($brr);
                M("car_owner_order_station")->where("coo_id=" . $nid)->setField($brr);
                M("car_owner_order_details")->where("nid=" . $bs)->setField(array("ispay" => 2, "paytype" => 2, "redpacked" => $crr["ntotal"]));
                $ordernum = $rs["ordernum"];
                $starting_place = $coos_rs["starting_place"];
                $end_place = $coos_rs["end_place"];
                M("car_owner_order")->where("nid=" . $nid)->setInc("now_num", $seatnum);
                $rs = M("car_owner_order")->where("nid=" . $nid)->find();
                $nownum = $rs["number"] - $rs["now_num"];
                M("car_owner_order")->where("nid=" . $nid)->setField("surplus_seat", $nownum);
                if (!$nownum) {
                    M("car_owner_order")->where("nid=" . $nid)->setField("nstatus", 1);
                    M("car_owner_order_station")->where("coo_id=" . $nid)->setField("nstatus", 1);
                }
                $rt = M("member")->where("nid=" . $rs["co_id"])->find();
                $paramString = "{\"starting_place\":\"" . $starting_place . "\",\"end_place\":\"" . $end_place . "\"}";
                if (send_aliyun_msg($rt["mobile"], C("ali_sms.sms3"), $paramString)) {
                    $data = array("retCode" => "0000", "retDesc" => "支付成功", "nid" => $bs, "paytype" => 2);
                } else {
                    $data = array("retCode" => "0000", "retDesc" => "短信发送失败", "nid" => $bs, "paytype" => 2);
                }
                exit(json_encode($data));
            }
            $data = array("retCode" => "0000", "retDesc" => "添加记录成功", "nid" => $bs, "paytype" => 1);
        } else {
            $data = array("retCode" => "0001", "retDesc" => "购买失败");
        }
        exit(json_encode($data));
    }
    public function passenger_buy_seat_pay()
    {
        $this->mb();
        $logintag = I("logintag");
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不全");
            exit(json_encode($data));
        }
        $nid = intval($_GET["nid"]);
        $rt = M("car_owner_order_details")->where("nid=" . $nid)->find();
        $seat_num = $rt["seat_num"];
        $rs = M("car_owner_order")->where("nid=" . $rt["coo_id"])->find();
        if ($rs["surplus_seat"] <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "座位不够了");
            exit(json_encode($data));
        }
        $ordernum = $rt["ordernum"];
        $ntotal = $rt["ntotal"];
        $m_id = $rt["m_id"];
        $ry = M("member")->where("nid=" . $m_id)->find();
        $openid = $ry["openid"];
        $mobile = $ry["mobile"];
        if ($ry["redpacked"] > 0) {
            if ($ntotal > $ry["redpacked"]) {
                $ntotal = $ntotal - $ry["redpacked"];
                M("car_owner_order_details")->where("nid=" . $nid)->setField("redpacked", $ry["redpacked"]);
            }
        }
        $arr = array("openid" => $openid, "body" => "拼车系统乘客任务支付", "attach" => $mobile, "out_trade_no" => $ordernum, "total_fee" => $ntotal * 100, "tag" => "乘客购买车主座位");
        $tmp = pc_passenger_buy_seat_pay($arr);
        exit($tmp);
    }
    public function ht_passenger_buy_seat_pay()
    {
        $this->getConfig();
        libxml_disable_entity_loader(true);
        $str = file_get_contents("php://input");
        if (trim($str) != '') {
            $arr = xmlToArray($str);
            if ($arr["result_code"] == "SUCCESS" && $arr["return_code"] == "SUCCESS") {
                $rs = M("car_owner_order_details")->where("ordernum='" . $arr["out_trade_no"] . "' and ispay=1")->find();
                $uniacid = $rs["uniacid"];
                if ($rs["redpacked"]) {
                    M("member")->where("nid=" . $rs["m_id"])->setDec("redpacked", $rs["redpacked"]);
                    $brr = array("m_id" => $rs["m_id"], "money" => $rs["redpacked"], "ntype" => 2, "addtime" => date("Y-m-d H:i:s"), "uniacid" => $uniacid, "note" => "支付订单");
                    M("redpacked_detail")->data($brr)->add();
                }
                $seat_num = $rs["seat_num"];
                $nid = $rs["coo_id"];
                M("car_owner_order")->where("nid=" . $rs["coo_id"])->setInc("now_num", $rs["seat_num"]);
                $rt = M("car_owner_order")->where("nid=" . $rs["coo_id"])->find();
                $number = $rt["number"];
                $now_num = $rt["now_num"];
                $surplus_seat = $number - $now_num;
                M("car_owner_order")->where("nid=" . $rs["coo_id"])->setField("surplus_seat", $surplus_seat);
                $rxx = M("car_owner_order_station")->where("id=" . $rs["coos_id"])->find();
                $ordernum = $rt["ordernum"];
                $starting_place = $rxx["starting_place"];
                $end_place = $rxx["end_place"];
                $co_id = $rt["co_id"];
                if ($now_num == $number) {
                    $brr = array("nstatus" => 1, "isreceipt" => 2);
                    M("car_owner_order")->where("nid=" . $nid)->setField($brr);
                    M("car_owner_order_station")->where("coo_id=" . $nid)->setField($brr);
                } else {
                    $brr = array("isreceipt" => 2);
                    M("car_owner_order")->where("nid=" . $nid)->setField($brr);
                    M("car_owner_order_station")->where("coo_id=" . $nid)->setField($brr);
                }
                $crr = array("ispay" => 2, "transaction_id" => $arr["transaction_id"], "transaction_time" => date("Y-m-d H:i:s"));
                M("car_owner_order_details")->where("ordernum='" . $arr["out_trade_no"] . "' and ispay=1")->setField($crr);
                $rt = M("member")->where("nid=" . $co_id)->find();
                $paramString = "{\"starting_place\":\"" . $starting_place . "\",\"end_place\":\"" . $end_place . "\"}";
                send_aliyun_msg($rt["mobile"], C("ali_sms.sms3"), $paramString);
                echo "<xml><return_code><![CDATA[SUCCESS]]></return_code>";
                echo "<return_msg><![CDATA[OK]]></return_msg></xml>";
                exit;
            } else {
                echo "<xml><return_code><![CDATA[FAIL]]></return_code>";
                echo "<return_msg><![CDATA[支付失败]]></return_msg></xml>";
                exit;
            }
        } else {
            echo "<xml><return_code><![CDATA[FAIL]]></return_code>";
            echo "<return_msg><![CDATA[订单不存在]]></return_msg></xml>";
            exit;
        }
    }
    public function ismemberdeposit()
    {
        $this->mb();
        $logintag = I("logintag");
        $rt = M("member")->where("session3r='" . $logintag . "'")->find();
        if ($rt["deposit"] < C("member.deposit")) {
            $data = array("retCode" => "0001", "retDesc" => "押金不足");
        } else {
            $data = array("retCode" => "0000", "retDesc" => "押金足够");
        }
        exit(json_encode($data));
    }
    public function car_owner_add_task()
    {
        $this->mb();
        $logintag = I("logintag");
        $rt = M("member")->where("session3r='" . $logintag . "'")->find();
        $m_id = $rt["nid"];
        if (empty($rt["mobile"])) {
            $data = array("retCode" => "0001", "retDesc" => "请完善手机号");
            exit(json_encode($data));
        }
        $count = M("car_owner_order")->where("co_id=" . $m_id . " and uniacid=" . $this->uniacid . " and ((isreceipt=1 and isdel=0) or isreceipt=2 or isreceipt=3)  and addtime>='" . date("Y-m-d 00:00:00", time()) . "' and addtime<='" . date("Y-m-d 23:59:59", time()) . "'")->count();
        if (C("member.taskcount")) {
            if ($count >= C("member.taskcount")) {
                $data = array("retCode" => "0001", "retDesc" => "今日发布已超限制");
                exit(json_encode($data));
            }
        }
        $begin_time = strtotime($_GET["begin_time"]);
        $end_time = strtotime($_GET["end_time"]);
        $starting_place = I("starting_place");
        $end_place = I("end_place");
        $money = $_GET["money"];
        $number = I("number", 0, "intval");
        $area_name = I("area_name");
        $b_lnglat = I("b_lnglat");
        $e_lnglat = I("e_lnglat");
        if ($starting_place == '') {
            $data = array("retCode" => "0001", "retDesc" => "请填写出发地");
            exit(json_encode($data));
        }
        if ($end_place == '') {
            $data = array("retCode" => "0001", "retDesc" => "请填写目的地");
            exit(json_encode($data));
        }
        if ($begin_time == '') {
            $data = array("retCode" => "0001", "retDesc" => "请输入最早出发时间");
            exit(json_encode($data));
        }
        if ($end_time == '') {
            $data = array("retCode" => "0001", "retDesc" => "请输入最迟发出时间");
            exit(json_encode($data));
        }
        if ($begin_time >= $end_time) {
            $data = array("retCode" => "0001", "retDesc" => "时间填写不正确");
            exit(json_encode($data));
        }
        if ($money == 0) {
            $data = array("retCode" => "0001", "retDesc" => "单价不正确");
            exit(json_encode($data));
        }
        if ($money < C("member.jine")) {
            $data = array("retCode" => "0001", "retDesc" => "单价不能小于" . C("member.jine") . "元");
            exit(json_encode($data));
        }
        if ($number <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "请选择座位数");
            exit(json_encode($data));
        }
        if ($area_name == '') {
            $data = array("retCode" => "0001", "retDesc" => "手机定位失败");
            exit(json_encode($data));
        }
        $ST = "HT" . date("YmdHis") . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9);
        $_GET["co_id"] = $m_id;
        $_GET["ordernum"] = $ST;
        $_GET["addtime"] = date("Y-m-d H:i:s");
        $_GET["nstatus"] = 2;
        $_GET["surplus_seat"] = $_GET["number"];
        $mid_info = I("mid_info");
        unset($_GET["logintag"], $_GET["loginopen"], $_GET["form_id"], $_GET["mid_info"]);
        $x = explode(",", $b_lnglat);
        $_GET["lng"] = $x[0];
        $_GET["lat"] = $x[1];
        $_GET["uniacid"] = $this->uniacid;
        if ($nid = M("car_owner_order")->data($_GET)->add()) {
            $addtime = $_GET["addtime"];
            $starting_place = I("starting_place");
            $end_place = I("end_place");
            $b_lnglat = I("b_lnglat");
            $e_lnglat = I("e_lnglat");
            $lng = $x[0];
            $lat = $x[1];
            $begin_addr = I("begin_addr");
            $end_addr = I("end_addr");
            $money = I("money");
            $nstatus = 2;
            $number = I("number");
            $coo_id = $nid;
            $arr = array("addtime" => $addtime, "starting_place" => $starting_place, "end_place" => $end_place, "b_lnglat" => $b_lnglat, "e_lnglat" => $e_lnglat, "lng" => $lng, "lat" => $lat, "begin_addr" => $begin_addr, "end_addr" => $end_addr, "money" => $money, "nstatus" => $nstatus, "number" => $number, "coo_id" => $coo_id, "area_name" => $area_name, "begin_time" => $begin_time, "uniacid" => $this->uniacid, "end_time" => $end_time);
            M("car_owner_order_station")->data($arr)->add();
            $arr = array();
            if (!empty($mid_info)) {
                $a_arr = explode("||", $mid_info);
                foreach ($a_arr as $k => $v) {
                    $b_arr = explode(",", $v);
                    $arr["coo_id"] = $nid;
                    $arr["starting_place"] = $starting_place;
                    $arr["end_place"] = $b_arr[0];
                    $arr["b_lnglat"] = $b_lnglat;
                    $arr["e_lnglat"] = $b_arr[1] . "," . $b_arr[2];
                    $arr["begin_addr"] = $begin_addr;
                    $arr["end_addr"] = $b_arr[3];
                    $arr["money"] = $b_arr[4];
                    $arr["lng"] = $lng;
                    $arr["lat"] = $lat;
                    $arr["area_name"] = $area_name;
                    $arr["addtime"] = $addtime;
                    $arr["number"] = $number;
                    $arr["begin_time"] = $begin_time;
                    $arr["end_time"] = $end_time;
                    $arr["uniacid"] = $this->uniacid;
                    M("car_owner_order_station")->data($arr)->add();
                }
            }
            $where = "uniacid=" . $this->uniacid . " and ispay=2 and isreceipt=1 and nstatus=2 and isdel1=0 and area_name='" . I("area_name") . "'";
            $where .= " and starting_place like '%" . I("starting_place") . "%' and end_place like '%" . I("end_place") . "%'";
            $where .= " and  ((begin_time >= '" . I("begin_time") . "' and begin_time<='" . I("end_time") . "') or (end_time >= '" . I("begin_time") . "' and end_time<='" . I("end_time") . "') )";
            $where .= " and number>=" . I("number");
            $rt = M("passenger_order")->where($where)->order("nid desc")->select();
            if ($rt) {
                $i = 0;
                while ($i < count($rt)) {
                    $rm = M("member")->where("nid=" . $rt[$i]["m_id"])->find();
                    $paramString = "{\"starting_place\":\"" . I("starting_place") . "\",\"end_place\":\"" . I("end_place") . "\"}";
                    send_aliyun_msg($rm["mobile"], C("ali_sms.sms23"), $paramString);
                    $i++;
                }
            }
            $data = array("retCode" => "0000", "retDesc" => "操作成功", "nid" => $nid);
        } else {
            $data = array("retCode" => "0001", "retDesc" => "发布失败");
        }
        exit(json_encode($data));
    }
    public function car_owner_search_passenger_task()
    {
        $this->mb();
        $logintag = I("logintag");
        if (trim($_GET["area_name"]) == '' || trim($_GET["starting_place"]) == '' || trim($_GET["end_place"]) == '' || trim($_GET["begin_time"]) == '' || trim($_GET["end_time"]) == '') {
            $data = array("retCode" => "0001", "retDesc" => "参数不能为空");
            exit(json_encode($data));
        }
        $logintag = I("logintag");
        $rs = M("member")->where("session3r='" . $logintag . "'")->find();
        if ($rs["mobile"] == '' || $rs["mobile"] == null) {
            $data = array("retCode" => "0001", "retDesc" => "请完善手机号");
            exit(json_encode($data));
        }
        $starting_place = I("starting_place");
        $end_place = I("end_place");
        $begin_time = I("begin_time");
        $end_time = I("end_time");
        $area_name = I("area_name");
        $xval = floatval($_GET["xval"]);
        $yval = floatval($_GET["yval"]);
        if (strtotime($begin_time) >= strtotime($end_time)) {
            $data = array("retCode" => "0001", "retDesc" => "时间参数不正确");
            exit(json_encode($data));
        }
        $where = " uniacid=" . $this->uniacid . " and ispay=2 and isreceipt=1 and nstatus=2 and isdel1=0 and area_name='" . $area_name . "' and end_time>'" . date("Y-m-d H:i:s") . "'";
        if ($starting_place != '' || $end_place != '') {
            $where .= " and starting_place like '%" . $starting_place . "%' and end_place like '%" . $end_place . "%'";
        } else {
            if ($starting_place != '') {
                $where .= " and starting_place like '%" . $starting_place . "%'";
            } else {
                if ($end_place != '') {
                    $where .= " and end_place like '%" . $end_place . "%'";
                }
            }
        }
        if ($begin_time != '' && $end_time != '') {
            $where .= " and ((begin_time >= '" . $begin_time . "' and begin_time<='" . $end_time . "') or (end_time >= '" . $begin_time . "' and end_time<='" . $end_time . "') )";
        } else {
            $data = array("retCode" => "0001", "retDesc" => "时间参数不正确");
            exit(json_encode($data));
        }
        $where .= " and number>0";
        $count = M("passenger_order")->where($where)->count();
        $Page = new Page($count, 10);
        $limit = $Page->firstRow . "," . $Page->listRows;
        $tmp = "ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN((" . $yval . " * PI() / 180 - lng * PI() / 180) / 2),2)+ COS(" . $yval . " * PI() / 180) * COS(lng * PI() / 180) * POW( SIN((" . $xval . " * PI() / 180 - lat * PI() / 180) / 2),2))) * 1000) AS juli";
        $field = "nid,m_id,starting_place,end_place,begin_time,end_time,ispay,addtime,isreceipt,number,note,money,co_id,area_name,ordernum,isstart,b_lnglat,e_lnglat,lng,lat,begin_addr,end_addr," . $tmp;
        $rs = M("passenger_order")->field($field)->where($where)->order("juli asc,nid desc")->limit($limit)->select();
        if ($rs) {
            $i = 0;
            while ($i < count($rs)) {
                if (intval($rs[$i]["juli"]) > 1000) {
                    $rs[$i]["juli"] = round($rs[$i]["juli"] / 1000, 2) . "Km";
                } else {
                    $rs[$i]["juli"] .= "m";
                }
                $rt = M("member")->where("nid=" . $rs[$i]["m_id"])->find();
                $rs[$i]["mobile"] = $rt["mobile"];
                $rs[$i]["x_mobile"] = $rt["mobile"];
                $rs[$i]["wx_headimg"] = $rt["wx_headimg"];
                $rs[$i]["wx_nickname"] = $rt["wx_nickname"];
                $rs[$i]["wx_gender"] = $rt["wx_gender"];
                $i++;
            }
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
        } else {
            $data = array("retCode" => "0001", "retDesc" => "没有数据");
        }
        exit(json_encode($data));
    }
    public function car_owner_enter_home_task()
    {
        $this->mb();
        if (!isset($_GET["area_name"]) || trim($_GET["area_name"]) == '') {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $area_name = I("area_name");
        $xval = floatval($_GET["xval"]);
        $yval = floatval($_GET["yval"]);
        $where = "uniacid=" . $this->uniacid . " and end_time>='" . date("Y-m-d H:i:s") . "' and nstatus=2 and ispay=2 and isreceipt=1 and area_name='" . $area_name . "'";
        $count = M("passenger_order")->where($where)->count();
        $Page = new Page($count, 10);
        $limit = $Page->firstRow . "," . $Page->listRows;
        $tmp = "ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN((" . $yval . " * PI() / 180 - lng * PI() / 180) / 2),2)+ COS(" . $yval . " * PI() / 180) * COS(lng * PI() / 180) * POW( SIN((" . $xval . " * PI() / 180 - lat * PI() / 180) / 2),2))) * 1000) AS juli";
        $field = "nid,m_id,starting_place,end_place,begin_time,end_time,ispay,addtime,isreceipt,number,note,money,co_id,area_name,ordernum,isstart,b_lnglat,e_lnglat,lng,lat,begin_addr,end_addr," . $tmp;
        $rs = M("passenger_order")->field($field)->where($where)->order("juli asc,nid desc")->limit($limit)->select();
        if ($rs) {
            $i = 0;
            while ($i < count($rs)) {
                if (intval($rs[$i]["juli"]) > 1000) {
                    $rs[$i]["juli"] = round($rs[$i]["juli"] / 1000, 2) . "Km";
                } else {
                    $rs[$i]["juli"] .= "m";
                }
                $rt = M("member")->where("nid=" . $rs[$i]["m_id"])->find();
                $rs[$i]["wx_gender"] = $rt["wx_gender"];
                $rs[$i]["mobile"] = $rt["mobile"];
                $rs[$i]["x_mobile"] = substr($rt["mobile"], 0, 3) . "****" . substr($rt["mobile"], 7, 4);
                $rs[$i]["wx_headimg"] = $rt["wx_headimg"];
                $rs[$i]["wx_nickname"] = $rt["wx_nickname"];
                $i++;
            }
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs, "ntype" => 1);
        } else {
            $data = array("retCode" => "0001", "retDesc" => "没有数据", "ntype" => 2);
        }
        exit(json_encode($data));
    }
    public function passenger_task_info()
    {
        $this->mb();
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $flag = isset($_GET["flag"]) ? intval($_GET["flag"]) : 0;
        $nid = intval($_GET["nid"]);
        $xval = floatval($_GET["xval"]);
        $yval = floatval($_GET["yval"]);
        if ($flag > 0) {
            if ($flag == 1) {
                $tmp = "ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN((" . $yval . " * PI() / 180 - lng * PI() / 180) / 2),2)+ COS(" . $yval . " * PI() / 180) * COS(lng * PI() / 180) * POW( SIN((" . $xval . " * PI() / 180 - lat * PI() / 180) / 2),2))) * 1000) AS juli";
                $field = "nid,m_id,starting_place,end_place,begin_time,end_time,ispay,addtime,isreceipt,number,note,money,co_id,area_name,ordernum,isstart,b_lnglat,e_lnglat,lng,lat,begin_addr,end_addr," . $tmp;
                if ($rs = M("passenger_order")->field($field)->where("nid=" . $nid)->find()) {
                    if ($rs["isreceipt"] > 1) {
                        $data = array("retCode" => "0001", "retDesc" => "已被抢了");
                    } else {
                        if (intval($rs["juli"]) > 1000) {
                            $rs["juli"] = round($rs["juli"] / 1000, 2) . "Km";
                        } else {
                            $rs["juli"] .= "m";
                        }
                        $rt = M("member")->where("nid=" . $rs["m_id"])->find();
                        $rs["wx_nickname"] = $rt["wx_nickname"];
                        $rs["wx_headimg"] = $rt["wx_headimg"];
                        $rs["mobile"] = $rt["mobile"];
                        $rs["x_mobile"] = substr($rt["mobile"], 0, 3) . "****" . substr($rt["mobile"], 7, 4);
                        $rs["truename"] = $rt["truename"];
                        $rs["wx_gender"] = $rt["wx_gender"];
                        $rs["car_number"] = $rt["car_number"];
                        $rs["car_model"] = $rt["car_model"];
                        $rs["car_color"] = $rt["car_color"];
                        $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
                    }
                } else {
                    $data = array("retCode" => "0001", "retDesc" => "记录不存在");
                }
            } else {
                $tmp = "ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN((" . $yval . " * PI() / 180 - lng * PI() / 180) / 2),2)+ COS(" . $yval . " * PI() / 180) * COS(lng * PI() / 180) * POW( SIN((" . $xval . " * PI() / 180 - lat * PI() / 180) / 2),2))) * 1000) AS juli";
                $field = "nid,co_id,starting_place,end_place,begin_time,end_time,nstatus,addtime,number,note,money,area_name,isreceipt,now_num,ordernum,ismatching,surplus_seat,b_lnglat,e_lnglat,lng,lat,begin_addr,end_addr," . $tmp;
                $rs = M("car_owner_order")->field($field)->where("nid=" . $nid)->find();
                if ($rs) {
                    if (intval($rs["juli"]) > 1000) {
                        $rs["juli"] = round($rs["juli"] / 1000, 2) . "Km";
                    } else {
                        $rs["juli"] .= "m";
                    }
                    $rt = M("member")->where("nid=" . $rs["co_id"])->find();
                    $rs["mobile"] = $rt["mobile"];
                    $rs["x_mobile"] = substr($rt["mobile"], 0, 3) . "****" . substr($rt["mobile"], 7, 4);
                    $rs["wx_headimg"] = $rt["wx_headimg"];
                    $rs["nowseat"] = $rs["number"] - $rs["now_num"];
                    $rs["truename"] = $rt["truename"];
                    $rs["wx_gender"] = $rt["wx_gender"];
                    $rs["car_number"] = $rt["car_number"];
                    $rs["car_model"] = $rt["car_model"];
                    $rs["car_color"] = $rt["car_color"];
                    $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
                } else {
                    $data = array("retCode" => "0001", "retDesc" => "没有记录");
                }
            }
        } else {
            $tmp = "ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN((" . $yval . " * PI() / 180 - lng * PI() / 180) / 2),2)+ COS(" . $yval . " * PI() / 180) * COS(lng * PI() / 180) * POW( SIN((" . $xval . " * PI() / 180 - lat * PI() / 180) / 2),2))) * 1000) AS juli";
            $field = "nid,m_id,starting_place,end_place,begin_time,end_time,ispay,addtime,isreceipt,number,note,money,co_id,area_name,ordernum,isstart,b_lnglat,e_lnglat,lng,lat,begin_addr,end_addr," . $tmp;
            if ($rs = M("passenger_order")->field($field)->where("nid=" . $nid)->find()) {
                if ($rs["isreceipt"] > 1) {
                    $data = array("retCode" => "0001", "retDesc" => "已被抢了");
                } else {
                    if (intval($rs["juli"]) > 1000) {
                        $rs["juli"] = round($rs["juli"] / 1000, 2) . "Km";
                    } else {
                        $rs["juli"] .= "m";
                    }
                    $rt = M("member")->where("nid=" . $rs["m_id"])->find();
                    $rs["wx_nickname"] = $rt["wx_nickname"];
                    $rs["wx_headimg"] = $rt["wx_headimg"];
                    $rs["mobile"] = $rt["mobile"];
                    $rs["x_mobile"] = substr($rt["mobile"], 0, 3) . "****" . substr($rt["mobile"], 7, 4);
                    $rs["truename"] = $rt["truename"];
                    $rs["wx_gender"] = $rt["wx_gender"];
                    $rs["car_number"] = $rt["car_number"];
                    $rs["car_model"] = $rt["car_model"];
                    $rs["car_color"] = $rt["car_color"];
                    $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
                }
            } else {
                $data = array("retCode" => "0001", "retDesc" => "记录不存在");
            }
        }
        exit(json_encode($data));
    }
    public function car_owner_robbing_passenger_task()
    {
        $this->mb();
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $logintag = I("logintag");
        $rt = M("member")->where("session3r='" . $logintag . "'")->find();
        $m_id = $rt["nid"];
        if (empty($rt["mobile"])) {
            $data = array("retCode" => "0001", "retDesc" => "请完善手机号");
            exit(json_encode($data));
        }
        if ($rt["deposit"] < C("member.deposit")) {
            $data = array("retCode" => "0001", "retDesc" => "押金不足");
            exit(json_encode($data));
        }
        if ($rt["is_audit"] != 2) {
            $data = array("retCode" => "0001", "retDesc" => "车主身份未审核");
            exit(json_encode($data));
        }
        $nid = intval($_GET["nid"]);
        if ($rs = M("passenger_order")->where("nid=" . $nid)->find()) {
            if ($rs["isreceipt"] > 1) {
                $data = array("retCode" => "0001", "retDesc" => "已被抢了");
            } else {
                $crr = array("co_id" => $rt["nid"], "isreceipt" => 2, "nstatus" => 1);
                M("passenger_order")->where("nid=" . $nid)->setField($crr);
                $rt = M("member")->where("nid=" . $rs["m_id"])->find();
                $paramString = "{\"starting_place\":\"" . $rs["starting_place"] . "\",\"end_place\":\"" . $rs["end_place"] . "\"}";
                send_aliyun_msg($rt["mobile"], C("ali_sms.sms4"), $paramString);
                $data = array("retCode" => "0000", "retDesc" => "抢单成功");
            }
        } else {
            $data = array("retCode" => "0001", "retDesc" => "记录不存在");
        }
        exit(json_encode($data));
    }
    public function get_car_owner_notes()
    {
        $this->mb();
        $logintag = I("logintag");
        $rs = M("member")->where("session3r='" . $logintag . "'")->find();
        $nclass = $rs["nclass"];
        if (!$nclass) {
            $nclass = 1;
        }
        $rs = M("car_owner_notes")->where("nclass=" . $nclass . " and uniacid=" . $this->uniacid)->find();
        $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
        exit(json_encode($data));
    }
    public function enter_my_center()
    {
        $this->mb();
        $logintag = I("logintag");
        $rs = M("member")->field("nid,mobile,wx_nickname,wx_headimg,is_audit")->where("session3r='" . $logintag . "'")->find();
        if (empty($rs["mobile"])) {
            $rs["mobile"] = "无";
        } else {
            $rs["x_mobile"] = substr($rs["mobile"], 0, 3) . "****" . substr($rs["mobile"], 7, 4);
        }
        $rs["car_owner_share"] = C("car_owner_share");
        $notice_count = M("notice")->where("m_id=" . $rs["nid"] . " and nstatus=1")->count();
        $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs, "flag" => $notice_count);
        exit(json_encode($data));
    }
    public function enter_my_wallet()
    {
        $this->mb();
        $logintag = I("logintag");
        $rs = M("member")->where("session3r='" . $logintag . "'")->field("nid,deposit,account_amount,redpacked,mobile,wx_headimg,wx_nickname")->find();
        if (empty($rs["mobile"])) {
            $rs["mobile"] = "无";
            $rs["x_mobile"] = '';
        } else {
            $rs["x_mobile"] = substr($rs["mobile"], 0, 3) . "****" . substr($rs["mobile"], 7, 4);
        }
        $rs["deposit"] = round($rs["deposit"], 2);
        $rs["account_amount"] = round($rs["account_amount"], 2);
        $rs["redpacked"] = round($rs["redpacked"], 2);
        $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
        exit(json_encode($data));
    }
    public function carowner_recharge_view()
    {
        $this->mb();
        $logintag = I("logintag");
        $rs = M("member")->where("session3r='" . $logintag . "'")->find();
        if ($rs) {
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "mobile" => substr($rs["mobile"], 0, 3) . "****" . substr($rs["mobile"], 7, 4));
        } else {
            $data = array("retCode" => "0001", "retDesc" => "账号不存在");
        }
        exit(json_encode($data));
    }
    public function carowner_recharge_log()
    {
        $this->mb();
        $logintag = I("logintag");
        if (!isset($_GET["deposit"]) || $_GET["deposit"] <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $deposit = $_GET["deposit"];
        $rs = M("member")->where("session3r='" . $logintag . "'")->find();
        $openid = $rs["openid"];
        $co_id = $rs["nid"];
        $mobile = $rs["mobile"];
        $ST = "HT" . date("YmdHis") . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9);
        $brr = array("co_id" => $co_id, "deposit" => $deposit, "addtime" => date("Y-m-d H:i:s"), "ispay" => 1, "ntype" => I("ntype"), "ordernum" => $ST, "uniacid" => $this->uniacid, "mobile" => $mobile);
        $crr = array("openid" => $openid, "body" => "拼车系统车主", "attach" => $mobile, "out_trade_no" => $ST, "total_fee" => $deposit * 100);
        if ($brr["ntype"] == 1) {
            $crr["tag"] = "押金充值";
        } else {
            $crr["tag"] = "账户充值";
        }
        if (M("car_owner_deposit_log")->data($brr)->add()) {
            $tmp = carowner_recharge_pay($crr);
            exit($tmp);
        } else {
            $data = array("retCode" => "0001", "retDesc" => "添加数据失败");
            exit(json_encode($data));
        }
    }
    public function ht_carowner_recharge_pay()
    {
        $this->getConfig();
        libxml_disable_entity_loader(true);
        $str = file_get_contents("php://input");
        if (trim($str) != '') {
            $arr = xmlToArray($str);
            if ($arr["result_code"] != "SUCCESS" || $arr["return_code"] != "SUCCESS") {
                echo "<xml><return_code><![CDATA[FAIL]]></return_code>";
                echo "<return_msg><![CDATA[支付失败]]></return_msg></xml>";
                exit;
            } else {
                $rs = M("car_owner_deposit_log")->where("ordernum='" . $arr["out_trade_no"] . "' and ispay=1")->find();
                if ($rs) {
                    $crr = array("transaction_id" => $arr["transaction_id"], "ispay" => 2, "overtime" => date("Y-m-d H:i:s"));
                    M("car_owner_deposit_log")->where("ordernum='" . $arr["out_trade_no"] . "' and ispay=1")->data($crr)->save();
                    if ($rs["ntype"] == 1) {
                        M("member")->where("nid=" . $rs["co_id"])->setInc("deposit", $rs["deposit"]);
                    } else {
                        M("member")->where("nid=" . $rs["co_id"])->setInc("account_amount", $rs["deposit"]);
                    }
                    $brr = array("money" => $rs["deposit"], "m_id" => $rs["co_id"], "pid" => $rs["nid"], "uniacid" => $this->uniacid, "addtime" => date("Y-m-d H:i:s"));
                    if ($rs["ntype"] == 1) {
                        $brr["nclass"] = 4;
                    } else {
                        $brr["nclass"] = 9;
                    }
                    M("revenue_detail")->data($brr)->add();
                    echo "<xml><return_code><![CDATA[SUCCESS]]></return_code>";
                    echo "<return_msg><![CDATA[OK]]></return_msg></xml>";
                    exit;
                } else {
                    echo "<xml><return_code><![CDATA[FAIL]]></return_code>";
                    echo "<return_msg><![CDATA[订单不存在]]></return_msg></xml>";
                    exit;
                }
            }
        } else {
            echo "<xml><return_code><![CDATA[FAIL]]></return_code>";
            echo "<return_msg><![CDATA[订单不存在]]></return_msg></xml>";
            exit;
        }
    }
    public function carowner_withdraw_deposit()
    {
        $this->mb();
        $logintag = I("logintag");
        $rs = M("member")->field("nid,mobile,deposit,account_amount,redpacked")->where("session3r='" . $logintag . "'")->find();
        if ($rs) {
            $rs["x_mobile"] = substr($rs["mobile"], 0, 3) . "****" . substr($rs["mobile"], 7, 4);
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
        } else {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
        }
        exit(json_encode($data));
    }
    public function carowner_withdraw_deposit_log()
    {
        $this->mb();
        $logintag = I("logintag");
        if (!isset($_GET["deposit"]) || $_GET["deposit"] <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $deposit = $_GET["deposit"];
        $rs = M("member")->where("session3r='" . $logintag . "'")->find();
        $co_deposit = $rs["deposit"];
        $nid = $rs["nid"];
        if (M("car_owner_order")->where("co_id=" . $nid . " and isreceipt=2")->select()) {
            $data = array("retCode" => "0001", "retDesc" => "不可提现");
            exit(json_encode($data));
        }
        if (M("passenger_order")->where("co_id=" . $nid . " and isreceipt=2")->select()) {
            $data = array("retCode" => "0001", "retDesc" => "不可提现");
            exit(json_encode($data));
        }
        $openid = $rs["openid"];
        if ($co_deposit < $deposit) {
            $data = array("retCode" => "0001", "retDesc" => "资金不足");
            exit(json_encode($data));
        }
        $amount_cash = $deposit;
        $nstatus = 1;
        $addtime = date("Y-m-d H:i:s");
        $nclass = 1;
        $famount_cash = $co_deposit;
        $eamount_cash = $co_deposit - $deposit;
        $co_id = $rs["nid"];
        $mobile = $rs["mobile"];
        $ST = "HT" . date("YmdHis") . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9);
        $brr = array("m_id" => $co_id, "amount_cash" => $amount_cash, "addtime" => date("Y-m-d H:i:s"), "nstatus" => $nstatus, "addtime" => $addtime, "famount_cash" => $famount_cash, "eamount_cash" => $eamount_cash, "nclass" => $nclass, "uniacid" => $this->uniacid, "ordernum" => $ST);
        if (M("member")->where("nid=" . $rs["nid"])->setDec("deposit", $deposit)) {
            $rec_id = M("withdrawals")->data($brr)->add();
            $data = array("retCode" => "0000", "retDesc" => "申请成功");
        } else {
            $data = array("retCode" => "0001", "retDesc" => "扣除押金失败");
        }
        exit(json_encode($data));
    }
    public function carowner_withdraw_account()
    {
        $this->mb();
        $logintag = I("logintag");
        $rs = M("member")->field("nid,mobile,account_amount")->where("session3r='" . $logintag . "'")->find();
        if ($rs) {
            $rs["x_mobile"] = substr($rs["mobile"], 0, 3) . "****" . substr($rs["mobile"], 7, 4);
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
        } else {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
        }
        exit(json_encode($data));
    }
    public function carowner_withdraw_account_log()
    {
        $this->mb();
        $logintag = I("logintag");
        if (!isset($_GET["deposit"]) || $_GET["deposit"] < 1) {
            $data = array("retCode" => "0001", "retDesc" => "金额至少1元");
            exit(json_encode($data));
        }
        $deposit = $_GET["deposit"];
        $rs = M("member")->where("session3r='" . $logintag . "'")->find();
        $co_deposit = $rs["account_amount"];
        $openid = $rs["openid"];
        if ($co_deposit < $deposit) {
            $data = array("retCode" => "0001", "retDesc" => "资金不足");
            exit(json_encode($data));
        }
        $amount_cash = $deposit;
        $nstatus = 1;
        $addtime = date("Y-m-d H:i:s");
        $nclass = 2;
        $famount_cash = $co_deposit;
        $eamount_cash = round($co_deposit - $deposit, 2);
        $co_id = $rs["nid"];
        $mobile = $rs["mobile"];
        $ST = "HT" . date("YmdHis") . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9);
        $brr = array("m_id" => $co_id, "amount_cash" => $amount_cash, "addtime" => date("Y-m-d H:i:s"), "nstatus" => $nstatus, "addtime" => $addtime, "famount_cash" => $famount_cash, "eamount_cash" => $eamount_cash, "nclass" => $nclass, "uniacid" => $this->uniacid, "ordernum" => $ST);
        if (M("member")->where("nid=" . $rs["nid"])->setDec("account_amount", $deposit)) {
            $rec_id = M("withdrawals")->data($brr)->add();
            $data = array("retCode" => "0000", "retDesc" => "账户提现申请成功");
        } else {
            $data = array("retCode" => "0001", "retDesc" => "扣除账户提现金额失败");
        }
        exit(json_encode($data));
    }
    public function revenue_detail_list()
    {
        $this->mb();
        $logintag = I("logintag");
        $rs = M("member")->where("session3r='" . $logintag . "' and nstatus=1")->find();
        $nclass = isset($_GET["nclass"]) ? intval($_GET["nclass"]) : 0;
        $where = "uniacid=" . $this->uniacid . " and isdel=0 and m_id=" . $rs["nid"];
        if ($nclass > 0) {
            $where .= " and nclass=" . $nclass;
        }
        $count = M("revenue_detail")->where($where)->count();
        $Page = new Page($count, 10);
        $limit = $Page->firstRow . "," . $Page->listRows;
        $rs = M("revenue_detail")->field("nid,money,nclass,addtime,pid,ntype")->where($where)->order("nid desc")->limit($limit)->select();
        if ($rs) {
            $i = 0;
            while ($i < count($rs)) {
                switch ($rs[$i]["nclass"]) {
                    case 1:
                        if ($rs[$i]["ntype"] == 1) {
                            if ($rt = M("passenger_order")->where("nid=" . $rs[$i]["pid"])->find()) {
                                $rs[$i]["ordernum"] = $rt["ordernum"];
                            } else {
                                $rs[$i]["ordernum"] = "无";
                            }
                        } else {
                            if ($rt = M("car_owner_order_details")->where("nid=" . $rs[$i]["pid"])->find()) {
                                $rs[$i]["ordernum"] = $rt["ordernum"];
                            } else {
                                $rs[$i]["ordernum"] = "无";
                            }
                        }
                        $rs[$i]["nclass1"] = "车位费";
                        break;
                    case 2:
                        $rt = M("withdrawals")->where("nid=" . $rs[$i]["pid"])->find();
                        $rs[$i]["ordernum"] = $rt["ordernum"];
                        $rs[$i]["nclass1"] = "扣除押金";
                        break;
                    case 3:
                        if ($rt = M("withdrawals")->where("nid=" . $rs[$i]["pid"])->find()) {
                            $rs[$i]["ordernum"] = $rt["ordernum"];
                        } else {
                            $rs[$i]["ordernum"] = "无";
                        }
                        $rs[$i]["nclass1"] = "扣除车资";
                        break;
                    case 4:
                        if ($rt = M("car_owner_deposit_log")->where("nid=" . $rs[$i]["pid"])->find()) {
                            $rs[$i]["ordernum"] = $rt["ordernum"];
                        } else {
                            $rs[$i]["ordernum"] = "无";
                        }
                        $rs[$i]["nclass1"] = "押金充值";
                        break;
                    case 5:
                        if ($rt = M("withdrawals")->where("nid=" . $rs[$i]["pid"])->find()) {
                            $rs[$i]["ordernum"] = $rt["ordernum"];
                        } else {
                            $rs[$i]["ordernum"] = "无";
                        }
                        $rs[$i]["nclass1"] = "押金提现";
                        break;
                    case 6:
                        $rt = M("withdrawals")->where("nid=" . $rs[$i]["pid"])->find();
                        $rs[$i]["ordernum"] = $rt["ordernum"];
                        $rs[$i]["nclass1"] = "账户提现";
                        break;
                    case 7:
                        $rt = M("withdrawals")->where("nid=" . $rs[$i]["pid"])->find();
                        $rs[$i]["ordernum"] = $rt["ordernum"];
                        $rs[$i]["nclass1"] = "收入";
                        break;
                    case 8:
                        $rt = M("withdrawals")->where("nid=" . $rs[$i]["pid"])->find();
                        $rs[$i]["ordernum"] = $rt["ordernum"];
                        $rs[$i]["nclass1"] = "退还余额";
                        break;
                    case 9:
                        $rt = M("car_owner_deposit_log")->where("nid=" . $rs[$i]["pid"])->find();
                        $rs[$i]["ordernum"] = $rt["ordernum"];
                        $rs[$i]["nclass1"] = "账户充值";
                        break;
                }
                $i++;
            }
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs, "nclass" => C("nclass"));
        } else {
            $data = array("retCode" => "0001", "retDesc" => "没有记录");
        }
        exit(json_encode($data));
    }
    public function member_account_amount_order_detail()
    {
        $this->mb();
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0 || !isset($_GET["pid"]) || intval($_GET["pid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $nid = intval($_GET["nid"]);
        $pid = intval($_GET["pid"]);
        $rs = M("car_owner_deposit_log")->field("nid,mobile,deposit,addtime,ordernum,ntype")->where("nid=" . $nid)->find();
        if ($rs) {
            $rs["nclass"] = "账户充值";
            $rs["pid"] = $pid;
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
        } else {
            $data = array("retCode" => "0001", "retDesc" => "记录不存在");
        }
        exit(json_encode($data));
    }
    public function member_account_amount_order_detail_del()
    {
        $this->mb();
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0 || !isset($_GET["pid"]) || intval($_GET["pid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $nid = intval($_GET["nid"]);
        $pid = intval($_GET["pid"]);
        M("revenue_detail")->where("nid=" . $pid)->setField("isdel", 1);
        $data = array("retCode" => "0000", "retDesc" => "操作成功");
        exit(json_encode($data));
    }
    public function passenger_parking_lot_detail()
    {
        $this->mb();
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0 || !isset($_GET["pid"]) || intval($_GET["pid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $nid = intval($_GET["nid"]);
        $pid = intval($_GET["pid"]);
        $rs = M("car_owner_order_details")->field("nid,m_id,menoy,seat_num,ntotal,transaction_time,ispay")->where("nid=" . $nid)->find();
        if ($rs) {
            $rt = M("member")->where("nid=" . $rs["m_id"])->find();
            $rs["mobile"] = $rt["mobile"];
            $rs["nclass"] = "车位费";
            $rs["x_mobile"] = substr($rt["mobile"], 0, 3) . "****" . substr($rt["mobile"], 7, 4);
            $rs["pid"] = $pid;
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
        } else {
            $data = array("retCode" => "0001", "retDesc" => "记录不存在");
        }
        exit(json_encode($data));
    }
    public function passenger_parking_lot_detail_del()
    {
        $this->mb();
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0 || !isset($_GET["pid"]) || intval($_GET["pid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $nid = intval($_GET["nid"]);
        $pid = intval($_GET["pid"]);
        M("revenue_detail")->where("nid=" . $nid)->setField("isdel", 1);
        $data = array("retCode" => "0000", "retDesc" => "操作成功");
        exit(json_encode($data));
    }
    public function passenger_recharge_detail()
    {
        $this->mb();
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0 || !isset($_GET["pid"]) || intval($_GET["pid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $nid = intval($_GET["nid"]);
        $pid = intval($_GET["pid"]);
        $rs = M("car_owner_deposit_log")->field("nid,deposit,overtime")->where("nid=" . $pid)->find();
        if ($rs) {
            $rs["nclass"] = "充值押金";
            $rs["pid"] = $nid;
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
        } else {
            $data = array("retCode" => "0001", "retDesc" => "记录不存在");
        }
        exit(json_encode($data));
    }
    public function passenger_recharge_detail_del()
    {
        $this->mb();
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0 || !isset($_GET["pid"]) || intval($_GET["pid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $nid = intval($_GET["nid"]);
        $pid = intval($_GET["pid"]);
        M("revenue_detail")->where("nid=" . $nid)->setField("isdel", 1);
        $data = array("retCode" => "0000", "retDesc" => "操作成功");
        exit(json_encode($data));
    }
    public function passenger_withdraw_detail()
    {
        $this->mb();
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0 || !isset($_GET["pid"]) || intval($_GET["pid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $nid = intval($_GET["nid"]);
        $pid = intval($_GET["pid"]);
        $rs = M("withdrawals")->field("nid,amount_cash,transaction_time,addtime,ordernum,nclass,playmoney_time")->where("nid=" . $pid)->find();
        if ($rs) {
            switch ($rs["nclass"]) {
                case 1:
                    $rs["nclass"] = "押金提现";
                    break;
                case 2:
                    $rs["nclass"] = "账户提现";
                    break;
                case 3:
                    $rs["nclass"] = "扣除押金";
                    break;
                case 4:
                    $rs["nclass"] = "扣除车资";
                    break;
                case 5:
                    $rs["nclass"] = "退还车资余款";
                    break;
            }
            $rs["pid"] = $nid;
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
        } else {
            $data = array("retCode" => "0001", "retDesc" => "记录不存在");
        }
        exit(json_encode($data));
    }
    public function passenger_withdraw_detail_del()
    {
        $this->mb();
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0 || !isset($_GET["pid"]) || intval($_GET["pid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $nid = intval($_GET["nid"]);
        $pid = intval($_GET["pid"]);
        M("revenue_detail")->where("nid=" . $nid)->setField("isdel", 1);
        $data = array("retCode" => "0000", "retDesc" => "操作成功");
        exit(json_encode($data));
    }
    public function deduction_deposit_detail()
    {
        $this->mb();
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0 || !isset($_GET["pid"]) || intval($_GET["pid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $nid = intval($_GET["nid"]);
        $pid = intval($_GET["pid"]);
        $rs = M("withdrawals")->field("nid,amount_cash,transaction_time,ordernum,nclass,playmoney_time")->where("nid=" . $pid)->find();
        if ($rs) {
            switch ($rs["nclass"]) {
                case 1:
                    $rs["nclass"] = "押金提现";
                    break;
                case 2:
                    $rs["nclass"] = "账户提现";
                    break;
                case 3:
                    $rs["nclass"] = "扣除押金";
                    break;
                case 4:
                    $rs["nclass"] = "扣除车资";
                    break;
                case 5:
                    $rs["nclass"] = "退还车资余款";
                    break;
            }
            $rs["pid"] = $nid;
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
        } else {
            $data = array("retCode" => "0001", "retDesc" => "记录不存在");
        }
        exit(json_encode($data));
    }
    public function deduction_deposit_detail_del()
    {
        $this->mb();
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0 || !isset($_GET["pid"]) || intval($_GET["pid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $nid = intval($_GET["nid"]);
        $pid = intval($_GET["pid"]);
        M("revenue_detail")->where("nid=" . $nid)->setField("isdel", 1);
        $data = array("retCode" => "0000", "retDesc" => "操作成功");
        exit(json_encode($data));
    }
    public function income_detail()
    {
        $this->mb();
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0 || !isset($_GET["pid"]) || intval($_GET["pid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $nid = intval($_GET["nid"]);
        $pid = intval($_GET["pid"]);
        $rs = M("withdrawals")->field("nid,amount_cash,playmoney_time,ordernum,nclass")->where("nid=" . $pid)->find();
        if ($rs) {
            switch ($rs["nclass"]) {
                case 1:
                    $rs["nclass"] = "押金提现";
                    break;
                case 2:
                    $rs["nclass"] = "账户提现";
                    break;
                case 3:
                    $rs["nclass"] = "扣除押金";
                    break;
                case 4:
                    $rs["nclass"] = "扣除车资";
                    break;
                case 5:
                    $rs["nclass"] = "退还车资余款";
                    break;
            }
            $rs["pid"] = $nid;
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
        } else {
            $data = array("retCode" => "0001", "retDesc" => "记录不存在");
        }
        exit(json_encode($data));
    }
    public function income_detail_del()
    {
        $this->mb();
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0 || !isset($_GET["pid"]) || intval($_GET["pid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $nid = intval($_GET["nid"]);
        $pid = intval($_GET["pid"]);
        M("revenue_detail")->where("nid=" . $nid)->setField("isdel", 1);
        $data = array("retCode" => "0000", "retDesc" => "操作成功");
        exit(json_encode($data));
    }
    public function deduction_carfare_detail()
    {
        $this->mb();
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0 || !isset($_GET["pid"]) || intval($_GET["pid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $nid = intval($_GET["nid"]);
        $pid = intval($_GET["pid"]);
        $rs = M("withdrawals")->field("nid,amount_cash,playmoney_time,ordernum,nclass")->where("nid=" . $pid)->find();
        if ($rs) {
            switch ($rs["nclass"]) {
                case 1:
                    $rs["nclass"] = "押金提现";
                    break;
                case 2:
                    $rs["nclass"] = "账户提现";
                    break;
                case 3:
                    $rs["nclass"] = "扣除押金";
                    break;
                case 4:
                    $rs["nclass"] = "扣除车资";
                    break;
                case 5:
                    $rs["nclass"] = "退还车资余款";
                    break;
            }
            $rs["pid"] = $nid;
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
        } else {
            $data = array("retCode" => "0001", "retDesc" => "记录不存在");
        }
        exit(json_encode($data));
    }
    public function deduction_carfare_detail_del()
    {
        $this->mb();
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0 || !isset($_GET["pid"]) || intval($_GET["pid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $nid = intval($_GET["nid"]);
        $pid = intval($_GET["pid"]);
        M("revenue_detail")->where("nid=" . $nid)->setField("isdel", 1);
        $data = array("retCode" => "0000", "retDesc" => "操作成功");
        exit(json_encode($data));
    }
    public function my_order_list()
    {
        $this->mb();
        $logintag = I("logintag");
        $rs = M("member")->where("session3r='" . $logintag . "'")->find();
        $ntype = intval($_GET["ntype"]);
        $nclass = $rs["nclass"];
        if ($ntype == 1) {
            $where = " uniacid=" . $this->uniacid . " and isdel=0 and m_id=" . $rs["nid"];
            $count = M("car_owner_order_details")->where($where)->count();
            $Page = new Page($count, 10);
            $limit = $Page->firstRow . "," . $Page->listRows;
            $rs = M("car_owner_order_details")->field("nid,coo_id,menoy,seat_num,ntotal,istransfer,ispay,isstart,coos_id")->where($where)->order("nid desc")->limit($limit)->select();
            if ($rs) {
                $i = 0;
                while ($i < count($rs)) {
                    if ($rs[$i]["ispay"] == 3) {
                        $rs[$i]["nclass"] = "取消";
                        $rs[$i]["hjl_status"] = 4;
                    } else {
                        if ($rs[$i]["ispay"] == 1) {
                            $rs[$i]["nclass"] = "未支付";
                            $rs[$i]["hjl_status"] = 5;
                        } else {
                            switch ($rs[$i]["isstart"]) {
                                case 1:
                                    $rs[$i]["nclass"] = "没有出行";
                                    $rs[$i]["hjl_status"] = 1;
                                    break;
                                case 2:
                                    $rs[$i]["nclass"] = "进行中";
                                    $rs[$i]["hjl_status"] = 2;
                                    break;
                                case 3:
                                    $rs[$i]["hjl_status"] = 3;
                                    $rs[$i]["nclass"] = "已完成";
                                    break;
                            }
                        }
                    }
                    $ntotal = $rs[$i]["ntotal"];
                    $istransfer = $rs[$i]["istransfer"];
                    $rt = M("car_owner_order")->where("nid=" . $rs[$i]["coo_id"])->field("starting_place,end_place,begin_time,end_time,co_id,begin_addr,end_addr")->find();
                    $rp = M("car_owner_order_station")->where("id=" . $rs[$i]["coos_id"])->find();
                    $rs[$i]["starting_place"] = $rp["starting_place"];
                    $rs[$i]["end_place"] = $rp["end_place"];
                    $rs[$i]["begin_time"] = $rt["begin_time"];
                    $rs[$i]["end_time"] = $rt["end_time"];
                    $rs[$i]["begin_addr"] = $rp["begin_addr"];
                    $rs[$i]["end_addr"] = $rp["end_addr"];
                    $rt = M("member")->find($rt["co_id"]);
                    $rs[$i]["wx_gender"] = $rt["wx_gender"];
                    $rs[$i]["wx_nickname"] = $rt["wx_nickname"];
                    $rs[$i]["wx_headimg"] = $rt["wx_headimg"];
                    $i++;
                }
                $data = array("retCode" => "0000", "retDesc" => "这是乘客订单根据nclass=1来判断的", "nclass" => $nclass, "info" => $rs);
            } else {
                $data = array("retCode" => "0001", "retDesc" => "没有记录");
            }
        } else {
            $where = "uniacid=" . $this->uniacid . " and isdel2=0 and co_id=" . $rs["nid"];
            $count = M("passenger_order")->where($where)->count();
            $Page = new Page($count, 10);
            $limit = $Page->firstRow . "," . $Page->listRows;
            $rs = M("passenger_order")->where($where)->order("nid desc")->limit($limit)->select();
            if ($rs) {
                $i = 0;
                while ($i < count($rs)) {
                    switch ($rs[$i]["ispay"]) {
                        case 1:
                            $rs[$i]["hjl_status"] = 5;
                            $rs[$i]["nclass"] = "未支付";
                            break;
                        case 2:
                            switch ($rs[$i]["isstart"]) {
                                case 1:
                                    $rs[$i]["nclass"] = "未出发";
                                    $rs[$i]["hjl_status"] = 1;
                                    break;
                                case 2:
                                    $rs[$i]["nclass"] = "进行中";
                                    $rs[$i]["hjl_status"] = 2;
                                    break;
                                case 3:
                                    $rs[$i]["nclass"] = "已完成";
                                    $rs[$i]["hjl_status"] = 3;
                                    break;
                            }
                            break;
                        case 3:
                            $rs[$i]["hjl_status"] = 4;
                            $rs[$i]["nclass"] = "已取消";
                            break;
                    }
                    $rt = M("member")->find($rs[$i]["m_id"]);
                    $rs[$i]["wx_gender"] = $rt["wx_gender"];
                    $rs[$i]["wx_nickname"] = $rt["wx_nickname"];
                    $rs[$i]["wx_headimg"] = $rt["wx_headimg"];
                    $i++;
                }
                $data = array("retCode" => "0000", "retDesc" => "这是车主订单根据nclass=2来判断的", "nclass" => $nclass, "info" => $rs);
            } else {
                $data = array("retCode" => "0001", "retDesc" => "没有记录");
            }
        }
        exit(json_encode($data));
    }
    public function my_carowner_order_view()
    {
        $this->mb();
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "非法操作");
            exit(json_encode($data));
        }
        $nid = intval($_GET["nid"]);
        $logintag = I("logintag");
        $rt = M("member")->where("session3r='" . $logintag . "'")->find();
        $rs = M("passenger_order")->where("nid=" . $nid)->find();
        if ($rs) {
            $rt = M("member")->field("mobile,wx_nickname")->where("nid=" . $rs["m_id"])->find();
            $rs["x_mobile"] = substr($rt["mobile"], 0, 3) . "****" . substr($rt["mobile"], 7, 4);
            $rs["mobile"] = $rt["mobile"];
            $rs["wx_nickname"] = $rt["wx_nickname"];
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
        } else {
            $data = array("retCode" => "0001", "retDesc" => "没有记录");
        }
        exit(json_encode($data));
    }
    public function my_passenger_order_view()
    {
        $this->mb();
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "非法操作");
            exit(json_encode($data));
        }
        $nid = intval($_GET["nid"]);
        $logintag = I("logintag");
        $rt = M("member")->where("session3r='" . $logintag . "'")->find();
        $rs = M("car_owner_order_details")->field("nid,menoy as money,seat_num,ntotal,ispay,coo_id,isstart,istransfer,cancel_order,iscancal,apply,num,coos_id")->where("nid=" . $nid . " and m_id=" . $rt["nid"])->find();
        if ($rs) {
            $rt = M("car_owner_order")->field("number,starting_place,end_place,begin_time,end_time,note,ismatching,co_id,begin_addr,end_addr,b_lnglat,e_lnglat,surplus_seat")->where("nid=" . $rs["coo_id"])->find();
            $rd = M("member")->field("mobile,wx_nickname")->where("nid=" . $rt["co_id"])->find();
            $rs["x_mobile"] = substr($rd["mobile"], 0, 3) . "****" . substr($rd["mobile"], 7, 4);
            $rs["wx_nickname"] = $rd["wx_nickname"];
            $rs["mobile"] = $rd["mobile"];
            $rp = M("car_owner_order_station")->where("id=" . $rs["coos_id"])->find();
            $rs["starting_place"] = $rp["starting_place"];
            $rs["end_place"] = $rp["end_place"];
            $rs["begin_time"] = $rt["begin_time"];
            $rs["end_time"] = $rt["end_time"];
            $rs["note"] = $rt["note"];
            $rs["ismatching"] = $rt["ismatching"];
            $rs["co_id"] = $rt["co_id"];
            $rs["begin_addr"] = $rp["begin_addr"];
            $rs["end_addr"] = $rp["end_addr"];
            $rs["number"] = $rt["number"];
            $rs["b_lnglat"] = $rp["b_lnglat"];
            $rs["e_lnglat"] = $rp["e_lnglat"];
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
        } else {
            $data = array("retCode" => "0001", "retDesc" => "没有记录");
        }
        exit(json_encode($data));
    }
    public function my_travel_list()
    {
        $this->mb();
        $logintag = I("logintag");
        $rs = M("member")->where("session3r='" . $logintag . "'")->find();
        if (!$rs) {
            $data = array("retCode" => "0001", "retDesc" => "用户不存在");
            exit(json_encode($data));
        }
        $nclass = $rs["nclass"];
        $ntype = intval($_GET["ntype"]);
        if ($ntype == 1) {
            $where = "uniacid=" . $this->uniacid . " and m_id=" . $rs["nid"] . " and isdel1=0 and ispay!=1";
            $count = M("passenger_order")->where($where)->count();
            $Page = new Page($count, 10);
            $limit = $Page->firstRow . "," . $Page->listRows;
            $rs = M("passenger_order")->where($where)->order("nid desc")->limit($limit)->select();
            if ($rs) {
                $i = 0;
                while ($i < count($rs)) {
                    if ($rs[$i]["ispay"] == 3 || $rs[$i]["isreceipt"] == 3 && $rs[$i]["ispay"] == 2 || $rs[$i]["isreceipt"] == 1 && $rs[$i]["ispay"] == 2) {
                        $rs[$i]["istransfer"] = 2;
                    } else {
                        $rs[$i]["istransfer"] = 1;
                    }
                    if ($rs[$i]["ispay"] == 3) {
                        $rs[$i]["isreceipt"] = "已取消";
                        $rs[$i]["hjl_status"] = 4;
                    } else {
                        switch ($rs[$i]["isreceipt"]) {
                            case 1:
                                $rs[$i]["isreceipt"] = "无人接单";
                                $rs[$i]["hjl_status"] = 1;
                                break;
                            case 2:
                                $rs[$i]["isreceipt"] = "进行中";
                                $rs[$i]["hjl_status"] = 2;
                                break;
                            case 3:
                                $rs[$i]["isreceipt"] = "已完成";
                                $rs[$i]["hjl_status"] = 3;
                                break;
                        }
                    }
                    $rt = M("member")->find($rs[$i]["m_id"]);
                    $rs[$i]["wx_gender"] = $rt["wx_gender"];
                    $rs[$i]["wx_nickname"] = $rt["wx_nickname"];
                    $rs[$i]["wx_headimg"] = $rt["wx_headimg"];
                    $i++;
                }
                $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
            } else {
                $data = array("retCode" => "0001", "retDesc" => "没有记录");
            }
        } else {
            $where = "co_id=" . $rs["nid"] . " and isdel=0 ";
            $count = M("car_owner_order")->where($where)->count();
            $Page = new Page($count, 10);
            $limit = $Page->firstRow . "," . $Page->listRows;
            $rs = M("car_owner_order")->field("co_id,nid,starting_place,end_place,begin_time,end_time,money,isreceipt,number,money,now_num,surplus_seat,begin_addr,end_addr")->where($where)->order("nid desc")->limit($limit)->select();
            if ($rs) {
                $i = 0;
                while ($i < count($rs)) {
                    switch ($rs[$i]["isreceipt"]) {
                        case 1:
                            $rs[$i]["nclass"] = "无人接单";
                            $rs[$i]["hjl_status"] = 1;
                            break;
                        case 2:
                            $rs[$i]["nclass"] = "进行中";
                            $rs[$i]["hjl_status"] = 2;
                            break;
                        case 3:
                            $rs[$i]["nclass"] = "已完成";
                            $rs[$i]["hjl_status"] = 3;
                            break;
                    }
                    if ($rs[$i]["isreceipt"] == 1 || $rs[$i]["isreceipt"] == 3) {
                        $rs[$i]["istransfer"] = 3;
                    } else {
                        $rs[$i]["istransfer"] = 1;
                    }
                    $rt = M("member")->find($rs[$i]["co_id"]);
                    $rs[$i]["wx_gender"] = $rt["wx_gender"];
                    $rs[$i]["wx_nickname"] = $rt["wx_nickname"];
                    $rs[$i]["wx_headimg"] = $rt["wx_headimg"];
                    $rp = M("car_owner_order_station")->where("coo_id=" . $rs[$i]["nid"])->order("id desc")->select();
                    $cou = count($rp);
                    if ($cou > 1) {
                        unset($rp[$cou - 1]);
                        $rs[$i]["station"] = $rp;
                    } else {
                        $rs[$i]["station"] = array();
                    }
                    $i++;
                }
                $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
            } else {
                $data = array("retCode" => "0001", "retDesc" => "没有记录");
            }
        }
        exit(json_encode($data));
    }
    public function my_travel_details()
    {
        $this->mb();
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $logintag = I("logintag");
        $nid = intval($_GET["nid"]);
        $ntype = I("ntype");
        $rs = M("member")->where("session3r='" . $logintag . "'")->find();
        $nclass = $rs["nclass"];
        if ($ntype == 1) {
            $where = "m_id=" . $rs["nid"] . " and isdel1=0 and nid=" . $nid;
            $rs = M("passenger_order")->where($where)->find();
            if ($rs) {
                if (C("is_ordercanel") == 2) {
                    $sj = time() - C("ordercaneltime") * 60;
                    $sj = date("Y-m-d H:i:s", $sj);
                } else {
                    $sj = date("Y-m-d H:i:s");
                }
                if ($rs["end_time"] > $sj) {
                    $rs["setout"] = 0;
                } else {
                    $rs["setout"] = 1;
                }
                $rs["isreceipt1"] = $rs["isreceipt"];
                if ($rs["ispay"] == 3) {
                    $rs["nclass"] = "已取消";
                } else {
                    switch ($rs["isstart"]) {
                        case 1:
                            if ($rs["isreceipt"] == 1) {
                                $rs["isreceipt1"] = "未出行";
                            } else {
                                if ($rs["isreceipt"] == 2) {
                                    $rs["isreceipt1"] = "进行中";
                                }
                            }
                            break;
                        case 2:
                            $rs["isreceipt1"] = "进行中";
                            break;
                        case 3:
                            $rs["isreceipt1"] = "已完成";
                            break;
                    }
                }
                if ($rs["co_id"]) {
                    $rt = M("member")->where("nid=" . $rs["co_id"])->find();
                    $rs["x_mobile"] = substr($rt["mobile"], 0, 3) . "****" . substr($rt["mobile"], 7, 4);
                    $rs["mobile"] = $rt["mobile"];
                    $rs["wx_headimg"] = $rt["wx_headimg"];
                    $rs["wx_nickname"] = $rt["wx_nickname"];
                }
                $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
            } else {
                $data = array("retCode" => "0001", "retDesc" => "没有记录");
            }
        } else {
            $where = "co_id=" . $rs["nid"] . " and isdel=0 and nid=" . $nid;
            $rs = M("car_owner_order")->where($where)->find();
            if ($rs) {
                if (C("is_ordercanel") == 2) {
                    $sj = time() - C("ordercaneltime") * 60;
                    $sj = date("Y-m-d H:i:s", $sj);
                } else {
                    $sj = date("Y-m-d H:i:s");
                }
                if ($rs["end_time"] > $sj) {
                    $rs["setout"] = 0;
                } else {
                    $rs["setout"] = 1;
                }
                $rp = M("car_owner_order_station")->where("coo_id=" . $nid)->order("id desc")->select();
                $cou = count($rp);
                if ($cou > 1) {
                    unset($rp[$cou - 1]);
                    $rs["station"] = $rp;
                } else {
                    $rs["station"] = array();
                }
                $rt = M("car_owner_order_details")->where("coo_id=" . $nid . " and ispay=2 and isdel=0")->select();
                if ($rt) {
                    $rs["num"] = $rt[0]["num"];
                    $i = 0;
                    while ($i < count($rt)) {
                        $rk = M("member")->where("nid=" . $rt[$i]["m_id"])->find();
                        $rt[$i]["x_mobile"] = substr($rk["mobile"], 0, 3) . "****" . substr($rk["mobile"], 7, 4);
                        $rt[$i]["mobile"] = $rk["mobile"];
                        $rt[$i]["wx_nickname"] = $rk["wx_nickname"];
                        $rt[$i]["wx_headimg"] = $rk["wx_headimg"];
                        $rt[$i]["wx_gender"] = $rk["wx_gender"];
                        $rt[$i]["pid"] = $rt[$i]["nid"];
                        if ($rt[$i]["istransfer"] != 3) {
                            $rs["istransfer"] = 0;
                        }
                        $i++;
                    }
                }
                $count = M("car_owner_order_details")->where("coo_id=" . $nid . " and ispay=2 and istransfer!=3")->count();
                if ($count) {
                    $rs["istransfer"] = 1;
                } else {
                    $rs["istransfer"] = 3;
                }
                $rs["data"] = $rt;
                switch ($rs["isreceipt"]) {
                    case 1:
                        $rs["isreceipt1"] = "未出行";
                        break;
                    case 2:
                        $rs["isreceipt1"] = "进行中";
                        break;
                    case 3:
                        $rs["isreceipt1"] = "已完成";
                        break;
                }
                $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
            } else {
                $data = array("retCode" => "0001", "retDesc" => "没有记录");
            }
        }
        exit(json_encode($data));
    }
    public function my_travel_carowner_click_passenger()
    {
        $this->mb();
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $nid = intval($_GET["nid"]);
        $logintag = I("logintag");
        $rt = M("car_owner_order_details")->where("nid=" . $nid)->find();
        if ($rt) {
            $coo_id = $rt["coo_id"];
            $rs = M("car_owner_order")->where("nid=" . $coo_id)->find();
            $rk = M("member")->where("nid=" . $rt["m_id"])->find();
            $rp = M("car_owner_order_station")->where("id=" . $rt["coos_id"])->find();
            $rt["wx_gender"] = $rk["wx_gender"];
            $rt["wx_nickname"] = $rk["wx_nickname"];
            $rt["wx_headimg"] = $rk["wx_headimg"];
            $rt["x_mobile"] = substr($rk["mobile"], 0, 3) . "****" . substr($rk["mobile"], 7, 4);
            $rt["mobile"] = $rk["mobile"];
            $rt["b_lnglat"] = $rp["b_lnglat"];
            $rt["e_lnglat"] = $rp["e_lnglat"];
            $rt["begin_addr"] = $rp["begin_addr"];
            $rt["end_addr"] = $rp["end_addr"];
            $rt["starting_place"] = $rp["starting_place"];
            $rt["end_place"] = $rp["end_place"];
            $rt["begin_time"] = $rs["begin_time"];
            $rt["end_time"] = $rs["end_time"];
            $rt["number"] = $rs["number"];
            $rt["note"] = $rs["note"];
            $rt["money"] = $rp["money"];
            $rt["now_num"] = $rs["now_num"];
            $rt["ismatching"] = $rs["ismatching"];
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rt, "nid" => $nid);
        } else {
            $data = array("retCode" => "0001", "retDesc" => "记录不存在");
        }
        exit(json_encode($data));
    }
    public function my_travel_chickbegin()
    {
        $this->mb();
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0 || !isset($_GET["ntype"]) || intval($_GET["ntype"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $logintag = I("logintag");
        $rs = M("member")->where("session3r='" . $logintag . "'")->find();
        $nclass = $rs["nclass"];
        $nid = intval($_GET["nid"]);
        $ntype = intval($_GET["ntype"]);
        if ($ntype == 1) {
            $where = " isdel1=0 and nid=" . $nid;
            M("passenger_order")->where($where)->setField("isstart", 2);
            $rs = M("passenger_order")->where($where)->find();
            $rt = M("member")->where("nid=" . $rs["m_id"])->find();
            $paramString = "{\"starting_place\":\"" . $rs["starting_place"] . "\",\"end_place\":\"" . $rs["end_place"] . "\"}";
            send_aliyun_msg($rt["mobile"], C("ali_sms.sms5"), $paramString);
        } else {
            $where = " isdel=0 and nid=" . $nid;
            $rs = M("car_owner_order_details")->where($where)->find();
            $setfield = array("nstatus" => 1);
            M("car_owner_order")->where("nid=" . $rs["coo_id"])->setField($setfield);
            M("car_owner_order_details")->where("ispay=2 and isdel=0  and coo_id=" . $rs["coo_id"])->setField("isstart", 2);
            $m_id = $rs["m_id"];
            $rs = M("car_owner_order")->where("nid=" . $rs["coo_id"])->find();
            $rx = M("car_owner_order_details")->where("ispay=2 and isdel=0  and coo_id=" . $rs["nid"])->select();
            $i = 0;
            while ($i < count($rx)) {
                $rt = M("member")->where("nid=" . $rx[$i]["m_id"])->find();
                $paramString = "{\"starting_place\":\"" . $rs["starting_place"] . "\",\"end_place\":\"" . $rs["end_place"] . "\"}";
                send_aliyun_msg($rt["mobile"], C("ali_sms.sms5"), $paramString);
                $i++;
            }
        }
        $data = array("retCode" => "0000", "retDesc" => "操作成功");
        exit(json_encode($data));
    }
    public function my_travel_chickend()
    {
        $this->mb();
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0 || !isset($_GET["ntype"]) || intval($_GET["ntype"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $logintag = I("logintag");
        $rs = M("member")->where("session3r='" . $logintag . "'")->find();
        $nclass = $rs["nclass"];
        $nid = intval($_GET["nid"]);
        $ntype = intval($_GET["ntype"]);
        if ($ntype == 1) {
            $where = " isdel1=0 and nid=" . $nid;
            M("passenger_order")->where($where)->setField("isstart", 3);
            $rs = M("passenger_order")->where($where)->find();
            $rt = M("member")->where("nid=" . $rs["m_id"])->find();
            $paramString = "{\"ordernum\":\"" . $rs["ordernum"] . "\",\"starting_place\":\"" . $rs["starting_place"] . "\",\"end_place\":\"" . $rs["end_place"] . "\"}";
            send_aliyun_msg($rt["mobile"], C("ali_sms.sms18"), $paramString);
        } else {
            $where = " isdel=0 and nid=" . $nid;
            M("car_owner_order_details")->where($where)->setField("isstart", 3);
            $rs = M("car_owner_order_details")->where($where)->find();
            $m_id = $rs["m_id"];
            $ordernum = $rs["ordernum"];
            $rt = M("member")->where("nid=" . $rs["m_id"])->find();
            $rs = M("car_owner_order_station")->where("id=" . $rs["coos_id"])->find();
            $starting_place = $rs["starting_place"];
            $end_place = $rs["end_place"];
            $paramString = "{\"ordernum\":\"" . $ordernum . "\",\"starting_place\":\"" . $starting_place . "\",\"end_place\":\"" . $end_place . "\"}";
            send_aliyun_msg($rt["mobile"], C("ali_sms.sms18"), $paramString);
        }
        $data = array("retCode" => "0000", "retDesc" => "操作成功");
        exit(json_encode($data));
    }
    public function my_travel_chickpay()
    {
        $this->mb();
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0 || !isset($_GET["ntype"]) || intval($_GET["ntype"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $logintag = I("logintag");
        $rs = M("member")->where("session3r='" . $logintag . "'")->find();
        $nclass = $rs["nclass"];
        $nid = intval($_GET["nid"]);
        $ntype = intval($_GET["ntype"]);
        if ($ntype == 1) {
            $where = " isdel1=0 and nid=" . $nid;
            $brr = array("isreceipt" => 3, "isstart" => 3, "istransfer" => 2);
            M("passenger_order")->where($where)->setField($brr);
            $rs = M("passenger_order")->where("nid=" . $nid)->find();
            $co_id = $rs["co_id"];
            $m_id = $rs["m_id"];
            if ($xx = M("car_owner_share")->where("m_id=" . $m_id . " and nstatus=0 and ntype=1 and uniacid=" . $this->uniacid)->find()) {
                $brr = array("nstatus" => 2, "redpacked" => C("member.share"));
                M("car_owner_share")->where("m_id=" . $m_id . " and nstatus=0 and ntype=1 and uniacid=" . $this->uniacid)->setField($brr);
                M("member")->where("nid=" . $xx["referee_id"])->setInc("redpacked", C("member.share"));
            }
            M("member")->where("nid=" . $rs["co_id"])->setInc("account_amount", $rs["money"] - $rs["number"] * C("platform.cover_charge"));
            $brr = array("money" => round($rs["money"] - $rs["number"] * C("platform.cover_charge"), 2), "nclass" => 1, "addtime" => date("Y-m-d H:i:s"), "m_id" => $co_id, "pid" => $nid, "uniacid" => $this->uniacid, "ntype" => $ntype);
            M("revenue_detail")->data($brr)->add();
            $brr = array("money" => round($rs["number"] * C("platform.cover_charge"), 2), "ntype" => 4, "ordernum" => $rs["ordernum"], "addtime" => date("Y-m-d H:i:s"), "uniacid" => $this->uniacid);
            M("platform_income")->data($brr)->add();
            $rt = M("member")->where("nid=" . $co_id)->find();
            $paramString = "{\"starting_place\":\"" . $rs["starting_place"] . "\",\"end_place\":\"" . $rs["end_place"] . "\"}";
            send_aliyun_msg($rt["mobile"], C("ali_sms.sms6"), $paramString);
            if (C("co_awards_status") == 2) {
                if (C("co_awards_type") == 1) {
                    M("member")->where("nid=" . $co_id)->setInc("account_amount", C("co_awards_value"));
                } else {
                    $money = round($rs["money"] * C("co_awards_value") / 100, 2);
                    M("member")->where("nid=" . $co_id)->setInc("account_amount", $money);
                }
            }
            if (C("passenger_awards_status") == 2) {
                if (C("passenger_awards_type") == 1) {
                    M("member")->where("nid=" . $m_id)->setInc("redpacked", C("passenger_awards_value"));
                } else {
                    $money = round($rs["money"] * C("passenger_awards_value") / 100, 2);
                    M("member")->where("nid=" . $m_id)->setInc("redpacked", $money);
                }
            }
        } else {
            $where = " isdel=0 and nid=" . $nid;
            $brr = array("istransfer" => 2, "isstart" => 3);
            M("car_owner_order_details")->where($where)->setField($brr);
            $rs = M("car_owner_order_details")->where("nid=" . $nid)->find();
            $m_id = $rs["m_id"];
            $coo_id = $rs["coo_id"];
            if ($xx = M("car_owner_share")->where("m_id=" . $m_id . " and nstatus=0 and ntype!=2 ")->find()) {
                $brr = array("nstatus" => 2, "redpacked" => C("member.share"));
                M("car_owner_share")->where("m_id=" . $m_id . " and nstatus=0 and ntype!=2")->setField($brr);
                M("member")->where("nid=" . $xx["referee_id"])->setInc("redpacked", C("member.share"));
            }
            if ($xx = M("invitation")->where("m_id=" . $m_id . " and nstatus=1 and orderid=" . $coo_id)->find()) {
                $brr = array("nstatus" => 2);
                M("invitation")->where("nid=" . $xx["nid"])->setField($brr);
            }
            $where = "coo_id=" . $rs["coo_id"] . " and ispay=2 and (istransfer!=2 or isstart!=3)";
            $result = M("car_owner_order_details")->where($where)->select();
            if (!$result) {
                $brr = array("isreceipt" => 3, "nstatus" => 1);
                M("car_owner_order")->where("nid=" . $rs["coo_id"])->setField($brr);
                M("car_owner_order_station")->where("coo_id=" . $rs["coo_id"])->setField($brr);
            }
            $coos_id = $rs["coos_id"];
            $rx = M("car_owner_order")->where("nid=" . $rs["coo_id"])->find();
            $co_id = $rx["co_id"];
            M("member")->where("nid=" . $co_id)->setInc("account_amount", $rs["ntotal"] - $rs["seat_num"] * C("platform.cover_charge"));
            $brr = array("money" => round($rs["ntotal"] - $rs["seat_num"] * C("platform.cover_charge"), 2), "nclass" => 1, "addtime" => date("Y-m-d H:i:s"), "m_id" => $co_id, "pid" => $nid, "uniacid" => $this->uniacid, "ntype" => $ntype);
            M("revenue_detail")->data($brr)->add();
            $brr = array("money" => round($rs["seat_num"] * C("platform.cover_charge"), 2), "ntype" => 4, "ordernum" => $rs["ordernum"], "uniacid" => $this->uniacid, "addtime" => date("Y-m-d H:i:s"));
            M("platform_income")->data($brr)->add();
            $rt = M("member")->where("nid=" . $co_id)->find();
            $rx = M("car_owner_order_station")->where("id =" . $coos_id)->find();
            $paramString = "{\"starting_place\":\"" . $rx["starting_place"] . "\",\"end_place\":\"" . $rx["end_place"] . "\"}";
            send_aliyun_msg($rt["mobile"], C("ali_sms.sms6"), $paramString);
            if (C("co_awards_status") == 2) {
                if (C("co_awards_type") == 1) {
                    M("member")->where("nid=" . $co_id)->setInc("account_amount", C("co_awards_value"));
                } else {
                    $money = round($rs["ntotal"] * C("co_awards_value") / 100, 2);
                    M("member")->where("nid=" . $co_id)->setInc("account_amount", $money);
                }
            }
            if (C("passenger_awards_status") == 2) {
                if (C("passenger_awards_type") == 1) {
                    M("member")->where("nid=" . $m_id)->setInc("redpacked", C("passenger_awards_value"));
                } else {
                    $money = round($rs["ntotal"] * C("passenger_awards_value") / 100, 2);
                    M("member")->where("nid=" . $m_id)->setInc("redpacked", $money);
                }
            }
        }
        $data = array("retCode" => "0000", "retDesc" => "操作成功");
        exit(json_encode($data));
    }
    public function my_travel_chicknotpay()
    {
        $this->mb();
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0 || !isset($_GET["ntype"]) || intval($_GET["ntype"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $logintag = I("logintag");
        $rs = M("member")->where("session3r='" . $logintag . "'")->find();
        $mobile = substr($rs["mobile"], 0, 3) . "****" . substr($rs["mobile"], 7, 4);
        $nclass = $rs["nclass"];
        $nid = intval($_GET["nid"]);
        $ntype = intval($_GET["ntype"]);
        if ($ntype == 1) {
            $brr = array("istransfer" => 3);
            M("passenger_order")->where("nid=" . $nid)->setField($brr);
            $rs = M("passenger_order")->where("nid=" . $nid)->find();
            if ($rs) {
                $rt = M("member")->where("nid=" . $rs["co_id"])->find();
                $paramString = "{\"ordernum\":\"" . $rs["ordernum"] . "\",\"starting_place\":\"" . $rs["starting_place"] . "\",\"end_place\":\"" . $rs["end_place"] . "\",\"truename\":\"" . $mobile . "\"}";
                send_aliyun_msg($rt["mobile"], C("ali_sms.sms19"), $paramString);
                $data = array("retCode" => "0000", "retDesc" => "操作成功");
            } else {
                $data = array("retCode" => "0001", "retDesc" => "操作失败");
            }
        } else {
            $brr = array("istransfer" => 3);
            $rs = M("car_owner_order_details")->where("nid=" . $nid)->setField($brr);
            $rs = M("car_owner_order_details")->where("nid=" . $nid)->find();
            if ($rs) {
                $result = M("car_owner_order_station")->where("id=" . $rs["coos_id"])->find();
                $rs = M("car_owner_order")->where("nid=" . $rs["coo_id"])->find();
                $rt = M("member")->where("nid=" . $rs["co_id"])->find();
                $paramString = "{\"ordernum\":\"" . $rs["ordernum"] . "\",\"starting_place\":\"" . $result["starting_place"] . "\",\"end_place\":\"" . $result["end_place"] . "\",\"truename\":\"" . $mobile . "\"}";
                send_aliyun_msg($rt["mobile"], C("ali_sms.sms19"), $paramString);
                $data = array("retCode" => "0000", "retDesc" => "操作成功");
            } else {
                $data = array("retCode" => "0001", "retDesc" => "操作失败");
            }
        }
        exit(json_encode($data));
    }
    public function my_upimg_view()
    {
        $this->mb();
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0 || !isset($_GET["ntype"]) || intval($_GET["ntype"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $logintag = I("logintag");
        $rs = M("member")->where("session3r='" . $logintag . "'")->find();
        $nclass = $rs["nclass"];
        $nid = intval($_GET["nid"]);
        $ntype = intval($_GET["ntype"]);
        if ($ntype == 1) {
            $rs = M("passenger_order")->where("nid=" . $nid)->find();
            if ($rs) {
                $data = array("retCode" => "0000", "retDesc" => "操作成功", "ordernum" => $rs["ordernum"]);
            } else {
                $data = array("retCode" => "0001", "retDesc" => "操作失败");
            }
        } else {
            $rs = M("car_owner_order_details")->where("nid=" . $nid)->find();
            if ($rs) {
                $data = array("retCode" => "0000", "retDesc" => "操作成功", "ordernum" => $rs["ordernum"]);
            } else {
                $data = array("retCode" => "0001", "retDesc" => "操作失败");
            }
        }
        exit(json_encode($data));
    }
    public function my_upimg()
    {
        $this->mb();
        if (!IS_POST) {
            $data = array("retCode" => "0001", "retDesc" => "非法操作");
            exit(json_encode($data));
        }
        $up = new UploadController();
        $up->uploadpic();
        exit;
        $logintag = trim($_GET["logintag"]);
        ini_set("date.timezone", "Asia/Chongqing");
        $files = $_FILES["file"];
        if ($files) {
            if ($files["size"] > 4194304) {
                $data = array("retCode" => "0001", "retDesc" => "文件不能超过4M");
                exit(json_encode($data));
            }
            $filename = explode(".", strtolower($files["name"]));
            $arr = C("uptype");
            if (!in_array($files["type"], $arr)) {
                $data = array("retCode" => "0001", "retDesc" => "文件格式不正确");
                exit(json_encode($data));
            }
            $filename = date("YmdHis") . mt_rand(1, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(1, 9) . mt_rand(0, 9) . "." . $filename[count($filename) - 1];
            $tmpname = $files["tmp_name"];
            $folder_tmp = "./Public/Uploads/Complain/";
            if (move_uploaded_file($tmpname, $folder_tmp . $filename)) {
                $data = array("retCode" => "0000", "retDesc" => "上传成功", "pathfile" => $filename);
            } else {
                $data = array("retCode" => "0001", "retDesc" => "上传失败");
            }
        } else {
            $data = array("retCode" => "0001", "retDesc" => "上传失败");
        }
        exit(json_encode($data));
    }
    public function car_owner_task_modi_view()
    {
        $this->mb();
        $logintag = I("logintag");
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $nid = intval($_GET["nid"]);
        if ($rs = M("car_owner_order")->where("isreceipt=1 and nid=" . $nid)->find()) {
            $rt = M("car_owner_order_station")->where("coo_id=" . $nid . " and isreceipt=1")->order("id desc")->select();
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs, "station_num" => C("station_num"));
            if (count($rt) > 1) {
                $cou = count($rt);
                unset($rt[$cou - 1]);
                $data["station"] = $rt;
            } else {
                $data["station"] = array();
            }
        } else {
            $data = array("retCode" => "0001", "retDesc" => "记录不存在");
        }
        exit(json_encode($data));
    }
    public function car_owner_task_modi_handle()
    {
        $this->mb();
        $logintag = I("logintag");
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $begin_time = strtotime($_GET["begin_time"]);
        $end_time = strtotime($_GET["end_time"]);
        if ($begin_time >= $end_time || $end_time < time()) {
            $data = array("retCode" => "0001", "retDesc" => "时间参数不正确");
            exit(json_encode($data));
        }
        $nid = intval($_GET["nid"]);
        $logintag = I("logintag");
        $mid_info = I("mid_info");
        $_GET["uniacid"] = $this->uniacid;
        unset($_GET["logintag"], $_GET["loginopen"], $_GET["form_id"], $_GET["nid"], $_GET["mid_info"]);
        M("car_owner_order")->where("nid=" . $nid)->data($_GET)->save();
        $rs = M("car_owner_order")->where("nid=" . $nid)->find();
        M("car_owner_order_station")->where("coo_id=" . $nid)->delete();
        $addtime = $rs["addtime"];
        $starting_place = I("starting_place");
        $end_place = I("end_place");
        $b_lnglat = I("b_lnglat");
        $e_lnglat = I("e_lnglat");
        $x = explode(",", $b_lnglat);
        $_GET["lng"] = $x[0];
        $_GET["lat"] = $x[1];
        $lng = $x[0];
        $lat = $x[1];
        $begin_addr = I("begin_addr");
        $end_addr = I("end_addr");
        $money = I("money");
        $number = I("number");
        $coo_id = $nid;
        $area_name = I("area_name");
        $nstatus = 2;
        $arr = array("addtime" => $addtime, "starting_place" => $starting_place, "end_place" => $end_place, "b_lnglat" => $b_lnglat, "e_lnglat" => $e_lnglat, "lng" => $lng, "lat" => $lat, "begin_addr" => $begin_addr, "end_addr" => $end_addr, "money" => $money, "nstatus" => $nstatus, "number" => $number, "coo_id" => $coo_id, "area_name" => $area_name, "begin_time" => $begin_time, "uniacid" => $this->uniacid, "end_time" => $end_time);
        M("car_owner_order_station")->data($arr)->add();
        $arr = array();
        if (!empty($mid_info)) {
            $a_arr = explode("||", $mid_info);
            foreach ($a_arr as $k => $v) {
                $b_arr = explode(",", $v);
                $arr["coo_id"] = $nid;
                $arr["starting_place"] = $starting_place;
                $arr["end_place"] = $b_arr[0];
                $arr["b_lnglat"] = $b_lnglat;
                $arr["e_lnglat"] = $b_arr[1] . "," . $b_arr[2];
                $arr["begin_addr"] = $begin_addr;
                $arr["end_addr"] = $b_arr[3];
                $arr["money"] = $b_arr[4];
                $arr["lng"] = $lng;
                $arr["lat"] = $lat;
                $arr["area_name"] = $area_name;
                $arr["addtime"] = $addtime;
                $arr["number"] = $number;
                $arr["nstatus"] = $nstatus;
                $arr["begin_time"] = $begin_time;
                $arr["end_time"] = $end_time;
                $arr["uniacid"] = $this->uniacid;
                M("car_owner_order_station")->data($arr)->add();
            }
        }
        $data = array("retCode" => "0000", "retDesc" => "操作成功");
        exit(json_encode($data));
    }
    public function car_owner_task_cancel()
    {
        $this->mb();
        $logintag = I("logintag");
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $nid = intval($_GET["nid"]);
        $rs = M("car_owner_order")->where("nid=" . $nid)->find();
        if ($rs["isreceipt"] == 2) {
            $data = array("retCode" => "0001", "retDesc" => "进行中，不可删除");
            exit(json_encode($data));
        }
        $brr = array("nstatus" => 1, "isreceipt" => 3, "isdel" => 1);
        if (M("car_owner_order")->where("nid=" . $nid)->setField($brr)) {
            $data = array("retCode" => "0000", "retDesc" => "操作成功");
        } else {
            $data = array("retCode" => "0001", "retDesc" => "下架失败");
        }
        exit(json_encode($data));
    }
    public function car_owner_wfcx_task()
    {
        $this->mb();
        $logintag = I("logintag");
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0 || !isset($_GET["ntype"]) || intval($_GET["ntype"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $nid = intval($_GET["nid"]);
        $ntype = intval($_GET["ntype"]);
        $access_token = $this->get_access_token();
        $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $access_token;
        if ($ntype == 1) {
            $iscancel = intval($_GET["iscancel"]);
            switch ($iscancel) {
                case 1:
                    $rs = M("passenger_order")->where("nid=" . $nid)->find();
                    $begin_time = 0;
                    if (C("is_ordercanel") == 2) {
                        $begin_time = strtotime($rs["begin_time"]) - C("ordercaneltime") * 60;
                    }
                    if ($begin_time < time()) {
                        $data = array("retCode" => "0001", "retDesc" => "超出取消订单规定时间");
                        exit(json_encode($data));
                    }
                    if ($rs["num"] >= 2) {
                        $data = array("retCode" => "0001", "retDesc" => "不能再点了");
                        exit(json_encode($data));
                    }
                    M("passenger_order")->where("nid=" . $nid)->setInc("num", 1);
                    $brr = array("apply" => 2, "iscancel" => $iscancel, "isflag" => 0);
                    M("passenger_order")->where("nid=" . $nid)->setField($brr);
                    $rt = M("member")->where("nid=" . $rs["m_id"])->find();
                    $paramString = "{\"starting_place\":\"" . $rs["starting_place"] . "\",\"end_place\":\"" . $rs["end_place"] . "\"}";
                    send_aliyun_msg($rt["mobile"], C("ali_sms.sms7"), $paramString);
                    $data = array("retCode" => "0000", "retDesc" => "操作成功");
                    exit(json_encode($data));
                    break;
                case 2:
                    $rs = M("passenger_order")->where("nid=" . $nid)->find();
                    $begin_time = 0;
                    if (C("is_ordercanel") == 2) {
                        $begin_time = strtotime($rs["begin_time"]) - C("ordercaneltime") * 60;
                    }
                    if ($begin_time < time()) {
                        $data = array("retCode" => "0001", "retDesc" => "超出取消订单规定时间");
                        exit(json_encode($data));
                    }
                    $redpacked = $rs["redpacked"];
                    $paytype = $rs["paytype"];
                    $starting_place = $rs["starting_place"];
                    $end_place = $rs["end_place"];
                    $ordernum = $rs["ordernum"];
                    $transaction_id = $rs["transaction_id"];
                    $money = $rs["money"];
                    $m_id = $rs["m_id"];
                    $co_id = $rs["co_id"];
                    if ($money > $redpacked) {
                        $arr = pc_passenger_task_refund($ordernum, $transaction_id, ($money - $redpacked) * 100);
                        if ($arr["result_code"] == "SUCCESS" && $arr["return_code"] == "SUCCESS") {
                            $data = array("ispay" => 3);
                            M("passenger_order")->where("nid=" . $nid)->data($data)->save();
                            if ($redpacked) {
                                M("member")->where("nid=" . $rs["m_id"])->setInc("redpacked", $redpacked);
                                $brr = array("m_id" => $rs["m_id"], "money" => $rs["redpacked"], "ntype" => 1, "note" => "车主直接取消乘客任务退款", "uniacid" => $this->uniacid, "addtime" => date("Y-m-d H:i:s"));
                                M("redpacked_detail")->data($brr)->add();
                            }
                            $rs = M("member")->where("nid=" . $co_id)->find();
                            $tmp = round((C("platform.platform") + C("platform.car_owner")) * $rs["deposit"], 2);
                            $xmp = round(C("platform.car_owner") * $rs["deposit"], 2);
                            M("member")->where("nid=" . $co_id)->setDec("deposit", $tmp);
                            M("member")->where("nid=" . $m_id)->setInc("account_amount", $xmp);
                            $sj = date("Y-m-d H:i:s");
                            $brr = array("money" => round(C("platform.platform") * $rs["deposit"], 2), "ntype" => 2, "ordernum" => $ordernum, "uniacid" => $this->uniacid, "addtime" => $sj);
                            M("platform_income")->data($brr)->add();
                            $brr = array("amount_cash" => $tmp, "nstatus" => 2, "playmoney_time" => $sj, "reason" => "扣除车主押金", "addtime" => $sj, "nclass" => 3, "ordernum" => "HT" . date("YmdHis") . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9), "uniacid" => $this->uniacid, "m_id" => $co_id);
                            $cid = M("withdrawals")->data($brr)->add();
                            $brr = array("money" => $tmp, "nclass" => 2, "addtime" => $sj, "m_id" => $co_id, "pid" => $cid, "uniacid" => $this->uniacid, "ntype" => 1);
                            M("revenue_detail")->data($brr)->add();
                            $brr = array("amount_cash" => $xmp, "nstatus" => 2, "playmoney_time" => $sj, "reason" => "扣除车主押金", "addtime" => $sj, "nclass" => 3, "ordernum" => "HT" . date("YmdHis") . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9), "uniacid" => $this->uniacid, "m_id" => $m_id);
                            $cid = M("withdrawals")->data($brr)->add();
                            $brr = array("money" => $xmp, "nclass" => 7, "addtime" => $sj, "m_id" => $m_id, "pid" => $cid, "uniacid" => $this->uniacid, "ntype" => 1);
                            M("revenue_detail")->data($brr)->add();
                            $brr = array("iscancel" => $iscancel, "isstart" => 3, "istransfer" => 2, "isreceipt" => 3, "nstatus" => 1);
                            M("passenger_order")->where("nid=" . $nid)->setField($brr);
                        } else {
                            $data = array("retCode" => "0001", "retDesc" => "退款失败");
                            exit($data);
                        }
                    } else {
                        $data = array("ispay" => 3);
                        M("passenger_order")->where("nid=" . $nid)->data($data)->save();
                        if ($redpacked) {
                            M("member")->where("nid=" . $rs["m_id"])->setInc("redpacked", $redpacked);
                            $brr = array("m_id" => $rs["m_id"], "money" => $rs["redpacked"], "ntype" => 1, "note" => "车主直接取消乘客任务退款", "uniacid" => $this->uniacid, "addtime" => date("Y-m-d H:i:s"));
                            M("redpacked_detail")->data($brr)->add();
                        }
                        $rs = M("member")->where("nid=" . $co_id)->find();
                        $tmp = round((C("platform.platform") + C("platform.car_owner")) * $rs["deposit"], 2);
                        $xmp = round(C("platform.car_owner") * $rs["deposit"], 2);
                        M("member")->where("nid=" . $co_id)->setDec("deposit", $tmp);
                        M("member")->where("nid=" . $m_id)->setInc("account_amount", $xmp);
                        $sj = date("Y-m-d H:i:s");
                        $brr = array("money" => round(C("platform.platform") * $rs["deposit"], 2), "ntype" => 2, "ordernum" => $ordernum, "uniacid" => $this->uniacid, "addtime" => $sj);
                        M("platform_income")->data($brr)->add();
                        $brr = array("amount_cash" => $tmp, "nstatus" => 2, "playmoney_time" => $sj, "reason" => "扣除车主押金", "addtime" => $sj, "nclass" => 3, "ordernum" => "HT" . date("YmdHis") . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9), "uniacid" => $this->uniacid, "m_id" => $co_id);
                        $cid = M("withdrawals")->data($brr)->add();
                        $brr = array("money" => $tmp, "nclass" => 2, "addtime" => $sj, "m_id" => $co_id, "pid" => $cid, "uniacid" => $this->uniacid, "ntype" => 1);
                        M("revenue_detail")->data($brr)->add();
                        $brr = array("amount_cash" => $xmp, "nstatus" => 2, "playmoney_time" => $sj, "reason" => "扣除车主押金", "addtime" => $sj, "nclass" => 3, "ordernum" => "HT" . date("YmdHis") . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9), "uniacid" => $this->uniacid, "m_id" => $m_id);
                        $cid = M("withdrawals")->data($brr)->add();
                        $brr = array("money" => $xmp, "nclass" => 7, "addtime" => $sj, "m_id" => $m_id, "pid" => $cid, "uniacid" => $this->uniacid, "ntype" => 1);
                        M("revenue_detail")->data($brr)->add();
                        $brr = array("iscancel" => $iscancel, "isstart" => 3, "istransfer" => 2, "isreceipt" => 3, "nstatus" => 1);
                        M("passenger_order")->where("nid=" . $nid)->setField($brr);
                    }
                    $rt = M("member")->where("nid=" . $m_id)->find();
                    $paramString = "{\"starting_place\":\"" . $starting_place . "\",\"end_place\":\"" . $end_place . "\"}";
                    send_aliyun_msg($rt["mobile"], C("ali_sms.sms8"), $paramString);
                    $data = array("retCode" => "0000", "retDesc" => "操作成功");
                    exit(json_encode($data));
                    break;
                case 3:
                    break;
            }
        } else {
            $iscancel = intval($_GET["iscancel"]);
            switch ($iscancel) {
                case 1:
                    $rs = M("car_owner_order")->find($nid);
                    if (C("is_ordercanel") == 2) {
                        $begin_time = strtotime($rs["begin_time"]) - C("ordercaneltime") * 60;
                    }
                    if ($begin_time < time()) {
                        $data = array("retCode" => "0001", "retDesc" => "超出取消订单规定时间");
                        exit(json_encode($data));
                    }
                    $rs = M("car_owner_order_details")->where("coo_id=" . $nid . " and ispay=2 and isdel=0 and num=2")->order("nid desc")->find();
                    if ($rs) {
                        $data = array("retCode" => "0001", "retDesc" => "你不能再点了");
                        exit(json_encode($data));
                    }
                    M("car_owner_order_details")->where("coo_id=" . $nid . " and ispay=2 and isdel=0")->setInc("num", 1);
                    $brr = array("cancel_order" => $iscancel, "apply" => 2, "iscancal" => 0);
                    M("car_owner_order_details")->where("coo_id=" . $nid . " and ispay=2 and isdel=0")->setField($brr);
                    $result = M("car_owner_order")->where("nid=" . $nid)->find();
                    $rs = M("car_owner_order_details")->where("coo_id=" . $nid . " and ispay=2 and isdel=0")->order("nid desc")->select();
                    if ($rs) {
                        $i = 0;
                        while ($i < count($rs)) {
                            $rt = M("member")->where("nid=" . $rs[$i]["m_id"])->find();
                            $paramString = "{\"starting_place\":\"" . $result["starting_place"] . "\",\"end_place\":\"" . $result["end_place"] . "\"}";
                            send_aliyun_msg($rt["mobile"], C("ali_sms.sms7"), $paramString);
                            $i++;
                        }
                    }
                    $data = array("retCode" => "0000", "retDesc" => "操作成功");
                    exit(json_encode($data));
                    break;
                case 2:
                    $rs = M("car_owner_order")->find($nid);
                    if (C("is_ordercanel") == 2) {
                        $begin_time = strtotime($rs["begin_time"]) - C("ordercaneltime") * 60;
                    }
                    if ($begin_time < time()) {
                        $data = array("retCode" => "0001", "retDesc" => "超出取消订单规定时间");
                        exit(json_encode($data));
                    }
                    $brr = array("isreceipt" => 3, "cancel_order" => 2);
                    M("car_owner_order")->where("nid=" . $nid)->setField($brr);
                    $rp = M("car_owner_order")->where("nid=" . $nid)->find();
                    $co_id = $rp["co_id"];
                    $starting_place = $rp["starting_place"];
                    $end_place = $rp["end_place"];
                    $ordernum = $rp["ordernum"];
                    $memrs = M("member")->where("nid=" . $co_id)->find();
                    $tmp = round((C("platform.platform") + C("platform.car_owner")) * $memrs["deposit"], 2);
                    $xmp = round(C("platform.car_owner") * $memrs["deposit"], 2);
                    $count = M("car_owner_order_details")->where("coo_id=" . $nid . " and ispay=2 and isdel=0 and isstart!=3")->count();
                    if ($count > 0) {
                        $seattotal = round($xmp / $count, 2);
                    } else {
                        $seattotal = $xmp;
                    }
                    $rs = M("car_owner_order_details")->where("coo_id=" . $nid . " and ispay=2 and isdel=0 and isstart!=3")->select();
                    $i = 0;
                    $sj = time();
                    while ($i < count($rs)) {
                        if ($rs[$i]["paytype"] == 1) {
                            $arr = pc_passenger_task_refund($rs[$i]["ordernum"], $rs[$i]["transaction_id"], ($rs[$i]["ntotal"] - $rs[$i]["redpacked"]) * 100);
                            if ($arr["result_code"] == "SUCCESS" && $arr["return_code"] == "SUCCESS") {
                                $data = array("ispay" => 3, "cancel_order" => 2, "istransfer" => 2, "isstart" => 3);
                                M("car_owner_order_details")->where("nid=" . $rs[$i]["nid"])->data($data)->save();
                                M("member")->where("nid=" . $rs[$i]["m_id"])->setInc("account_amount", $seattotal);
                                $brr = array("amount_cash" => $seattotal, "nstatus" => 2, "playmoney_time" => $sj, "reason" => "扣除车主押金", "addtime" => $sj, "nclass" => 3, "ordernum" => "HT" . date("YmdHis") . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9), "uniacid" => $this->uniacid, "m_id" => $rs[$i]["m_id"]);
                                $cid_x = M("withdrawals")->data($brr)->add();
                                $brr = array("money" => $seattotal, "nclass" => 7, "addtime" => $sj, "m_id" => $rs[$i]["m_id"], "pid" => $cid_x, "uniacid" => $this->uniacid, "ntype" => 2);
                                M("revenue_detail")->data($brr)->add();
                                if ($rs[$i]["redpacked"]) {
                                    M("member")->where("nid=" . $rs[$i]["m_id"])->setInc("redpacked", $rs[$i]["redpacked"]);
                                    $brr = array("m_id" => $rs[$i]["m_id"], "money" => $rs[$i]["redpacked"], "ntype" => 1, "addtime" => date("Y-m-d H:i:s"), "uniacid" => $this->uniacid, "note" => "车主直接取消订单退款");
                                    M("redpacked_detail")->data($brr)->add();
                                }
                            } else {
                                $data = array("retCode" => "0001", "retDesc" => "退款失败");
                                exit(json_encode($data));
                            }
                        } else {
                            $data = array("ispay" => 3, "cancel_order" => 2, "istransfer" => 2, "isstart" => 3);
                            M("car_owner_order_details")->where("nid=" . $rs[$i]["nid"])->data($data)->save();
                            M("member")->where("nid=" . $rs[$i]["m_id"])->setInc("account_amount", $seattotal);
                            $brr = array("amount_cash" => $seattotal, "nstatus" => 2, "playmoney_time" => $sj, "reason" => "扣除车主押金", "addtime" => $sj, "nclass" => 3, "ordernum" => "HT" . date("YmdHis") . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9), "uniacid" => $this->uniacid, "m_id" => $rs[$i]["m_id"]);
                            $cid_x = M("withdrawals")->data($brr)->add();
                            $brr = array("money" => $seattotal, "nclass" => 7, "addtime" => $sj, "m_id" => $rs[$i]["m_id"], "pid" => $cid_x, "uniacid" => $this->uniacid, "ntype" => 2);
                            M("revenue_detail")->data($brr)->add();
                            if ($rs[$i]["redpacked"]) {
                                M("member")->where("nid=" . $rs[$i]["m_id"])->setInc("redpacked", $rs[$i]["redpacked"]);
                                $brr = array("m_id" => $rs[$i]["m_id"], "money" => $rs[$i]["redpacked"], "ntype" => 1, "addtime" => date("Y-m-d H:i:s"), "uniacid" => $this->uniacid, "note" => "车主直接取消订单退款");
                                M("redpacked_detail")->data($brr)->add();
                            }
                        }
                        $mrs = M("member")->where("nid=" . $rs[$i]["m_id"])->find();
                        $tp_rs = M("car_owner_order_station")->where("id=" . $rs[$i]["coos_id"])->find();
                        $paramString = "{\"starting_place\":\"" . $tp_rs["starting_place"] . "\",\"end_place\":\"" . $tp_rs["end_place"] . "\"}";
                        send_aliyun_msg($mrs["mobile"], C("ali_sms.sms8"), $paramString);
                        $i++;
                    }
                    M("member")->where("nid=" . $co_id)->setDec("deposit", $tmp);
                    $sj = date("Y-m-d H:i:s");
                    $brr = array("money" => round(C("platform.platform") * $memrs["deposit"], 2), "ntype" => 2, "addtime" => $sj, "uniacid" => $this->uniacid, "ordernum" => $ordernum);
                    M("platform_income")->data($brr)->add();
                    $brr = array("amount_cash" => $tmp, "nstatus" => 2, "playmoney_time" => $sj, "reason" => "扣除车主押金", "addtime" => $sj, "nclass" => 3, "ordernum" => "HT" . date("YmdHis") . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9), "uniacid" => $this->uniacid, "m_id" => $co_id);
                    $cid = M("withdrawals")->data($brr)->add();
                    $brr = array("money" => $tmp, "nclass" => 2, "addtime" => $sj, "m_id" => $co_id, "pid" => $cid, "uniacid" => $this->uniacid, "ntype" => 2);
                    M("revenue_detail")->data($brr)->add();
                    $data = array("retCode" => "0000", "retDesc" => "操作成功");
                    exit(json_encode($data));
                    break;
                case 3:
                    break;
            }
        }
    }
    public function passenger_wfcx_task()
    {
        $this->mb();
        $logintag = I("logintag");
        if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0 || !isset($_GET["ntype"]) || intval($_GET["ntype"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $nid = intval($_GET["nid"]);
        $ntype = intval($_GET["ntype"]);
        $iscancel = intval($_GET["iscancel"]);
        $access_token = $this->get_access_token();
        $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $access_token;
        if ($ntype == 1) {
            switch ($iscancel) {
                case 1:
                    $rs = M("passenger_order")->where("nid=" . $nid)->find();
                    $begin_time = 0;
                    if (C("is_ordercanel") == 2) {
                        $begin_time = strtotime($rs["begin_time"]) - C("ordercaneltime") * 60;
                    }
                    if ($begin_time < time()) {
                        $data = array("retCode" => "0001", "retDesc" => "超出取消订单规定时间");
                        exit(json_encode($data));
                    }
                    if ($rs["num"] == 2) {
                        $data = array("retCode" => "0001", "retDesc" => "不能再点了");
                        exit(json_encode($data));
                    }
                    M("passenger_order")->where("nid=" . $nid)->setInc("num", 1);
                    $brr = array("apply" => 1, "isflag" => 0, "iscancel" => $iscancel);
                    M("passenger_order")->where("nid=" . $nid)->setField($brr);
                    $rs = M("passenger_order")->where("nid=" . $nid)->find();
                    $rt = M("member")->where("nid=" . $rs["co_id"])->find();
                    $paramString = "{\"starting_place\":\"" . $rs["starting_place"] . "\",\"end_place\":\"" . $rs["end_place"] . "\"}";
                    send_aliyun_msg($rt["mobile"], C("ali_sms.sms9"), $paramString);
                    $data = array("retCode" => "0000", "retDesc" => "操作成功");
                    exit(json_encode($data));
                    break;
                case 2:
                    $rs = M("passenger_order")->where("nid=" . $nid)->find();
                    $begin_time = 0;
                    if (C("is_ordercanel") == 2) {
                        $begin_time = strtotime($rs["begin_time"]) - C("ordercaneltime") * 60;
                    }
                    if ($begin_time < time()) {
                        $data = array("retCode" => "0001", "retDesc" => "超出取消订单规定时间");
                        exit(json_encode($data));
                    }
                    $redpacked = $rs["redpacked"];
                    $tmp = round((C("platform.platform") + C("platform.passenger")) * $rs["money"], 2);
                    $xmp = round(C("platform.passenger") * $rs["money"], 2);
                    $sy = round($rs["money"] - $tmp, 2);
                    if ($sy > $redpacked) {
                        $re = pc_order_refund($rs["ordernum"], $rs["transaction_id"], round($rs["money"] - $redpacked, 2) * 100, round($sy - $redpacked, 2) * 100);
                        if ($re["return_code"] == "SUCCESS" && $re["result_code"] == "SUCCESS") {
                            M("member")->where("nid=" . $rs["m_id"])->setInc("redpacked", $redpacked);
                            $brr = array("isreceipt" => 3, "istransfer" => 2, "iscancel" => 2, "isstart" => 3, "ispay" => 3);
                            M("passenger_order")->where("nid=" . $nid)->setField($brr);
                        } else {
                            $data = array("retCode" => "0001", "retDesc" => "剩余车资退款失败");
                            exit(json_encode($data));
                        }
                    } else {
                        M("member")->where("nid=" . $rs["m_id"])->setInc("redpacked", $sy);
                        $brr = array("isreceipt" => 3, "istransfer" => 2, "iscancel" => 2, "isstart" => 3, "ispay" => 3);
                        M("passenger_order")->where("nid=" . $nid)->setField($brr);
                    }
                    $sj = date("Y-m-d H:i:s");
                    $brr = array("money" => round(C("platform.platform") * $rs["money"], 2), "ntype" => 1, "addtime" => $sj, "uniacid" => $this->uniacid, "ordernum" => $rs["ordernum"]);
                    M("platform_income")->data($brr)->add();
                    $brr = array("m_id" => $rs["m_id"], "amount_cash" => $tmp, "nstatus" => 2, "playmoney_time" => $sj, "addtime" => $sj, "reason" => "扣除车资", "nclass" => 4, "uniacid" => $this->uniacid, "ordernum" => "HT" . date("YmdHis") . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9));
                    $cid = M("withdrawals")->data($brr)->add();
                    $brr = array("money" => $tmp, "nclass" => 3, "addtime" => $sj, "m_id" => $rs["m_id"], "pid" => $cid, "uniacid" => $this->uniacid, "ntype" => 1);
                    M("revenue_detail")->data($brr)->add();
                    $brr = array("m_id" => $rs["co_id"], "amount_cash" => $xmp, "nstatus" => 2, "playmoney_time" => $sj, "addtime" => $sj, "reason" => "收入", "nclass" => 4, "uniacid" => $this->uniacid, "ordernum" => "HT" . date("YmdHis") . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9));
                    $cid = M("withdrawals")->data($brr)->add();
                    $brr = array("money" => $xmp, "nclass" => 7, "addtime" => $sj, "m_id" => $rs["co_id"], "pid" => $cid, "uniacid" => $this->uniacid, "ntype" => 1);
                    M("revenue_detail")->data($brr)->add();
                    $crr = array("m_id" => $rs["m_id"], "amount_cash" => $sy, "nstatus" => 2, "reason" => "退还车资余额", "addtime" => $sj, "nclass" => 5, "uniacid" => $this->uniacid, "ordernum" => "HT" . date("YmdHis") . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9));
                    $cid = M("withdrawals")->data($crr)->add();
                    $brr = array("money" => $sy, "nclass" => 8, "addtime" => $sj, "m_id" => $rs["m_id"], "pid" => $cid, "uniacid" => $this->uniacid, "ntype" => 1);
                    M("revenue_detail")->data($brr)->add();
                    M("member")->where("nid=" . $rs["co_id"])->setInc("account_amount", $xmp);
                    $rt = M("member")->where("nid=" . $rs["co_id"])->find();
                    $paramString = "{\"starting_place\":\"" . $rs["starting_place"] . "\",\"end_place\":\"" . $rs["end_place"] . "\"}";
                    send_aliyun_msg($rt["mobile"], C("ali_sms.sms10"), $paramString);
                    $data = array("retCode" => "0000", "retDesc" => "操作成功");
                    exit(json_encode($data));
                    break;
            }
        } else {
            switch ($iscancel) {
                case 1:
                    $rs = M("car_owner_order_details")->where("nid=" . $nid)->find();
                    $re = M("car_owner_order")->where("nid=" . $rs["coo_id"])->find();
                    $begin_time = 0;
                    if (C("is_ordercanel") == 2) {
                        $begin_time = strtotime($re["begin_time"]) - C("ordercaneltime") * 60;
                    }
                    if ($begin_time < time()) {
                        $data = array("retCode" => "0001", "retDesc" => "超出取消订单规定时间");
                        exit(json_encode($data));
                    }
                    if ($rs["num"] >= 2) {
                        $data = array("retCode" => "0001", "retDesc" => "不能再点了");
                        exit(json_encode($data));
                    }
                    M("car_owner_order_details")->where("nid=" . $nid)->setInc("num", 1);
                    $brr = array("cancel_order" => 1, "iscancal" => 0);
                    M("car_owner_order_details")->where("nid=" . $nid)->setField($brr);
                    $rs = M("car_owner_order_details")->where("nid=" . $nid)->find();
                    $rt = M("member")->where("nid=" . $re["co_id"])->find();
                    $paramString = "{\"starting_place\":\"" . $re["starting_place"] . "\",\"end_place\":\"" . $re["end_place"] . "\"}";
                    send_aliyun_msg($rt["mobile"], C("ali_sms.sms9"), $paramString);
                    $data = array("retCode" => "0000", "retDesc" => "操作成功");
                    exit(json_encode($data));
                    break;
                case 2:
                    $rs = M("car_owner_order_details")->where("nid=" . $nid)->find();
                    $rp = M("car_owner_order_station")->find($rs["coos_id"]);
                    $tf_rs = M("car_owner_order")->where("nid=" . $rs["coo_id"])->find();
                    $begin_time = 0;
                    if (C("is_ordercanel") == 2) {
                        $begin_time = strtotime($tf_rs["begin_time"]) - C("ordercaneltime") * 60;
                    }
                    if ($begin_time < time()) {
                        $data = array("retCode" => "0001", "retDesc" => "超出取消订单规定时间");
                        exit(json_encode($data));
                    }
                    $sj = date("Y-m-d H:i:s");
                    $brr = array("cancel_order" => 2, "istransfer" => 2, "isstart" => 3);
                    M("car_owner_order_details")->where("nid=" . $nid)->setField($brr);
                    $starting_place = $rp["starting_place"];
                    $end_place = $rp["end_place"];
                    $ntotal = $rs["ntotal"];
                    $redpacked = $rs["redpacked"];
                    $tmp = round((C("platform.platform") + C("platform.passenger")) * $ntotal, 2);
                    $xmp = round(C("platform.passenger") * $ntotal, 2);
                    $sy = round($ntotal - $tmp, 2);
                    if ($sy > $redpacked) {
                        $re = pc_order_refund($rs["ordernum"], $rs["transaction_id"], round($rs["ntotal"] - $redpacked, 2) * 100, round($sy - $redpacked, 2) * 100);
                        if ($re["return_code"] == "SUCCESS" && $re["result_code"] == "SUCCESS") {
                            M("member")->where("nid=" . $rs["m_id"])->setInc("redpacked", $redpacked);
                            $brr = array("cancel_order" => 2, "ispay" => 3, "istransfer" => 2, "isstart" => 3);
                            M("car_owner_order_details")->where("nid=" . $nid)->setField($brr);
                        } else {
                            $data = array("retCode" => "0001", "retDesc" => "退款出错");
                            exit(json_encode($data));
                        }
                    } else {
                        M("member")->where("nid=" . $rs["m_id"])->setInc("redpacked", $sy);
                        $brr = array("cancel_order" => 2, "ispay" => 3, "istransfer" => 2, "isstart" => 3);
                        M("car_owner_order_details")->where("nid=" . $nid)->setField($brr);
                    }
                    $brr = array("money" => round(C("platform.platform") * $ntotal, 2), "ntype" => 1, "addtime" => $sj, "uniacid" => $this->uniacid, "ordernum" => $rs["ordernum"]);
                    M("platform_income")->data($brr)->add();
                    $brr = array("m_id" => $rs["m_id"], "amount_cash" => $tmp, "nstatus" => 2, "playmoney_time" => $sj, "reason" => "扣除车资", "addtime" => $sj, "nclass" => 4, "uniacid" => $this->uniacid, "ordernum" => "HT" . date("YmdHis") . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9));
                    $cid = M("withdrawals")->data($brr)->add();
                    $brr = array("money" => $tmp, "nclass" => 3, "addtime" => $sj, "m_id" => $rs["m_id"], "pid" => $cid, "uniacid" => $this->uniacid, "ntype" => 2);
                    M("revenue_detail")->data($brr)->add();
                    $re = M("car_owner_order")->where("nid=" . $rs["coo_id"])->find();
                    $ordernum = $re["ordernum"];
                    $x_end_time = strtotime($re["end_time"]);
                    if ($x_end_time < time()) {
                        $xx = array("nstatus" => 1);
                        M("car_owner_order")->where("nid=" . $rs["coo_id"])->data($xx)->save();
                    } else {
                        if (!M("car_owner_order_details")->where("nid=" . $rs["coo_id"] . " and ispay=2 and isstart!=3 and istransfer!=2")->count()) {
                            $xx = array("nstatus" => 1);
                            M("car_owner_order")->where("nid=" . $rs["coo_id"])->data($xx)->save();
                        }
                    }
                    M("member")->where("nid=" . $re["co_id"])->setInc("account_amount", $xmp);
                    $co_id = $re["co_id"];
                    $brr = array("m_id" => $re["co_id"], "amount_cash" => $xmp, "nstatus" => 2, "playmoney_time" => $sj, "reason" => "扣除车资", "addtime" => $sj, "nclass" => 4, "uniacid" => $this->uniacid, "ordernum" => "HT" . date("YmdHis") . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9));
                    $cid = M("withdrawals")->data($brr)->add();
                    $brr = array("money" => $xmp, "nclass" => 3, "addtime" => $sj, "m_id" => $re["co_id"], "pid" => $cid, "uniacid" => $this->uniacid, "ntype" => 2);
                    M("revenue_detail")->data($brr)->add();
                    $crr = array("m_id" => $rs["m_id"], "amount_cash" => $sy, "nstatus" => 2, "reason" => "退还车资余额", "addtime" => $sj, "nclass" => 5, "uniacid" => $this->uniacid, "ordernum" => "HT" . date("YmdHis") . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9));
                    $cid = M("withdrawals")->data($crr)->add();
                    $brr = array("money" => $sy, "nclass" => 8, "addtime" => $sj, "m_id" => $rs["m_id"], "pid" => $cid, "uniacid" => $this->uniacid, "ntype" => 2);
                    M("revenue_detail")->data($brr)->add();
                    $rt = M("member")->where("nid=" . $co_id)->find();
                    $paramString = "{\"starting_place\":\"" . $starting_place . "\",\"end_place\":\"" . $end_place . "\"}";
                    send_aliyun_msg($rt["mobile"], C("ali_sms.sms10"), $paramString);
                    $data = array("retCode" => "0000", "retDesc" => "操作成功");
                    exit(json_encode($data));
                    break;
            }
        }
    }
    public function passenger_click_agree_op()
    {
        $this->mb();
        if (!isset($_GET["ntype"]) || intval($_GET["ntype"]) <= 0 || !isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $nid = intval($_GET["nid"]);
        $ntype = intval($_GET["ntype"]);
        $access_token = $this->get_access_token();
        $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $access_token;
        if ($ntype == 1) {
            $brr = array("ispay" => 3, "isreceipt" => 3, "istransfer" => 2, "isflag" => 1, "isstart" => 3, "iscancel" => 1);
            $rs = M("passenger_order")->where("nid=" . $nid)->find();
            if (M("passenger_order")->where("nid=" . $nid)->data($brr)->save()) {
                if ($rs["money"] > $rs["redpacked"]) {
                    $arr = pc_passenger_task_refund($rs["ordernum"], $rs["transaction_id"], ($rs["money"] - $rs["redpacked"]) * 100);
                    if ($arr["result_code"] == "SUCCESS" && $arr["return_code"] == "SUCCESS") {
                        if ($rs["redpacked"]) {
                            M("member")->where("nid=" . $rs["m_id"])->setInc("redpacked", $rs["redpacked"]);
                        }
                        $rt = M("member")->where("nid=" . $rs["co_id"])->find();
                        $rx = M("member")->where("nid=" . $rs["m_id"])->find();
                        $mobile = substr($rx["mobile"], 0, 3) . "****" . substr($rx["mobile"], 7, 4);
                        $paramString = "{\"starting_place\":\"" . $rs["starting_place"] . "\",\"end_place\":\"" . $rs["end_place"] . "\",\"mem\":\"" . $mobile . "\"}";
                        send_aliyun_msg($rt["mobile"], C("ali_sms.sms11"), $paramString);
                        $data = array("retCode" => "0000", "retDesc" => "操作成功");
                    } else {
                        $data = array("retCode" => "0001", "retDesc" => "退款失败");
                    }
                } else {
                    if ($rs["redpacked"]) {
                        M("member")->where("nid=" . $rs["m_id"])->setInc("redpacked", $rs["redpacked"]);
                    }
                    $rt = M("member")->where("nid=" . $rs["co_id"])->find();
                    $rx = M("member")->where("nid=" . $rs["m_id"])->find();
                    $mobile = substr($rx["mobile"], 0, 3) . "****" . substr($rx["mobile"], 7, 4);
                    $paramString = "{\"starting_place\":\"" . $rs["starting_place"] . "\",\"end_place\":\"" . $rs["end_place"] . "\",\"mem\":\"" . $mobile . "\"}";
                    send_aliyun_msg($rt["mobile"], C("ali_sms.sms11"), $paramString);
                    $data = array("retCode" => "0000", "retDesc" => "操作成功");
                }
            } else {
                $data = array("retCode" => "0001", "retDesc" => "操作出错");
            }
        } else {
            $rs = M("car_owner_order_details")->where("nid=" . $nid)->find();
            $m_id = $rs["m_id"];
            $coos_id = $rs["coos_id"];
            $brr = array("iscancal" => 1);
            if (M("car_owner_order_details")->where("nid=" . $nid)->data($brr)->save()) {
                $rt = M("car_owner_order_details")->where("ispay=2 and isstart!=3 and iscancal!=1 and isdel=0 and coo_id=" . $rs["coo_id"])->select();
                $rs = M("car_owner_order")->where("nid=" . $rs["coo_id"])->find();
                if (!$rt) {
                    $ret = M("car_owner_order_details")->where("ispay=2  and isstart!=3 and coo_id=" . $rs["nid"])->select();
                    $i = 0;
                    while ($i < count($ret)) {
                        if ($ret[$i]["ntotal"] > $ret[$i]["redpacked"]) {
                            $arr = pc_passenger_task_refund($ret[$i]["ordernum"], $ret[$i]["transaction_id"], ($ret[$i]["ntotal"] - $ret[$i]["redpacked"]) * 100);
                            if ($arr["result_code"] != "SUCCESS" || $arr["return_code"] != "SUCCESS") {
                                $data = array("retCode" => "0001", "retDesc" => "退款失败");
                                exit(json_encode($data));
                            } else {
                                $brr = array("ispay" => 3, "istransfer" => 2, "isstart" => 3);
                                M("car_owner_order_details")->where("nid=" . $ret[$i]["nid"])->data($brr)->save();
                            }
                        }
                        if ($ret[$i]["redpacked"]) {
                            M("member")->where("nid=" . $ret[$i]["m_id"])->setInc("redpacked", $ret[$i]["redpacked"]);
                        }
                        $rt = M("member")->where("nid=" . $rs["co_id"])->find();
                        $rx = M("member")->where("nid=" . $ret[$i]["m_id"])->find();
                        $mobile = substr($rx["mobile"], 0, 3) . "****" . substr($rx["mobile"], 7, 4);
                        $coos_id = $ret[$i]["coos_id"];
                        $rpp = M("car_owner_order_station")->where("id=" . $coos_id)->find();
                        $paramString = "{\"starting_place\":\"" . $rpp["starting_place"] . "\",\"end_place\":\"" . $rpp["end_place"] . "\",\"mem\":\"" . $mobile . "\"}";
                        send_aliyun_msg($rt["mobile"], C("ali_sms.sms11"), $paramString);
                        $i++;
                    }
                    $brr = array("nstatus" => 1, "isreceipt" => 3, "cancel_order" => 1, "iscancel" => 1);
                    M("car_owner_order")->where("nid=" . $rs["nid"])->data($brr)->save();
                    $data = array("retCode" => "0000", "retDesc" => "操作成功");
                    exit(json_encode($data));
                }
                $rt = M("member")->where("nid=" . $rs["co_id"])->find();
                $rx = M("member")->where("nid=" . $m_id)->find();
                $mobile = substr($rx["mobile"], 0, 3) . "****" . substr($rx["mobile"], 7, 4);
                $rpp = M("car_owner_order_station")->where("id=" . $coos_id)->find();
                $paramString = "{\"starting_place\":\"" . $rpp["starting_place"] . "\",\"end_place\":\"" . $rpp["end_place"] . "\",\"mem\":\"" . $mobile . "\"}";
                send_aliyun_msg($rt["mobile"], C("ali_sms.sms11"), $paramString);
                $data = array("retCode" => "0000", "retDesc" => "操作成功");
            } else {
                $data = array("retCode" => "0001", "retDesc" => "修改状态失败");
            }
        }
        exit(json_encode($data));
    }
    public function passenger_click_notagree_op()
    {
        $this->mb();
        if (!isset($_GET["ntype"]) || intval($_GET["ntype"]) <= 0 || !isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $nid = intval($_GET["nid"]);
        $ntype = intval($_GET["ntype"]);
        $access_token = $this->get_access_token();
        $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $access_token;
        if ($ntype == 1) {
            $brr = array("isflag" => 2);
            M("passenger_order")->where("nid=" . $nid)->data($brr)->save();
            $rs = M("passenger_order")->where("nid=" . $nid)->find();
            $m_id = $rs["m_id"];
            $rt = M("member")->where("nid=" . $rs["co_id"])->find();
            $rx = M("member")->where("nid=" . $m_id)->find();
            $mobile = substr($rx["mobile"], 0, 3) . "****" . substr($rx["mobile"], 7, 4);
            $paramString = "{\"starting_place\":\"" . $rs["starting_place"] . "\",\"end_place\":\"" . $rs["end_place"] . "\",\"mem\":\"" . $mobile . "\"}";
            send_aliyun_msg($rt["mobile"], C("ali_sms.sms12"), $paramString);
        } else {
            $rs = M("car_owner_order_details")->where("nid=" . $nid)->find();
            $m_id = $rs["m_id"];
            $coos_id = $rs["coos_id"];
            M("car_owner_order_details")->where("nid=" . $nid)->data(array("iscancal" => 2))->save();
            $rs = M("car_owner_order")->where("nid=" . $rs["coo_id"])->find();
            $rt = M("member")->where("nid=" . $rs["co_id"])->find();
            $rx = M("member")->where("nid=" . $m_id)->find();
            $mobile = substr($rx["mobile"], 0, 3) . "****" . substr($rx["mobile"], 7, 4);
            $rpp = M("car_owner_order_station")->where("id=" . $coos_id)->find();
            $paramString = "{\"starting_place\":\"" . $rpp["starting_place"] . "\",\"end_place\":\"" . $rpp["end_place"] . "\",\"mem\":\"" . $mobile . "\"}";
            send_aliyun_msg($rt["mobile"], C("ali_sms.sms12"), $paramString);
        }
        $data = array("retCode" => "0000", "retDesc" => "操作成功");
        exit(json_encode($data));
    }
    public function car_owner_click_notagree_op()
    {
        $this->mb();
        if (!isset($_GET["ntype"]) || intval($_GET["ntype"]) <= 0 || !isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $nid = intval($_GET["nid"]);
        $ntype = intval($_GET["ntype"]);
        $access_token = $this->get_access_token();
        $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $access_token;
        if ($ntype == 1) {
            $brr = array("isflag" => 2);
            M("passenger_order")->where("nid=" . $nid)->data($brr)->save();
            $rs = M("passenger_order")->where("nid=" . $nid)->find();
            $rt = M("member")->where("nid=" . $rs["m_id"])->find();
            $rx = M("member")->where("nid=" . $rs["co_id"])->find();
            $mobile = substr($rx["mobile"], 0, 3) . "****" . substr($rx["mobile"], 7, 4);
            $paramString = "{\"starting_place\":\"" . $rs["starting_place"] . "\",\"end_place\":\"" . $rs["end_place"] . "\",\"mem\":\"" . $mobile . "\"}";
            send_aliyun_msg($rt["mobile"], C("ali_sms.sms13"), $paramString);
        } else {
            $rs = M("car_owner_order_details")->where("nid=" . $nid)->find();
            $coos_id = $rs["coos_id"];
            M("car_owner_order_details")->where("nid=" . $nid)->data(array("iscancal" => 2))->save();
            $rf = M("car_owner_order")->where("nid=" . $rs["coo_id"])->find();
            $co_id = $rf["co_id"];
            $rt = M("member")->where("nid=" . $rs["m_id"])->find();
            $rx = M("member")->where("nid=" . $co_id)->find();
            $mobile = substr($rx["mobile"], 0, 3) . "****" . substr($rx["mobile"], 7, 4);
            $rpp = M("car_owner_order_station")->where("id=" . $coos_id)->find();
            $paramString = "{\"starting_place\":\"" . $rpp["starting_place"] . "\",\"end_place\":\"" . $rpp["end_place"] . "\",\"mem\":\"" . $mobile . "\"}";
            send_aliyun_msg($rt["mobile"], C("ali_sms.sms13"), $paramString);
        }
        $data = array("retCode" => "0000", "retDesc" => "操作成功");
        exit(json_encode($data));
    }
    public function car_owner_click_agree_op()
    {
        $this->mb();
        if (!isset($_GET["ntype"]) || intval($_GET["ntype"]) <= 0 || !isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $nid = intval($_GET["nid"]);
        $ntype = intval($_GET["ntype"]);
        $access_token = $this->get_access_token();
        $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $access_token;
        if ($ntype == 1) {
            $rs = M("passenger_order")->where("nid=" . $nid)->find();
            if ($rs["money"] > $rs["redpacked"]) {
                $arr = pc_passenger_task_refund($rs["ordernum"], $rs["transaction_id"], ($rs["money"] - $rs["redpacked"]) * 100);
                if ($arr["result_code"] == "SUCCESS" && $arr["return_code"] == "SUCCESS") {
                    if ($rs["redpacked"]) {
                        M("member")->where("nid=" . $rs["m_id"])->setInc("redpacked", $rs["redpacked"]);
                    }
                    $brr = array("ispay" => 3, "isreceipt" => 3, "istransfer" => 2, "isflag" => 1, "isstart" => 3);
                    M("passenger_order")->where("nid=" . $rs["nid"])->data($brr)->save();
                } else {
                    $data = array("retCode" => "0001", "retDesc" => "退款失败");
                    exit(json_encode($data));
                }
            } else {
                if ($rs["redpacked"]) {
                    M("member")->where("nid=" . $rs["m_id"])->setInc("redpacked", $rs["redpacked"]);
                }
                $brr = array("ispay" => 3, "isreceipt" => 3, "istransfer" => 2, "isflag" => 1, "isstart" => 3);
                M("passenger_order")->where("nid=" . $rs["nid"])->data($brr)->save();
            }
            $rt = M("member")->where("nid=" . $rs["m_id"])->find();
            $rx = M("member")->where("nid=" . $rs["co_id"])->find();
            $mobile = substr($rx["mobile"], 0, 3) . "****" . substr($rx["mobile"], 7, 4);
            $paramString = "{\"starting_place\":\"" . $rs["starting_place"] . "\",\"end_place\":\"" . $rs["end_place"] . "\",\"mem\":\"" . $mobile . "\"}";
            send_aliyun_msg($rt["mobile"], C("ali_sms.sms14"), $paramString);
            $data = array("retCode" => "0000", "retDesc" => "操作成功");
            exit(json_encode($data));
        } else {
            $brr = array("iscancal" => 1);
            M("car_owner_order_details")->where("nid=" . $nid)->data($brr)->save();
            $rs = M("car_owner_order_details")->where("nid=" . $nid)->find();
            $coo_id = $rs["coo_id"];
            $coos_id = $rs["coos_id"];
            $m_id = $rs["m_id"];
            if ($rs["ntotal"] > $rs["redpacked"]) {
                $arr = pc_passenger_task_refund($rs["ordernum"], $rs["transaction_id"], ($rs["ntotal"] - $rs["redpacked"]) * 100);
                if ($arr["result_code"] == "SUCCESS" && $arr["return_code"] == "SUCCESS") {
                    $brr = array("ispay" => 3, "istransfer" => 2, "isstart" => 3);
                    M("car_owner_order_details")->where("nid=" . $rs["nid"])->data($brr)->save();
                } else {
                    $data = array("retCode" => "0001", "retDesc" => "退款失败");
                    exit(json_encode($data));
                }
            }
            if ($rs["redpacked"]) {
                M("member")->where("nid=" . $rs["m_id"])->setInc("redpacked", $rs["redpacked"]);
            }
            if (!M("car_owner_order_details")->where("coo_id=" . $coo_id . " and ispay=2 and isstart!=3 ")->select()) {
                $brr = array("nstatus" => 1, "isreceipt" => 3);
            }
            $rt = M("member")->where("nid=" . $rs["m_id"])->find();
            $rpp = M("car_owner_order_station")->where("id=" . $coos_id)->find();
            $rx = M("car_owner_order")->where("nid=" . $rpp["coo_id"])->find();
            $rx = M("member")->where("nid=" . $rx["co_id"])->find();
            $mobile = substr($rx["mobile"], 0, 3) . "****" . substr($rx["mobile"], 7, 4);
            $paramString = "{\"starting_place\":\"" . $rpp["starting_place"] . "\",\"end_place\":\"" . $rpp["end_place"] . "\",\"mem\":\"" . $mobile . "\"}";
            send_aliyun_msg($rt["mobile"], C("ali_sms.sms14"), $paramString);
        }
        $data = array("retCode" => "0000", "retDesc" => "操作成功");
        exit(json_encode($data));
    }
    public function car_owner_click_complain_op()
    {
        $this->mb();
        if (!isset($_GET["ntype"]) || intval($_GET["ntype"]) <= 0 || !isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $nid = intval($_GET["nid"]);
        $ntype = intval($_GET["ntype"]);
        $logintag = I("logintag");
        $picpath = I("picpath");
        if ($ntype == 1) {
            $rs = M("member")->where("session3r='" . $logintag . "'")->find();
            $brr = array("m_id" => $rs["nid"], "cood_id" => $nid, "picpath" => $picpath, "addtime" => date("Y-m-d H:i:s"), "note" => I("note"), "uniacid" => $this->uniacid, "nclass" => $rs["nclass"]);
            if (M("member_complain")->data($brr)->add()) {
                $brr = array("istransfer" => 3);
                M("passenger_order")->where("nid=" . $nid)->data($brr)->save();
                $data = array("retCode" => "0000", "retDesc" => "操作成功");
            } else {
                $data = array("retCode" => "0001", "retDesc" => "操作失败");
            }
        } else {
            $rs = M("member")->where("session3r='" . $logintag . "'")->find();
            $brr = array("m_id" => $rs["nid"], "pid" => $nid, "picpath" => $picpath, "addtime" => date("Y-m-d H:i:s"), "note" => I("note"), "uniacid" => $this->uniacid, "nclass" => $rs["nclass"]);
            if (M("car_owner_order_complain")->data($brr)->add()) {
                $brr = array("istransfer" => 3);
                M("car_owner_order_details")->where("nid=" . $nid)->data($brr)->save();
                $rs = M("car_owner_order_details")->where("nid=" . $nid)->find();
                M("car_owner_order")->where("nid=" . $rs["coo_id"])->setField("is_flag", 2);
                $data = array("retCode" => "0000", "retDesc" => "操作成功");
            } else {
                $data = array("retCode" => "0001", "retDesc" => "操作失败");
            }
        }
        exit(json_encode($data));
    }
    public function passenger_click_complain_op()
    {
        $this->mb();
        if (!isset($_GET["ntype"]) || intval($_GET["ntype"]) <= 0 || !isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $logintag = I("logintag");
        $nid = intval($_GET["nid"]);
        $ntype = intval($_GET["ntype"]);
        $picpath = I("picpath");
        if ($ntype == 1) {
            $rs = M("member")->where("session3r='" . $logintag . "'")->find();
            $brr = array("m_id" => $rs["nid"], "cood_id" => $nid, "picpath" => $picpath, "addtime" => date("Y-m-d H:i:s"), "note" => I("note"), "uniacid" => $this->uniacid, "nclass" => $rs["nclass"]);
            if (M("member_complain")->data($brr)->add()) {
                $brr = array("istransfer" => 3);
                M("passenger_order")->where("nid=" . $nid)->data($brr)->save();
                $data = array("retCode" => "0000", "retDesc" => "操作成功");
            } else {
                $data = array("retCode" => "0001", "retDesc" => "操作失败");
            }
        } else {
            $rs = M("member")->where("session3r='" . $logintag . "'")->find();
            $brr = array("m_id" => $rs["nid"], "pid" => $nid, "picpath" => $picpath, "addtime" => date("Y-m-d H:i:s"), "note" => I("note"), "uniacid" => $this->uniacid, "nclass" => $rs["nclass"]);
            if (M("car_owner_order_complain")->data($brr)->add()) {
                $brr = array("istransfer" => 3);
                M("car_owner_order_details")->where("nid=" . $nid)->data($brr)->save();
                $rs = M("car_owner_order_details")->where("nid=" . $nid)->find();
                M("car_owner_order")->where("nid=" . $rs["coo_id"])->setField("is_flag", 2);
                $data = array("retCode" => "0000", "retDesc" => "操作成功");
            } else {
                $data = array("retCode" => "0001", "retDesc" => "操作失败");
            }
        }
        exit(json_encode($data));
    }
    public function member_withdraw_redpacked()
    {
        $this->mb();
        $logintag = I("logintag");
        $rs = M("member")->field("nid,mobile,redpacked")->where("session3r='" . $logintag . "'")->find();
        if ($rs) {
            $rs["x_mobile"] = substr($rs["mobile"], 0, 3) . "****" . substr($rs["mobile"], 7, 4);
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
        } else {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
        }
        exit(json_encode($data));
    }
    public function member_withdraw_redpacked_log()
    {
        $this->mb();
        $logintag = I("logintag");
        if (!isset($_GET["deposit"]) || $_GET["deposit"] <= 0) {
            $data = array("retCode" => "0001", "retDesc" => "参数不正确");
            exit(json_encode($data));
        }
        $deposit = $_GET["deposit"];
        $rs = M("member")->where("session3r='" . $logintag . "'")->find();
        $co_deposit = $rs["redpacked"];
        if ($co_deposit < C("member.redpacked")) {
            $data = array("retCode" => "0001", "retDesc" => "红包大于" . C("member.redpacked") . "元可提现");
            exit(json_encode($data));
        }
        if ($co_deposit < $deposit) {
            $data = array("retCode" => "0001", "retDesc" => "红包金额不足");
            exit(json_encode($data));
        }
        $sj = date("Y-m-d H:i:s");
        $brr = array("m_id" => $rs["nid"], "money" => $deposit, "addtime" => $sj, "nstatus" => 1, "uniacid" => $this->uniacid, "ordernum" => "HT" . date("YmdHis") . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9));
        if (M("member")->where("nid=" . $rs["nid"])->setDec("redpacked", $deposit)) {
            M("redpacked_withdraw")->data($brr)->add();
            $data = array("retCode" => "0000", "retDesc" => "申请成功");
        } else {
            $data = array("retCode" => "0001", "retDesc" => "扣除账户红包金额失败");
        }
        exit(json_encode($data));
    }
    public function member_enter_share()
    {
        $this->mb();
        $logintag = I("logintag");
        if ($rs = M("member")->where("session3r='" . $logintag . "'")->find()) {
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "nid" => $rs["nid"]);
        } else {
            $data = array("retCode" => "0001", "retDesc" => "用户不存在");
        }
        exit(json_encode($data));
    }
    public function Identity_swap()
    {
        $this->mb();
        $logintag = I("logintag");
        if ($rs = M("member")->where("session3r='" . $logintag . "'")->find()) {
            if ($rs["nclass"] == 1) {
                M("member")->where("session3r='" . $logintag . "'")->setField("nclass", 2);
            } else {
                M("member")->where("session3r='" . $logintag . "'")->setField("nclass", 1);
            }
            $data = array("retCode" => "0000", "retDesc" => "操作成功");
        } else {
            $data = array("retCode" => "0001", "retDesc" => "用户不存在");
        }
        exit(json_encode($data));
    }
    public function get_member_msg()
    {
        $str = file_get_contents("php://input");
        $filename = "test2.txt";
        if (!($handle = fopen($filename, "a+"))) {
            exit;
        }
        if (fwrite($handle, $str . "\r\n") === FALSE) {
            exit;
        }
        fclose($handle);
        if ($str != '') {
            $brr = json_decode($str, true);
            $data = array("touser" => trim($brr["FromUserName"]), "msgtype" => "text", "text" => array("content" => "请问，有什么可以帮助您？"));
            switch ($brr["MsgType"]) {
                case "text":
                    switch ($brr["Content"]) {
                        case "你好":
                            if ($brr["FromUserName"] != "oQU4H0VO1IdgXmxkavcNIeiP2o3U") {
                            }
                            $data["text"]["content"] = urlencode($data["text"]["content"]);
                            $data = json_encode($data);
                            $data = urldecode($data);
                            break;
                        case "在吗":
                            $data = urldecode($data);
                            $data["text"]["content"] = urlencode($data["text"]["content"]);
                            $data = json_encode($data);
                            $data = array("touser" => trim($brr["FromUserName"]), "msgtype" => "text", "text" => array("content" => "我们一直都在您的身边，从来没有离开。"));
                            if ($brr["FromUserName"] != "oQU4H0VO1IdgXmxkavcNIeiP2o3U") {
                            }
                            break;
                        default:
                            $data = json_encode($data);
                            $data = array("touser" => "oQU4H0VO1IdgXmxkavcNIeiP2o3U", "msgtype" => "text", "text" => array("content" => $brr["Content"]));
                            $data["text"]["content"] = urlencode($data["text"]["content"]);
                            if (!$brr["FromUserName"] != "oQU4H0VO1IdgXmxkavcNIeiP2o3U") {
                            }
                            $data["text"]["content"] = urlencode($data["text"]["content"]);
                            $data = urldecode($data);
                            $data = urldecode($data);
                            $data = json_encode($data);
                            $data = array("touser" => trim($brr["FromUserName"]), "msgtype" => "text", "text" => array("content" => $brr["Content"]));
                            break;
                    }
                    break;
                case "image":
                    break;
                case "miniprogrampage":
                    break;
                case "event":
                    break;
                default:
                    $data = array("ToUserName" => trim($brr["FromUserName"]), "FromUserName" => "gh_436e07aae300", "MsgType" => "transfer_customer_service", "CreateTime" => time());
                    $data = json_encode($data);
                    break;
            }
        }
        $access_token = $this->get_access_token();
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $access_token;
        $res = Http_post($url, $data);
    }
    public function checkSignature()
    {
        if (!isset($_GET["signature"]) || !isset($_GET["timestamp"]) || !isset($_GET["nonce"]) || !isset($_GET["echostr"])) {
            echo "非法操作";
            exit;
        }
        $signature = I("signature");
        $timestamp = I("timestamp");
        $nonce = I("nonce");
        $token = "5121cff22400193814a3d37d83ca40";
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if ($tmpStr == $signature) {
            ob_clean();
            echo $_GET["echostr"];
        }
    }
    public function mb()
    {
        $logintag = I("logintag");
        if ($logintag == '') {
            $data = array("retCode" => "0001", "retDesc" => "请先登录");
            exit(json_encode($data));
        }
        $this->getConfig();
        $rs = M("member")->where("session3r='" . $logintag . "' and nstatus=1")->find();
        if (!$rs) {
            $data = array("retCode" => "0001", "retDesc" => "请先登录");
            exit(json_encode($data));
        }
        if ($rs["nstatus"] == 2) {
            $data = array("retCode" => "0001", "retDesc" => "账号已冻结");
            exit(json_encode($data));
        }
    }
    public function noticelist()
    {
        $this->mb();
        $logintag = I("logintag");
        $rs = M("member")->where("session3r='" . $logintag . "'")->find();
        if (!$rs) {
            $data = array("retCode" => "0001", "retDesc" => "用户不存在");
            exit(json_encode($data));
        }
        $nid = $rs["nid"];
        $rs = M("notice")->field("title,contents,addtime")->where("nstatus=1 and m_id=" . $rs["nid"] . " and uniacid=" . $this->uniacid)->order("nid desc")->select();
        M("notice")->where("nstatus=1 and m_id=" . $nid . " and uniacid=" . $this->uniacid)->setField("nstatus", 2);
        if ($rs) {
            $data = array("retCode" => "0000", "retDesc" => "操作成功", "info" => $rs);
        } else {
            $data = array("retCode" => "0001", "retDesc" => "没有信息");
        }
        exit(json_encode($data));
    }
    public function my_license_upimg()
    {
        $this->mb();
        if (!IS_POST) {
            $data = array("retCode" => "0001", "retDesc" => "非法操作");
            exit(json_encode($data));
        }
        $up = new UploadController();
        $up->uploadpic();
        exit;
        $logintag = trim($_GET["logintag"]);
        ini_set("date.timezone", "Asia/Chongqing");
        $files = $_FILES["file"];
        if ($files) {
            if ($files["size"] > 4194304) {
                $data = array("retCode" => "0001", "retDesc" => "文件不能超过4M");
                exit(json_encode($data));
            }
            $filename = explode(".", strtolower($files["name"]));
            $arr = C("uptype");
            if (!in_array($files["type"], $arr)) {
                $data = array("retCode" => "0001", "retDesc" => "文件格式不正确");
                exit(json_encode($data));
            }
            $filename = date("YmdHis") . mt_rand(1, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(1, 9) . mt_rand(0, 9) . "." . $filename[count($filename) - 1];
            $tmpname = $files["tmp_name"];
            $folder_tmp = "./Public/Uploads/license/";
            if (move_uploaded_file($tmpname, $folder_tmp . $filename)) {
                $data = array("retCode" => "0000", "retDesc" => "上传成功", "pathfile" => "https://" . $_SERVER["HTTP_HOST"] . "/addons/yb_pingche/Public/Uploads/license/" . $filename);
            } else {
                $data = array("retCode" => "0001", "retDesc" => "上传失败");
            }
        } else {
            $data = array("retCode" => "0001", "retDesc" => "上传失败");
        }
        exit(json_encode($data));
    }
    public function carowner_audit_show()
    {
        $this->mb();
        $logintag = I("logintag");
        $rs = M("member")->where("session3r='" . $logintag . "'")->find();
        $nid = $rs["nid"];
        $arr = array("car_number" => $rs["car_number"], "car_model" => $rs["car_model"], "car_color" => $rs["car_color"], "is_audit" => $rs["is_audit"]);
        if (empty($rs["driving_license"])) {
            $arr["driving_license"] = '';
        } else {
            $arr["driving_license"] = $rs["driving_license"];
        }
        if (empty($rs["vehicle_license"])) {
            $arr["vehicle_license"] = '';
        } else {
            $arr["vehicle_license"] = $rs["vehicle_license"];
        }
        $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $arr);
        exit(json_encode($data));
    }
    public function carowner_audit_handle()
    {
        $this->mb();
        $logintag = I("logintag");
        $rs = M("member")->where("session3r='" . $logintag . "'")->find();
        $nid = $rs["nid"];
        $arr = array("car_number" => strtoupper(I("car_number")), "car_model" => I("car_model"), "car_color" => I("car_color"), "driving_license" => I("driving_license"), "vehicle_license" => I("vehicle_license"), "is_audit" => 1);
        if (M("member")->where("nid=" . $nid)->data($arr)->save()) {
            $data = array("retCode" => "0000", "retDesc" => "提交成功");
        } else {
            $data = array("retCode" => "0001", "retDesc" => "提交失败");
        }
        exit(json_encode($data));
    }
    public function showpersoninfo()
    {
        $this->mb();
        $logintag = I("logintag");
        $rs = M("member")->field("nid,mobile,province,city,country,gender,wx,truename,wx_headimg")->where("session3r='" . $logintag . "'")->find();
        if (!$rs) {
            $data = array("retCode" => "0001", "retDesc" => "用户不存在");
        } else {
            $data = array("retCode" => "0000", "retDesc" => "提交成功", "info" => $rs);
        }
        exit(json_encode($data));
    }
    public function modipersoninfo()
    {
        $this->mb();
        $logintag = I("logintag");
        $this->login_veri();
        $rs = M("member")->where("session3r='" . $logintag . "'")->find();
        $arr = array("mobile" => I("mobile"), "province" => I("province"), "city" => I("city"), "country" => I("country"), "gender" => I("gender"), "wx" => I("wx"), "truename" => I("truename"));
        M("member")->where("session3r='" . $logintag . "'")->data($arr)->save();
        $data = array("retCode" => "0000", "retDesc" => "修改成功");
        exit(json_encode($data));
    }
    public function getprice()
    {
        $b_lnglat = I("b_lnglat");
        $e_lnglat = I("e_lnglat");
        $area = I("area");
        $rs = M("area_price")->where("name='" . $area . "' and nstatus=1 and p_id>0 and uniacid=" . $this->uniacid)->order("nid desc")->find();
        if (!$rs) {
            $rs = M("area_price")->where("nstatus=1  and p_id>0 and uniacid=" . $this->uniacid)->order("nid desc")->find();
            if (!$rs) {
                $data = array("retCode" => "0001", "retDesc" => "无法获取车价");
                exit($data);
            }
        }
        $key = "QDVBZ-SWI3X-4WR4G-Z57MN-RLWHH-VMF4R";
        $result = file_get_contents("https://apis.map.qq.com/ws/direction/v1/driving/?from=" . $b_lnglat . "&to=" . $e_lnglat . "&output=json&key=" . $key);
        $result = json_decode($result, true);
        if ($result["status"] == 0) {
            $mileage = round($result["result"]["routes"][0]["distance"] / 1000, 2);
            if ($mileage < 3) {
                $price = $rs["start_price"];
            }
            if ($mileage > 3 and $mileage < 10) {
                $price = round($rs["start_price"] + ($mileage - $rs["sstart_mileage"]) * $rs["skm_price"], 2);
            }
            if ($mileage >= 10) {
                $price = round($rs["start_price"] + ($rs["bstart_mileage"] - $rs["sstart_mileage"]) * $rs["skm_price"] + ($mileage - $rs["bstart_mileage"]) * $rs["bkm_price"], 2);
            }
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "price" => $price);
        } else {
            $data = array("retCode" => "0001", "retDesc" => "网络异常");
        }
        exit(json_encode($data));
    }
    public function bidding_list()
    {
        $this->mb();
        $rs = M("bidding")->where("audit=2 and overdue>" . time() . " and nstatus=0 and uniacid=" . $this->uniacid)->select();
        if ($rs) {
            foreach ($rs as $k => $v) {
                $tmp_arr = explode(",", $v["ccc"]);
                sort($tmp_arr);
                if (count($tmp_arr) == 8) {
                    $rs[$k]["ccc"] = "每天";
                } else {
                    $rs[$k]["ccc"] = '';
                    foreach ($tmp_arr as $tmp_v) {
                        switch ($tmp_v) {
                            case 1:
                                $rs[$k]["ccc"] .= "周一,";
                                break;
                            case 2:
                                $rs[$k]["ccc"] .= "周二,";
                                break;
                            case 3:
                                $rs[$k]["ccc"] .= "周三,";
                                break;
                            case 4:
                                $rs[$k]["ccc"] .= "周四,";
                                break;
                            case 5:
                                $rs[$k]["ccc"] .= "周五,";
                                break;
                            case 6:
                                $rs[$k]["ccc"] .= "周六,";
                                break;
                            case 7:
                                $rs[$k]["ccc"] .= "周日,";
                                break;
                        }
                    }
                    $rs[$k]["ccc"] = substr($rs[$k]["ccc"], 0, -1);
                }
                $rs[$k]["x_mobile"] = substr($v["mobile"], 0, 3) . "****" . substr($v["mobile"], 7, 4);
                $rt = M("member")->find($v["m_id"]);
                $rs[$k]["wx_nickname"] = $rt["wx_nickname"];
                $rs[$k]["wx_headimg"] = $rt["wx_headimg"];
                $rs[$k]["wx_gender"] = $rt["wx_gender"];
            }
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
        } else {
            $data = array("retCode" => "0001", "retDesc" => "没有记录");
        }
        exit(json_encode($data));
    }
    public function bidding_addshow()
    {
        $this->mb();
        $rs = M("bidding_price")->where("nstatus=1 and uniacid=" . $this->uniacid)->select();
        if ($rs) {
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
        } else {
            $data = array("retCode" => "0001", "retDesc" => "没有记录");
        }
        exit(json_encode($data));
    }
    public function bidding_addhandle()
    {
        $this->mb();
        $logintag = I("logintag");
        $param = I("get.");
        $rs = M("member")->where("session3r='" . $logintag . "'")->find();
        $b_lnglat = I("b_lnglat");
        $e_lnglat = I("e_lnglat");
        $x = explode(",", $b_lnglat);
        $param["lng"] = $x[0];
        $param["lat"] = $x[1];
        $param["addtime"] = time();
        $param["m_id"] = $rs["nid"];
        $param["uniacid"] = $this->uniacid;
        unset($param["logintag"]);
        if ($rt = M("bidding")->data($param)->add()) {
            $data = array("retCode" => "0000", "retDesc" => "提交成功");
        } else {
            $data = array("retCode" => "0001", "retDesc" => "操作失败");
        }
        exit(json_encode($data));
    }
    public function car_owner_bidding_list()
    {
        $this->mb();
        $logintag = I("logintag");
        $rs = M("member")->where("session3r='" . $logintag . "'")->find();
        $m_id = $rs["nid"];
        $count = M("bidding")->where("m_id=" . $m_id . " and uniacid=" . $this->uniacid)->count();
        $Page = new Page($count, 10);
        $limit = $Page->firstRow . "," . $Page->listRows;
        $rs = M("bidding")->where("m_id=" . $m_id . " and uniacid=" . $this->uniacid)->limit($limit)->order("id desc")->select();
        if ($rs) {
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
        } else {
            $data = array("retCode" => "0001", "retDesc" => "没有数据");
        }
        exit(json_encode($data));
    }
    public function car_owner_bidding_view()
    {
        $this->mb();
        $logintag = I("logintag");
        $nid = I("nid");
        $rs = M("bidding")->where("id=" . $nid)->find();
        if ($rs) {
            $rf = M("bidding_price")->where("price=" . $rs["put_time"] . " and uniacid=" . $this->uniacid)->find();
            $rs["put_time"] = $rf["daynum"];
            $tmp_arr = explode(",", $rs["ccc"]);
            sort($tmp_arr);
            if (count($tmp_arr) == 8) {
                $rs["ccc"] = "每天";
            } else {
                $ddd = '';
                foreach ($tmp_arr as $tmp_v) {
                    switch ($tmp_v) {
                        case 1:
                            $ddd .= "周一,";
                            break;
                        case 2:
                            $ddd .= "周二,";
                            break;
                        case 3:
                            $ddd .= "周三,";
                            break;
                        case 4:
                            $ddd .= "周四,";
                            break;
                        case 5:
                            $ddd .= "周五,";
                            break;
                        case 6:
                            $ddd .= "周六,";
                            break;
                        case 7:
                            $ddd .= "周日,";
                            break;
                    }
                }
                $rs["ccc"] = substr($ddd, 0, -1);
            }
            $rt = M("member")->where("nid=" . $rs["m_id"])->find();
            $rs["wx_nickname"] = $rt["wx_nickname"];
            $rs["wx_headimg"] = $rt["wx_headimg"];
            $rs["wx_gender"] = $rt["wx_gender"];
            if (!empty($rt["car_number"])) {
                $rs["car_number"] = $rt["car_number"];
            } else {
                $rs["car_number"] = '';
            }
            if (!empty($rt["car_model"])) {
                $rs["car_model"] = $rt["car_model"];
            } else {
                $rs["car_model"] = '';
            }
            if (!empty($rt["car_color"])) {
                $rs["car_color"] = $rt["car_color"];
            } else {
                $rs["car_color"] = '';
            }
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
        } else {
            $data = array("retCode" => "0001", "retDesc" => "没有数据");
        }
        exit(json_encode($data));
    }
    public function car_owner_del_bidding()
    {
        $this->mb();
        $logintag = I("logintag");
        $rs = M("member")->where("session3r='" . $logintag . "'")->find();
        $nid = I("nid");
        $rt = M("bidding")->where("id=" . $nid . " and m_id=" . $rs["nid"])->find();
        if ($rt) {
            if ($rt["audit"] == 2 && $rt["overdue"] > time()) {
                $data = array("retCode" => "0001", "retDesc" => "有效中不可删除");
                exit($data);
            }
        } else {
            $data = array("retCode" => "0001", "retDesc" => "记录不存在");
            exit($data);
        }
        if (M("bidding")->where("id=" . $nid . " and m_id=" . $rs["nid"])->delete()) {
            $data = array("retCode" => "0000", "retDesc" => "操作成功");
        } else {
            $data = array("retCode" => "0001", "retDesc" => "操作失败");
        }
        exit(json_encode($data));
    }
    public function my_share_list()
    {
        $this->mb();
        $logintag = I("logintag");
        $rs = M("member")->where("session3r='" . $logintag . "'")->find();
        $nid = $rs["nid"];
        $count = M("car_owner_share")->where("referee_id=" . $nid)->count();
        $page = new Page($count, 10);
        $limit = $page->firstRow . "," . $page->listRows;
        $rs = M("car_owner_share")->field("nid,nstatus,m_id")->where("referee_id=" . $nid)->order("nid desc")->select();
        if ($rs) {
            $i = 0;
            while ($i < count($rs)) {
                $rt = M("member")->find($rs[$i]["m_id"]);
                $rs[$i]["wx_nickname"] = $rt["wx_nickname"];
                $rs[$i]["wx_headimg"] = $rt["wx_headimg"];
                switch ($rs[$i]["nstatus"]) {
                    case 0:
                        $rs[$i]["nstatus1"] = "分享进行中";
                        break;
                    case 1:
                        $rs[$i]["nstatus1"] = "分享失败";
                        break;
                    case 2:
                        $rs[$i]["nstatus1"] = "分享成功";
                        break;
                }
                $i++;
            }
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
        } else {
            $data = array("retCode" => "0001", "retDesc" => "没有记录");
        }
        exit(json_encode($data));
    }
    public function my_carfriend_list()
    {
        $this->mb();
        $logintag = I("logintag");
        $rs = M("member")->where("session3r='" . $logintag . "'")->find();
        $nid = $rs["nid"];
        $count = M("invitation")->where("nstatus =2 and referee_id=" . $nid)->count();
        $page = new Page($count, 10);
        $limit = $page->firstRow . "," . $page->listRows;
        $rs = M("invitation")->field("m_id,nid")->where(" referee_id=" . $nid)->order("nid desc")->select();
        if ($rs) {
            $i = 0;
            while ($i < count($rs)) {
                $rt = M("member")->find($rs[$i]["m_id"]);
                $rs[$i]["wx_nickname"] = $rt["wx_nickname"];
                $rs[$i]["wx_headimg"] = $rt["wx_headimg"];
                switch ($rs[$i]["nstatus"]) {
                    case 0:
                        $rs[$i]["nstatus1"] = "分享进行中";
                        break;
                    case 1:
                        $rs[$i]["nstatus1"] = "分享失败";
                        break;
                    case 2:
                        $rs[$i]["nstatus1"] = "分享成功";
                        break;
                }
                $i++;
            }
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
        } else {
            $data = array("retCode" => "0001", "retDesc" => "没有记录");
        }
        exit(json_encode($data));
    }
    public function show_car_owner_share_view()
    {
        $this->mb();
        $logintag = I("logintag");
        $rs = M("member")->where("session3r='" . $logintag . "'")->find();
        if (!$rs) {
            $data = array("retCode" => "0001", "retDesc" => "用户不存在");
        } else {
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "nid" => $rs["nid"]);
        }
        exit(json_encode($data));
    }
    public function get_fzsm_content()
    {
        $this->mb();
        $logintag = I("logintag");
        $rs = M("fzsm")->where("uniacid=" . $this->uniacid)->find();
        if ($rs) {
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "info" => $rs);
        } else {
            $data = array("retCode" => "0001", "retDesc" => "没有记录");
        }
        exit(json_encode($data));
    }
    public function fbrw()
    {
        $this->mb();
        $data = array("retCode" => "0000", "retDesc" => "获取成功", "is_autoprice" => C("is_autoprice"), "station_num" => C("station_num"));
        exit(json_encode($data));
    }
    public function morecitylist()
    {
        $this->mb();
        $data = array("retCode" => "0000", "retDesc" => "获取成功");
        $rs = M("area_price")->field("nid,name")->where("p_id>0 and nstatus=1 and flag=2 and uniacid=" . $this->uniacid)->order("nid desc")->select();
        if ($rs) {
            $data["info"]["city"] = $rs;
        } else {
            $data["info"]["city"] = array();
        }
        $rm = M("area_price")->where("p_id>0 and nstatus=1 and uniacid=" . $this->uniacid)->order("nid desc")->group("word")->select();
        $data["info"]["word"] = array();
        foreach ($rm as $k => $v) {
            $d = array();
            $rt = M("area_price")->field("nid,name")->where("word='" . $v["word"] . "' and p_id>0 and nstatus=1 and uniacid=" . $this->uniacid)->order("nid desc")->select();
            $d["a"] = $v["word"];
            $d["b"] = $rt;
            array_push($data["info"]["word"], $d);
        }
        if (!$rm) {
            $data = array("retCode" => "0001", "retDesc" => "没有信息");
        }
        exit(json_encode($data));
    }
    public function getappcode()
    {
        $this->mb();
        if (file_exists("./Public/Uploads/license/1.jpg")) {
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "pathfile" => "https://" . $_SERVER["HTTP_HOST"] . "/addons/yb_pingche/Public/Uploads/license/1.jpg");
        } else {
            $access_token = $this->get_access_token();
            $url = "https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=" . $access_token;
            $arr = array("path" => "pages/log/log", "width" => 430);
            $data = Http_post($url, json_encode($arr));
            file_put_contents("./Public/Uploads/license/1.jpg", $data);
            $data = array("retCode" => "0000", "retDesc" => "获取成功", "pathfile" => "https://" . $_SERVER["HTTP_HOST"] . "/addons/yb_pingche/Public/Uploads/license/1.jpg");
        }
        exit(json_encode($data));
    }
    public function getmember_mobile_decryption()
    {
        $this->mb();
        $appid = C("pingche_xcx.appid");
        $sessionKey = '';
        $encryptedData = I("encryptedData");
        $iv = I("iv");
        $logintag = I("logintag");
        $rs = M("member")->where("session3r='" . $logintag . "'")->find();
        $sessionKey = $rs["session_key"];
        if (strlen($sessionKey) != 24) {
            $data = array("retCode" => "0001", "retDesc" => "encodingAesKey 非法");
            exit(json_encode($data));
        }
        $aesKey = base64_decode($sessionKey);
        if (strlen($iv) != 24) {
            $data = array("retCode" => "0001", "retDesc" => "获取失败");
            exit(json_encode($data));
        }
        $aesIV = base64_decode($iv);
        $aesCipher = base64_decode($encryptedData);
        $result = openssl_decrypt($aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);
        $dataObj = json_decode($result, true);
        if ($dataObj["watermark"]["appid"] != $appid) {
            $data = array("retCode" => "0001", "retDesc" => "小程序appid不一致");
            exit(json_encode($data));
        }
        M("member")->where("session3r='" . $logintag . "'")->setField("mobile", $dataObj["purePhoneNumber"]);
        $data = array("retCode" => "0000", "retDesc" => "获取成功");
        exit(json_encode($data));
    }
}