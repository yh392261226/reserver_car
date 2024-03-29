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
              <a><cite>上传设置</cite></a>
            </span>
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"  href="javascript:location.replace(location.href);" title="刷新"><i class="layui-icon" style="line-height:30px">ဂ</i></a>
        </div>       
            <form class="layui-form layui-form-pane" id="form1" name="form1" method="post" action="<?php echo U('Subset/update');?>">
                <div class="layui-form-item" style="margin-top:20px;">
                        <label class="layui-form-label" style="width:155px;"><span class="x-red">*</span>上传方式</label>
                        <div class="layui-input-block" style="margin-left:187px;">
                            <select lay-verify="required" name="upload_type" lay-verify="required" lay-filter="upload_type">
                                <option>
                                </option>
                                <optgroup label="请选择">
                                    <option value="0" <?php if($data['upload_type'] == 0) echo 'selected' ?>>本地上传</option>
                                    <option value="1" <?php if($data['upload_type'] == 1) echo 'selected' ?>>阿里云</option>
									<option value="2" <?php if($data['upload_type'] == 2) echo 'selected' ?>>七牛云</option>
                                </optgroup>
                            </select><span id="upload_typea"></span>
                        </div>
                </div>                
                <div class="layui-form-item" >
                    <label for="L_title" class="layui-form-label" style="width:155px;"><span class="x-red">*</span>文件大小限制(byte)</label>
                    <div class="layui-input-block" style="margin-left:187px;">
                        <input type="text"  name="max_upload_size"  value="<?php echo ($data['max_upload_size']); ?>" placeholder="" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item al_oss" <?php if($data["upload_type"] == 1): ?>style="display:block"<?php else: ?>style="display:none"<?php endif; ?>>
                    <label for="L_title" class="layui-form-label" style="width:155px;"><span class="x-red">*</span>阿里云 oss_access_id</label>
                    <div class="layui-input-block" style="margin-left:187px;">
                        <input type="text" name="oss_access_id" value="<?php echo ($data['oss_access_id']); ?>"  placeholder="" autocomplete="off" class="layui-input">
                    </div>
                </div>
                 <div class="layui-form-item al_oss" <?php if($data["upload_type"] == 1): ?>style="display:block"<?php else: ?>style="display:none"<?php endif; ?>>
                    <label for="L_title" class="layui-form-label" style="width:155px;"><span class="x-red">*</span>阿里云 oss_access_key</label>
                    <div class="layui-input-block" style="margin-left:187px;">
                        <input type="text" name="oss_access_key"  value="<?php echo ($data['oss_access_key']); ?>" placeholder="" autocomplete="off" class="layui-input">
                    </div>
                </div>               
                 <div class="layui-form-item al_oss" <?php if($data["upload_type"] == 1): ?>style="display:block"<?php else: ?>style="display:none"<?php endif; ?>>
                    <label for="L_title" class="layui-form-label" style="width:155px;"><span class="x-red">*</span>阿里云 oss_endpoint</label>
                    <div class="layui-input-block" style="margin-left:187px;">
                        <input type="text" name="oss_endpoint"  value="<?php echo ($data['oss_endpoint']); ?>" placeholder="" autocomplete="off" class="layui-input">
                    </div>
                </div>
                 <div class="layui-form-item al_oss" <?php if($data["upload_type"] == 1): ?>style="display:block"<?php else: ?>style="display:none"<?php endif; ?>>
                    <label for="L_title" class="layui-form-label" style="width:155px;"><span class="x-red">*</span>阿里云OSS bucket</label>
                    <div class="layui-input-block" style="margin-left:187px;">
                        <input type="text" name="oss_bucket"   value="<?php echo ($data['oss_bucket']); ?>" placeholder="" autocomplete="off" class="layui-input" >
                    </div>
                </div>                               
                 <div class="layui-form-item al_oss" <?php if($data["upload_type"] == 1): ?>style="display:block"<?php else: ?>style="display:none"<?php endif; ?>>
                    <label for="L_title" class="layui-form-label" style="width:155px;"><span class="x-red">*</span>阿里云oss_web_site</label>
                    <div class="layui-input-block" style="margin-left:187px;">
                        <input type="text" name="oss_web_site"  value="<?php echo ($data['oss_web_site']); ?>" placeholder="" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <!-- 七牛云开始  -->
 				<div class="layui-form-item qn_oss" <?php if($data["upload_type"] == 2): ?>style="display:block"<?php else: ?>style="display:none"<?php endif; ?>>
                    <label for="L_title" class="layui-form-label" style="width:155px;"><span class="x-red">*</span>七牛云accessKey</label>
                    <div class="layui-input-block" style="margin-left:187px;">
                        <input type="text" name="qiniu_ak" value="<?php echo ($data['qiniu_ak']); ?>"  placeholder="" autocomplete="off" class="layui-input">
                    </div>
                </div>
                 <div class="layui-form-item qn_oss" <?php if($data["upload_type"] == 2): ?>style="display:block"<?php else: ?>style="display:none"<?php endif; ?>>
                    <label for="L_title" class="layui-form-label" style="width:155px;"><span class="x-red">*</span>七牛云的secretKey</label>
                    <div class="layui-input-block" style="margin-left:187px;">
                        <input type="text" name="qiniu_sk"  value="<?php echo ($data['qiniu_sk']); ?>" placeholder="" autocomplete="off" class="layui-input">
                    </div>
                </div>               
                 <div class="layui-form-item qn_oss" <?php if($data["upload_type"] == 2): ?>style="display:block"<?php else: ?>style="display:none"<?php endif; ?>>
                    <label for="L_title" class="layui-form-label" style="width:155px;"><span class="x-red">*</span>七牛云OSS bucket</label>
                    <div class="layui-input-block" style="margin-left:187px;">
                        <input type="text" name="qiniu_bucket"  value="<?php echo ($data['qiniu_bucket']); ?>" placeholder="" autocomplete="off" class="layui-input">
                    </div>
                </div>
                 <div class="layui-form-item qn_oss" <?php if($data["upload_type"] == 2): ?>style="display:block"<?php else: ?>style="display:none"<?php endif; ?>>
                    <label for="L_title" class="layui-form-label" style="width:155px;"><span class="x-red">*</span>七牛云OSS_web_site</label>
                    <div class="layui-input-block" style="margin-left:187px;">
                        <input type="text" name="qiniu_site"   value="<?php echo ($data['qiniu_site']); ?>" placeholder="" autocomplete="off" class="layui-input" >
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
		layui.use(['layer', 'form'], function(){
			    var layer = layui.layer,form = layui.form;
			    form.on('select(upload_type)', function(data){
			   	if(data.value=="0"){
				    $(".al_oss").hide();
				    $(".qn_oss").hide();
			  	}
			   	if(data.value=="1"){
				    $(".al_oss").show();
				    $(".qn_oss").hide();
			  	}		  	
			   	if(data.value=="2"){
				    $(".al_oss").hide();
				    $(".qn_oss").show();
			  	}		  
			});
		});		
		layui.use(['element','layer','layedit','form'], function(){
			  layedit = layui.layedit;  
			  //lement = layui.element();//面包导航
			  layer = layui.layer;//弹出层
			  //form = layui.form();
		});
		</script>
    </body>
</html>