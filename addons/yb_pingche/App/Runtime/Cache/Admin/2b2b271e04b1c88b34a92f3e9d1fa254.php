<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    
    <head>
        <meta charset="utf-8">
        <title></title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="format-detection" content="telephone=no">
        <link rel="stylesheet" href="/addons/yb_pingche/Public/css/x-admin.css" media="all">
        <script src="/addons/yb_pingche/Public/js/jquery.js"></script>     
    </head>
    
    <body>
        <div class="x-body">
       <div class="x-nav">
            <span class="layui-breadcrumb">
              <a><cite>首页</cite></a>
              <a><cite>基本设置</cite></a>
              <a><cite>支付设置</cite></a>
            </span>
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"  href="javascript:location.replace(location.href);" title="刷新"><i class="layui-icon" style="line-height:30px">ဂ</i></a>
        </div>       
            <form class="layui-form layui-form-pane" id="form1" name="form1" method="post" action="<?php echo U('Subset/update');?>">
                <div class="layui-form-item" style="margin-top:20px;">
                    <label for="L_title" class="layui-form-label" style="width:155px;"><span class="x-red">*</span>小程序Appid</label>
                    <div class="layui-input-block" style="margin-left:187px;">
                        <input type="text"  name="pingche_xcx_appid"  value="<?php echo ($data['pingche_xcx_appid']); ?>" placeholder="" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:155px;"><span class="x-red">*</span>小程序的密钥</label>
                    <div class="layui-input-block" style="margin-left:187px;">
                        <input type="text" name="pingche_xcx_secret" value="<?php echo ($data['pingche_xcx_secret']); ?>"  placeholder="" autocomplete="off" class="layui-input">
                    </div>
                </div>
                 <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:155px;"><span class="x-red">*</span>商户号</label>
                    <div class="layui-input-block" style="margin-left:187px;">
                        <input type="text" name="wx_pay_mchid"  value="<?php echo ($data['wx_pay_mchid']); ?>" placeholder="" autocomplete="off" class="layui-input">
                    </div>
                </div>               
                 <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:155px;"><span class="x-red">*</span>支付密钥</label>
                    <div class="layui-input-block" style="margin-left:187px;">
                        <input type="text" name="wx_pay_secrect_key"  value="<?php echo ($data['wx_pay_secrect_key']); ?>" placeholder="" autocomplete="off" class="layui-input">
                    </div>
                </div>
                 <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:155px;"><span class="x-red">*</span>支付证书cert<?php if($data['wx_pay_sslcert_path']) echo '(已填写)' ?></label>
                    <div class="layui-input-block" style="margin-left:187px;">
                        <textarea name="wx_pay_sslcert_path"   placeholder="" class="layui-textarea onfocus" t="<?php echo ($data['wx_pay_sslcert_path']); ?>"></textarea>
                    </div>
                </div>                 
                 <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:155px;"><span class="x-red">*</span>支付证书key <?php if($data['wx_pay_sslkey_path']) echo '(已填写)' ?></label>
                    <div class="layui-input-block" style="margin-left:187px;">
                        <textarea name="wx_pay_sslkey_path" placeholder=""  class="layui-textarea onfocus" t="<?php echo ($data['wx_pay_sslkey_path']); ?>"></textarea>
                    </div>
                </div>                
                 <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:155px;"><span class="x-red">*</span>小程序名称</label>
                    <div class="layui-input-block" style="margin-left:187px;">
                        <input type="text" name="appname"  value="<?php echo ($data['appname']); ?>" placeholder="" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:155px;"><span class="x-red">*</span>版权信息</label>
                    <div class="layui-input-block" style="margin-left:187px;">
                        <input type="text" name="copyright"  value="<?php echo ($data['copyright']); ?>" placeholder="" autocomplete="off" class="layui-input">
                    </div>
                </div>  
                <div class="layui-form-item">
                <input type="hidden" id="a_id" name="a_id" value="<?php echo ($a_id); ?>" />
                    <button class="layui-btn" id="nclick">提交信息</button>
                </div>
            </form>
        </div>
		<script src="/addons/yb_pingche/Public/layui/layui.js" charset="utf-8"></script>
		<script src="/addons/yb_pingche/Public/js/x-layui.js" charset="utf-8"></script>
		<script>
	    $('.onfocus').focus(function () {
	        $(this).text($(this).attr('t'));
	    })

		layui.use(['element','layer','layedit','form'], function(){
			  layedit = layui.layedit;  
			  //lement = layui.element();//面包导航
			  layer = layui.layer;//弹出层
			  //form = layui.form();
		});    
		</script>
    </body>
</html>