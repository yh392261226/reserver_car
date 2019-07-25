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
              <a><cite>短信设置</cite></a>
            </span>
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"  href="javascript:location.replace(location.href);" title="刷新"><i class="layui-icon" style="line-height:30px">ဂ</i></a>
        </div>       
            <form class="layui-form layui-form-pane" id="form1" name="form1" method="post" action="<?php echo U('Subset/update');?>">
                 <div class="layui-form-item" style="margin-top:20px;">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>阿里云短信KeyId</label>
                    <div class="layui-input-inline" style="width:70%;">
                        <input name="ali_sms_key_id" type="text" value="<?php echo ($data['ali_sms_key_id']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
	                <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>
					</div>                   
                </div>                 
                 <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>短信发送密钥</label>
                    <div class="layui-input-inline" style="width:70%;">
                        <input name="ali_sms_key_secret" type="text" value="<?php echo ($data['ali_sms_key_secret']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>
					</div>                    
                </div>                
                 <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>短信发送签名</label>
                    <div class="layui-input-inline" style="width:70%;">
                        <input name="ali_sms_signname" type="text" value="<?php echo ($data['ali_sms_signname']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>
					</div>                    
                </div>
                <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>手机认证验证码</label>
                    <div class="layui-input-inline" style="width:30%;">
                        <input name="ali_sms_templatecode" type="text" value="<?php echo ($data['ali_sms_templatecode']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>您的验证码${code}，该验证码5分钟内有效，请勿泄漏于他人！
					</div>                   
                </div>
                <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>乘客发布出行任务与你车主相同通知</label>
                    <div class="layui-input-inline" style="width:30%;">
                    	<input name="ali_sms_sms2" type="text" value="<?php echo ($data['ali_sms_sms2']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>尊敬的车主：有乘客发布[${starting_place}]到[${end_place}]任务与你出行任务相似，请及时登录处理。
					</div>                   
                </div>
                 <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>车主任务被接通知</label>
                    <div class="layui-input-inline" style="width:30%;">
                    	<input name="ali_sms_sms3" type="text" value="<?php echo ($data['ali_sms_sms3']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>尊敬的车主：你发布的从${starting_place}到${end_place}的任务被接了，请及时登录处理。
					</div>                  
                </div>
                 <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>车主抢单成功通知乘客</label>
                    <div class="layui-input-inline" style="width:30%;">
                    	<input name="ali_sms_sms4" type="text" value="<?php echo ($data['ali_sms_sms4']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>尊敬的乘客：你的出行任务${starting_place}到${end_place}任务被接了，请及时登录处理。
					</div>                   
                </div>                
                <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>乘客任务车主点击开始行程时通知乘客</label>
                    <div class="layui-input-inline" style="width:30%;">
                        <input name="ali_sms_sms5" type="text" value="<?php echo ($data['ali_sms_sms5']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>尊敬的乘客：你的任务从${starting_place}到${end_place}现在开始出发了。
					</div>                   
                </div>               
                <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>乘客点击确认付款通知车主</label>
                    <div class="layui-input-inline" style="width:30%;">
                        <input name="ali_sms_sms6" type="text" value="<?php echo ($data['ali_sms_sms6']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>尊敬的车主：你已接订单从${starting_place}到${end_place}，乘客已确认付款。
					</div>                   
                </div>
                 <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>乘客任务车主和乘客无责取消通知</label>
                    <div class="layui-input-inline" style="width:30%;">
                       <input name="ali_sms_sms7" type="text" value="<?php echo ($data['ali_sms_sms7']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>尊敬的乘客：你从${starting_place}到${end_place}的任务,车主要求无责取消。
					</div>                   
                </div>               
                 <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>车主直接取消通知乘客</label>
                    <div class="layui-input-inline" style="width:30%;">
                       <input name="ali_sms_sms8" type="text" value="<?php echo ($data['ali_sms_sms8']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>尊敬的乘客：你的任务从${starting_place}到${end_place}被接单车主直接取消了。
					</div>                   
                </div>
                 <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>乘客点击无法出行操作通知车主</label>
                    <div class="layui-input-inline" style="width:30%;">
                       <input name="ali_sms_sms9" type="text" value="<?php echo ($data['ali_sms_sms9']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>尊敬的车主：乘客发起从${starting_place}到${end_place}行程无责取消操作。
					</div>                   
                </div>                
                  <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>乘客直接取消任务操作通知车主</label>
                    <div class="layui-input-inline" style="width:30%;">
                       <input name="ali_sms_sms10" type="text" value="<?php echo ($data['ali_sms_sms10']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>尊敬的车主：乘客行程从${starting_place}到${end_place}被乘客直接取消了。
					</div>                   
                </div>
                   <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>乘客同意无责取消通知车主</label>
                    <div class="layui-input-inline" style="width:30%;">
                       <input name="ali_sms_sms11" type="text" value="<?php echo ($data['ali_sms_sms11']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>尊敬的车主：你的任务从${starting_place}到${end_place}被乘客${mem}同意无责取消了。
					</div>                   
                </div>               
                <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>乘客点击不同意操作通知车主</label>
                    <div class="layui-input-inline" style="width:30%;">
                       <input name="ali_sms_sms12" type="text" value="<?php echo ($data['ali_sms_sms12']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>尊敬的车主：你的任务从${starting_place}到${end_place}，${mem}乘客不同意取消。
					</div>                   
                </div>
                 <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>车主点击不同意通知乘客</label>
                    <div class="layui-input-inline" style="width:30%;">
                       <input name="ali_sms_sms13" type="text" value="<?php echo ($data['ali_sms_sms13']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>尊敬的乘客：你的任务从${starting_place}到${end_place}车主${mem}不同意取消。
					</div>                   
                </div>               
                <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>车主点击同意取消通知乘客</label>
                    <div class="layui-input-inline" style="width:30%;">
                       <input name="ali_sms_sms14" type="text" value="<?php echo ($data['ali_sms_sms14']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>尊敬的乘客：你的任务从${starting_place}到${end_place}，车主${mem}同意无责取消了。
					</div>                   
                </div>                
                <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>乘客出行任务退款通知</label>
                    <div class="layui-input-inline" style="width:30%;">
                       <input name="ali_sms_sms15" type="text" value="<?php echo ($data['ali_sms_sms15']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>尊敬的乘客：你的任务从${starting_place}到${end_place}，${paytype}退款成功。
					</div>                   
                </div>                
                <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>车主竟价通知</label>
                    <div class="layui-input-inline" style="width:30%;">
                       <input name="ali_sms_sms16" type="text" value="<?php echo ($data['ali_sms_sms16']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>尊敬的车主${truename}：你线路竟价${flag}，详情请登录小程序查看。
					</div>                   
                </div>                                 
                <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>车主身份认证通知</label>
                    <div class="layui-input-inline" style="width:30%;">
                       <input name="ali_sms_sms17" type="text" value="<?php echo ($data['ali_sms_sms17']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>尊敬的车主${truename}：你的车主身份认证已${flag}，详情请登录小程序查看。
					</div>                   
                </div>
                <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>任务，车主已点击到达目的地</label>
                    <div class="layui-input-inline" style="width:30%;">
                       <input name="ali_sms_sms18" type="text" value="<?php echo ($data['ali_sms_sms18']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>你的任务${ordernum}从${starting_place}到${end_place}车主已点击到达目的地。
					</div>                   
                </div>                
                 <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>乘客申请冻结通知</label>
                    <div class="layui-input-inline" style="width:30%;">
                       <input name="ali_sms_sms19" type="text" value="<?php echo ($data['ali_sms_sms19']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>你的任务(订单)${ordernum}从${starting_place}到${end_place},乘客${truename}已申请冻结。
					</div>                   
                </div>
                 <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>会员红包提现通知</label>
                    <div class="layui-input-inline" style="width:30%;">
                       <input name="ali_sms_sms20" type="text" value="<?php echo ($data['ali_sms_sms20']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>尊敬的会员${mem}：你申请的红包${redpacked}元提现已${flag}，请及时登录查看。
					</div>                   
                </div> 
                 <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>车主押金提现通知</label>
                    <div class="layui-input-inline" style="width:30%;">
                       <input name="ali_sms_sms21" type="text" value="<?php echo ($data['ali_sms_sms21']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>尊敬的${mem},你提现的押金${deposit} 元已${flag}，请及时登录查看。
					</div>                   
                </div>
                 <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>订单解冻通知</label>
                    <div class="layui-input-inline" style="width:30%;">
                       <input name="ali_sms_sms22" type="text" value="<?php echo ($data['ali_sms_sms22']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>乘客（车主）：订单任务${ordernum}从${starting_place}到${end_place}，目前已解冻，请注意账户、红包、押金变化，有疑问联系客服。
					</div>                   
                </div>
                <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" style="width:250px;"><span class="x-red">*</span>车主发布出行任务与乘客相同通知</label>
                    <div class="layui-input-inline" style="width:30%;">
                    	<input name="ali_sms_sms23" type="text" value="<?php echo ($data['ali_sms_sms23']); ?>"  placeholder="" autocomplete="off" class="layui-input"  />
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>尊敬的乘客：有车主发布[${starting_place}]到[${end_place}]任务与你出行任务相似，请及时登录处理。
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