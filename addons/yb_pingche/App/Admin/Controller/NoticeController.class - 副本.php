<?php

//decode by http://www.yunlu99.com/
namespace Admin\Controller;

use Think\Page;
use Think\Controller;
class NoticeController extends CommonController
{
	public function index()
	{
		$this->display();
	}
	public function index_addhandle()
	{
		if (!IS_POST) {
			$this->error("非法操作!");
		}
		$where = "uniacid =" . $this->uniacid;
		$brr = I("post.");
		switch ($brr["nstatus"]) {
			case 1:
				$where .= '';
				break;
			case 2:
				$where .= " and nclass=2";
				break;
			case 3:
				$where .= " and nclass=1";
				break;
		}
		$list = M("member")->where($where)->select();
		unset($brr["nstatus"]);
		$brr["addtime"] = date("Y-m-d H:i:s");
		if ($list) {
			foreach ($list as $k => $v) {
				$brr["m_id"] = $v["nid"];
				$brr["uniacid"] = $this->uniacid;
				M("notice")->add($brr);
			}
			$this->success("发布成功");
		} else {
			$this->error("当前还没有会员哦!");
		}
	}
	public function noticelist()
	{
		$this->mb();
		$where = " uniacid=" . $this->uniacid;
		$count = M("notice")->where($where)->count();
		$Page = new Page($count, 20);
		$show = $Page->show();
		$rs = M("notice")->where($where)->limit($Page->firstRow . "," . $Page->listRows)->order(" nid desc")->select();
		foreach ($rs as $k => $v) {
			$rt = M("member")->where("nid=" . $v["m_id"] . " and uniacid=" . $this->uniacid)->find();
			$rs[$k]["mobile"] = $rt["mobile"];
		}
		$this->rs = $rs;
		$this->count = $count;
		$this->assign("page", $show);
		$this->display();
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
		if (M("notice")->where("nid in(" . $allid . ") and uniacid=" . $this->uniacid)->delete()) {
			$data = array("status" => 1, "retDesc" => "删除成功");
		} else {
			$data = array("status" => 0, "retDesc" => "删除失败");
		}
		$this->ajaxReturn($data);
	}
	public function mb()
	{
		$mb = new IndexController();
		$mb->moban();
	}
}