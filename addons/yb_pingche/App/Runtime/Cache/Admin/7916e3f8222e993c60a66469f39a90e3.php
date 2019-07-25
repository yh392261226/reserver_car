<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html> 
    <head>
        <meta charset="utf-8">
        <title></title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="shortcut icon" href="/addons/yb_pingche/Public/favicon.ico" type="image/x-icon" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="format-detection" content="telephone=no">
        <link rel="stylesheet" href="/addons/yb_pingche/Public/css/x-admin.css" media="all">
        <link rel="stylesheet" href="/addons/yb_pingche/Public/css/page.css" >
        <script src="/addons/yb_pingche/Public/js/jquery.js"></script>
        <script src="/addons/yb_pingche/Public/js/laydate/laydate.js"></script>
    </head>
    <script>
    	$(document).ready(function(){
    		//全选函数
    		$("#check").click(function(){
    		    var checked = $(this).is(":checked"); 
    		    $("input[name='nid[]']").each(function () {
    		    	$(this).attr("checked", !$(this).attr("checked"));
    		    })
    		});
    		//全选批量设置已读
	  		$("#delall").click(function(){
	  			 if(delconfirm()){
		  			  var arrChk=$("input[name='nid[]']:checked");
		  			  if(arrChk.length>0){
		  				  $.post("<?php echo U('Admin/Personmember/log_alldel');?>",{
		  						allid:cheall(),
		  						data:Math.random()
		  				  },function(msg){
		  					   if(msg.status){
		  						   alert(msg.retDesc);
		  						   window.location.reload();
		  					   }else{
		  						   alert(msg.retDesc);   
		  					   }
		  				  },"json");
		  			  }else{
		  				  alert("请选择要删除的记录！");
		  			  }	  				 
	  			 }

	  		});

    	});
		  //全选值
		  function cheall(){
				var zhe="";
				$("input[name='nid[]']").each(function () {
					if ($(this).attr('checked')) {
						zhe+= $(this).val()+',';
					}
				});
				return zhe;
		  } 
  		//删除确认
		  function delconfirm(){
		    if(window.confirm("请确认是否选中的记录都要删除？")){
		     return true;
		    }
		    return false;
		  }
    </script>
    <body>
      <div class="x-nav">
            <span class="layui-breadcrumb">
              <a><cite>首页</cite></a>
              <a><cite>基本设置</cite></a>
              <a><cite>验证码列表</cite></a>
            </span>
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"  href="javascript:location.replace(location.href);" title="刷新"><i class="layui-icon" style="line-height:30px">ဂ</i></a>
        </div>
        <div class="x-body">
               <form id="form1" class="layui-form x-center" action="<?php echo U('Admin/Personmember/loginlog');?>" method="get" style="width:600px">
                <div class="layui-form-pane" style="margin-top: 15px;">
                  <div class="layui-form-item">
                    <label class="layui-form-label" style="width:90px">短信使用状态</label>
                    <div class="layui-input-inline" style="width:120px;text-align: left">
                    <input type="hidden" name="mobile" id="mobile" value="<?php echo ($mobile); ?>" />
                        <select name="status" id="nstatus">
                            <option value="0" <?php if($status == 0): ?>selected=""<?php endif; ?>>请选择</option>
                            <option value="1" <?php if($status == 1): ?>selected=""<?php endif; ?>>未使用</option>
                            <option value="2" <?php if($status == 2): ?>selected=""<?php endif; ?>>已使用</option>
                        </select>
                    </div>
                    <label class="layui-form-label" style="width:70px">手机号</label>
                    <div class="layui-input-inline" style="width:120px;text-align: left">
                      <input class="layui-input" name="mobile" id="mobile" placeholder="手机号" value="<?php echo ($mobile); ?>"  >
                    </div>
                    <div class="layui-input-inline" style="width:80px">
                        <button type="submit" class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;查询</i></button>
                    </div>
                  </div>
                </div> 
            </form>       
            <xblock><button class="layui-btn layui-btn-danger" id="delall"><i class="layui-icon">&#xe640;</i>批量删除</button><span class="x-right" style="line-height:40px">共有数据：<?php echo ($count); ?> 条</span></xblock>
            <table class="layui-table">
                <thead>
                    <tr>
                        <th style="width:30px;">
                            <input type="checkbox"  id="check">
                        </th>
                        <th style="width:30px;">编号</th>
                        <th>会员姓名</th>
                        <th>手机号</th>
                        <th>验证码</th>
                        <th>过期时间</th>
                        <th>状态</th>
                        <th>发送短信时间</th>
                        <th>验证时间</th>
                        <th>操作</th>
                    </tr>
                </thead>

                    <?php if(is_array($rs)): foreach($rs as $key=>$v): ?><tr>
                        <td>
                            <input type="checkbox" value="<?php echo ($v["nid"]); ?>" name="nid[]">
                        </td>
                        <td><?php echo ($v["nid"]); ?></td>
                        <td><?php echo ($v["name"]); ?></td>
                        <td><?php echo ($v["mobile"]); ?></td>
                        <td><?php echo ($v["smscode"]); ?></td>
                        <td><?php echo (date("Y-m-d H:i:s",$v["totime"])); ?></td>
                        <td><?php if($v["status"] == 1): ?><font color=red>未使用</font><?php else: ?><font color=green>已使用</font><?php endif; ?></td>
                        <td><?php echo ($v["addtime"]); ?></td>
                        <td><?php echo ($v["veri_time"]); ?></td>
                        <td class="td-manage">
                            <a title="删除" onclick="return delconfirm()" href="<?php echo U("Admin/Personmember/log_del",array('nid'=>$v["nid"]));?>" style="text-decoration:none">
                                <i class="layui-icon">&#xe640;</i>
                            </a>
                        </td>
                    </tr><?php endforeach; endif; ?>

            </table>
            <div class='page1'><?php echo ($page); ?></div>
        </div>

    </body>
    <script src="/addons/yb_pingche/Public/lib/layui/layui.js" charset="utf-8"></script>
    <script src="/addons/yb_pingche/Public/js/x-layui.js" charset="utf-8"></script>
    <script>
    layui.use(['element','layer','form'], function(){
        
      lement = layui.element();//面包导航
      layer = layui.layer;//弹出层
      form = layui.form();
    })    
    </script>    
</html>