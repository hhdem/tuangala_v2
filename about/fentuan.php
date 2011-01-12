<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$page = Table::Fetch('page', 'about_fentuan');
$pagetitle = '分团说明';
include template('about_fentuan');
