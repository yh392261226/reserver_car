<?php
	/**
	 * 打印数组函数
	 * @param array $arr
	 */
	function p($arr){
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
		exit;
	}
	//oss上传
	/*
	 *$fFiles:文件域
	 *$n：上传的路径目录
	 *$ossClient
	 *$bucketName
	 *$web:oss访问地址
	 *$isThumb:是否缩略图
	 */
	function ossUpPic($fFiles,$n,$ossClient,$bucketName,$web,$isThumb=1){
	
	    $fType=$fFiles['type'];
	    $back=array(
	        'code'=>0,
	        'msg'=>'',
	    );
	    //         if(!in_array($fType, C('oss_exts'))){
	    //             $back['msg']='文件格式不正确';
	    //             return $back;
	    //             exit;
	    //         }
	    $fSize=$fFiles['size'];
	    if($fSize>C('max_upload_size')){
	        $back['msg']=C('max_upload_size');
	        $back['code']=1;
	        return $back;
	        exit;
	    }
	
	    $fname=$fFiles['name'];
	    $ext=substr($fname,stripos($fname,'.'));
	     
	    $fup_n=$fFiles['tmp_name'];
	    //$file_n=time().'_'.rand(100,999);
	    $file_n=substr(md5_file($fup_n), 8, 16);
	    $object = $n."/".date('Ymd')."/".$file_n.$ext;//目标文件名
	     
	     
	    if (is_null($ossClient)) exit(1);
	    $ossClient->uploadFile($bucketName, $object, $fup_n);
	     
	
	    $back['url']=$web."/".$object;
	    if($isThumb==1){
	        // 图片缩放，参考https://help.aliyun.com/document_detail/44688.html?spm=5176.doc32174.6.481.RScf0S
	        $back['url']=$web."/".$object.C('OSS_PICEND');
	    }else{
	        $back['url']=$web."/".$object;
	    }
	    return $back;
	    exit;
	}
	//oss上传 多图
	/*
	 *$fFiles:文件域
	 *$n：上传的路径目录
	 *$ossClient
	 *$bucketName
	 *$web:oss访问地址
	 *$isThumb:是否缩略图
	 */
	function ossUpPics($fFiles,$n,$ossClient,$bucketName,$web,$isThumb=0){
	
	
	    $back=array(
	        'code'=>0,
	        'msg'=>'',
	    );
	    if (is_null($ossClient)) {
	        $back['msg']='未声明ossClient对象';
	        return $back;
	    }
	    for($i=0;$i<count($fFiles['tmp_name']);$i++){
	        $fType=$fFiles['type'][$i];
	        if(!in_array($fType, C('oss_exts'))){
	            continue;
	        }
	        $fSize=$fFiles['size'][$i];
	        if($fSize>C('oss_maxSize')){
	            continue;
	        }
	        $fname=$fFiles['name'][$i];
	        $ext=substr($fname,stripos($fname,'.'));
	        $fup_n=$fFiles['tmp_name'][$i];
	        //$file_n=time().'_'.rand(100,999);
	        $file_n=substr(md5_file($fup_n), 8, 16);
	        $object = $n."/".date('Ymd')."/".$file_n.$ext;//目标文件名
	        $ossClient->uploadFile($bucketName, $object, $fup_n);
	
	        if($isThumb==1){
	            $arr[]=$web."/".$object.C('OSS_PICEND');
	        }else{
	            $arr[]=$web."/".$object;
	        }
	    }
	    $back['url']=implode('|',$arr);
	    $back['code']=1;
	
	    return $back;
	    exit;
	}	
	/*
	 *@支付证书地址路径
	 * */
	function getPayPath(){
	    $arr=array(
	        "SSLCERT_PATH"=>'./ThinkPHP/Library/Vendor/wxpay/cert/apiclient_cert.pem',
	        "SSLKEY_PATH"=>'./ThinkPHP/Library/Vendor/wxpay/cert/apiclient_key.pem'
	    );
	    return $arr;
	}
	/**
	 * 获取当前服务器地址
	 * @return string
	 */
	function get_url() {
	    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
	    $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
	    $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
	    $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
	    return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
	}	
	/*
	 *@获取公众号token
	 
	function getAccessToken2(){
	    $access_token = S('access_token');
	    if(!$access_token){
	        $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".C("gzh_appid")."&secret=".C("gzh_secret");
	        $result=file_get_contents($url);
	        $result=json_decode($result,true);
	        S('access_token',$result["access_token"],$result["expires_in"]);
	        $access_token=$result["access_token"];
	    }
	    return $access_token;
	}
	*/

	/**
	 *@保存会员formid函数
	 *参数： $arr
	 */
	function save_member_formid($form_id,$m_id){
        if($form_id==0){
            return false;
        }
	    $brr=array(
            "form_id"=>$form_id,
            "form_id_expires_in"=>time()+7*24*3600,
            "ntype"=>1,
            "num"=>0,
            "addtime"=>date("Y-m-d H:i:s"),
            "m_id"=>$m_id
        );
	    M("member_formid")->data($brr)->add();
	}
	//截取字符串的长度
	function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true)
	{
		if(function_exists("mb_substr")){
			if($suffix)
				return mb_substr($str, $start, $length, $charset)."...";
			else
				return mb_substr($str, $start, $length, $charset);
		}
		elseif(function_exists('iconv_substr')) {
			if($suffix)
				return iconv_substr($str,$start,$length,$charset)."...";
			else
				return iconv_substr($str,$start,$length,$charset);
		}
		$re['utf-8']   = "/[x01-x7f]|[xc2-xdf][x80-xbf]|[xe0-xef]
		[x80-xbf]{2}|[xf0-xff][x80-xbf]{3}/";
		$re['gb2312'] = "/[x01-x7f]|[xb0-xf7][xa0-xfe]/";
		$re['gbk']    = "/[x01-x7f]|[x81-xfe][x40-xfe]/";
		$re['big5']   = "/[x01-x7f]|[x81-xfe]([x40-x7e]|xa1-xfe])/";
		preg_match_all($re[$charset], $str, $match);
		$slice = join("",array_slice($match[0], $start, $length));
		if($suffix) return $slice."…";
		return $slice;
	}
	/*去掉特殊的html标签*/
	/**
	 * @去掉特定标签
	 * @param unknown_type $tagsArr
	 * @param unknown_type $str
	 * @return mixed
	 */
	function g_strip_tags($tagsArr,$str) {
		foreach ($tagsArr as $tag) {
			$p[]="/(<(?:\/".$tag."|".$tag.")[^>]*>)/i";
		}
		$return_str = preg_replace($p,"",$str);
		return $return_str;
	}
	/**
	 * @等比例生成缩略图
	 * @param $imgSrc
	 * @param $resize_width
	 * @param $resize_height
	 * @param $isCut
	 * @author上帝禁区  2017-11-1
	 */
	function reSizeImg($imgSrc, $resize_width, $resize_height,$imgpath,$isCut = false) {
		//图片的类型
		$type = strtolower(substr(strrchr($imgSrc, "."), 1));
		//初始化图象
		if ($type == "jpg") {
			$im = imagecreatefromjpeg($imgpath.$imgSrc);
		}
		if ($type == "gif") {
			$im = imagecreatefromgif($imgpath.$imgSrc);
		}
		if ($type == "png") {
			$im = imagecreatefrompng($imgpath.$imgSrc);
		}
		if ($type == "jpeg") {
			$im = imagecreatefromjpeg($imgpath.$imgSrc);
		}
		//imagecreatefromjpeg
		//目标图象地址
		$full_length = strlen($imgSrc);
		$type_length = strlen($type);
		$name_length = $full_length - $type_length;
		$name = substr($imgSrc, 0, $name_length - 1);
		$dstimg = $imgpath.$name . "_s." . $type;
		$width = imagesx($im);
		$height = imagesy($im);
		//生成图象
		//改变后的图象的比例
		$resize_ratio = ($resize_width) / ($resize_height);
		//实际图象的比例
		$ratio = ($width) / ($height);
		if (($isCut) == 1) { //裁图
			if ($ratio >= $resize_ratio) { //高度优先
				$newimg = imagecreatetruecolor($resize_width, $resize_height);
				imagecopyresampled($newimg, $im, 0, 0, 0, 0, $resize_width, $resize_height, (($height) * $resize_ratio), $height);
				ImageJpeg($newimg, $dstimg);
			}
			if ($ratio < $resize_ratio) { //宽度优先
				$newimg = imagecreatetruecolor($resize_width, $resize_height);
				imagecopyresampled($newimg, $im, 0, 0, 0, 0, $resize_width, $resize_height, $width, (($width) / $resize_ratio));
				ImageJpeg($newimg, $dstimg);
			}
		} else { //不裁图
			if ($ratio >= $resize_ratio) {
				$newimg = imagecreatetruecolor($resize_width, ($resize_width) / $ratio);
				imagecopyresampled($newimg, $im, 0, 0, 0, 0, $resize_width, ($resize_width) / $ratio, $width, $height);
				ImageJpeg($newimg, $dstimg);
			}
			if ($ratio < $resize_ratio) {
				$newimg = imagecreatetruecolor(($resize_height) * $ratio, $resize_height);
				imagecopyresampled($newimg, $im, 0, 0, 0, 0, ($resize_height) * $ratio, $resize_height, $width, $height);
				ImageJpeg($newimg, $dstimg);
			}
		}
		ImageDestroy($im);
		@unlink($imgpath.$imgSrc);
		rename($dstimg,$imgpath.$imgSrc);
	}
	//获取openid
	function xcx_get_openid(){
		Vendor('wxpay.lib.JsApiPay');
		$tools = new \JsApiPay();
		$openId = $tools->GetOpenid();
		return $openId;
	}
	//乘客发布任务发起微信小程序支付
	function pc_passenger_task_pay($arr){
	    Vendor('wxpay.lib.Api');
	    Vendor('wxpay.lib.JsApiPay');
	    $tools = new \JsApiPay();
	    $openId = $arr["openid"];
	    //统一下单
	    $input = new \WxPayUnifiedOrder();
	    $input->SetBody($arr["body"]);                                  //商品描述
	    $input->SetAttach($arr["attach"]);                              //附加数据
	    //$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
	    $input->SetOut_trade_no($arr["out_trade_no"]);                  //商铺订单号
	    $input->SetTotal_fee($arr["total_fee"]);                        //总金额
	    $input->SetTime_start(date("YmdHis"));                          //交易起始时间
	    $input->SetTime_expire(date("YmdHis", time() + 600));           //交易结束时间
	    $input->SetGoods_tag($arr["tag"]);                              //商品标记
	    $input->SetNotify_url(C("ht_pay_path.passengerTaskPay"));       //回调地址
	    $input->SetTrade_type("JSAPI");
	    $input->SetOpenid($openId);
	    $order = WxPayApi::unifiedOrder($input);
	    $jsApiParameters = $tools->GetJsApiParameters($order);
	    return $jsApiParameters;
	}
	//乘客购买车主任务发起微信小程序支付
	function pc_passenger_buy_seat_pay($arr){
	    Vendor('wxpay.lib.Api');
	    Vendor('wxpay.lib.JsApiPay');
	    $tools = new \JsApiPay();
	    $openId = $arr["openid"];
	    //统一下单
	    $input = new \WxPayUnifiedOrder();
	    $input->SetBody($arr["body"]);                                  //商品描述
	    $input->SetAttach($arr["attach"]);                              //附加数据
	    //$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
	    $input->SetOut_trade_no($arr["out_trade_no"]);                  //商铺订单号
	    $input->SetTotal_fee($arr["total_fee"]);                        //总金额
	    $input->SetTime_start(date("YmdHis"));                          //交易起始时间
	    $input->SetTime_expire(date("YmdHis", time() + 600));           //交易结束时间
	    $input->SetGoods_tag($arr["tag"]);                              //商品标记
	    $input->SetNotify_url(C("ht_pay_path.passengerBuySeatPay"));    //回调地址
	    $input->SetTrade_type("JSAPI");
	    $input->SetOpenid($openId);
	    $order = WxPayApi::unifiedOrder($input);
	    $jsApiParameters = $tools->GetJsApiParameters($order);
	    return $jsApiParameters;
	}
	/*
	 *@车主押金充值 
	 * */
	function carowner_recharge_pay($arr){
	    Vendor('wxpay.lib.Api');
	    Vendor('wxpay.lib.JsApiPay');
	    $tools = new \JsApiPay();
	    $openId = $arr["openid"];
	    //统一下单
	    $input = new \WxPayUnifiedOrder();
	    $input->SetBody($arr["body"]);                                  //商品描述
	    $input->SetAttach($arr["attach"]);                              //附加数据
	    //$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
	    $input->SetOut_trade_no($arr["out_trade_no"]);                  //商铺订单号
	    $input->SetTotal_fee($arr["total_fee"]);                        //总金额
	    $input->SetTime_start(date("YmdHis"));                          //交易起始时间
	    $input->SetTime_expire(date("YmdHis", time() + 600));           //交易结束时间
	    $input->SetGoods_tag($arr["tag"]);                              //商品标记
	    $input->SetNotify_url(C("ht_pay_path.carownerRechargePay"));    //回调地址
	    $input->SetTrade_type("JSAPI");
	    $input->SetOpenid($openId);
	    $order = WxPayApi::unifiedOrder($input);
	    $jsApiParameters = $tools->GetJsApiParameters($order);
	    return $jsApiParameters;
	}
	/**
	 * 模拟post进行url请求
	 * @param string $url
	 * @param string $param
	 */
	function Http_post($url = '', $param = '') {
	    if (empty($url) || empty($param)) {
	        return false;
	    }
	    $postUrl = $url;
	    $curlPost = $param;
	    $ch = curl_init();                                  //初始化curl
	    curl_setopt($ch, CURLOPT_URL,$postUrl);             //抓取指定网页
	    curl_setopt($ch, CURLOPT_HEADER, 0);                //设置header
	    curl_setopt($ch,CURLOPT_TIMEOUT,3);                 //定义超时3秒钟
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        //要求结果为字符串且输出到屏幕上
	    curl_setopt($ch, CURLOPT_POST, 1);                  //post提交方式
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
	    $data = curl_exec($ch);                             //运行curl
	    curl_close($ch);
	    return $data;
	}
	/* 发送json格式的数据，到api接口 -xzz0704  */
	function https_curl_json($url,$data,$type){
	    if($type=='json'){//json $_POST=json_decode(file_get_contents('php://input'), TRUE);
	        $headers = array("Content-type: application/json;charset=UTF-8","Accept: application/json","Cache-Control: no-cache", "Pragma: no-cache");
	        $data=json_encode($data,320);
	    }
	    
	    
	    //dump($data);die;
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	    if (!empty($data)){
	        curl_setopt($curl, CURLOPT_POST, 1);
	        curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
	    }
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers );
	    $output = curl_exec($curl);
	    if (curl_errno($curl)) {
	        echo 'Errno'.curl_error($curl);//捕抓异常
	    }
	    curl_close($curl);
	    return $output;
	}
    //将XML转为array
    function xmlToArray($xml)
    {
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $values;
    }
    //单订申请退款
    function pc_passenger_task_refund($ordernum,$Transaction_id,$money){
        Vendor('wxpay.lib.Api');
        Vendor('wxpay.lib.JsApiPay');
        $tools = new \JsApiPay();
        $input = new \WxPayRefund();
        //查询订单信息
        $input->SetOut_trade_no($ordernum);                         //商家订单号
        $input->SetTransaction_id($Transaction_id);                 //微信交易号
        $input->SetOut_refund_no(C("wx_pay.mchid").date("YmdHis")); //退款订单号
        $input->SetTotal_fee($money);                               //订单金额
        $input->SetRefund_fee($money);                              //退款金额
        $input->SetOp_user_id(C("wx_pay.mchid"));                   //操作员"1489603982"
        return WxPayApi::refund($input);
    }
    //申请单订部分退款
    function pc_order_refund($ordernum,$Transaction_id,$total_payment,$refund_fee){
        Vendor('wxpay.lib.Api');
        Vendor('wxpay.lib.JsApiPay');
        $tools = new \JsApiPay();
        $input = new \WxPayRefund();
        //查询订单信息
        $input->SetOut_trade_no($ordernum);                         //商家订单号
        $input->SetTransaction_id($Transaction_id);                 //微信交易号
        $input->SetOut_refund_no(C("wx_pay.mchid").date("YmdHis"));//退款订单号
        $input->SetTotal_fee($total_payment);                       //订单金额
        $input->SetRefund_fee($refund_fee);                         //退款金额
        $input->SetOp_user_id(C("wx_pay.mchid"));                   //操作员"1489603982"
        return WxPayApi::refund($input);
    }
    //新的支付接口
	//测试支付
	function paytest($arr){
	    $config = array(
	        'appid'		=> C("WX_PAY.APPID"),
	        'mch_id'	 	=> C("WX_PAY.MCHID"),
	        'pay_apikey' 	=> C("WX_PAY.SECRECT_KEY"),
	        'api_cert'		=> C("WX_PAY.SSLCERT_PATH"),
	        'api_key'		=> C("WX_PAY.SSLKEY_PATH")
	    );
	    Vendor('wxpay.WxPayjikou');
	    $wxpay = new \WxPayjikou($config);
	    $res=$wxpay->xx();
		//$res = $wxpay->wxpay($arr["openid"],$arr["total_fee"],$arr["body"],$arr["out_trade_no"],$arr["notify_url"]);
		return $res;
	}
	
	//发送短信
	/**
	 * @param 手机号码     $mobile
	 * @param 短信码编号 $smscode
	 * @param 发送的参数 $paramString
	 * @return boolean
	 */
	function send_aliyun_msg($mobile,$smscode,$paramString){
	    //发送短信开始
	    Vendor('alisms.Alisms');
	    $alisms = new \Alisms(C('ali_sms.key_id'),C('ali_sms.key_secret'));
	    $alisms->signName = C('ali_sms.signname');
	    $re = $alisms->smsend($mobile,$smscode,$paramString);

	    if($re['Code'] =='OK'){
	        return TRUE;
	    }else{
	        return false;
	    }
	}
	
	
	//车主身份审核发送公众号模板消息函数
    function send_carownermb_msg($m_id,$unionid,$mbid,$data,$flag){
        $access_token=getAccessToken2();
        $rs=M("gzh_member")->where("unionid='".$unionid."'")->find();
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token;
        if($rs){
            $dd=array(
                "touser"        =>$rs["openid"],
                "template_id"   =>$mbid,
                "url"           =>"",//这里是搜索页面
                "data"          =>array(
                    "first"=>array(
                        "value"=>$data["title"],
                        "color"=>"#173177"
                    ),
                    "keyword1"=>array(
                        "value"=>$data["truename"],
                        "color"=>"#173177"
                    ),
                    "keyword2"=>array(
                        "value"=>$data["car_model"]."-".$data["car_number"],
                        "color"=>"#173177"
                    ),
                    "keyword3"=>array(
                        "value"=>date("Y-m-d H:i:s"),
                        "color"=>"#173177"
                    ),                            
                    "remark"=>array(
                        "value"=>$data["remark"],
                        "color"=>"#173177"
                    ),
                )
            );
            $res=https_curl_json($url,$dd,'json');
            $res=json_decode($res,true);
            if($res["errcode"]!="0" || $res["errmsg"]!="ok" ){
                Vendor('alisms.Alisms');
                $alisms = new \Alisms(C('ali_sms.key_id'),C('ali_sms.key_secret'));
                $temp_code   = C('ali_sms.sms17');
                $rt=M("member")->find($m_id);
                $paramString = '{"truename":"'.$rt["truename"].'","flag":"'.$flag.'"}';
                $alisms->signName = C('ali_sms.signname');
                $alisms->smsend($rt["mobile"],$temp_code,$paramString);
            }
        }else{
            //发送短信开始
            Vendor('alisms.Alisms');
            $alisms = new \Alisms(C('ali_sms.key_id'),C('ali_sms.key_secret'));
            $temp_code   = C('ali_sms.sms17');
            $rt=M("member")->find($m_id);
            $paramString = '{"truename":"'.$rt["truename"].'","flag":"'.$flag.'"}';
            $alisms->signName = C('ali_sms.signname');
            $alisms->smsend($rt["mobile"],$temp_code,$paramString);

        }
    }
    //车主竟价审核发送公众号模板消息函数
    function send_carownermb_bidding_msg($mobile,$m_id,$unionid,$mbid,$data,$flag){
        $access_token=getAccessToken2();
        $rs=M("gzh_member")->where("unionid='".$unionid."'")->find();
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token;
        if($rs){
            $dd=array(
                "touser"        =>$rs["openid"],
                "template_id"   =>$mbid,
                "url"           =>"",//这里是搜索页面
                "data"          =>array(
                    "first"=>array(
                        "value"=>$data["title"],
                        "color"=>"#173177"
                    ),
                    "keyword1"=>array(
                        "value"=>$data["truename"],
                        "color"=>"#173177"
                    ),
                    "keyword2"=>array(
                        "value"=>$data["mobile"],
                        "color"=>"#173177"
                    ),
                    "keyword3"=>array(
                        "value"=>$data["wx"],
                        "color"=>"#173177"
                    ),
                    "keyword4"=>array(
                        "value"=>$data["date"],
                        "color"=>"#173177"
                    ),                    
                    "remark"=>array(
                        "value"=>$data["remark"],
                        "color"=>"#173177"
                    ),
                )
            );
            $res=https_curl_json($url,$dd,'json');
            $res=json_decode($res,true);
            if($res["errcode"]!="0" || $res["errmsg"]!="ok" ){
                //发送短信开始
                Vendor('alisms.Alisms');
                $alisms = new \Alisms(C('ali_sms.key_id'),C('ali_sms.key_secret'));
                $temp_code   = C('ali_sms.sms16');
                $rt=M("member")->find($m_id);
                $paramString = '{"truename":"'.$rt["truename"].'","flag":"'.$flag.'"}';
                $alisms->signName = C('ali_sms.signname');
                $alisms->smsend($mobile,$temp_code,$paramString);
            }
        }else{
            //发送短信开始
            Vendor('alisms.Alisms');
            $alisms = new \Alisms(C('ali_sms.key_id'),C('ali_sms.key_secret'));
            $temp_code   = C('ali_sms.sms16');
            $rt=M("member")->find($m_id);
            $paramString = '{"truename":"'.$rt["truename"].'","flag":"'.$flag.'"}';
            $alisms->signName = C('ali_sms.signname');
            $alisms->smsend($mobile,$temp_code,$paramString);
        }
    }
    
    /**
     * @订单状态改变发送模板消息函数
     * @param 会员id $m_id
     * @param 会员的unionid $unionid
     * @param 公众号模板消息id  $mbid
     * @param 模板消息数据 $data
     * @param 短信模板id $smsid
     * @param 短信发送参数 $paramString
     * @return number[]|string[]
     */
    function send_orderstatus_msg($m_id,$unionid,$mbid,$data,$smsid,$paramString){
        $access_token=getAccessToken2();
        $rs=M("gzh_member")->where("unionid='".$unionid."'")->find();
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token;
        if($rs){
            $dd=array(
                "touser"        =>$rs["openid"],
                "template_id"   =>$mbid,
                "url"           =>"",//这里是搜索页面
                "data"          =>array(
                    "first"=>array(
                        "value"=>$data["ordernum"],
                        "color"=>"#173177"
                    ),
                    "keyword1"=>array(
                        "value"=>$data["starting_place"],
                        "color"=>"#173177"
                    ),
                    "keyword2"=>array(
                        "value"=>$data["end_place"],
                        "color"=>"#173177"
                    ),
                    "keyword3"=>array(
                        "value"=>$data["status"],
                        "color"=>"#173177"
                    ),
                    "remark"=>array(
                        "value"=>$data["remark"],
                        "color"=>"#173177"
                    ),
                )
            );
            $res=https_curl_json($url,$dd,'json');
            $res=json_decode($res,true);
            if($res["errcode"]!="0" || $res["errmsg"]!="ok" ){
                //发送短信开始
                Vendor('alisms.Alisms');
                $alisms = new \Alisms(C('ali_sms.key_id'),C('ali_sms.key_secret'));
                $rt=M("member")->find($m_id);
                $alisms->signName = C('ali_sms.signname');
                $alisms->smsend($rt["mobile"],$smsid,$paramString);
            }
        }else{
            //发送短信开始
            Vendor('alisms.Alisms');
            $alisms = new \Alisms(C('ali_sms.key_id'),C('ali_sms.key_secret'));
            $rt=M("member")->find($m_id);
            $alisms->signName = C('ali_sms.signname');
            $alisms->smsend($rt["mobile"],$smsid,$paramString);
        }
    }    
    /**
     * @出行任务完成发送模板消息函数
     * @param 会员id $m_id
     * @param 会员的unionid $unionid
     * @param 公众号模板消息id  $mbid
     * @param 模板消息数据 $data
     * @param 短信模板id $smsid
     * @param 短信发送参数 $paramString
     * @return number[]|string[]
     */
    function send_orderover_msg($m_id,$unionid,$mbid,$data,$smsid,$paramString){
        $access_token=getAccessToken2();
        $rs=M("gzh_member")->where("unionid='".$unionid."'")->find();
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token;
        if($rs){
            $dd=array(
                "touser"        =>$rs["openid"],
                "template_id"   =>$mbid,
                "url"           =>"",//这里是搜索页面
                "data"          =>array(
                    "ordernum"=>array(
                        "value"=>$data["ordernum"],
                        "color"=>"#173177"
                    ),
                    "keyword1"=>array(
                        "value"=>$data["starting_place"],
                        "color"=>"#173177"
                    ),
                    "keyword2"=>array(
                        "value"=>$data["end_place"],
                        "color"=>"#173177"
                    ),
                    "remark"=>array(
                        "value"=>$data["remark"],
                        "color"=>"#173177"
                    ),
                )
            );
            $res=https_curl_json($url,$dd,'json');
            $res=json_decode($res,true);
            if($res["errcode"]!="0" || $res["errmsg"]!="ok" ){
                //发送短信开始
                Vendor('alisms.Alisms');
                $alisms = new \Alisms(C('ali_sms.key_id'),C('ali_sms.key_secret'));
                $rt=M("member")->find($m_id);
                $alisms->signName = C('ali_sms.signname');
                $alisms->smsend($rt["mobile"],$smsid,$paramString);
            }
        }else{
            //发送短信开始
            Vendor('alisms.Alisms');
            $alisms = new \Alisms(C('ali_sms.key_id'),C('ali_sms.key_secret'));
            $rt=M("member")->find($m_id);
            $alisms->signName = C('ali_sms.signname');
            $alisms->smsend($rt["mobile"],$smsid,$paramString);
        }
    }    
?>	