<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

if(isset($_SESSION['user_id'])) {
	unset($_SESSION['user_id']);
	ZLogin::NoRemember();
	ZUser::SynLogout();
}

redirect( WEB_ROOT . '/index.php');
