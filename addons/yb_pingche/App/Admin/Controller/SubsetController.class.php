<?php

//decode by http://www.yunlu99.com/
namespace Admin\Controller;

use Think\Controller;
class SubsetController extends CommonController
{
	private function getdata()
	{
		$this->mb;
		$data = M("config")->where("uniacid=" . $this->uniacid)->find();
		if ($data["gzh_ywym_status"] == 1) {
			$data["gzh_ywym_status1"] = "没有上传";
		} else {
			$data["gzh_ywym_status1"] = "已上传";
		}
		if ($data["gzh_wysq_status"] == 1) {
			$data["gzh_wysq_status1"] = "没有上传";
		} else {
			$data["gzh_wysq_status1"] = "已上传";
		}
		return $data;
	}
	public function index()
	{
		$this->mb();
		$this->data = $this->getdata();
		$this->display();
	}
	public function pingchepara()
	{
		$this->mb();
		$this->data = $this->getdata();
		$this->display();
	}
	public function pianshengflag()
	{
		$this->mb();
		$this->data = $this->getdata();
		$this->display();
	}
	public function kefu()
	{
		$this->mb();
		$this->data = $this->getdata();
		$this->display();
	}
	public function sms()
	{
		$this->mb();
		$this->data = $this->getdata();
		$this->display();
	}
	public function gzh()
	{
		$this->mb();
		$this->data = $this->getdata();
		$this->display();
	}
	public function upload()
	{
		$this->mb();
		$this->data = $this->getdata();
		$this->display();
	}
	public function update()
	{
		$this->mb();
		if (IS_POST) {
			$param = I("post.");
			$obj = M("config");
			$con = M("config")->where("uniacid=" . $this->uniacid)->find();
			$hd = new \Vendor\FileHelper();
			if ($param["wx_pay_sslcert_path"]) {
				$filename = "./ThinkPHP/Library/Vendor/wxpay/cert/apiclient_cert.pem";
				$hd::filePutContents($filename, $param["wx_pay_sslcert_path"]);
			}
			if ($param["wx_pay_sslkey_path"]) {
				$filename = "./ThinkPHP/Library/Vendor/wxpay/cert/apiclient_key.pem";
				$hd::filePutContents($filename, $param["wx_pay_sslkey_path"]);
			}
			if ($param["gzh_ywym_filename"]) {
				$filename = "./" . $param["gzh_ywym_filename"];
				$hd::filePutContents($filename, $param["gzh_ywym_filecontent"]);
				$param["gzh_ywym_status"] = 2;
			} else {
				$param["gzh_ywym_status"] = 1;
			}
			if ($param["gzh_wysq_filename"]) {
				$filename = "./" . $param["gzh_wysq_filename"];
				$hd::filePutContents($filename, $param["gzh_wysq_filecontent"]);
				$param["gzh_wysq_status"] = 2;
			} else {
				$param["gzh_wysq_status"] = 1;
			}
			if ($con) {
				$obj->where("id=" . $con["id"])->save($param);
			} else {
				$obj->add($param);
			}
			$con = M("config")->find();
			S("shopconfig", null);
			$this->getConfig();
		}
		$this->success("操作成功");
	}
	public function mb()
	{
		$mb = new IndexController();
		$mb->moban();
	}
}