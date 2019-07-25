<?php
/**
* [ System] Copyright (c) 2018 www.we7.cc
 */
defined('IN_IA') or exit('Access Denied');
if ($do == 'online') {
	header('Location: //www.we7.cc/app/api.php?referrer='.$_W['setting']['site']['key']);
	exit;
} elseif ($do == 'offline') {
	header('Location: //www.we7.cc/app/api.php?referrer='.$_W['setting']['site']['key'].'&standalone=1');
	exit;
} else {
}
template('cloud/device');
