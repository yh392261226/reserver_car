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
		  				  $.post("<?php echo U('Admin/Personmember/wash_alldel');?>",{
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
    		
    		//返回上层
    		$("#back").click(function(){
    			location.href='<?php echo U("Admin/Personmember/index");?>';
    		});
    		//添加须知
    		$("#addprovince").click(function(){
    			location.href="<?php echo U('Admin/Personmember/car_owner_notes_add');?>";
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
              <a><cite>平台须知</cite></a>
            </span>
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"  href="javascript:location.replace(location.href);" title="刷新"><i class="layui-icon" style="line-height:30px">ဂ</i></a>
        </div>
        <div class="x-body">
            <xblock><button class="layui-btn layui-btn-danger" id="delall"><i class="layui-icon">&#xe640;</i>批量删除</button><button class="layui-btn" id="addprovince"><i class="layui-icon">&#xe608;</i>添加须知</button><span class="x-right" style="line-height:40px">共有数据：<?php echo ($count); ?> 条</span></xblock>
            <table class="layui-table">
                <thead>
                    <tr>
                        <th style="width:30px;">
                            <input type="checkbox"  id="check">
                        </th>
                        <th style="width:30px;">编号</th>
                        <th>内容</th>
                        <th>服务热线</th>
                        <th>发布时间</th>
                        <th>分类</th>
                        <th>操作</th>
                    </tr>
                </thead>

                    <?php if(is_array($rs)): foreach($rs as $key=>$v): ?><tr>
                        <td>
                            <input type="checkbox" value="<?php echo ($v["nid"]); ?>" name="nid[]">
                        </td>
                        <td><?php echo ($v["nid"]); ?></td>
                        <td><?php echo ($v["note"]); ?></td>
                        <td><?php echo ($v["chotline"]); ?></td>
                        <td ><?php echo ($v["addtime"]); ?></td>
                        <td ><?php echo ($v["nclass1"]); ?></td>
                        <td class="td-manage">
                            <a title="修改"  href="<?php echo U('Admin/Personmember/car_owner_notes_modi',array('nid'=>$v['nid']));?>" style="text-decoration:none">
                                <i class="layui-icon">&#xe642;</i>
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