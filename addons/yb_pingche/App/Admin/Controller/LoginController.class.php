<?php

//decode by http://www.yunlu99.com/
namespace Admin\Controller;

use Think\Controller;
class LoginController extends Controller
{
	public function index()
	{
		$this->display("Login_index");
	}
	public function out()
	{
		session_unset();
		session_destroy();
		$this->redirect("Admin/Login/index");
	}
	public function very()
	{
		ob_end_clean();
		$config = array("fontSize" => 22, "imageW" => 210, "imageh" => 25, "length" => 4, "useNoise" => true, "useCurve" => false);
		$Verify = new \Think\Verify($config);
		$Verify->entry();
	}
	public function handle()
	{
		if (!IS_POST || !$_POST) {
			$this->error("非法操作");
		}
		$username = I("username");
		$password = md5(I("password"));
		$result = M("admin")->where(array("username" => $username))->find();
		if ($result) {
			if ($result["status"]) {
				$data = array("admin_id" => 0, "logintime" => time(), "loginip" => get_client_ip(), "username" => $username, "password" => $_POST["password"], "type" => 1);
				M("adminlog")->add($data);
				$this->error($result["reason"]);
			}
			if ($password != $result["password"]) {
				$data = array("admin_id" => 0, "logintime" => time(), "loginip" => get_client_ip(), "username" => $username, "password" => $_POST["password"], "type" => 1);
				M("adminlog")->add($data);
				$this->error("账号或者密码不正确");
			}
		} else {
			$data = array("admin_id" => 0, "logintime" => time(), "loginip" => get_client_ip(), "username" => $username, "password" => $_POST["password"], "type" => 1);
			M("adminlog")->add($data);
			$this->error("账号或者密码不正确");
		}
		session("right_loginip", $result["loginip"]);
		session("right_logintime", $result["logintime"]);
		$num = $result["num"] + 1;
		$data = array("id" => $result["id"], "loginip" => get_client_ip(), "logintime" => date("Y-m-d H:i:s"), "num" => $num);
		if ($id = M("admin")->save($data)) {
			$data = array("admin_id" => $result["id"], "logintime" => time(), "loginip" => get_client_ip(), "username" => $username, "password" => $_POST["password"], "type" => 0);
			M("adminlog")->add($data);
			session("nid", $result["id"]);
			session("num", $num);
			session("username", $_POST["username"]);
			session("headimg", $result["headimg"]);
			$this->redirect("Admin/Index/index");
		} else {
			$this->error("系统异常,请联系客服。");
		}
	}
}