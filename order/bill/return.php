<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

$merchantAcctId = $INI['bill']['mid']; 
$key =$INI['bill']['sec'];		///商户密钥


//获取人民币网关账户号
//$merchantAcctId=trim($_REQUEST['merchantAcctId']);
//设置人民币网关密钥
///区分大小写
//$key="1234567897654321";

//获取网关版本.固定值
///快钱会根据版本号来调用对应的接口处理程序。
///本代码版本号固定为v2.0
$version=trim($_REQUEST['version']);

//获取语言种类.固定选择值。
///只能选择1、2、3
///1代表中文；2代表英文
///默认值为1
$language=trim($_REQUEST['language']);

//签名类型.固定值
///1代表MD5签名
///当前版本固定为1
$signType=trim($_REQUEST['signType']);

//获取支付方式
///值为：10、11、12、13、14
///00：组合支付（网关支付页面显示快钱支持的各种支付方式，推荐使用）10：银行卡支付（网关支付页面只显示银行卡支付）.11：电话银行支付（网关支付页面只显示电话支付）.12：快钱账户支付（网关支付页面只显示快钱账户支付）.13：线下支付（网关支付页面只显示线下支付方式）.14：B2B支付（网关支付页面只显示B2B支付，但需要向快钱申请开通才能使用）
$payType=trim($_REQUEST['payType']);

//获取银行代码
///参见银行代码列表
$bankId=trim($_REQUEST['bankId']);

//获取商户订单号
$orderId=trim($_REQUEST['orderId']);

//获取订单提交时间
///获取商户提交订单时的时间.14位数字。年[4位]月[2位]日[2位]时[2位]分[2位]秒[2位]
///如：20080101010101
$orderTime=trim($_REQUEST['orderTime']);

//获取原始订单金额
///订单提交到快钱时的金额，单位为分。
///比方2 ，代表0.02元
$orderAmount=trim($_REQUEST['orderAmount']);

//获取快钱交易号
///获取该交易在快钱的交易号
$dealId=trim($_REQUEST['dealId']);

//获取银行交易号
///如果使用银行卡支付时，在银行的交易号。如不是通过银行支付，则为空
$bankDealId=trim($_REQUEST['bankDealId']);

//获取在快钱交易时间
///14位数字。年[4位]月[2位]日[2位]时[2位]分[2位]秒[2位]
///如；20080101010101
$dealTime=trim($_REQUEST['dealTime']);

//获取实际支付金额
///单位为分
///比方 2 ，代表0.02元
$payAmount=trim($_REQUEST['payAmount']);

//获取交易手续费
///单位为分
///比方 2 ，代表0.02元
$fee=trim($_REQUEST['fee']);

//获取扩展字段1
$ext1=trim($_REQUEST['ext1']);

//获取扩展字段2
$ext2=trim($_REQUEST['ext2']);

//获取处理结果
///10代表 成功; 11代表 失败
$payResult=trim($_REQUEST['payResult']);

//获取错误代码
///详细见文档错误代码列表
$errCode=trim($_REQUEST['errCode']);

//获取加密签名串
$signMsg=trim($_REQUEST['signMsg']);



//生成加密串。必须保持如下顺序。
$merchantSignMsgVal=appendParam($merchantSignMsgVal,"merchantAcctId",$merchantAcctId);
$merchantSignMsgVal=appendParam($merchantSignMsgVal,"version",$version);
$merchantSignMsgVal=appendParam($merchantSignMsgVal,"language",$language);
$merchantSignMsgVal=appendParam($merchantSignMsgVal,"signType",$signType);
$merchantSignMsgVal=appendParam($merchantSignMsgVal,"payType",$payType);
$merchantSignMsgVal=appendParam($merchantSignMsgVal,"bankId",$bankId);
$merchantSignMsgVal=appendParam($merchantSignMsgVal,"orderId",$orderId);
$merchantSignMsgVal=appendParam($merchantSignMsgVal,"orderTime",$orderTime);
$merchantSignMsgVal=appendParam($merchantSignMsgVal,"orderAmount",$orderAmount);
$merchantSignMsgVal=appendParam($merchantSignMsgVal,"dealId",$dealId);
$merchantSignMsgVal=appendParam($merchantSignMsgVal,"bankDealId",$bankDealId);
$merchantSignMsgVal=appendParam($merchantSignMsgVal,"dealTime",$dealTime);
$merchantSignMsgVal=appendParam($merchantSignMsgVal,"payAmount",$payAmount);
$merchantSignMsgVal=appendParam($merchantSignMsgVal,"fee",$fee);
$merchantSignMsgVal=appendParam($merchantSignMsgVal,"ext1",$ext1);
$merchantSignMsgVal=appendParam($merchantSignMsgVal,"ext2",$ext2);
$merchantSignMsgVal=appendParam($merchantSignMsgVal,"payResult",$payResult);
$merchantSignMsgVal=appendParam($merchantSignMsgVal,"errCode",$errCode);
$merchantSignMsgVal=appendParam($merchantSignMsgVal,"key",$key);
$merchantSignMsg= md5($merchantSignMsgVal);


//初始化结果及地址
$rtnOk=0;
$rtnUrl="";

//商家进行数据处理，并跳转会商家显示支付结果的页面
///首先进行签名字符串验证
if(strtoupper($signMsg)==strtoupper($merchantSignMsg)){

	switch($payResult){

		case "10":

			/* 
			   ' 商户网站逻辑处理，比方更新订单支付状态为成功
			   ' 特别注意：只有strtoupper($signMsg)==strtoupper($merchantSignMsg)，且payResult=10，才表示支付成功！同时将订单金额与提交订单前的订单金额进行对比校验。
			 */
			 $v_amount = ($orderAmount/100);

			list($_, $order_id, $city_id, $_) = explode('-', $orderId, 4);
		/* charge */
		if ( $_ == 'charge' ) {
			@list($_, $user_id, $create_time, $_) = explode('-', $orderId, 4);
			if(ZFlow::CreateFromCharge($v_amount, $user_id, $create_time, 'bill')){
				Session::Set('notice', "快钱充值{$v_amount}元成功！");
			}
			//redirect(WEB_ROOT . '/credit/index.php');
			$rurl = $INI['system']['wwwprefix'] . '/credit/index.php';
			die("<result>1</result><redirecturl>{$rurl}</redirecturl>");
		}
		/* end charge */

		$service = 'bill';
		$bank = '快钱';
		$currency = 'CNY';
		ZOrder::OnlineIt($order_id, $orderId, $v_amount, $currency, $service, $bank);
		//redirect( WEB_ROOT . "/order/pay.php?id={$order_id}");
		break;

		default:
		//redirect( WEB_ROOT . "/order/pay.php?id={$order_id}");
		break;
	}

	$rurl = $INI['system']['wwwprefix'] . "/order/pay.php?id={$order_id}";
	die("<result>1</result><redirecturl>{$rurl}</redirecturl>");

}else{
	Session::Set('error', "签名错误，请联系管理员");
	//redirect( WEB_ROOT . "/order/pay.php?id={$order_id}");
	$rurl = $INI['system']['wwwprefix'] . "/order/pay.php?id={$order_id}";
	die("<result>1</result><redirecturl>{$rurl}</redirecturl>");
}

//功能函数。将变量值不为空参数组成字符串
Function appendParam($returnStr,$paramId,$paramValue){

	if($returnStr!=""){

		if($paramValue!=""){

			$returnStr.="&".$paramId."=".$paramValue;
		}

	}else{

		If($paramValue!=""){
			$returnStr=$paramId."=".$paramValue;
		}
	}

	return $returnStr;
}
//功能函数。将变量值不为空参数组成字符串。结束
