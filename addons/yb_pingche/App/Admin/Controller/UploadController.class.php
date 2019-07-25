<?php

//decode by http://www.yunlu99.com/
namespace Admin\Controller;

use Think\Controller;
use Think\Upload;
use Think\Upload\Driver\Oss;
use Qiniu\Storage\UploadManager;
use Qiniu\Auth;
use Qiniu\Config;
use Qiniu\Storage\BucketManager;
use Ht\Controller\MemberController;
class UploadController extends CommonController
{
	public function uploadpic1()
	{
		$this->getConfig();
		ini_set("date.timezone", "Asia/Chongqing");
		$files = $_FILES["img"];
		if ($files) {
			$filename = explode(".", strtolower($files["name"]));
			$arr = C("uptype");
			if (!in_array($files["type"], $arr)) {
				$data = array("retCode" => "0001", "retDesc" => "非法上传");
				exit(json_encode($data));
			}
			$filename = date("YmdHis") . "." . $filename[count($filename) - 1];
			$tmpname = $files["tmp_name"];
			$folder_tmp = "./Public/Uploads/Ads/";
			if (move_uploaded_file($tmpname, $folder_tmp . $filename)) {
				$data = array("code" => 0, "msg" => "上传成功", "data" => $filename);
			} else {
				$data = array("code" => 1, "msg" => "上传失败");
			}
		} else {
			$data = array("code" => 1, "msg" => "上传失败");
		}
		exit(json_encode($data));
	}
	public function uploadpic()
	{
		$this->getConfig();
		$Img = I("Img");
		$Path = null;
		if ($_FILES["img"]) {
			switch (C("upload_type")) {
				case 0:
					$Img = $this->saveimg_local($_FILES);
					break;
				case 1:
					$Img = $this->saveimg($_FILES);
					break;
				case 2:
					$Img = $this->qiniu_saveimg($_FILES);
					break;
			}
		}
		exit(json_encode($Img));
	}
	private function saveimg_local($files)
	{
		$this->getConfig();
		$exts = array("jpeg", "jpg", "jpeg", "png", "pjpeg", "gif", "bmp", "x-png");
		$upload = new Upload(array("mimes" => C("uptype"), "exts" => $exts, "rootPath" => "./Public/", "savePath" => "Uploads/Ads/", "subName" => array("date", "d"), "maxSize" => C("max_upload_size")));
		$info = $upload->upload($files);
		$code = 0;
		$error = '';
		$data = '';
		if (!$info) {
			$error = $upload->getError();
			$code = 1;
		} else {
			foreach ($info as $item) {
				$filePath[] = "https://" . $_SERVER["SERVER_NAME"] . __ROOT__ . "/Public/" . $item["savepath"] . $item["savename"];
			}
			$ImgStr = implode("|", $filePath);
			$data = $ImgStr;
			$error = "上传成功";
		}
		return ["code" => $code, "msg" => $error, "data" => $data];
	}
	private function saveimg($files)
	{
		$bucketName = C("oss_bucket");
		$ossClient = new \Org\OSS\OssClient(C("oss_access_id"), C("oss_access_key"), C("oss_endpoint"), false);
		$web = C("oss_web_site");
		$fFiles = $_FILES["img"];
		$rs = ossUpPic($fFiles, date("Y"), $ossClient, $bucketName, $web, 1);
		if ($rs["code"]) {
			$rs["msg"] = "上传出错";
		} else {
			$rs["msg"] = "上传成功";
		}
		return ["code" => $rs["code"], "msg" => $rs["msg"], "data" => $rs["url"]];
	}
	private function qiniu_saveimg($files)
	{
		$this->getConfig();
		vendor("qiniu.autoload");
		vendor("qiniu.src.Qiniu.Auth");
		vendor("qiniu.src.Qiniu.Etag");
		vendor("qiniu.src.Qiniu.Zone");
		$auth = new Auth(C("qiniu_ak"), C("qiniu_sk"));
		$token = $auth->uploadToken(C("qiniu_bucket"));
		$um = new UploadManager();
		$ext = explode(".", $_FILES["img"]["name"]);
		$key = date("YmdHis") . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9) . "." . $ext[count($ext) - 1];
		$filePath = $_FILES["img"]["tmp_name"];
		list($ret, $err) = $um->putFile($token, $key, $filePath);
		if ($err !== null) {
			return ["code" => 1, "msg" => "上传失败", "data" => ''];
		} else {
			return ["code" => 0, "msg" => "上传成功", "data" => C("qiniu_site") . "/" . $ret["key"]];
		}
	}
	public function batchpic()
	{
		$ImgStr = I("Img");
		$ImgStr = trim($ImgStr, "|");
		$Img = array();
		if (strlen($ImgStr) > 1) {
			$Img = explode("|", $ImgStr);
		}
		$Path = null;
		$newImg = array();
		$newImgStr = null;
		if ($_FILES) {
			if (C("isoss")) {
				$newImgStr = $this->saveimgs($_FILES);
			} else {
				$newImgStr = $this->saveimg_local($_FILES);
			}
			if ($newImgStr) {
				$newImg = explode("|", $newImgStr);
			}
		}
		$Img = array_merge($Img, $newImg);
		$ImgStr = implode("|", $Img);
		$BackCall = I("BackCall");
		$Width = I("u");
		$Height = I("Height");
		if (!$BackCall) {
			$Width = $_POST["BackCall"];
		}
		if (!$Width) {
			$Width = $_POST["Width"];
		}
		if (!$Height) {
			$Width = $_POST["Height"];
		}
		$this->assign("Width", $Width);
		$this->assign("BackCall", $BackCall);
		$this->assign("ImgStr", $ImgStr);
		$this->assign("Img", $Img);
		$this->assign("Height", $Height);
		$this->display("Batchpic");
	}
	private function saveimgs($files)
	{
		$bucketName = C("OSS_BUCKET");
		$ossClient = new \Org\OSS\OssClient(C("OSS_ACCESS_ID"), C("OSS_ACCESS_KEY"), C("OSS_ENDPOINT"), false);
		$web = C("OSS_WEB_SITE");
		$fFiles = $_FILES["img"];
		$rs = ossUpPics($fFiles, "ekcms", $ossClient, $bucketName, $web, 0);
		if ($rs["code"] == 1) {
			$img = $rs["url"];
			return $img;
		} else {
			echo "<script>alert('{$rs["msg"]}')</script>";
		}
	}
	public function saveimg_kind()
	{
		$this->getConfig();
		$files = $_FILES;
		$bucketName = C("oss_bucket");
		$ossClient = new \Org\OSS\OssClient(C("oss_access_id"), C("oss_access_key"), C("oss_endpoint"), false);
		$web = C("oss_web_site");
		$fFiles = $_FILES["img"];
		$rs = ossUpPic($fFiles, "ybfxyx", $ossClient, $bucketName, $web, 0);
		if ($rs["code"] == 0) {
			$img = $rs["url"];
			echo json_encode(array("error" => 0, "url" => $img));
		} else {
			echo "<script>alert('{$rs["msg"]}')</script>";
		}
	}
	public function qiniu_saveimg_kind()
	{
		$this->getConfig();
		$mimes = array("image/jpeg", "image/jpg", "image/jpeg", "image/png", "image/pjpeg", "image/gif", "image/bmp", "image/x-png");
		$exts = array("jpeg", "jpg", "jpeg", "png", "pjpeg", "gif", "bmp", "x-png");
		vendor("qiniu.autoload");
		vendor("qiniu.src.Qiniu.Auth");
		vendor("qiniu.src.Qiniu.Etag");
		vendor("qiniu.src.Qiniu.Zone");
		$auth = new Auth(C("qiniu_ak"), C("qiniu_sk"));
		$token = $auth->uploadToken(C("qiniu_bucket"));
		$um = new UploadManager();
		$ext = explode(".", $_FILES["img"]["name"]);
		if (!in_array(strtolower($ext[count($ext) - 1]), $exts)) {
			echo "<script>alert('文件格式不正确')</script>";
			exit;
		}
		$fSize = $_FILES["img"]["size"];
		if ($fSize > C("max_upload_size")) {
			echo "<script>alert('文件超出大小')</script>";
			exit;
		}
		$key = date("YmdHis") . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9) . "." . $ext[count($ext) - 1];
		$filePath = $_FILES["img"]["tmp_name"];
		list($ret, $err) = $um->putFile($token, $key, $filePath);
		if ($err !== null) {
			echo "<script>alert('上传出错了')</script>";
		} else {
			echo json_encode(array("error" => 0, "url" => C("qiniu_site") . "/" . $ret["key"]));
		}
		exit;
	}
	public function saveimg_lay()
	{
		$files = $_FILES;
		$bucketName = C("OSS_BUCKET");
		$ossClient = new \Org\OSS\OssClient(C("oss_access_id"), C("OSS_ACCESS_KEY"), C("OSS_ENDPOINT"), false);
		$web = C("OSS_WEB_SITE");
		$fFiles = $_FILES["file"];
		$rs = ossUpPic($fFiles, "ekcms", $ossClient, $bucketName, $web, 0);
		if ($rs["code"] == 1) {
			$ajax["code"] = 0;
			$ajax["msg"] = "上传成功";
			$ajax["data"]["src"] = $rs["url"];
			$ajax["data"]["title"] = '';
		} else {
			$ajax["code"] = 1;
			$ajax["msg"] = $rs["msg"];
		}
		$this->ajaxReturn($ajax);
	}
}