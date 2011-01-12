<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$page = Table::Fetch('page', 'about_bizs');
$pagetitle = '商户协议';
include template('about_bizs');
