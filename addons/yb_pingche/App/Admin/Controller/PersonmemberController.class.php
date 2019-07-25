<?php

//decode by http://www.yunlu99.com/
namespace Admin\Controller;

use Think\Controller;
use Think\Page;
class PersonmemberController extends CommonController
{
	public function index()
	{
		$this->mb();
		$str = " uniacid=" . $this->uniacid . " ";
		if (isset($_GET["nclass"]) && intval($_GET["nclass"]) > 0) {
			$nclass = intval($_GET["nclass"]);
			$str .= " and nclass='" . $nclass . "'";
			$this->nclass = $_GET["nclass"];
		} else {
			$this->nclass = 0;
		}
		if (isset($_GET["nstatus"]) && intval($_GET["nstatus"]) > 0) {
			$nstatus = intval($_GET["nstatus"]);
			$str .= " and nstatus='" . $nstatus . "'";
			$this->nstatus = $_GET["nstatus"];
		} else {
			$this->nstatus = 0;
		}
		if (isset($_GET["mobile"]) && trim($_GET["mobile"]) != '') {
			$mobile = trim($_GET["mobile"]);
			$str .= " and mobile='" . $mobile . "'";
			$this->mobile = $_GET["mobile"];
		} else {
			$this->mobile = '';
		}
		if (isset($_GET["btime"]) && trim($_GET["btime"]) != '') {
			$btime = date("Y-m-d 00:00:00", strtotime($_GET["btime"]));
			$str .= " and regtime>='" . $btime . "'";
			$this->btime = $_GET["btime"];
		} else {
			$this->btime = '';
		}
		if (isset($_GET["etime"]) && trim($_GET["etime"]) != '') {
			$etime = date("Y-m-d 23:59:59", strtotime($_GET["etime"]));
			$str .= " and regtime<='" . $etime . "'";
			$this->etime = $_GET["etime"];
		} else {
			$this->etime = '';
		}
		$count = M("member")->where($str)->count();
		$Page = new Page($count, 10);
		$show = $Page->show();
		$rs = M("member")->where($str)->order("nid desc")->limit($Page->firstRow . "," . $Page->listRows)->select();
		$this->page = $show;
		$this->count = $count;
		$i = 0;
		while ($i < count($rs)) {
			$rt = M("member")->where("nid=" . $rs[$i]["referee_id"])->find();
			if ($rt) {
				$rs[$i]["inviter"] = $rt["mobile"];
			} else {
				$rs[$i]["inviter"] = "无";
			}
			$i++;
		}
		$this->rs = $rs;
		$this->display();
	}
	public function passenger_list()
	{
		$this->mb();
		$str = " uniacid=" . $this->uniacid . " and  nclass=1 ";
		if (isset($_GET["nstatus"]) && intval($_GET["nstatus"]) > 0) {
			$nstatus = intval($_GET["nstatus"]);
			$str .= " and nstatus='" . $nstatus . "'";
			$this->nstatus = $_GET["nstatus"];
		} else {
			$this->nstatus = 0;
		}
		if (isset($_GET["mobile"]) && trim($_GET["mobile"]) != '') {
			$mobile = trim($_GET["mobile"]);
			$str .= " and mobile='" . $mobile . "'";
			$this->mobile = $_GET["mobile"];
		} else {
			$this->mobile = '';
		}
		if (isset($_GET["btime"]) && trim($_GET["btime"]) != '') {
			$btime = date("Y-m-d 00:00:00", strtotime($_GET["btime"]));
			$str .= " and regtime>='" . $btime . "'";
			$this->btime = $_GET["btime"];
		} else {
			$this->btime = '';
		}
		if (isset($_GET["etime"]) && trim($_GET["etime"]) != '') {
			$etime = date("Y-m-d 23:59:59", strtotime($_GET["etime"]));
			$str .= " and regtime<='" . $etime . "'";
			$this->etime = $_GET["etime"];
		} else {
			$this->etime = '';
		}
		$count = M("member")->where($str)->count();
		$Page = new Page($count, 10);
		$show = $Page->show();
		$rs = M("member")->where($str)->order("nid desc")->limit($Page->firstRow . "," . $Page->listRows)->select();
		$this->page = $show;
		$this->count = $count;
		$i = 0;
		while ($i < count($rs)) {
			$rt = M("member")->where("nid=" . $rs[$i]["referee_id"])->find();
			if ($rt) {
				$rs[$i]["inviter"] = $rt["mobile"];
			} else {
				$rs[$i]["inviter"] = "无";
			}
			$i++;
		}
		$this->rs = $rs;
		$this->display();
	}
	public function modi()
	{
		$this->mb();
		if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
			$this->error("非法操作");
		}
		$nid = intval($_GET["nid"]);
		$rs = M("member")->where("nid=" . $nid)->find();
		$this->nid = $nid;
		$this->rs = $rs;
		$this->display();
	}
	public function modihandle()
	{
		$this->mb();
		if (!IS_POST || intval($_POST["nid"]) <= 0) {
			$this->error("非法操作");
		}
		$nid = I("nid", 0, "intval");
		$rs = M("member")->where("nid='" . $nid . "'")->find();
		if (!$rs) {
			$this->error("记录不存在");
		}
		unset($_POST["nid"]);
		M("member")->where("nid=" . $nid)->data($_POST)->save();
		$this->success("修改成功", U("Admin/Personmember/index"));
	}
	public function del()
	{
		$this->mb();
		if (!IS_GET || intval($_GET["nid"]) <= 0) {
			$this->error("非法操作");
		}
		$nid = intval($_GET["nid"]);
		if (M("member")->where("nid=" . $nid)->data(array("nstatus" => 2))->save()) {
			$this->success("删除成功");
		} else {
			$this->error("删除失败");
		}
	}
	public function alldel()
	{
		$this->mb();
		if (!IS_POST || trim($_POST["allid"]) == '') {
			$this->error("非法操作");
		}
		$allid = substr(trim($_POST["allid"]), 0, -1);
		if ($allid == '') {
			$this->error("非法操作");
		}
		if (M("member")->where(" nid in (" . $allid . ")")->data(array("nstatus" => 2))->save()) {
			$data = array("status" => 1, "retDesc" => "操作成功");
		} else {
			$data = array("status" => 0, "retDesc" => "操作失败");
		}
		$this->ajaxReturn($data);
	}
	public function log()
	{
		$this->mb();
		if (!isset($_GET["m_id"]) || trim($_GET["m_id"]) == '') {
			$this->error("非法操作");
		}
		$str = " uniacid=" . $this->uniacid . " ";
		$m_id = intval($_GET["m_id"]);
		$this->m_id = $m_id;
		if (isset($_GET["mobile"]) && trim($_GET["mobile"]) != '') {
			$mobile = trim($_GET["mobile"]);
			$str .= " and  mobile='" . $mobile . "'";
			$this->mobile = $mobile;
		} else {
			$this->mobile = '';
		}
		if (isset($_GET["btime"]) && trim($_GET["btime"]) != '') {
			$btime = trim($_GET["btime"]);
			$str .= " and  addtime>='" . date("Y-m-d 00:00:00", strtotime($btime)) . "'";
			$this->btime = $btime;
		} else {
			$this->btime = '';
		}
		if (isset($_GET["etime"]) && trim($_GET["etime"]) != '') {
			$etime = trim($_GET["etime"]);
			$str .= " and  addtime<='" . date("Y-m-d 23:59:59", strtotime($etime)) . "'";
			$this->etime = $etime;
		} else {
			$this->etime = '';
		}
		$str .= " and  m_id='" . $m_id . "'";
		$count = M("member_log")->where($str)->count();
		$this->count = $count;
		$Page = new Page($count, 20);
		$show = $Page->show();
		$this->page = $show;
		$rs = M("member_log")->limit($Page->firstRow . "," . $Page->listRows)->where($str)->order("nid desc")->select();
		if ($rs) {
			$i = 0;
			while ($i < count($rs)) {
				$res = M("member")->where("nid='" . $rs[$i]["m_id"] . "'")->find();
				if ($res) {
					$rs[$i]["wx_nickname"] = $res["wx_nickname"];
				} else {
					$rs[$i]["wx_nickname"] = "无";
				}
				$i++;
			}
		}
		$this->rs = $rs;
		$this->display();
	}
	public function log_del1()
	{
		$this->mb();
		if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
			$this->error("非法操作");
		}
		$nid = intval($_GET["nid"]);
		if (M("member_log")->where(array("nid" => $nid))->delete()) {
			$this->success("删除成功");
		} else {
			$this->error("删除失败");
		}
	}
	public function log_alldel1()
	{
		$this->mb();
		if (!isset($_POST["allid"]) || trim($_POST["allid"]) == '') {
			$this->error("非法操作");
		}
		$allid = substr(trim($_POST["allid"]), 0, -1);
		if (M("member_log")->where("nid in (" . $allid . ")")->delete()) {
			$data = array("status" => 1, "retDesc" => "删除成功");
		} else {
			$data = array("status" => 0, "retDesc" => "删除失败");
		}
		$this->ajaxReturn($data);
	}
	public function log_del()
	{
		$this->mb();
		if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
			$this->error("非法操作");
		}
		$nid = intval($_GET["nid"]);
		if (M("member_verycode_log")->where(array("nid" => $nid))->delete()) {
			$this->success("删除成功");
		} else {
			$this->error("删除失败");
		}
	}
	public function log_alldel()
	{
		$this->mb();
		if (!isset($_POST["allid"]) || trim($_POST["allid"]) == '') {
			$this->error("非法操作");
		}
		$allid = substr(trim($_POST["allid"]), 0, -1);
		if (M("member_verycode_log")->where("nid in (" . $allid . ")")->delete()) {
			$data = array("status" => 1, "retDesc" => "删除成功");
		} else {
			$data = array("status" => 0, "retDesc" => "删除失败");
		}
		$this->ajaxReturn($data);
	}
	public function wash_alldel()
	{
		$this->mb();
		if (!isset($_POST["allid"]) || trim($_POST["allid"]) == '') {
			$this->error("非法操作");
		}
		$allid = substr(trim($_POST["allid"]), 0, -1);
		if (M("car_owner_notes")->where("nid in (" . $allid . ")")->delete()) {
			$data = array("status" => 1, "retDesc" => "删除成功");
		} else {
			$data = array("status" => 0, "retDesc" => "删除失败");
		}
		$this->ajaxReturn($data);
	}
	public function loginlog()
	{
		$this->mb();
		$str = " uniacid=" . $this->uniacid . " ";
		if (isset($_GET["mobile"]) && trim($_GET["mobile"]) != '') {
			$mobile = trim($_GET["mobile"]);
			$str .= " and mobile='" . $mobile . "'";
			$this->mobile = $mobile;
		} else {
			$this->mobile = '';
		}
		if (isset($_GET["status"]) && intval($_GET["status"])) {
			$str .= " and status='" . intval($_GET["status"]) . "'";
			$this->status = intval($_GET["status"]);
		} else {
			$this->status = 0;
		}
		$count = M("member_verycode_log")->where($str)->count();
		$this->count = $count;
		$Page = new Page($count, 13);
		$show = $Page->show();
		$this->page = $show;
		$rs = M("member_verycode_log")->limit($Page->firstRow . "," . $Page->listRows)->where($str)->order("nid desc")->select();
		if ($rs) {
			$i = 0;
			while ($i < count($rs)) {
				$res = M("member")->where("mobile='" . $rs[$i]["mobile"] . "' and uniacid=" . $this->uniacid)->find();
				if ($res) {
					$rs[$i]["name"] = $res["wx_nickname"];
				} else {
					$rs[$i]["name"] = "没有注册";
				}
				$i++;
			}
		}
		$this->rs = $rs;
		$this->display();
	}
	public function deposit_list()
	{
		$this->mb();
		$str = " uniacid=" . $this->uniacid;
		if (isset($_GET["btime"]) && trim($_GET["btime"]) != '') {
			$btime = trim($_GET["btime"]);
			$str .= " and  overtime>='" . date("Y-m-d 00:00:00", strtotime($btime)) . "'";
			$this->btime = $btime;
		} else {
			$this->btime = '';
		}
		if (isset($_GET["etime"]) && trim($_GET["etime"]) != '') {
			$etime = trim($_GET["etime"]);
			$str .= " and  overtime<='" . date("Y-m-d 23:59:59", strtotime($etime)) . "'";
			$this->etime = $etime;
		} else {
			$this->etime = '';
		}
		if (isset($_GET["mobile"]) && trim($_GET["mobile"]) != '') {
			$mobile = trim($_GET["mobile"]);
			$str .= " and mobile='" . $mobile . "'";
			$this->mobile = $mobile;
		} else {
			$this->mobile = '';
		}
		if (isset($_GET["ispay"]) && intval($_GET["ispay"]) > 0) {
			$str .= " and ispay='" . intval($_GET["ispay"]) . "'";
			$this->ispay = intval($_GET["ispay"]);
		} else {
			$this->ispay = 0;
		}
		$count = M("car_owner_deposit_log")->where($str)->count();
		$this->count = $count;
		$page = new Page($count, 10);
		$limit = $page->firstRow . "," . $page->listRows;
		$this->page = $page->show();
		$rs = M("car_owner_deposit_log")->order("nid desc")->where($str)->limit($limit)->select();
		$i = 0;
		while ($i < count($rs)) {
			$rt = M("member")->where("nid=" . $rs[$i]["co_id"])->find();
			if ($rt) {
				$rs[$i]["wx_nickname"] = $rt["wx_nickname"];
			} else {
				$rs[$i]["wx_nickname"] = "<font color='red'>会员不存在</font>";
			}
			$i++;
		}
		$this->rs = $rs;
		$this->display();
	}
	public function deposit_alldel()
	{
		$this->mb();
		if (!IS_POST || trim($_POST["allid"]) == '') {
			$this->error("非法操作");
		}
		$allid = substr(trim($_POST["allid"]), 0, -1);
		if ($allid == '') {
			$this->error("非法操作");
		}
		if (M("car_owner_deposit_log")->where(" nid in (" . $allid . ")")->delete()) {
			$data = array("status" => 1, "retDesc" => "操作成功");
		} else {
			$data = array("status" => 0, "retDesc" => "操作失败");
		}
		$this->ajaxReturn($data);
	}
	public function passenger_order()
	{
		$this->mb();
		$where = " uniacid=" . $this->uniacid . " ";
		if (isset($_GET["istransfer"]) && intval($_GET["istransfer"]) > 0) {
			$istransfer = intval($_GET["istransfer"]);
			$this->istransfer = $istransfer;
			$where .= " and istransfer=" . $istransfer;
		} else {
			$this->istransfer = 0;
		}
		if (isset($_GET["ordernum"]) && trim($_GET["ordernum"]) != '') {
			$ordernum = trim($_GET["ordernum"]);
			$this->ordernum = $ordernum;
			$where .= " and ordernum='" . $ordernum . "'";
		} else {
			$this->ordernum = '';
		}
		if (isset($_GET["btime"]) && trim($_GET["btime"]) != '') {
			$btime = trim($_GET["btime"]);
			$where .= " and  transaction_time>='" . date("Y-m-d 00:00:00", strtotime($btime)) . "'";
			$this->btime = $btime;
		} else {
			$this->btime = '';
		}
		if (isset($_GET["etime"]) && trim($_GET["etime"]) != '') {
			$etime = trim($_GET["etime"]);
			$where .= " and  transaction_time<='" . date("Y-m-d 23:59:59", strtotime($etime)) . "'";
			$this->etime = $etime;
		} else {
			$this->etime = '';
		}
		$count = M("passenger_order")->where($where)->count();
		$this->count = $count;
		$page = new Page($count, 8);
		$limit = $page->firstRow . "," . $page->listRows;
		$this->page = $page->show();
		$rs = M("passenger_order")->order("nid desc")->where($where)->limit($limit)->select();
		if ($rs) {
			$i = 0;
			while ($i < count($rs)) {
				$rt = M("member")->where("nid=" . $rs[$i]["m_id"])->find();
				$rs[$i]["m_wx_nickname"] = $rt["wx_nickname"];
				$rs[$i]["m_mobile"] = $rt["mobile"];
				if ($rs[$i]["co_id"] > 0) {
					$rt = M("member")->where("nid=" . $rs[$i]["co_id"])->find();
					$rs[$i]["co_wx_nickname"] = $rt["wx_nickname"];
					$rs[$i]["co_mobile"] = $rt["mobile"];
				} else {
					$rs[$i]["co_mobile"] = "无车主接单";
				}
				switch ($rs[$i]["ispay"]) {
					case 1:
						$rs[$i]["ispay"] = "<font color='red'>未支付</font>";
						break;
					case 2:
						$rs[$i]["ispay"] = "<font color='green'>已支付</font>";
						break;
					case 3:
						$rs[$i]["ispay"] = "<font color='blue'>已退款</font>";
						break;
				}
				switch ($rs[$i]["nstatus"]) {
					case 1:
						$rs[$i]["nstatus"] = "<font color='red'>下架</font>";
						break;
					case 2:
						$rs[$i]["nstatus"] = "<font color='green'>上架</font>";
						break;
				}
				switch ($rs[$i]["istransfer"]) {
					case 1:
						$rs[$i]["istransfer1"] = "<font color='red'>否</font>";
						break;
					case 2:
						$rs[$i]["istransfer1"] = "<font color='green'>是</font>";
						break;
					case 3:
						$rs[$i]["istransfer1"] = "<font color='blue'>冻结</font>";
						break;
				}
				$i++;
			}
		}
		$this->rs = $rs;
		$this->display();
	}
	public function passenger_order_alldel()
	{
		$this->mb();
		if (!isset($_POST["allid"]) || trim($_POST["allid"]) == '') {
			$this->error("非法操作");
		}
		$allid = substr(trim($_POST["allid"]), 0, -1);
		$rs = M("passenger_order")->where("nid in (" . $allid . ")")->select();
		if (M("passenger_order")->where("nid in (" . $allid . ")")->delete()) {
			if ($rs) {
				$i = 0;
				while ($i < count($rs)) {
					M("member_complain")->where("cood_id= " . $rs[$i]["nid"])->delete();
					$i++;
				}
			}
			$data = array("status" => 1, "retDesc" => "删除成功");
		} else {
			$data = array("status" => 0, "retDesc" => "删除失败");
		}
		$this->ajaxReturn($data);
	}
	public function refundtopassenger()
	{
		$this->mb();
		if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
			$this->error("参数不正确");
		}
		$nid = intval($_GET["nid"]);
		$rs = M("passenger_order")->where("nid=" . $nid)->find();
		if (!$rs) {
			$this->error("记录不存在");
		}
		$this->getConfig();
		$sj = date("Y-m-d H:i:s");
		$m_id = $rs["m_id"];
		$co_id = $rs["co_id"];
		$car_owner = M("member")->where("nid=" . $co_id)->find();
		$x_deposit = round($car_owner["deposit"] * C("platform.plat_car_owner1") * C("platform.plat_dj_car_owner"), 2);
		$co_deposit = round($car_owner["deposit"] * C("platform.plat_car_owner1"), 2);
		$p_deposit = round($co_deposit - $x_deposit, 2);
		$brr = array("money" => $x_deposit, "ntype" => 3, "addtime" => $sj, "uniacid" => $this->uniacid, "ordernum" => $rs["ordernum"]);
		M("platform_income")->data($brr)->add();
		$brr = array("m_id" => $co_id, "amount_cash" => $co_deposit, "nstatus" => 2, "playmoney_time" => $sj, "reason" => "扣除车主押金", "addtime" => $sj, "nclass" => 3, "ordernum" => $rs["ordernum"], "uniacid" => $this->uniacid, "transaction_time" => $sj);
		$cid = M("withdrawals")->data($brr)->add();
		$brr = array("money" => $p_deposit, "nclass" => 7, "addtime" => $sj, "m_id" => $m_id, "pid" => $cid, "uniacid" => $this->uniacid, "ntype" => 1);
		M("revenue_detail")->data($brr)->add();
		$arr = pc_passenger_task_refund($rs["ordernum"], $rs["transaction_id"], round($rs["money"] - $rs["redpacked"], 2) * 100);
		if ($arr["result_code"] == "SUCCESS" && $arr["return_code"] == "SUCCESS") {
			M("member")->where("nid=" . $m_id)->setInc("account_amount", $p_deposit);
			M("member")->where("nid=" . $co_id)->setDec("deposit", $co_deposit);
			if ($rs["redpacked"]) {
				M("member")->where("nid=" . $m_id)->setInc("redpacked", $rs["redpacked"]);
				$brr = array("m_id" => $m_id, "money" => $rs["redpacked"], "ntype" => 1, "addtime" => $sj, "uniacid" => $this->uniacid, "note" => "退款红包");
				M("redpacked_detail")->data($brr)->add();
			}
			$field = array("ispay" => 3, "isreceipt" => 3, "istransfer" => 2, "isstart" => 3);
			M("passenger_order")->where("nid=" . $nid)->setField($field);
			$rt = M("member")->where("nid=" . $rs["m_id"])->find();
			$rx = M("member")->where("nid=" . $rs["co_id"])->find();
			$paramString = "{\"ordernum\":\"" . $rs["ordernum"] . "\",\"starting_place\":\"" . $rs["starting_place"] . "\",\"end_place\":\"" . $rs["end_place"] . "\"}";
			send_aliyun_msg($rt["mobile"], C("ali_sms.sms22"), $paramString);
			send_aliyun_msg($rx["mobile"], C("ali_sms.sms22"), $paramString);
			if (C("passenger_awards_status") == 2) {
				if (C("passenger_awards_type") == 1) {
					M("member")->where("nid=" . $m_id)->setInc("redpacked", C("passenger_awards_value"));
				} else {
					$money = round($rs["money"] * C("passenger_awards_value") / 100, 2);
					M("member")->where("nid=" . $m_id)->setInc("redpacked", $money);
				}
			}
			$this->success("操作成功");
		} else {
			$this->error("退款操作失败");
		}
	}
	public function transfertocar_owner()
	{
		$this->mb();
		if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
			$this->error("参数不正确");
		}
		$nid = intval($_GET["nid"]);
		$rs = M("passenger_order")->where("nid=" . $nid)->find();
		if (!$rs) {
			$this->error("记录不存在");
		}
		$this->getConfig();
		$sj = date("Y-m-d H:i:s");
		$m_id = $rs["m_id"];
		$co_id = $rs["co_id"];
		$redpacked = $rs["redpacked"];
		$x_money = round($rs["money"] * C("platform.plat_passenger2") * C("platform.plat_dj_passenger"), 2);
		$s_money = round($rs["money"] * C("platform.plat_passenger2"), 2);
		$car_owner_money = round($s_money - $x_money, 2);
		$t_money = round($rs["money"] - $s_money, 2);
		$brr = array("money" => $x_money, "ntype" => 3, "addtime" => $sj, "uniacid" => $this->uniacid, "ordernum" => $rs["ordernum"]);
		M("platform_income")->data($brr)->add();
		$brr = array("m_id" => $co_id, "amount_cash" => $car_owner_money, "nstatus" => 2, "playmoney_time" => $sj, "reason" => "扣除车位费", "addtime" => $sj, "nclass" => 4, "ordernum" => $rs["ordernum"], "uniacid" => $this->uniacid, "transaction_time" => $sj);
		$cid = M("withdrawals")->data($brr)->add();
		$brr = array("money" => $car_owner_money, "nclass" => 7, "addtime" => $sj, "m_id" => $co_id, "pid" => $cid, "uniacid" => $this->uniacid, "ntype" => 1);
		M("revenue_detail")->data($brr)->add();
		M("member")->where("nid=" . $co_id)->setInc("account_amount", $car_owner_money);
		if ($t_money > $redpacked) {
			$arr = pc_order_refund($rs["ordernum"], $rs["transaction_id"], round($rs["money"] - $redpacked, 2) * 100, round($t_money - $redpacked, 2) * 100);
			if ($arr["result_code"] == "SUCCESS" && $arr["return_code"] == "SUCCESS") {
				M("member")->where("nid=" . $m_id)->setInc("redpacked", $rs["redpacked"]);
				if ($rs["redpacked"]) {
					$brr = array("m_id" => $m_id, "money" => $rs["redpacked"], "ntype" => 1, "addtime" => $sj, "uniacid" => $this->uniacid, "note" => "退款红包");
					M("redpacked_detail")->data($brr)->add();
				}
				$field = array("ispay" => 3, "isreceipt" => 3, "istransfer" => 2, "uniacid" => $this->uniacid, "isstart" => 3);
				M("passenger_order")->where("nid=" . $nid)->setField($field);
				$rt = M("member")->where("nid=" . $rs["m_id"])->find();
				$rx = M("member")->where("nid=" . $rs["co_id"])->find();
				$paramString = "{\"ordernum\":\"" . $rs["ordernum"] . "\",\"starting_place\":\"" . $rs["starting_place"] . "\",\"end_place\":\"" . $rs["end_place"] . "\"}";
				send_aliyun_msg($rt["mobile"], C("ali_sms.sms22"), $paramString);
				send_aliyun_msg($rx["mobile"], C("ali_sms.sms22"), $paramString);
				if (C("co_awards_status") == 2) {
					if (C("co_awards_type") == 1) {
						M("member")->where("nid=" . $co_id)->setInc("account_amount", C("co_awards_value"));
					} else {
						$money = round($rs["money"] * C("co_awards_value") / 100, 2);
						M("member")->where("nid=" . $co_id)->setInc("account_amount", $money);
					}
				}
				$this->success("操作成功");
			} else {
				$this->error("退款操作失败");
			}
		} else {
			M("member")->where("nid=" . $m_id)->setInc("redpacked", $t_money);
			if ($t_money) {
				$brr = array("m_id" => $m_id, "money" => $t_money, "ntype" => 1, "addtime" => $sj, "uniacid" => $this->uniacid, "note" => "退款红包");
				M("redpacked_detail")->data($brr)->add();
			}
			$field = array("ispay" => 3, "isreceipt" => 3, "istransfer" => 2, "isstart" => 3);
			M("passenger_order")->where("nid=" . $nid)->setField($field);
			$rt = M("member")->where("nid=" . $rs["m_id"])->find();
			$rx = M("member")->where("nid=" . $rs["co_id"])->find();
			$paramString = "{\"ordernum\":\"" . $rs["ordernum"] . "\",\"starting_place\":\"" . $rs["starting_place"] . "\",\"end_place\":\"" . $rs["end_place"] . "\"}";
			send_aliyun_msg($rt["mobile"], C("ali_sms.sms22"), $paramString);
			send_aliyun_msg($rx["mobile"], C("ali_sms.sms22"), $paramString);
			$this->success("操作成功");
		}
	}
	public function member_complain()
	{
		$this->mb();
		if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
			$this->error("非法操作");
		}
		$nid = I("nid", 0, "intval");
		$where = "cood_id=" . $nid . " and uniacid=" . $this->uniacid . " ";
		$count = M("member_complain")->where($where)->count();
		$this->count = $count;
		$page = new Page($count, 10);
		$limit = $page->firstRow . "," . $page->listRows;
		$this->page = $page->show();
		$rs = M("member_complain")->order("nid desc")->where($where)->limit($limit)->select();
		$i = 0;
		while ($i < count($rs)) {
			$rt = M("member")->where("nid=" . $rs[$i]["m_id"])->find();
			$rs[$i]["mobile"] = $rt["mobile"];
			if ($rs[$i]["nclass"] > 0) {
				if ($rs[$i]["nclass"] == 1) {
					$rs[$i]["nclass"] = "乘客:";
				} else {
					$rs[$i]["nclass"] = "车主:";
				}
			} else {
				$rs[$i]["nclass"] = "无：";
			}
			$pic = explode(",", $rs[$i]["picpath"]);
			$arr = array();
			foreach ($pic as $k => $v) {
				array_push($arr, $v);
			}
			$rs[$i]["picpath"] = $arr;
			$rt = M("passenger_order")->where("nid=" . $rs[$i]["cood_id"])->find();
			$rs[$i]["ordernum"] = $rt["ordernum"];
			$i++;
		}
		$this->rs = $rs;
		$this->display();
	}
	public function car_owner_order()
	{
		$this->mb();
		$where = " uniacid=" . $this->uniacid . " ";
		if (isset($_GET["isreceipt"]) && intval($_GET["isreceipt"]) > 0) {
			$isreceipt = intval($_GET["isreceipt"]);
			$this->isreceipt = $isreceipt;
			$where .= " and isreceipt=" . $isreceipt;
		} else {
			$this->isreceipt = 0;
		}
		if (isset($_GET["is_flag"]) && intval($_GET["is_flag"]) > 0) {
			$is_flag = intval($_GET["is_flag"]);
			$this->is_flag = $is_flag;
			$where .= " and is_flag=" . $is_flag;
		} else {
			$this->is_flag = 0;
		}
		if (isset($_GET["cancel_order"]) && intval($_GET["cancel_order"]) > 0) {
			$cancel_order = intval($_GET["cancel_order"]);
			$this->cancel_order = $cancel_order;
			$where .= " and cancel_order=" . $cancel_order;
		} else {
			$this->cancel_order = 0;
		}
		if (isset($_GET["ordernum"]) && trim($_GET["ordernum"]) != '') {
			$ordernum = trim($_GET["ordernum"]);
			$this->ordernum = $ordernum;
			$where .= " and ordernum='" . $ordernum . "'";
		} else {
			$this->ordernum = '';
		}
		if (isset($_GET["btime"]) && trim($_GET["btime"]) != '') {
			$btime = trim($_GET["btime"]);
			$where .= " and  addtime>='" . date("Y-m-d 00:00:00", strtotime($btime)) . "'";
			$this->btime = $btime;
		} else {
			$this->btime = '';
		}
		if (isset($_GET["etime"]) && trim($_GET["etime"]) != '') {
			$etime = trim($_GET["etime"]);
			$where .= " and  addtime<='" . date("Y-m-d 23:59:59", strtotime($etime)) . "'";
			$this->etime = $etime;
		} else {
			$this->etime = '';
		}
		$count = M("car_owner_order")->where($where)->count();
		$this->count = $count;
		$page = new Page($count, 8);
		$limit = $page->firstRow . "," . $page->listRows;
		$this->page = $page->show();
		$rs = M("car_owner_order")->order("nid desc")->where($where)->limit($limit)->select();
		if ($rs) {
			$i = 0;
			while ($i < count($rs)) {
				$rt = M("member")->where("nid=" . $rs[$i]["co_id"])->find();
				$rs[$i]["m_wx_nickname"] = $rt["wx_nickname"];
				$rs[$i]["m_mobile"] = $rt["mobile"];
				switch ($rs[$i]["nstatus"]) {
					case 1:
						$rs[$i]["nstatus1"] = "<font color='red'>下架</font>";
						break;
					case 2:
						$rs[$i]["nstatus1"] = "<font color='green'>上架</font>";
						break;
				}
				switch ($rs[$i]["isreceipt"]) {
					case 1:
						$rs[$i]["isreceipt1"] = "<font color='red'>无人接单</font>";
						break;
					case 2:
						$rs[$i]["isreceipt1"] = "<font color='green'>已接单</font>";
						break;
					case 3:
						$rs[$i]["isreceipt1"] = "<font color='blue'>行程结束</font>";
						break;
				}
				switch ($rs[$i]["cancel_order"]) {
					case 1:
						$rs[$i]["cancel_order1"] = "<font color='red'>否</font>";
						break;
					case 2:
						$rs[$i]["cancel_order1"] = "<font color='green'>是</font>";
						break;
					case 3:
						$rs[$i]["cancel_order1"] = "<font color='blue'>冻结</font>";
						break;
					default:
						$rs[$i]["cancel_order1"] = "无";
				}
				$i++;
			}
		}
		$this->rs = $rs;
		$this->display();
	}
	public function car_owner_order_alldel()
	{
		$this->mb();
		if (!isset($_POST["allid"]) || trim($_POST["allid"]) == '') {
			$this->error("非法操作");
		}
		$allid = substr(trim($_POST["allid"]), 0, -1);
		$rs = M("car_owner_order")->where("nid in (" . $allid . ")")->select();
		if (M("car_owner_order")->where("nid in (" . $allid . ")")->delete()) {
			if ($rs) {
				$i = 0;
				while ($i < count($rs)) {
					$rt = M("car_owner_order_details")->where("coo_id= " . $rs[$i]["nid"])->select();
					M("car_owner_order_details")->where("coo_id= " . $rs[$i]["nid"])->delete();
					$k = 0;
					while ($k < count($rt)) {
						M("car_owner_order_complain")->where("pid= " . $rt[$k]["nid"])->delete();
						$k++;
					}
					$i++;
				}
			}
			$data = array("status" => 1, "retDesc" => "删除成功");
		} else {
			$data = array("status" => 0, "retDesc" => "删除失败");
		}
		$this->ajaxReturn($data);
	}
	public function car_owner_order_details()
	{
		$this->mb();
		if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
			$this->error("非法操作");
		}
		$nid = intval($_GET["nid"]);
		$this->nid = $nid;
		$where = "uniacid=" . $this->uniacid . " and coo_id=" . $nid;
		if (!isset($_GET["ispay"]) || intval($_GET["ispay"]) <= 0) {
			$this->ispay = 0;
		} else {
			$ispay = intval($_GET["ispay"]);
			$where .= " and ispay=" . $ispay;
			$this->ispay = $ispay;
		}
		if (!isset($_GET["cancel_order"]) || intval($_GET["cancel_order"]) <= 0) {
			$this->cancel_order = 0;
		} else {
			$cancel_order = intval($_GET["cancel_order"]);
			$where .= " and cancel_order=" . $cancel_order;
			$this->cancel_order = $cancel_order;
		}
		if (!isset($_GET["istransfer"]) || intval($_GET["istransfer"]) <= 0) {
			$this->istransfer = 0;
		} else {
			$istransfer = intval($_GET["istransfer"]);
			$where .= " and istransfer=" . $istransfer;
			$this->istransfer = $istransfer;
		}
		$count = M("car_owner_order_details")->where($where)->count();
		$this->count = $count;
		$page = new Page($count, 10);
		$limit = $page->firstRow . "," . $page->listRows;
		$this->page = $page->show();
		$rs = M("car_owner_order_details")->order("nid desc")->where($where)->limit($limit)->select();
		if ($rs) {
			$i = 0;
			while ($i < count($rs)) {
				$rt = M("car_owner_order")->where("nid=" . $rs[$i]["coo_id"])->find();
				$rs[$i]["ordernum"] = $rt["ordernum"];
				$rt = M("member")->where("nid=" . $rt["co_id"])->find();
				$rs[$i]["c_wx_nickname"] = $rt["wx_nickname"];
				$rs[$i]["c_mobile"] = $rt["mobile"];
				$rt = M("member")->where("nid=" . $rs[$i]["m_id"])->find();
				$rs[$i]["m_wx_nickname"] = $rt["wx_nickname"];
				$rs[$i]["m_mobile"] = $rt["mobile"];
				$rt = M("car_owner_order_station")->where("id=" . $rs[$i]["coos_id"])->find();
				$rs[$i]["starting_place"] = $rt["starting_place"];
				$rs[$i]["end_place"] = $rt["end_place"];
				switch ($rs[$i]["ispay"]) {
					case 1:
						$rs[$i]["ispay1"] = "未支付";
						break;
					case 2:
						$rs[$i]["ispay1"] = "已支付";
						break;
					case 3:
						$rs[$i]["ispay1"] = "已退款";
						break;
				}
				switch ($rs[$i]["cancel_order"]) {
					case 0:
						$rs[$i]["cancel_order1"] = "无";
						break;
					case 1:
						$rs[$i]["cancel_order1"] = "协商取消";
						break;
					case 2:
						$rs[$i]["cancel_order1"] = "直接取消";
						break;
					case 3:
						$rs[$i]["cancel_order1"] = "无法联系乘客";
						break;
				}
				switch ($rs[$i]["istransfer"]) {
					case 0:
						$rs[$i]["istransfer1"] = "无";
						break;
					case 1:
						$rs[$i]["istransfer1"] = "申请划款";
						break;
					case 2:
						$rs[$i]["istransfer1"] = "已划款";
						break;
					case 3:
						$rs[$i]["istransfer1"] = "冻结";
						break;
				}
				$i++;
			}
		}
		$this->rs = $rs;
		$this->display();
	}
	public function car_owner_order_complain()
	{
		$this->mb();
		if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
			$this->error("非法操作");
		} else {
			$nid = intval($_GET["nid"]);
			$this->nid = $nid;
		}
		if (!isset($_GET["pid"]) || intval($_GET["pid"]) <= 0) {
			$this->error("非法操作");
		} else {
			$pid = intval($_GET["pid"]);
			$this->pid = $pid;
		}
		$where = " uniacid=" . $this->uniacid . " and pid=" . $nid;
		$res = M("car_owner_order")->where("nid=" . $pid)->find();
		$this->ordernum = $res["ordernum"];
		$count = M("car_owner_order_complain")->where($where)->count();
		$this->count = $count;
		$page = new Page($count, 10);
		$limit = $page->firstRow . "," . $page->listRows;
		$this->page = $page->show();
		$rs = M("car_owner_order_complain")->where($where)->limit($limit)->order("nid desc")->select();
		if ($rs) {
			$i = 0;
			while ($i < count($rs)) {
				$rt = M("member")->where("nid=" . $rs[$i]["m_id"])->find();
				$rs[$i]["m_mobile"] = $rt["mobile"];
				switch ($rs[$i]["nstatus"]) {
					case 1:
						$rs[$i]["nstatus"] = "未处理";
						break;
					case 2:
						$rs[$i]["nstatus"] = "通过";
						break;
					case 3:
						$rs[$i]["nstatus"] = "拒绝";
						break;
				}
				if ($rs[$i]["nclass"] > 0) {
					if ($rs[$i]["nclass"] == 1) {
						$rs[$i]["nclass"] = "乘客:";
					} else {
						$rs[$i]["nclass"] = "车主:";
					}
				} else {
					$rs[$i]["nclass"] = "无：";
				}
				$pic = explode(",", $rs[$i]["picpath"]);
				$arr = array();
				foreach ($pic as $k => $v) {
					array_push($arr, $v);
				}
				$rs[$i]["picpath"] = $arr;
				$i++;
			}
		}
		$this->rs = $rs;
		$this->display();
	}
	public function car_owner_order_refundtopassenger()
	{
		$this->mb();
		if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
			$this->error("参数不正确");
		}
		$nid = intval($_GET["nid"]);
		$rs = M("car_owner_order_details")->where("istransfer=3 and nid=" . $nid)->find();
		if (!$rs) {
			$this->error("记录不存在");
		}
		$this->getConfig();
		$rt = M("car_owner_order")->where("nid=" . $rs["coo_id"])->find();
		$rtp = M("car_owner_order_station")->where("id=" . $rs["coos_id"])->find();
		$co_id = $rt["co_id"];
		$m_id = $rs["m_id"];
		$sj = date("Y-m-d H:i:s");
		$ordernum = $rt["ordernum"];
		$starting_place = $rtp["starting_place"];
		$end_place = $rtp["end_place"];
		$car_owner = M("member")->where("nid=" . $co_id)->find();
		$x_deposit = round($car_owner["deposit"] * C("platform.plat_car_owner1") * C("platform.plat_dj_car_owner"), 2);
		$s_deposit = round($car_owner["deposit"] * C("platform.plat_car_owner1"), 2);
		$p_deposit = round($s_deposit - $x_deposit, 2);
		$brr = array("money" => $x_deposit, "ntype" => 3, "addtime" => $sj, "uniacid" => $this->uniacid, "ordernum" => $rt["ordernum"]);
		M("platform_income")->data($brr)->add();
		$count = M("car_owner_order_details")->where("istransfer=3 and coo_id=" . $rs["coo_id"])->count();
		$m_deposit = round($p_deposit / $count, 2);
		$res = M("car_owner_order_details")->where("istransfer=3 and coo_id=" . $rs["coo_id"])->select();
		M("member")->where("nid=" . $co_id)->setDec("deposit", $s_deposit);
		$brr = array("m_id" => $co_id, "amount_cash" => $s_deposit, "nstatus" => 2, "playmoney_time" => $sj, "reason" => "扣除车主押金", "addtime" => $sj, "nclass" => 3, "ordernum" => $rs["ordernum"], "uniacid" => $this->uniacid, "transaction_time" => $sj);
		$cid = M("withdrawals")->data($brr)->add();
		$brr = array("money" => $s_deposit, "nclass" => 7, "addtime" => $sj, "m_id" => $m_id, "pid" => $cid, "uniacid" => $this->uniacid, "ntype" => 2);
		M("revenue_detail")->data($brr)->add();
		$i = 0;
		while ($i < count($res)) {
			$rt = M("member")->where("nid=" . $res[$i]["m_id"])->find();
			$brr = array("m_id" => $rt["nid"], "amount_cash" => $m_deposit, "nstatus" => 2, "playmoney_time" => $sj, "reason" => "扣除车主押金", "addtime" => $sj, "nclass" => 3, "ordernum" => $res["ordernum"], "uniacid" => $this->uniacid, "transaction_time" => $sj);
			$cid = M("withdrawals")->data($brr)->add();
			$brr = array("money" => $m_deposit, "nclass" => 7, "addtime" => $sj, "m_id" => $rt["nid"], "pid" => $cid, "uniacid" => $this->uniacid, "ntype" => 2);
			M("revenue_detail")->data($brr)->add();
			$arr = pc_passenger_task_refund($res[$i]["ordernum"], $res[$i]["transaction_id"], round($res[$i]["ntotal"] - $res[$i]["redpacked"], 2) * 100);
			if ($arr["result_code"] == "SUCCESS" && $arr["return_code"] == "SUCCESS") {
				M("member")->where("nid=" . $rt["nid"])->setInc("account_amount", $m_deposit);
				if ($res[$i]["redpacked"]) {
					M("member")->where("nid=" . $res[$i]["m_id"])->setInc("redpacked", $res[$i]["redpacked"]);
					$brr = array("m_id" => $res[$i]["m_id"], "money" => $res[$i], "ntype" => 1, "addtime" => $sj, "uniacid" => $this->uniacid, "note" => "退款红包");
					M("redpacked_detail")->data($brr)->add();
				}
				$field = array("ispay" => 3, "istransfer" => 2, "isstart" => 3);
				M("car_owner_order_details")->where("nid=" . $res[$i]["nid"])->setField($field);
				$rt = M("member")->where("nid=" . $res[$i]["m_id"])->find();
				$rx = M("member")->where("nid=" . $co_id)->find();
				$paramString = "{\"ordernum\":\"" . $ordernum . "\",\"starting_place\":\"" . $starting_place . "\",\"end_place\":\"" . $end_place . "\"}";
				send_aliyun_msg($rt["mobile"], C("ali_sms.sms22"), $paramString);
				send_aliyun_msg($rx["mobile"], C("ali_sms.sms22"), $paramString);
				if (C("passenger_awards_status") == 2) {
					if (C("passenger_awards_type") == 1) {
						M("member")->where("nid=" . $res[$i]["m_id"])->setInc("redpacked", C("passenger_awards_value"));
					} else {
						$money = round($res[$i]["ntotal"] * C("passenger_awards_value") / 100, 2);
						M("member")->where("nid=" . $res[$i]["m_id"])->setInc("redpacked", $money);
					}
				}
			} else {
				$this->error("退款操作失败");
			}
			$i++;
		}
		$res = M("car_owner_order_details")->where("ispay=2 and istransfer<>2 and isstart!=3 and coo_id=" . $rs["coo_id"])->select();
		if (!$res) {
			$field = array("nstatus" => 1, "isreceipt" => 3, "is_flag" => 1);
			M("car_owner_order")->where("nid=" . $rs["coo_id"])->setField($field);
			$field = array("nstatus" => 1, "isreceipt" => 3);
			M("car_owner_order_station")->where("coo_id=" . $rs["coo_id"])->setField($field);
		}
		$this->success("操作成功");
	}
	public function car_owner_order_transfertocar_owner()
	{
		$this->mb();
		if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
			$this->error("参数不正确");
		}
		$nid = intval($_GET["nid"]);
		$rs = M("car_owner_order_details")->where("istransfer=3 and nid=" . $nid)->find();
		if (!$rs) {
			$this->error("记录不存在");
		}
		$redpacked = $rs["redpacked"];
		$this->getConfig();
		$rt = M("car_owner_order")->where("nid=" . $rs["coo_id"])->find();
		$co_id = $rt["co_id"];
		$m_id = $rs["m_id"];
		$ordernum = $rt["ordernum"];
		$rtp = M("car_owner_order_station")->where("id=" . $rs["coos_id"])->find();
		$starting_place = $rtp["starting_place"];
		$end_place = $rtp["end_place"];
		$sj = date("Y-m-d H:i:s");
		$car_owner = M("member")->where("nid=" . $m_id)->find();
		$x_deposit = round($rs["ntotal"] * C("platform.plat_passenger2") * C("platform.plat_dj_passenger"), 2);
		$s_deposit = round($rs["ntotal"] * C("platform.plat_passenger2"), 2);
		$p_deposit = round($s_deposit - $x_deposit, 2);
		$t_deposit = round($rs["ntotal"] - $s_deposit, 2);
		$brr = array("money" => $x_deposit, "ntype" => 3, "addtime" => $sj, "uniacid" => $this->uniacid, "ordernum" => $rs["ordernum"]);
		M("platform_income")->data($brr)->add();
		$brr = array("m_id" => $co_id, "amount_cash" => $p_deposit, "nstatus" => 2, "playmoney_time" => $sj, "reason" => "扣除乘客车资费用", "addtime" => $sj, "nclass" => 4, "ordernum" => $rs["ordernum"], "uniacid" => $this->uniacid, "transaction_time" => $sj);
		$cid = M("withdrawals")->data($brr)->add();
		$brr = array("money" => $p_deposit, "nclass" => 7, "addtime" => $sj, "m_id" => $co_id, "pid" => $cid, "uniacid" => $this->uniacid, "ntype" => 2);
		M("revenue_detail")->data($brr)->add();
		$field = array("istransfer" => 2, "isstart" => 3);
		M("car_owner_order_details")->where(" nid=" . $nid)->setField($field);
		M("member")->where("nid=" . $co_id)->setInc("account_amount", $p_deposit);
		if ($t_deposit > $redpacked) {
			$arr = pc_order_refund($rs["ordernum"], $rs["transaction_id"], $rs["ntotal"] * 100, round($t_deposit - $redpacked, 2) * 100);
			if ($arr["result_code"] == "SUCCESS" && $arr["return_code"] == "SUCCESS") {
				if ($rs["redpacked"]) {
					M("member")->where("nid=" . $m_id)->setInc("redpacked", $rs["redpacked"]);
					$brr = array("m_id" => $m_id, "money" => $rs["redpacked"], "ntype" => 1, "addtime" => $sj, "uniacid" => $this->uniacid, "note" => "退款红包");
					M("redpacked_detail")->data($brr)->add();
				}
				$rt = M("member")->where("nid=" . $m_id)->find();
				$rx = M("member")->where("nid=" . $co_id)->find();
				$paramString = "{\"ordernum\":\"" . $ordernum . "\",\"starting_place\":\"" . $starting_place . "\",\"end_place\":\"" . $end_place . "\"}";
				send_aliyun_msg($rt["mobile"], C("ali_sms.sms22"), $paramString);
				send_aliyun_msg($rx["mobile"], C("ali_sms.sms22"), $paramString);
				if (C("co_awards_status") == 2) {
					if (C("co_awards_type") == 1) {
						M("member")->where("nid=" . $co_id)->setInc("account_amount", C("co_awards_value"));
					} else {
						$money = round($rs["ntotal"] * C("co_awards_value") / 100, 2);
						M("member")->where("nid=" . $co_id)->setInc("account_amount", $money);
					}
				}
				$rtt = M("car_owner_order_details")->where("ispay=2 and istransfer!=2 and isstart!=3 and coo_id=" . $rs["coo_id"])->select();
				if (!$rtt) {
					$field = array("nstatus" => 1, "isreceipt" => 3, "is_flag" => 1);
				}
				M("car_owner_order")->where("nid=" . $rs["coo_id"])->setField($field);
				$this->success("操作成功");
			} else {
				$this->error("退款操作失败");
			}
		} else {
			M("member")->where("nid=" . $m_id)->setInc("redpacked", $t_deposit);
			if ($t_deposit) {
				$brr = array("m_id" => $m_id, "money" => $t_deposit, "ntype" => 1, "addtime" => $sj, "uniacid" => $this->uniacid, "note" => "退款红包");
				M("redpacked_detail")->data($brr)->add();
			}
			$rt = M("member")->where("nid=" . $m_id)->find();
			$rx = M("member")->where("nid=" . $co_id)->find();
			$paramString = "{\"ordernum\":\"" . $ordernum . "\",\"starting_place\":\"" . $starting_place . "\",\"end_place\":\"" . $end_place . "\"}";
			send_aliyun_msg($rt["mobile"], C("ali_sms.sms22"), $paramString);
			send_aliyun_msg($rx["mobile"], C("ali_sms.sms22"), $paramString);
			$rtt = M("car_owner_order_details")->where("ispay=2 and istransfer!=2 and isstart!=4 and coo_id=" . $rs["coo_id"])->select();
			if (!$rtt) {
				$field = array("nstatus" => 1, "isreceipt" => 3, "is_flag" => 1);
			}
			M("car_owner_order")->where("nid=" . $rs["coo_id"])->setField($field);
			$this->success("操作成功");
		}
	}
	public function car_owner_notes()
	{
		$this->mb();
		$where = "uniacid=" . $this->uniacid;
		$count = M("car_owner_notes")->where($where)->count();
		$this->count = $count;
		$page = new Page($count, 10);
		$limit = $page->firstRow . "," . $page->listRows;
		$this->page = $page->show();
		$rs = M("car_owner_notes")->where($where)->order("nid desc")->limit($limit)->select();
		if ($rs) {
			$i = 0;
			while ($i < count($rs)) {
				if ($rs[$i]["nclass"] == 1) {
					$rs[$i]["nclass1"] = "乘客须知";
				} else {
					$rs[$i]["nclass1"] = "车主须知";
				}
				$i++;
			}
		}
		$this->rs = $rs;
		$this->display();
	}
	public function car_owner_notes_add()
	{
		$this->mb();
		$this->display();
	}
	public function car_owner_notes_addhandle()
	{
		$this->mb();
		$param = I("post.");
		if (trim($param["note"]) == '' && trim($param["chotline"]) == '') {
			$this->error("非法操作 ");
		}
		$param["addtime"] = date("Y-m-d H:i:s");
		$param["uniacid"] = $this->uniacid;
		M("car_owner_notes")->data($param)->add();
		$this->success("操作成功");
	}
	public function car_owner_notes_modi()
	{
		$this->mb();
		if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
			$this->error("非法操作");
		}
		$nid = intval($_GET["nid"]);
		$rs = M("car_owner_notes")->where("nid=" . $nid)->find();
		$this->rs = $rs;
		$this->display();
	}
	public function car_owner_notes_modihandle()
	{
		$this->mb();
		if (!IS_POST || !isset($_POST["nid"]) || intval($_POST["nid"]) <= 0) {
			$this->error("非法操作");
		}
		$nid = intval($_GET["nid"]);
		M("car_owner_notes")->data($_POST)->save();
		$this->success("操作成功", U("car_owner_notes"));
	}
	public function car_owner_share()
	{
		$this->mb();
		$where = "uniacid=" . $this->uniacid . " ";
		if (!isset($_GET["nstatus"]) || intval($_GET["nstatus"]) == -1) {
			$this->nstatus = -1;
		} else {
			$nstatus = intval($_GET["nstatus"]);
			$where .= " and nstatus=" . $nstatus;
			$this->nstatus = $nstatus;
		}
		if (!isset($_GET["ntype"]) || intval($_GET["ntype"]) <= 0) {
			$this->ntype = 0;
		} else {
			$ntype = intval($_GET["ntype"]);
			$this->ntype = $ntype;
			$where .= " and ntype=" . $ntype;
		}
		if (isset($_GET["btime"]) && trim($_GET["btime"]) != '') {
			$btime = trim($_GET["btime"]);
			$where .= " and  addtime>='" . date("Y-m-d 00:00:00", strtotime($btime)) . "'";
			$this->btime = $btime;
		} else {
			$this->btime = '';
		}
		if (isset($_GET["etime"]) && trim($_GET["etime"]) != '') {
			$etime = trim($_GET["etime"]);
			$where .= " and  addtime<='" . date("Y-m-d 23:59:59", strtotime($etime)) . "'";
			$this->etime = $etime;
		} else {
			$this->etime = '';
		}
		$count = M("car_owner_share")->where($where)->count();
		$this->count = $count;
		$page = new Page($count, 10);
		$limit = $page->firstRow . "," . $page->listRows;
		$this->page = $page->show();
		$rs = M("car_owner_share")->where($where)->order("nid desc")->limit($limit)->select();
		if ($rs) {
			$i = 0;
			while ($i < count($rs)) {
				$rt = M("member")->where("nid=" . $rs[$i]["m_id"])->find();
				$rs[$i]["m_mobile"] = $rt["mobile"];
				$rt = M("member")->where("nid=" . $rs[$i]["referee_id"])->find();
				$rs[$i]["c_mobile"] = $rt["mobile"];
				switch ($rs[$i]["nstatus"]) {
					case 1:
						$rs[$i]["nstatus1"] = "<font color='red'>分享不成功</font>";
						break;
					case 2:
						$rs[$i]["nstatus1"] = "<font color='green'>分享成功</font>";
						break;
					default:
						$rs[$i]["nstatus1"] = "记录入库";
						break;
				}
				$i++;
			}
		}
		$this->rs = $rs;
		$this->display();
	}
	public function share_alldel()
	{
		$this->mb();
		if (!isset($_POST["allid"]) || trim($_POST["allid"]) == '') {
			$this->error("非法操作");
		}
		$allid = substr(trim($_POST["allid"]), 0, -1);
		if (M("car_owner_share")->where("nid in (" . $allid . ")")->delete()) {
			$data = array("status" => 1, "retDesc" => "删除成功");
		} else {
			$data = array("status" => 0, "retDesc" => "删除失败");
		}
		$this->ajaxReturn($data);
	}
	public function redpacked_withdraw()
	{
		$this->mb();
		$where = " uniacid=" . $this->uniacid . " ";
		if (!isset($_GET["nstatus"]) || intval($_GET["nstatus"]) <= 0) {
			$this->nstatus = 0;
		} else {
			$nstatus = intval($_GET["nstatus"]);
			$where .= " and nstatus=" . $nstatus;
			$this->nstatus = $nstatus;
		}
		if (isset($_GET["btime"]) && trim($_GET["btime"]) != '') {
			$btime = trim($_GET["btime"]);
			$where .= "and  transaction_time>='" . date("Y-m-d 00:00:00", strtotime($btime)) . "'";
			$this->btime = $btime;
		} else {
			$this->btime = '';
		}
		if (isset($_GET["etime"]) && trim($_GET["etime"]) != '') {
			$etime = trim($_GET["etime"]);
			$where .= "and  transaction_time<='" . date("Y-m-d 23:59:59", strtotime($etime)) . "'";
			$this->etime = $etime;
		} else {
			$this->etime = '';
		}
		$count = M("redpacked_withdraw")->where($where)->count();
		$this->count = $count;
		$page = new Page($count, 10);
		$limit = $page->firstRow . "," . $page->listRows;
		$this->page = $page->show();
		$rs = M("redpacked_withdraw")->where($where)->order("nid desc")->limit($limit)->select();
		if ($rs) {
			$i = 0;
			while ($i < count($rs)) {
				$rt = m("member")->where("nid=" . $rs[$i]["m_id"])->find();
				$rs[$i]["mobile"] = $rt["mobile"];
				$rs[$i]["wx_nickname"] = $rt["wx_nickname"];
				switch ($rs[$i]["nstatus"]) {
					case 1:
						$rs[$i]["nstatus1"] = "申请提现";
						break;
					case 2:
						$rs[$i]["nstatus1"] = "<font color='green'>已提现</font>";
						break;
					case 3:
						$rs[$i]["nstatus1"] = "<font color='red'>拒绝提现</font>";
						break;
				}
				$i++;
			}
		}
		$this->rs = $rs;
		$this->display();
	}
	public function redpacked_withdraw_alldel()
	{
		$this->mb();
		if (!IS_POST || trim($_POST["allid"]) == '') {
			$this->error("非法操作");
		}
		$allid = substr(trim($_POST["allid"]), 0, -1);
		if ($allid == '') {
			$this->error("非法操作");
		}
		if (M("redpacked_withdraw")->where(" nid in (" . $allid . ")")->data(array("isdel" => 2))->save()) {
			$data = array("status" => 1, "retDesc" => "删除成功");
		} else {
			$data = array("status" => 0, "retDesc" => "删除失败");
		}
		$this->ajaxReturn($data);
	}
	public function redpacked_withdraw_make_money_alldel()
	{
		$this->mb();
		if (!IS_POST || trim($_POST["allid"]) == '') {
			$this->error("非法操作");
		}
		$allid = substr(trim($_POST["allid"]), 0, -1);
		if ($allid == '') {
			$this->error("非法操作");
		}
		$this->getConfig();
		Vendor("alisms.sendMoney");
		$arr = getPayPath();
		$wxpay = new \sendMoney(C("wx_pay.appid"), C("wx_pay.mchid"), C("wx_pay.secrect_key"), C("wx_pay.ip"), $arr["SSLCERT_PATH"], $arr["SSLKEY_PATH"]);
		$rs = M("redpacked_withdraw")->where(" nid in (" . $allid . ")")->select();
		if ($rs) {
			$i = 0;
			while ($i < count($rs)) {
				$desc = "红包提现";
				$res = M("member")->where("nid=" . $rs[$i]["m_id"])->find();
				$mobile = $res["mobile"];
				$x_mobile = substr($mobile, 0, 3) . "****" . substr($mobile, 7, 4);
				$re = $wxpay->sendmoney($rs[$i]["money"], $res["openid"], $rs[$i]["ordernum"], $desc);
				if ($re["return_code"] == "SUCCESS" && $re["result_code"] == "SUCCESS") {
					M("redpacked_withdraw")->where("nid=" . $rs[$i]["nid"])->data(array("nstatus" => 2, "transaction_time" => $re["payment_time"], "transaction_id" => $re["payment_no"]))->save();
					$crr = array("m_id" => $rs[$i]["m_id"], "money" => $rs[$i]["money"], "ntype" => 2, "addtime" => date("Y-m-d H:i:s"), "uniacid" => $this->uniacid, "note" => "红包提现");
					M("redpacked_detail")->data($crr)->add();
					$paramString = "{\"mem\":\"" . $x_mobile . "\",\"redpacked\":\"" . $rs[$i]["money"] . "\",\"flag\":\"审核通过\"}";
					send_aliyun_msg($mobile, C("ali_sms.sms20"), $paramString);
				} else {
					$data = array("status" => 1, "retDesc" => "提现失败");
					$this->ajaxReturn($data);
					exit;
				}
				$i++;
			}
			$data = array("status" => 1, "retDesc" => "批量打款成功");
		} else {
			$data = array("status" => 1, "retDesc" => "提现失败");
		}
		$this->ajaxReturn($data);
	}
	public function redpacked_withdraw_notmake_money_alldel()
	{
		$this->mb();
		if (!IS_POST || trim($_POST["allid"]) == '') {
			$this->error("非法操作");
		}
		$allid = substr(trim($_POST["allid"]), 0, -1);
		if ($allid == '') {
			$this->error("非法操作");
		}
		$this->getConfig();
		$rs = M("redpacked_withdraw")->where(" nid in (" . $allid . ")")->select();
		if (M("redpacked_withdraw")->where(" nid in (" . $allid . ")")->data(array("nstatus" => 3, "transaction_time" => date("Y-m-d H:i:s")))->save()) {
			$i = 0;
			while ($i < count($rs)) {
				$res = M("member")->where("nid=" . $rs[$i]["m_id"])->find();
				$mobile = $res["mobile"];
				$x_mobile = substr($mobile, 0, 3) . "****" . substr($mobile, 7, 4);
				$paramString = "{\"mem\":\"" . $x_mobile . "\",\"redpacked\":\"" . $rs[$i]["money"] . "\",\"flag\":\"被拒绝\"}";
				send_aliyun_msg($mobile, C("ali_sms.sms20"), $paramString);
				$i++;
			}
			$data = array("status" => 1, "retDesc" => "操作成功");
		} else {
			$data = array("status" => 0, "retDesc" => "操作失败");
		}
		$this->ajaxReturn($data);
	}
	public function redpacked_withdraw_del()
	{
		$this->mb();
		if (!IS_GET || intval($_GET["nid"]) <= 0) {
			$this->error("非法操作");
		}
		$nid = intval($_GET["nid"]);
		if (M("redpacked_withdraw")->where("nid=" . $nid)->setField("isdel", 2)) {
			$this->success("删除成功");
		} else {
			$this->error("删除失败");
		}
	}
	public function withdrawals_list()
	{
		$this->mb();
		$where = " isdel=1 and uniacid=" . $this->uniacid . " ";
		if (!isset($_GET["nstatus"]) || intval($_GET["nstatus"]) <= 0) {
			$this->nstatus = 0;
		} else {
			$nstatus = intval($_GET["nstatus"]);
			$where .= " and nstatus=" . $nstatus;
			$this->nstatus = $nstatus;
		}
		if (!isset($_GET["nclass"]) || intval($_GET["nclass"]) <= 0) {
			$this->nclass = 0;
		} else {
			$nclass = intval($_GET["nclass"]);
			$where .= " and nclass=" . $nclass;
			$this->nclass = $nclass;
		}
		if (isset($_GET["btime"]) && trim($_GET["btime"]) != '') {
			$btime = trim($_GET["btime"]);
			$where .= " and  playmoney_time>='" . date("Y-m-d 00:00:00", strtotime($btime)) . "'";
			$this->btime = $btime;
		} else {
			$this->btime = '';
		}
		if (isset($_GET["etime"]) && trim($_GET["etime"]) != '') {
			$etime = trim($_GET["etime"]);
			$where .= " and  playmoney_time<='" . date("Y-m-d 23:59:59", strtotime($etime)) . "'";
			$this->etime = $etime;
		} else {
			$this->etime = '';
		}
		$count = M("withdrawals")->where($where)->count();
		$this->count = $count;
		$page = new Page($count, 10);
		$limit = $page->firstRow . "," . $page->listRows;
		$this->page = $page->show();
		$rs = M("withdrawals")->where($where)->order("nid desc")->limit($limit)->select();
		if ($rs) {
			$i = 0;
			while ($i < count($rs)) {
				$rt = m("member")->where("nid=" . $rs[$i]["m_id"])->find();
				$rs[$i]["mobile"] = $rt["mobile"];
				$rs[$i]["wx_nickname"] = $rt["wx_nickname"];
				switch ($rs[$i]["nstatus"]) {
					case 1:
						$rs[$i]["nstatus1"] = "申请提现";
						break;
					case 2:
						$rs[$i]["nstatus1"] = "<font color='green'>已提现</font>";
						break;
					case 3:
						$rs[$i]["nstatus1"] = "<font color='red'>拒绝提现</font>";
						break;
				}
				switch ($rs[$i]["nclass"]) {
					case 0:
						$rs[$i]["nclass1"] = "无";
						break;
					case 1:
						$rs[$i]["nclass1"] = "押金提现";
						break;
					case 2:
						$rs[$i]["nclass1"] = "账户提现";
						break;
					case 3:
						$rs[$i]["nclass1"] = "扣除押金";
						break;
					case 4:
						$rs[$i]["nclass1"] = "扣除车资";
						break;
					case 5:
						$rs[$i]["nclass1"] = "退还车资余款";
						break;
				}
				switch ($rs[$i]["isdel"]) {
					case 1:
						$rs[$i]["isdel1"] = "没有删除";
						break;
					case 2:
						$rs[$i]["isdel1"] = "已删除";
						break;
				}
				$i++;
			}
		}
		$this->rs = $rs;
		$this->display();
	}
	public function amount_cash_list()
	{
		$this->mb();
		$where = "uniacid=" . $this->uniacid;
		$count = M("person_member_amount_cash")->where($where)->count();
		$this->count = $count;
		$page = new Page($count, 10);
		$limit = $page->firstRow . "," . $page->listRows;
		$this->page = $page->show();
		$rs = M("person_member_amount_cash")->where($where)->limit($limit)->select();
		$this->rs = $rs;
		$this->display();
	}
	public function amount_cash_del()
	{
		$this->mb();
		if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
			$this->error("非法操作");
		}
		$nid = intval($_GET["nid"]);
		M("person_member_amount_cash")->where("nid=" . $nid)->delete();
		$this->success("操作成功");
	}
	public function withdrawals_list_alldel()
	{
		$this->mb();
		if (!IS_POST || trim($_POST["allid"]) == '') {
			$this->error("非法操作");
		}
		$allid = substr(trim($_POST["allid"]), 0, -1);
		if ($allid == '') {
			$this->error("非法操作");
		}
		if (M("withdrawals")->where(" nid in (" . $allid . ")")->data(array("isdel" => 2))->save()) {
			$data = array("status" => 1, "retDesc" => "删除成功");
		} else {
			$data = array("status" => 0, "retDesc" => "删除失败");
		}
		$this->ajaxReturn($data);
	}
	public function member_withdrawals_list_del()
	{
		$this->mb();
		if (!IS_GET || intval($_GET["nid"]) <= 0) {
			$this->error("非法操作");
		}
		$nid = intval($_GET["nid"]);
		if (M("withdrawals")->where("nid=" . $nid)->setField("isdel", 2)) {
			$this->success("删除成功");
		} else {
			$this->error("删除失败");
		}
	}
	public function withdrawals_list_make_money_alldel()
	{
		$this->mb();
		if (!IS_POST || trim($_POST["allid"]) == '') {
			$this->error("非法操作");
		}
		$allid = substr(trim($_POST["allid"]), 0, -1);
		if ($allid == '') {
			$this->error("非法操作");
		}
		$this->getConfig();
		Vendor("alisms.sendMoney");
		$arr = getPayPath();
		$wxpay = new \sendMoney(C("wx_pay.appid"), C("wx_pay.mchid"), C("wx_pay.secrect_key"), C("wx_pay.ip"), $arr["SSLCERT_PATH"], $arr["SSLKEY_PATH"]);
		$rs = M("withdrawals")->where(" nid in (" . $allid . ")")->select();
		if ($rs) {
			$i = 0;
			while ($i < count($rs)) {
				if ($rs[$i]["nclass"] == 1) {
					$desc = "押金提现";
				}
				if ($rs[$i]["nclass"] == 2) {
					$desc = "账户提现";
				}
				$res = M("member")->where("nid=" . $rs[$i]["m_id"])->find();
				$re = $wxpay->sendmoney($rs[$i]["amount_cash"], $res["openid"], $rs[$i]["ordernum"], $desc);
				if ($re["return_code"] == "SUCCESS" && $re["result_code"] == "SUCCESS") {
					M("withdrawals")->where("nid=" . $rs[$i]["nid"])->data(array("nstatus" => 2, "playmoney_time" => $re["payment_time"], "transaction_id" => $re["payment_no"]))->save();
					$crr = array("money" => $rs[$i]["amount_cash"], "addtime" => date("Y-m-d H:i:s"), "m_id" => $rs[$i]["m_id"], "uniacid" => $this->uniacid, "pid" => $rs[$i]["nid"]);
					if ($rs[$i]["nclass"] == 1) {
						$crr["nclass"] = 5;
					}
					if ($rs[$i]["nclass"] == 2) {
						$crr["nclass"] = 6;
					}
					M("revenue_detail")->data($crr)->add();
				} else {
					$data = array("status" => 1, "retDesc" => "提现失败");
					$this->ajaxReturn($data);
					exit;
				}
				$i++;
			}
			$data = array("status" => 1, "retDesc" => "批量打款成功");
		} else {
			$data = array("status" => 1, "retDesc" => "提现失败");
		}
		$this->ajaxReturn($data);
	}
	public function withdrawals_list_notmake_money_alldel()
	{
		$this->mb();
		if (!IS_POST || trim($_POST["allid"]) == '') {
			$this->error("非法操作");
		}
		$allid = substr(trim($_POST["allid"]), 0, -1);
		if ($allid == '') {
			$this->error("非法操作");
		}
		if (M("withdrawals")->where(" nid in (" . $allid . ")")->data(array("nstatus" => 3, "playmoney_time" => date("Y-m-d H:i:s"), "reason" => "无效的申请"))->save()) {
			$data = array("status" => 1, "retDesc" => "操作成功");
		} else {
			$data = array("status" => 0, "retDesc" => "操作失败");
		}
		$this->ajaxReturn($data);
	}
	public function member_share_list()
	{
		$this->mb();
		$where = " uniacid=" . $this->uniacid . " ";
		if (!isset($_GET["nstatus"]) || intval($_GET["nstatus"]) <= 0) {
			$this->nstatus = 0;
		} else {
			$where .= " and nstatus=" . intval($_GET["nstatus"]);
			$this->nstatus = intval($_GET["nstatus"]);
		}
		$count = M("person_member_share")->where($where)->count();
		$Page = new Page($count, 10);
		$limit = $Page->firstRow . "," . $Page->listRows;
		$this->page = $Page->show();
		$this->count = $count;
		$rs = M("person_member_share")->where($where)->limit($limit)->order("nid desc")->select();
		if ($rs) {
			$i = 0;
			while ($i < count($rs)) {
				$rt = M("member")->where("nid=" . $rs[$i]["m_id"])->find();
				$rs[$i]["m_name"] = $rt["wx_nickname"];
				$rt = M("member")->where("nid=" . $rs[$i]["b_id"])->find();
				$rs[$i]["b_name"] = $rt["wx_nickname"];
				if ($rs[$i]["nstatus"] == 1) {
					$rs[$i]["nstatus1"] = "<font color='red'>分享不成功</font>";
				} else {
					$rs[$i]["nstatus1"] = "<font color='green'>分享成功</font>";
				}
				if ($rs[$i]["isdel"] == 1) {
					$rs[$i]["isdel1"] = "<font color='green'>否</font>";
				} else {
					$rs[$i]["isdel1"] = "<font color='red'>是</font>";
				}
				$i++;
			}
		}
		$this->rs = $rs;
		$this->display();
	}
	public function member_share_list_alldel()
	{
		$this->mb();
		if (!IS_POST || trim($_POST["allid"]) == '') {
			$this->error("非法操作");
		}
		$allid = substr(trim($_POST["allid"]), 0, -1);
		if ($allid == '') {
			$this->error("非法操作");
		}
		if (M("person_member_share")->where(" nid in (" . $allid . ")")->data(array("isdel" => 2))->save()) {
			$data = array("status" => 1, "retDesc" => "操作成功");
		} else {
			$data = array("status" => 0, "retDesc" => "操作失败");
		}
		$this->ajaxReturn($data);
	}
	public function member_share_list_del()
	{
		$this->mb();
		if (!isset($_GET["nid"]) || intval($_GET["nid"]) <= 0) {
			$this->error("非法操作");
		}
		$nid = intval($_GET["nid"]);
		M("person_member_share")->where("nid=" . $nid)->setField("isdel", 2);
		$this->success("操作成功");
	}
	public function platform_income_list()
	{
		$this->mb();
		$where = " uniacid=" . $this->uniacid . " ";
		if (!isset($_GET["ntype"]) || intval($_GET["ntype"]) <= 0) {
			$this->ntype = 0;
		} else {
			$where .= " and ntype=" . intval($_GET["ntype"]);
			$this->ntype = intval($_GET["ntype"]);
		}
		if (isset($_GET["btime"]) && trim($_GET["btime"]) != '') {
			$btime = trim($_GET["btime"]);
			$where .= " and  addtime>='" . date("Y-m-d 00:00:00", strtotime($btime)) . "'";
			$this->btime = $btime;
		} else {
			$this->btime = '';
		}
		if (isset($_GET["etime"]) && trim($_GET["etime"]) != '') {
			$etime = trim($_GET["etime"]);
			$where .= " and  addtime<='" . date("Y-m-d 23:59:59", strtotime($etime)) . "'";
			$this->etime = $etime;
		} else {
			$this->etime = '';
		}
		$this->money = round(M("platform_income")->sum("money"), 2);
		$count = M("platform_income")->where($where)->count();
		$Page = new Page($count, 10);
		$limit = $Page->firstRow . "," . $Page->listRows;
		$this->page = $Page->show();
		$this->count = $count;
		$rs = M("platform_income")->where($where)->limit($limit)->order("id desc")->select();
		if ($rs) {
			$i = 0;
			while ($i < count($rs)) {
				switch ($rs[$i]["ntype"]) {
					case 1:
						$rs[$i]["ntype1"] = "用户直接取消任务平台收入";
						break;
					case 2:
						$rs[$i]["ntype1"] = "车主直接取消任务平台收入";
						break;
					case 3:
						$rs[$i]["ntype1"] = "处理冻结订单平台收入";
						break;
					case 4:
						$rs[$i]["ntype1"] = "车主拼车任务平台收入";
						break;
				}
				$i++;
			}
		}
		$this->rs = $rs;
		$this->display();
	}
	public function platform_income_list_alldel()
	{
		$this->mb();
		if (!isset($_POST["allid"]) || trim($_POST["allid"]) == '') {
			$this->error("非法操作");
		}
		$allid = substr(trim($_POST["allid"]), 0, -1);
		if (M("platform_income")->where("id in (" . $allid . ")")->delete()) {
			$data = array("status" => 1, "retDesc" => "删除成功");
		} else {
			$data = array("status" => 0, "retDesc" => "删除失败");
		}
		$this->ajaxReturn($data);
	}
	public function car_owner_list()
	{
		$this->mb();
		$str = "nclass=2 and uniacid=" . $this->uniacid . " ";
		if (isset($_GET["is_audit"]) && intval($_GET["is_audit"]) != -1) {
			$is_audit = intval($_GET["is_audit"]);
			$str .= " and is_audit='" . $is_audit . "'";
			$this->is_audit = $_GET["is_audit"];
		} else {
			$this->is_audit = -1;
		}
		if (isset($_GET["nstatus"]) && intval($_GET["nstatus"]) > 0) {
			$nstatus = intval($_GET["nstatus"]);
			$str .= " and nstatus='" . $nstatus . "'";
			$this->nstatus = $_GET["nstatus"];
		} else {
			$this->nstatus = 0;
		}
		if (isset($_GET["mobile"]) && trim($_GET["mobile"]) != '') {
			$mobile = trim($_GET["mobile"]);
			$str .= " and mobile='" . $mobile . "'";
			$this->mobile = $_GET["mobile"];
		} else {
			$this->mobile = '';
		}
		if (isset($_GET["btime"]) && trim($_GET["btime"]) != '') {
			$btime = date("Y-m-d 00:00:00", strtotime($_GET["btime"]));
			$str .= " and regtime>='" . $btime . "'";
			$this->btime = $_GET["btime"];
		} else {
			$this->btime = '';
		}
		if (isset($_GET["etime"]) && trim($_GET["etime"]) != '') {
			$etime = date("Y-m-d 23:59:59", strtotime($_GET["etime"]));
			$str .= " and regtime<='" . $etime . "'";
			$this->etime = $_GET["etime"];
		} else {
			$this->etime = '';
		}
		$count = M("member")->where($str)->count();
		$this->count = $count;
		$page = new Page($count, 10);
		$limit = $page->firstRow . "," . $page->listRows;
		$this->page = $page->show();
		$rs = M("member")->where($str)->order("nid desc")->limit($limit)->select();
		if ($rs) {
			$i = 0;
			while ($i < count($rs)) {
				$rs[$i]["nclass1"] = "车主";
				switch ($rs[$i]["is_audit"]) {
					case 0:
						$rs[$i]["is_audit1"] = "未提交";
						break;
					case 1:
						$rs[$i]["is_audit1"] = "认证中";
						break;
					case 2:
						$rs[$i]["is_audit1"] = "已审核";
						break;
					case 3:
						$rs[$i]["is_audit1"] = "已拒绝";
						break;
				}
				$i++;
			}
		}
		$this->rs = $rs;
		$this->display();
	}
	public function isaudit()
	{
		$this->mb();
		if (!IS_POST || trim($_POST["allid"]) == '') {
			$this->error("非法操作");
		}
		$allid = substr(trim($_POST["allid"]), 0, -1);
		if ($allid == '') {
			$this->error("非法操作");
		}
		$this->getConfig();
		$rs = M("member")->where(" nid in (" . $allid . ")")->select();
		if (M("member")->where(" nid in (" . $allid . ")")->data(array("is_audit" => 2))->save()) {
			foreach ($rs as $v) {
				$rt = M("car_owner_share")->where("m_id=" . $v["nid"] . " and ntype=2 and nstatus=0 and isdel=1")->find();
				if ($rt) {
					$field = array("nstatus" => 2, "redpacked" => C("car_owner_share"));
					M("car_owner_share")->where("nid=" . $rt["nid"])->data($field)->save();
					M("member")->where("nid=" . $v["referee_id"])->setInc("redpacked", C("car_owner_share"));
				}
				if ($v["unionid"] != "0") {
					$data = array("title" => "车主身份审核结果通知", "truename" => $v["truename"], "car_model" => $v["car_model"], "car_number" => $v["car_number"], "remark" => "祝贺你，车主身份审核通过。");
					send_carownermb_msg($v["nid"], $v["unionid"], C("gzh_template1"), $data, "审核通过");
				} else {
					Vendor("alisms.Alisms");
					$alisms = new \Alisms(C("ali_sms.key_id"), C("ali_sms.key_secret"));
					$temp_code = C("ali_sms.sms17");
					$alisms->signName = C("ali_sms.signname");
					$rt = M("member")->find($v["nid"]);
					$paramString = "{\"truename\":\"" . $rt["truename"] . "\",\"flag\":\"审核通过\"}";
					$alisms->smsend($rt["mobile"], $temp_code, $paramString);
				}
			}
			$data = array("status" => 1, "retDesc" => "操作成功");
		} else {
			$data = array("status" => 0, "retDesc" => "操作失败");
		}
		$this->ajaxReturn($data);
	}
	public function refused()
	{
		$this->mb();
		if (!IS_POST || trim($_POST["allid"]) == '') {
			$this->error("非法操作");
		}
		$allid = substr(trim($_POST["allid"]), 0, -1);
		if ($allid == '') {
			$this->error("非法操作");
		}
		$this->getConfig();
		$rs = M("member")->where(" nid in (" . $allid . ")")->select();
		if (M("member")->where(" nid in (" . $allid . ")")->data(array("is_audit" => 3))->save()) {
			foreach ($rs as $v) {
				$rt = M("car_owner_share")->where("m_id=" . $v["nid"] . " and ntype=2 and nstatus=0 and isdel=1")->find();
				if ($rt) {
					$field = array("nstatus" => 1, "reason" => "资料不全或者不正确");
					M("car_owner_share")->where("nid=" . $rt["nid"])->data($field)->save();
				}
				if ($v["unionid"] != "0") {
					$data = array("title" => "车主身份审核结果通知", "truename" => $v["truename"], "car_model" => $v["car_model"], "car_number" => $v["car_number"], "remark" => "资料不全或者不正确，车主身份审核拒绝。");
					send_carownermb_msg($v["nid"], $v["unionid"], C("gzh_template1"), $data, "拒绝");
				} else {
					Vendor("alisms.Alisms");
					$alisms = new \Alisms(C("ali_sms.key_id"), C("ali_sms.key_secret"));
					$temp_code = C("ali_sms.sms17");
					$rt = M("member")->find($v["nid"]);
					$paramString = "{\"truename\":\"" . $rt["truename"] . "\",\"flag\":\"拒绝\"}";
					$alisms->signName = C("ali_sms.signname");
					$alisms->smsend($rt["mobile"], $temp_code, $paramString);
				}
			}
			$data = array("status" => 1, "retDesc" => "操作成功");
		} else {
			$data = array("status" => 0, "retDesc" => "操作失败");
		}
		$this->ajaxReturn($data);
	}
	public function gzh_index()
	{
		$this->mb();
		$this->display();
	}
	public function send_gzh_send()
	{
		$this->mb();
		$mbid = I("mbid");
		$name = I("name");
		$remark = I("remark");
		$this->getConfig();
		$access_token = $this->getAccessToken2();
		$rs = M("gzh_member")->where("uniacid=" . $this->uniacid)->order("nid desc")->select();
		$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $access_token;
		if ($rs) {
			foreach ($rs as $v) {
				$dd = array("touser" => $v["openid"], "template_id" => $mbid, "url" => '', "data" => array("first" => array("value" => "您好,您已购买成功", "color" => "#173177"), "keyword1" => array("value" => $name, "color" => "#173177"), "keyword2" => array("value" => $remark, "color" => "#173177"), "remark" => array("value" => "发送时间：" . date("Y-m-d H:i:s"), "color" => "#173177")));
				$res = https_curl_json($url, $dd, "json");
				$res = json_decode($res, true);
				if ($res["errcode"] != "0" || $res["errmsg"] != "ok") {
					Vendor("alisms.Alisms");
					$alisms = new \Alisms(C("ali_sms.key_id"), C("ali_sms.key_secret"));
					$temp_code = C("ali_sms.templatecode");
					$paramString = "{\"code\":\"公众号测试信息\"}";
					$alisms->signName = C("ali_sms.signname");
					$rt = M("member")->where("unionid='" . $v["unionid"] . "' and unionid!='0'")->find();
					$re = $alisms->smsend($rt["mobile"], $temp_code, $paramString);
					if ($re["Code"] != "OK") {
						$this->error("发送短信失败");
						exit;
					}
				}
			}
			$this->success("发送成功");
		} else {
			$this->error("发送失败");
		}
	}
	public function fzsm_list()
	{
		$this->mb();
		$where = "uniacid=" . $this->uniacid;
		$count = M("fzsm")->where($where)->count();
		$this->count = $count;
		$page = new Page($count, 10);
		$limit = $page->firstRow . "," . $page->listRows;
		$this->page = $page->show();
		$rs = M("fzsm")->where($where)->limit($limit)->order("nid desc")->select();
		$this->rs = $rs;
		$this->display();
	}
	public function fzsm_add()
	{
		$this->mb();
		$this->display();
	}
	public function fzsm_addhandle()
	{
		$this->mb();
		$param = I("post.");
		if (trim($param["title"]) == '') {
			$this->error("信息不全，提交失败");
		} else {
			$param["addtime"] = date("Y-m-d H:i:s");
			$param["uniacid"] = $this->uniacid;
			M("fzsm")->add($param);
			$this->success("提交成功", U("fzsm_list"));
		}
	}
	public function fzsm_alldel()
	{
		$this->mb();
		if (!isset($_POST["allid"]) || trim($_POST["allid"]) == '') {
			$this->error("非法操作");
		}
		$allid = substr(trim($_POST["allid"]), 0, -1);
		if (M("fzsm")->where("nid in (" . $allid . ")")->delete()) {
			$data = array("status" => 1, "retDesc" => "删除成功");
		} else {
			$data = array("status" => 0, "retDesc" => "删除失败");
		}
		$this->ajaxReturn($data);
	}
	public function fzsm_modi()
	{
		$this->mb();
		$nid = I("nid");
		if ($nid <= 0) {
			$this->error("非法操作");
		}
		$rs = M("fzsm")->where("nid=" . $nid)->find();
		$this->rs = $rs;
		$this->display();
	}
	public function fzsm_modihandle()
	{
		$this->mb();
		$param = I("post.");
		if (!$param["nid"] || trim($param["title"]) == '') {
			$this->error("非法操作");
		}
		$nid = I("nid");
		unset($param["nid"]);
		M("fzsm")->where("nid=" . $nid)->data($param)->save();
		$this->success("操作成功", U("fzsm_list"));
	}
	public function getAccessToken2()
	{
		$access_token = S("access_token");
		if (!$access_token) {
			$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . C("gzh_appid") . "&secret=" . C("gzh_secret");
			$result = file_get_contents($url);
			$result = json_decode($result, true);
			S("access_token", $result["access_token"], $result["expires_in"]);
			$access_token = $result["access_token"];
		}
		return $access_token;
	}
	public function show1()
	{
		$this->mb();
		$this->license = urldecode(I("license"));
		$this->display();
	}
	public function show2()
	{
		$this->mb();
		$ntype = I("ntype");
		$nid = I("nid");
		$rs = M("member_complain")->find($nid);
		$arr = explode(",", $rs["picpath"]);
		$k = 0;
		foreach ($arr as $k => $v) {
			$k++;
			if ($ntype == $k + 1) {
				$this->license = $v;
			}
		}
		$this->display();
	}
	public function mb()
	{
		$mb = new IndexController();
		$mb->moban();
	}
}