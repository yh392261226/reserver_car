<?php defined('IN_IA') or exit('Access Denied');?><div class="text-center"><img src="<?php  echo tomedia('headimg_'.$_W['account']['acid'].'.jpg')?>?time=<?php  echo time()?>" class="head-logo"></div>
<div class="text-center wxapp-name font-lg"><?php  echo $_W['account']['name'];?></div>
<div class="text-center wxapp-version"><?php  echo $version_info['version'];?></div>
<div class="text-center operate">
	<a href="<?php  echo url('wxapp/display/version_display')?>"><i class="wi wi-cut" data-toggle="tooltip" data-placement="bottom" title="切换版本"></i></a>
	<?php  if(in_array($role, array(ACCOUNT_MANAGE_NAME_OWNER, ACCOUNT_MANAGE_NAME_MANAGER)) || $_W['isfounder']) { ?>
	<a href="<?php  echo url('wxapp/manage/display', array('uniacid' => $_W['uniacid']))?>"><i class="wi wi-text" data-toggle="tooltip" data-placement="bottom" title="管理"></i></a>
	<?php  } ?>
	<a href="<?php  echo url('account/display', array('type' => 'all'))?>"><i class="wi wi-small-routine" data-toggle="tooltip" data-placement="bottom" title="切换平台"></i></a>
</div>