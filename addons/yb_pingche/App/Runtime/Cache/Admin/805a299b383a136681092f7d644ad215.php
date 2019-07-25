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
              <a><cite>客服信息</cite></a>
            </span>
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"  href="javascript:location.replace(location.href);" title="刷新"><i class="layui-icon" style="line-height:30px">ဂ</i></a>
        </div>       
            <form class="layui-form layui-form-pane" id="form1" name="form1" method="post" action="<?php echo U('Subset/update');?>">
                <div class="layui-form-item" style="margin-top:20px;">
                    <label for="L_title" class="layui-form-label" style="width:175px;"><span class="x-red">*</span>客服电话</label>
                    <div class="layui-input-inline" style="width:70%;">
                        <input name="kefumobile" type="text" value="<?php echo ($data['kefumobile']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                    	<span></span>
                    </div> 
                </div>
                <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:175px;"><span class="x-red">*</span>客服时间</label>
                    <div class="layui-input-inline" style="width:70%;">
                        <input name="kefu_time" type="text" value="<?php echo ($data['kefu_time']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
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