<?php
/* payservice */
$payservice = array(
	'credit', 'alipay', 'tenpay', 'paypal', 'bill', 'chinabank',
);

/* paybank settings */
$qqbank = array(
		'cmb' => '1038',
		'icbc' => '1002',
		'ccb' => '1034',
		'abc' => '1005', 

		'comm' => '1020',
		'spdb' => '1004',
		'citic' => '1021',
		'cib' => '1009',

		'gdb' => '1027',
		'sdb' => '1008',
		'cmbc' => '1006',
		'bofc' => '1052',

		'cebb' => '1022',
		'pingan' => '1010',
		'bob' => '1032',
);
$paybank = array_keys($qqbank);

function pay_getqqbank($paytype='cmbc') {
	global $qqbank;
	$paytype = strtolower($paytype);
	return isset($qqbank[$paytype]) ? $qqbank[$paytype] : 0;
}

function pay_getservice($paytype='tenpay') {
	global $payservice;
	$paytype = strtolower($paytype);
	return (empty($paytype) || in_array($paytype, $payservice))
		? $paytype : 'tenpay';
}
