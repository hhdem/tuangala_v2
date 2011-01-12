<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_partner();
$id = abs(intval($_GET['id']));
$ask = Table::Fetch('ask', $id);
$partner_id = abs(intval($_SESSION['partner_id']));

need_biz_auth($ask['partner_id']==$partner_id);

Table::Delete('ask', $id);
Session::Set('notice', "删除团购咨询({$id})记录成功");
redirect(udecode($_GET['r']));
