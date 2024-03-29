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
              <a><cite>公众号配置</cite></a>
            </span>
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"  href="javascript:location.replace(location.href);" title="刷新"><i class="layui-icon" style="line-height:30px">ဂ</i></a>
        </div>       
            <form class="layui-form layui-form-pane" id="form1" name="form1" method="post" action="<?php echo U('Subset/update');?>">
                <blockquote class="layui-elem-quote" style='height:30px;line-height:30px;;padding:0px;width:100%;'>
	            <p>注意：<font color=red>公众号绑定小程序需要两者都绑定在同一个微信开放平台下，如尚未绑定请登录开放平台绑定公众号和小程序，</font><a href='https://open.weixin.qq.com/' target='_blank'>前往开放平台</a> </p>
	            </blockquote>
                <div class="layui-form-item" style="margin-top:20px;">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>服务号appid</label>
                    <div class="layui-input-inline" style="width:70%;">
                    	<input name="gzh_appid" type="text" value="<?php echo ($data['gzh_appid']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                    	<span></span>
                    </div> 
                </div>
                <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>服务号密钥</label>
                    <div class="layui-input-inline" style="width:70%;">
                    	<input name="gzh_secret" type="text" value="<?php echo ($data['gzh_secret']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>
					</div>
                </div>
                 <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>服务号令牌</label>
                    <div class="layui-input-inline" style="width:70%;">
                    	<input name="gzh_token" type="text" value="<?php echo ($data['gzh_token']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>
					</div>                     
                </div>               
                 <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>车主身份认证通知模板消息id</label>
                    <div class="layui-input-inline" style="width:30%;">
                    	<input name="gzh_template1" type="text" value="<?php echo ($data['gzh_template1']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>审核结果通知 变量 first.DATA、keyword1.DATA、keyword2.DATA、keyword3.DATA、remark.DATA
					</div>                    
                </div>
                 <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>车主竟价通知模板消息id</label>
                    <div class="layui-input-inline" style="width:30%;">
                    	<input name="gzh_template2" type="text" value="<?php echo ($data['gzh_template2']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
	                <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>审核提醒  变量 first.DATA、姓名keyword1.DATA、手机号keyword2.DATA、微信号keyword3.DATA、申请时间keyword4.DATA、remark.DATA
					</div>                   
                </div>                 
                 <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>批量发送模板消息id</label>
                    <div class="layui-input-inline" style="width:30%;">
                    	<input name="gzh_template3" type="text" value="<?php echo ($data['gzh_template3']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>购买成功通知  {{first.DATA}}、商品信息：{{keyword1.DATA}}、温馨提示：{{keyword2.DATA}}、{{remark.DATA}}
					</div>                    
                </div>                
                 <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>业务域名效验文件上传状态</label>
                    <div class="layui-input-inline" style="width:70%;">
                    	<input name="gzh_ywym_status1" type="text" value="<?php echo ($data['gzh_ywym_status1']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>
					</div>                    
                </div>
                <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>配置业务域名效验文件名称</label>
                    <div class="layui-input-inline" style="width:70%;">
                    	<input name="gzh_ywym_filename" type="text" value="<?php echo ($data['gzh_ywym_filename']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>
					</div>                   
                </div>
                <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>配置业务域名效验文件内容</label>
                    <div class="layui-input-inline" style="width:70%;">
                    	<input name="gzh_ywym_filecontent" type="text" value="<?php echo ($data['gzh_ywym_filecontent']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>
					</div>                   
                </div>
                 <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>网页授权效验文件上传状态</label>
                    <div class="layui-input-inline" style="width:70%;">
                    	<input name="gzh_wysq_status1" type="text" value="<?php echo ($data['gzh_wysq_status1']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>
					</div>                  
                </div>
                 <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>网页授权域名效验文件名称</label>
                    <div class="layui-input-inline" style="width:70%;">
                    	<input name="gzh_wysq_filename" type="text" value="<?php echo ($data['gzh_wysq_filename']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>
					</div>                   
                </div>                
                <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>网页授权域名效验文件内容</label>
                    <div class="layui-input-inline" style="width:70%;">
                    	<input name="gzh_wysq_filecontent" type="text" value="<?php echo ($data['gzh_wysq_filecontent']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>
					</div>                   
                </div>               
                                                                                         
                <div class="layui-form-item">
                    <button class="layui-btn" id="nclick">提交信息</button>
                </div>
            </form>
        </div>
		<script src="/addons/yb_pingche/Public/layui/layui.js" charset="utf-8"></script>
		<script src="/addons/yb_pingche/Public/js/x-layui.js" charset="utf-8"></script>
		<script>
		layui.use(['element','layer','layedit','form'], function(){
			  layedit = layui.layedit;  
			  //lement = layui.element();//面包导航
			  layer = layui.layer;//弹出层
			  //form = layui.form();
		});    
		</script>
    </body>
</html>