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
              <a><cite>骗审开关</cite></a>
            </span>
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"  href="javascript:location.replace(location.href);" title="刷新"><i class="layui-icon" style="line-height:30px">ဂ</i></a>
        </div>       
            <form class="layui-form layui-form-pane" id="form1" name="form1" method="post" action="<?php echo U('Subset/update');?>">
                <div class="layui-form-item" style="margin-top:20px;">
                    <div class="layui-inline">
                        <label class="layui-form-label"><span class="x-red">*</span>骗审开关</label>
                        <div class="layui-input-block">
                            <select lay-verify="required" name="is_web" id="is_web">
                                <option>
                                </option>
                                <optgroup label="请选择">
                                    <option value="1" <?php if($data['is_web'] == 1) echo 'selected=""' ?>>关闭</option>
                                    <option value="2" <?php if($data['is_web'] == 2) echo 'selected=""' ?>>打开</option>
                                </optgroup>
                            </select><span id="nstatusa"></span>
                        </div>
                    </div>
                </div>
				<!--
                 <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" ><span class="x-red">*</span>骗审信息</label>
                    <div class="layui-input-inline" style="width:70%;">
                        <input  type="text" name="piansheng_title"  value="<?php echo ($data['piansheng_title']); ?>" placeholder="" autocomplete="off" class="layui-input" >
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>如：美丽女孩  此小程序转让
					</div>
                </div>
                 <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" ><span class="x-red">*</span>联系邮箱</label>
                    <div class="layui-input-inline" style="width:70%;">
                        <input  type="text" name="piansheng_email"  value="<?php echo ($data['piansheng_email']); ?>" placeholder="" autocomplete="off" class="layui-input" >
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>
					</div>
                </div>
                 <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label" ><span class="x-red">*</span>联系QQ</label>
                    <div class="layui-input-inline" style="width:70%;">
                        <input  type="text" name="piansheng_qq"  value="<?php echo ($data['piansheng_qq']); ?>" placeholder="" autocomplete="off" class="layui-input" >
                    </div>
                    <div class="layui-form-mid layui-word-aux">
						<span class="x-red"></span>
					</div>
                </div>
				-->
		         <div class="layui-form-item">
		            <label for="price" class="layui-form-label">
		                <span class="x-red">*</span>骗审内容
		            </label>
		            <div class="layui-input-inline">
		                <textarea name="piansheng_content" id="piansheng_content" style="width:800px;height:400px"><?php echo ($data['piansheng_content']); ?></textarea>
		
		            </div>
		            <div class="layui-form-mid layui-word-aux">
		                <span class="x-red">*</span>
		            </div>
		        </div>                                                                                                                                            
                <div class="layui-form-item">
                    <button class="layui-btn" id="nclick">提交信息</button>
                </div>
            </form>
        </div>
        <script charset="utf-8" src="/addons/yb_pingche/Public/kindeditor/kindeditor-min.js?v=201706261"></script>
		<script charset="utf-8" src="/addons/yb_pingche/Public/kindeditor/lang/zh_CN.js"></script>
		<script src="/addons/yb_pingche/Public/layui/layui.js" charset="utf-8"></script>
		<script src="/addons/yb_pingche/Public/js/x-layui.js" charset="utf-8"></script>
		<script>
		upload_url ='/addons/yb_pingche/Public/kindeditor/php/upload_json.php';
	    
	    var flag = "<?php echo C('upload_type');?>";

	    if(flag>0){
	    	if(flag==1){
	    		upload_url = '<?php echo U("Upload/saveimg_kind");?>';
	    	}else{
	    		upload_url = '<?php echo U("Upload/qiniu_saveimg_kind");?>';
	    	}
	    }

	     var editor = KindEditor.create('textarea[name="piansheng_content"]', {
	         uploadJson: upload_url,
	         formatUploadUrl: false,
	         filePostName:'img',
	        // uploadJson: '<?php echo U("Upload/saveimg_kind");?>',
	         fileManagerJson: '/addons/yb_pingche/Public/kindeditor/php/file_manager_json.php',
	         allowFileManager: false,
	         items : ['source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
	          		'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
	        		'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
	        		'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
	        		'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
	        		'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'multiimage',
	        		'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
	        		'anchor', 'link', 'unlink'],
	         afterBlur: function () {
	             this.sync();
	         }
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