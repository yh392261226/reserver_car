<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo (session('web_title')); ?></title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="/addons/yb_pingche/Public/admincss/layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="/addons/yb_pingche/Public/admincss/layuiadmin/style/admin.css" media="all">
</head>
<body>
  
  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md8" style="width:100%;">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
            <div class="layui-card" >
              <div class="layui-card-header">数据统计</div>
              <div class="layui-card-body">

                <div class="layui-carousel layadmin-carousel layadmin-backlog">
                  <div carousel-item>
                    <ul class="layui-row layui-col-space10">
                      <li class="layui-col-xs6" >
                        <a href="javascript:;" onclick="layer.tips('总交易额:<?php echo ($summenoy); ?>', this, {tips: 3});" class="layadmin-backlog-body" style="background-color:#A9F5D0;">
                          <h3 style="color:#000">总交易额</h3>
                          <p><cite><?php echo ($summenoy); ?></cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs6" >
                        <a href="javascript:;" onclick="layer.tips('总笔数:<?php echo ($sumcount); ?>', this, {tips: 3});" class="layadmin-backlog-body" style="background-color:#A9F5D0;">
                          <h3 style="color:#000">总笔数</h3>
                          <p><cite><?php echo ($sumcount); ?></cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs6" >
                        <a href="javascript:;" onclick="layer.tips('昨天交易额:<?php echo ($yessummenoy); ?>', this, {tips: 3});" class="layadmin-backlog-body" style="background-color:#A9F5D0;">
                          <h3 style="color:#000">昨天交易额</h3>
                          <p><cite><?php echo ($yessummenoy); ?></cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs6" >
                        <a href="javascript:;" onclick="layer.tips('昨日交易数:<?php echo ($yessumcount); ?>', this, {tips: 3});" class="layadmin-backlog-body" style="background-color:#A9F5D0;">
                          <h3 style="color:#000">昨日交易数</h3>
                          <p><cite><?php echo ($yessumcount); ?></cite></p>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="layui-col-md12">
            <div class="layui-card">
              <div class="layui-card-header">快捷方式</div>
              <div class="layui-card-body">
                
                <div class="layui-carousel layadmin-carousel layadmin-shortcut">
                  <div carousel-item>
                    <ul class="layui-row layui-col-space10" >
                      <li class="layui-col-xs3" style="width:100px;">
                        <a href="<?php echo U('Personmember/index');?>">
                          <i class="layui-icon layui-icon-console" style="background-color:#A9F5D0;color:green"></i>
                          <cite>会员列表</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3" style="width:100px;">
                        <a href="<?php echo U('Personmember/withdrawals_list');?>">
                          <i class="layui-icon layui-icon-chart" style="background-color:#A9F5D0;color:green"></i>
                          <cite>提现列表</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3" style="width:100px;">
                        <a href="<?php echo U('Personmember/redpacked_withdraw');?>">
                          <i class="layui-icon layui-icon-template-1" style="background-color:#A9F5D0;color:green"></i>
                          <cite>红包提现</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3" style="width:100px;">
                        <a href="<?php echo U('Personmember/deposit_list');?>">
                          <i class="layui-icon layui-icon-chat" style="background-color:#A9F5D0;color:green"></i>
                          <cite>充值列表</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3" style="width:100px;">
                        <a href="<?php echo U('Bidding/index');?>">
                          <i class="layui-icon layui-icon-find-fill" style="background-color:#A9F5D0;color:green"></i>
                          <cite>车主竟价</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3" style="width:100px;">
                        <a href="<?php echo U('Subset/index');?>">
                          <i class="layui-icon layui-icon-survey" style="background-color:#A9F5D0;color:green"></i>
                          <cite>支付设置</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3" style="width:100px;">
                        <a href="<?php echo U('Subset/pingchepara');?>">
                          <i class="layui-icon layui-icon-user" style="background-color:#A9F5D0;color:green"></i>
                          <cite>拼车参数</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3" style="width:100px;">
                        <a href="<?php echo U('Subset/sms');?>">
                          <i class="layui-icon layui-icon-set" style="background-color:#A9F5D0;color:green"></i>
                          <cite>短信设置</cite>
                        </a>
                      </li>                                       
                    </ul>
                  </div>
                </div>
                
              </div>
            </div>
          </div>

          
          
        </div>
      </div>

    </div>
  </div>

  <script src="/addons/yb_pingche/Public/admincss/layuiadmin/layui/layui.js?t=1"></script>  
  <script>
  layui.config({
    base: '/addons/yb_pingche/Public/admincss/layuiadmin/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'console']);
  </script>
</body>
</html>