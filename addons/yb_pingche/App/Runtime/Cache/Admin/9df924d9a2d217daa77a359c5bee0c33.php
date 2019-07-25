<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="format-detection" content="telephone=no">
        <link rel="stylesheet" href="/addons/yb_pingche/Public/css/x-admin.css" media="all">
    </head>
    <body>
        <div class="layui-layout layui-layout-admin">
            <div class="layui-header header header-demo">
                <div class="layui-main">
                    <?php echo ($title); ?>
                    <a class="logo" href="/addons/yb_pingche/Public/index.html">
                        
                    </a>
                    <ul class="layui-nav" lay-filter="">
                      <li class="layui-nav-item"><img src="/addons/yb_pingche/Public/images/logo.png" class="layui-circle" style="border: 2px solid #A9B7B7;" width="35px" alt=""></li>
                      <li class="layui-nav-item">
                        <a href="javascript:;"><?php echo ($top_name); ?></a>
                         <!-- 二级菜单 -->
						<!--
						<dl class="layui-nav-child">
                         
                          <dd><a href="">个人信息</a></dd>
                          <dd><a href="">切换帐号</a></dd>
                         
                          <dd><a href="<?php echo U('Admin/Login/out');?>">退出</a></dd>
                        </dl>
						-->
                      </li>
                      <!-- 
                      <li class="layui-nav-item">
                        <a href="javascript:void(0)" title="消息">
                            <i class="layui-icon" style="top: 1px;">&#xe63a;</i><font color=yellow>44</font>
                        </a>
                      </li>
                      -->
                      <li class="layui-nav-item x-index"><a href="<?php echo ($url); ?>" target="_blank">前台首页</a></li>
                      <li class="layui-nav-item to-index"><a href="<?php echo U('Configure/clearcache');?>">清除缓存</a></li>
                    </ul>
                </div>
            </div>
            <div class="layui-side layui-bg-black x-side">
                <div class="layui-side-scroll">
                    <ul class="layui-nav layui-nav-tree site-demo-nav" lay-filter="side">
                        <li class="layui-nav-item">
                            <a class="javascript:;" href="javascript:;">
                                <i class="layui-icon" style="top: 3px;">&#xe607;</i><cite>基本设置</cite>
                            </a>
                            <dl class="layui-nav-child">
<!-- 
                                <dd class="">
                                    <dd class="">
                                        <a href="javascript:;" _href="<?php echo U('Admininfo/index');?>">
                                            <cite>管理员列表</cite>
                                        </a>
                                    </dd>
                                </dd>                               
                                <dd class="">
                                    <dd class="">
                                        <a href="javascript:;" _href="<?php echo U('Adminlog/index');?>">
                                            <cite>登录日志列表</cite>
                                        </a>
                                    </dd>
                                </dd> 
 -->
                                 <dd class="">
                                        <a href="javascript:;" _href="<?php echo U('Subset/index');?>">
                                            <cite>支付设置</cite>
                                        </a>
                                </dd>
                                 <dd class="">
                                    <dd class="">
                                        <a href="javascript:;" _href="<?php echo U('Subset/pingchepara');?>">
                                            <cite>拼车参数</cite>
                                        </a>
                                    </dd>
                                </dd>
                                 <dd class="">
                                        <a href="javascript:;" _href="<?php echo U('Subset/pianshengflag');?>">
                                            <cite>骗审开关</cite>
                                        </a>
                                </dd>
                                <dd class="">
                                    <dd class="">
                                        <a href="javascript:;" _href="<?php echo U('Subset/kefu');?>">
                                            <cite>客服信息</cite>
                                        </a>
                                    </dd>
                                </dd>                               
                                <dd class="">
                                        <a href="javascript:;" _href="<?php echo U('Subset/sms');?>">
                                            <cite>短信设置</cite>
                                        </a>
                                </dd>
                               
                                 <dd class="">
                                        <a href="javascript:;" _href="<?php echo U('Subset/upload');?>">
                                            <cite>上传设置</cite>
                                        </a>
                                </dd>
                                                            
                                <dd class="">
                                    <dd class="">
                                        <a href="javascript:;" _href="<?php echo U('Subset/gzh');?>">
                                            <cite>公众号配置</cite>
                                        </a>
                                    </dd>
                                </dd>
                                <dd class="">
                                    <a href="javascript:;" _href="<?php echo U('Personmember/loginlog');?>">
                                        <cite>验证码列表</cite>
                                    </a>
                                </dd>                                
                               
                                <dd class="">
                                    <a href="javascript:;" _href="<?php echo U('Personmember/car_owner_notes');?>">
                                        <cite>平台须知</cite>
                                    </a>
                                </dd>                                
                                
                                <dd class="">
                                    <a href="javascript:;" _href="<?php echo U('Personmember/car_owner_share');?>">
                                        <cite>分享记录</cite>
                                    </a>
                                </dd>


                                 <dd class="">
                                    <a href="javascript:;" _href="<?php echo U('Personmember/fzsm_list');?>">
                                        <cite>免责声明</cite>
                                    </a>
                                </dd>                               
                                <dd class="">
                                    <a href="javascript:;" _href="<?php echo U('Personmember/gzh_index');?>">
                                        <cite>发送公众号模板消息</cite>
                                    </a>
                                </dd>                                                                                                                                                                                                                                                                                           
                            </dl>
                        </li>
                        <li class="layui-nav-item">
                            <a class="javascript:;" href="javascript:;">
                                <i class="layui-icon" style="top: 3px;">&#xe62d;</i><cite>城市管理</cite>
                            </a>
                            <dl class="layui-nav-child">
                                <dd class="">
                                     <a href="javascript:;" _href="<?php echo U('Area/list_index');?>">
                                         <cite>城市列表</cite>
                                     </a>
                                </dd>                               
                            </dl>
                        </li>                        
                        <li class="layui-nav-item">
                            <a class="javascript:;" href="javascript:;">
                                <i class="layui-icon" style="top: 3px;">&#xe62d;</i><cite>公告管理</cite>
                            </a>
                            <dl class="layui-nav-child">
                                 <dd class="">
                                        <a href="javascript:;" _href="<?php echo U('Notice/noticelist');?>">
                                            <cite>公告列表</cite>
                                        </a>
                                </dd>                               
                            </dl>
                        </li>                       
                         <li class="layui-nav-item">
                            <a class="javascript:;" href="javascript:;">
                                <i class="layui-icon" style="top: 3px;">&#xe634;</i><cite>交易大厅</cite>
                            </a>
                            <dl class="layui-nav-child">
                                <dd class="">
                                        <a href="javascript:;" _href="<?php echo U('Personmember/passenger_order');?>">
                                            <cite>乘客任务</cite>
                                        </a>
                                </dd>
                               <dd class="">
                                    <a href="javascript:;" _href="<?php echo U('Personmember/car_owner_order');?>">
                                        <cite>车主任务</cite>
                                    </a>
                                </dd>                                
                            </dl>
                        </li>                       
                        <li class="layui-nav-item">
                            <a class="javascript:;" href="javascript:;">
                                <i class="layui-icon" style="top: 3px;">&#xe642;</i><cite>广告管理</cite>
                            </a>
                            <dl class="layui-nav-child">
                                    <dd class="">
                                        <a href="javascript:;" _href="<?php echo U('Ad/index');?>">
                                            <cite>广告位列表</cite>
                                        </a>
                                    </dd>
                            </dl>
                        </li>
                        <li class="layui-nav-item">
                            <a class="javascript:;" href="javascript:;">
                                <i class="layui-icon" style="top: 3px;">&#xe630;</i><cite>竞价管理</cite>
                            </a>
                            <dl class="layui-nav-child">
                                 <dd class="">
                                    <a href="javascript:;" _href="<?php echo U('Bidding/pricelist');?>">
                                        <cite>价格管理</cite>
                                    </a>
                                </dd>                            
                                <dd class="">
                                    <a href="javascript:;" _href="<?php echo U('Bidding/index');?>">
                                        <cite>车主竟价</cite>
                                    </a>
                                </dd>
                               
<!-- 
                                 <dd class="">
                                    <a href="javascript:;" _href="<?php echo U('Bidding/caiwu');?>">
                                        <cite>财务明细</cite>
                                    </a>
                                </dd>
 -->                                    
                            </dl>
                        </li>                        
                        <li class="layui-nav-item">
                            <a class="javascript:;" href="javascript:;">
                                <i class="layui-icon" style="top: 3px;">&#xe606;</i><cite>财务管理</cite>
                            </a>
                            <dl class="layui-nav-child">
                                 <dd class="">
                                     <a href="javascript:;" _href="<?php echo U("Personmember/platform_income_list");?>">
                                         <cite>订单列表</cite>
                                     </a>
                                 </dd>
                                <dd class="">
                                    <a href="javascript:;" _href="<?php echo U('Personmember/withdrawals_list');?>">
                                        <cite>提现列表</cite>
                                    </a>
                                </dd>
                                <dd class="">
                                    <a href="javascript:;" _href="<?php echo U('Personmember/redpacked_withdraw');?>">
                                        <cite>红包提现列表</cite>
                                    </a>
                                </dd>
                                 <dd class="">
                                    <a href="javascript:;" _href="<?php echo U('Personmember/deposit_list');?>">
                                        <cite>充值管理</cite>
                                    </a>
                                </dd>                               	                                                                  
                            </dl>
                        </li>                        
                        
                        <li class="layui-nav-item">
                            <a class="javascript:;" href="javascript:;">
                                <i class="layui-icon" style="top: 3px;">&#xe612;</i><cite>会员管理</cite>
                            </a>
                            <dl class="layui-nav-child">
                                <dd class="">
                                    <a href="javascript:;" _href="<?php echo U('Personmember/index');?>">
                                        <cite>会员列表</cite>
                                    </a>
                                </dd>
                                <dd class="">
                                    <a href="javascript:;" _href="<?php echo U('Personmember/car_owner_list');?>">
                                        <cite>司机列表</cite>
                                    </a>
                                </dd>
                                <dd class="">
                                    <a href="javascript:;" _href="<?php echo U('Personmember/passenger_list');?>">
                                        <cite>乘客列表</cite>
                                    </a>
                                </dd>                                                                                                                        
                            </dl>
                        </li>
						<li class="layui-nav-item" style="height: 30px; text-align: center">
                        </li>

                    </ul>
                </div>

            </div>
            <div class="layui-tab layui-tab-card site-demo-title x-main" lay-filter="x-tab" lay-allowclose="true" style="position:fixed;height:95%;">
                <div class="x-slide_left"></div>
                <ul class="layui-tab-title">
                    <li class="layui-this">我的桌面<i class="layui-icon layui-unselect layui-tab-close">ဆ</i>
                    </li>
                </ul>
                <div class="layui-tab-content site-demo site-demo-body">
                    <div class="layui-tab-item layui-show" >
                        <iframe frameborder="0" src="<?php echo U('Index/welcome');?>" class="x-iframe"></iframe>
                    </div>
                </div>
            </div>            
            <div class="site-mobile-shade"></div>
            <div style="position:fixed;right:0;bottom:0;left:0px;height:30px;line-height:30px;padding:0 0;background-color:#ccc; color:green;text-align:center">
                <?php if($_SESSION['copyright']['footerright']!= '' ): echo ($_SESSION['copyright']['footerright']); ?>
                <?php else: ?>	
                <a href="http://www.we7.cc" style="color:#000;margin-right:10px;" >微信开发</a>
			    <a href="http://s.we7.cc" style="color:#000;margin-right:10px;">微信应用</a>
			    <a href="http://bbs.we7.cc" style="color:#000;margin-right:10px;">微擎论坛</a>
			    <a href="http://wpa.b.qq.com/cgi/wpa.php?ln=1&key=XzkzODAwMzEzOV8xNzEwOTZfNDAwMDgyODUwMl8yXw" style="color:#000;margin-right:50px"><font color='#000'>联系客服</font></a><?php endif; ?>
	            <?php if($_SESSION['copyright']['footerleft']!= '' ): echo ($_SESSION['copyright']['sitename']); ?>-<?php echo ($_SESSION['copyright']['company']); ?>
	                <?php else: ?>
	                <font color='#000'>Powered by 微擎 v<?php echo (session('ims_version')); ?> © 2014-2015 www.we7.cc</font><?php endif; ?>
			</div>
        </div>
        <script src="/addons/yb_pingche/Public/lib/layui/layui.js" charset="utf-8"></script>
        <script src="/addons/yb_pingche/Public/js/x-admin.js"></script>
    </body>
</html>