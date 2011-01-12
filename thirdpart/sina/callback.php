<?php
require_once(dirname(__FILE__) . '/config.php');

$o = new WeiboOAuth(WB_AKEY , WB_SKEY , $_SESSION['keys']['oauth_token'] , $_SESSION['keys']['oauth_token_secret']);
$_SESSION['last_key'] = $o->getAccessToken($_REQUEST['oauth_verifier']);

Utility::Redirect( WEB_ROOT . '/thirdpart/sina/auth.php' );
