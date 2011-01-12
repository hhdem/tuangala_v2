<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$page = Table::Fetch('page', 'help_bizhowtouse');
$pagetitle = '商家使用说明';
include template('help_bizhowtouse');
