<?php
namespace Admin\Controller;

use Think\Controller;

class CommonController extends Controller
{

    protected $uniacid = 1;

    public function _initialize()
    {
        
        $this->check_login();
        $current_url = get_url();
        
        // $key = 'addons/' . WE7_MODULE_NAME;
        
        $we7_url = 'https://' . $_SERVER['HTTP_HOST'];
        
        $this->assign('logout', $we7_url);
        
        $this->getConfig();
    }
    
    /*
     *@用于获取全局变量函数
     */
    protected function getConfig(){
        $config = S('shopconfig');
        if(!$config)
        {
            $config = M('config')->where("uniacid=".$this->uniacid)->find();
            $config["wx_pay_appid"]=$config["pingche_xcx_appid"];//
            $config["member"]=array(
                "deposit"=>$config["member_deposit"],
                "redpacked"=>$config["member_redpacked"],
                "share"=>$config["member_share"],
                "jine"=>$config["member_jine"],
                "taskcount"=>$config["member_taskcount"]
            );
            unset($config["member_deposit"],$config["member_redpacked"],$config["member_share"],$config["member_jine"],$config["member_taskcount"]);
            $config["platform"]=array(
                "plat_dj_passenger"=>$config["platform_plat_dj_passenger"],
                "plat_dj_car_owner"=>$config["platform_plat_dj_car_owner"],
                "plat_car_owner1"=>$config["platform_plat_car_owner1"],
                "plat_passenger2"=>$config["platform_plat_passenger2"],
                "platform"=>$config["platform_platform"],
                "car_owner"=>$config["platform_car_owner"],
                "passenger"=>$config["platform_passenger"],
                "cover_charge"=>$config["platform_cover_charge"],
            );
            unset($config["platform_plat_dj_passenger"],
                $config["platform_plat_dj_car_owner"],
                $config["platform_plat_car_owner1"],
                $config["platform_plat_passenger2"],
                $config["platform_platform"],
                $config["platform_car_owner"],
                $config["platform_passenger"],
                $config["platform_cover_charge"]);

            $config["pingche_xcx"]=array(
                "appid"=>$config["pingche_xcx_appid"],
                "secret"=>$config["pingche_xcx_secret"],
            );
            

            $config["ali_sms"]=array(
                "product"=>'Dysmsapi',
                "domain"=>'dysmsapi.aliyuncs.com',
                "region"=>'cn-hangzhou',
                "end_point_name"=>'cn-hangzhou',
                "key_id"=>$config["ali_sms_key_id"],
                "key_secret"=>$config["ali_sms_key_secret"],
                "signname"=>$config["ali_sms_signname"],
                "templatecode"=>$config["ali_sms_templatecode"],
                "sms2"=>$config["ali_sms_sms2"],
                "sms3"=>$config["ali_sms_sms3"],
                "sms4"=>$config["ali_sms_sms4"],
                "sms5"=>$config["ali_sms_sms5"],
                "sms6"=>$config["ali_sms_sms6"],
                "sms7"=>$config["ali_sms_sms7"],
                "sms8"=>$config["ali_sms_sms8"],
                "sms9"=>$config["ali_sms_sms9"],
                "sms10"=>$config["ali_sms_sms10"],
                "sms11"=>$config["ali_sms_sms11"],
                "sms12"=>$config["ali_sms_sms12"],
                "sms13"=>$config["ali_sms_sms13"],
                "sms14"=>$config["ali_sms_sms14"],
                "sms15"=>$config["ali_sms_sms15"],
                "sms16"=>$config["ali_sms_sms16"],
                "sms17"=>$config["ali_sms_sms17"],
                "sms18"=>$config["ali_sms_sms18"],
                "sms19"=>$config["ali_sms_sms19"],
                "sms20"=>$config["ali_sms_sms20"],
                "sms21"=>$config["ali_sms_sms21"],
                "sms22"=>$config["ali_sms_sms22"],
                "sms23"=>$config["ali_sms_sms23"]
            );
            unset($config["ali_sms_product"],
                $config["ali_sms_domain"],
                $config["ali_sms_region"],
                $config["ali_sms_end_point_name"],
                $config["ali_sms_key_id"],
                $config["ali_sms_key_secret"],
                $config["ali_sms_signname"],
                $config["ali_sms_templatecode"],
                $config["ali_sms_sms2"],
                $config["ali_sms_sms3"],
                $config["ali_sms_sms4"],
                $config["ali_sms_sms5"],
                $config["ali_sms_sms6"],
                $config["ali_sms_sms7"],
                $config["ali_sms_sms8"],
                $config["ali_sms_sms9"],
                $config["ali_sms_sms10"],
                $config["ali_sms_sms11"],
                $config["ali_sms_sms12"],
                $config["ali_sms_sms13"],
                $config["ali_sms_sms14"],
                $config["ali_sms_sms15"],
                $config["ali_sms_sms16"],
                $config["ali_sms_sms17"],
                $config["ali_sms_sms18"],
                $config["ali_sms_sms19"],
                $config["ali_sms_sms20"],
                $config["ali_sms_sms21"],
                $config["ali_sms_sms22"],
                $config["ali_sms_sms23"]
            );
            $config["wx_pay"]=array(
                "appid"=>$config["wx_pay_appid"],
                "mchid"=>$config["wx_pay_mchid"],
                "secrect_key"=>$config["wx_pay_secrect_key"],
                "ip"=>get_client_ip(),
                "sslcert_path"=>"./ThinkPHP/Library/Vendor/wxpay/cert/apiclient_cert.pem",
                "sslkey_path"=>'./ThinkPHP/Library/Vendor/wxpay/cert/apiclient_key.pem',
            );
            unset(
                $config["auth_on"],$config["auth_type"],$config["auth_group"],$config["auth_group_access"],
                $config["auth_rule"],$config["auth_user"],$config["nclass"],$config["tmpl_exception_file"],
                $config["error_page"],$config["tmpl_template_suffix"],$config["default_module"],$config["module_allow_list"],
                $config["module_deny_list"],$config["uploadaddr_uploadhead"],$config["uploadaddr_adimg"],$config["uploadaddr_complain"],
                $config["ht_pay_path_passengertaskpay"],$config["ht_pay_path_passengerbuyseatpay"],$config["ht_pay_path_carownerrechargepay"],
                $config["wx_pay_appid"],$config["wx_pay_mchid"],$config["wx_pay_secrect_key"],$config["wx_pay_ip"],$config["uptype"],
                $config["wx_pay_sslcert_path"],$config["wx_pay_sslkey_path"],$config["pingche_xcx_secret"],$config["pingche_xcx_appid"],
                $config["templet_id1"],$config["templet_id2"],$config["templet_id3"]
            );
            S('shopconfig',$config);
        }
        C($config);
    }   
    

    protected function check_login()
    
    {
        $account = session('we8');
        
        if (empty($account)) {
            
            $this->error('登录已超时');
        }
        
        $this->uniacid = $account['acid'];
    }
}