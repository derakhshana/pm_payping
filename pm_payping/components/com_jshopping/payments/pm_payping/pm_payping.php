<?php
/*
 * @version      1.0.0
 * @author       Ali Derakhshan
 * @package      pm_payping
 * @copyright    Copyright (C) 2020
 * @license      GNU/GPL
 */

defined('_JEXEC') or die('Restricted access');


require_once dirname(__FILE__) . '/lib/payping.class.php';

class pm_payping extends PaymentRoot
{
	function __construct() {
		JSFactory::loadExtLanguageFile('pm_payping');
	}
	
	function showPaymentForm($params, $pmconfigs)
	{
		include(dirname(__FILE__)."/paymentform.php");
    }


	//function call in admin
	function showAdminFormParams($params)
	{
		$array_params = array('token', 'returnUrl', 'currency', 'transaction_end_status', 'transaction_pending_status', 'transaction_failed_status');
        	 
		foreach ($array_params as $key)
		{
          if (!isset($params[$key]))
          {
              $params[$key] = '';
          }
		}		
		if (empty($params['returnUrl']) || strlen($params['returnUrl']) < 42)
		{
			$params['returnUrl'] = JURI::root() . "index.php?option=com_jshopping&controller=checkout&task=step7&act=return&js_paymentclass=" . $this->pm_method->payment_class; 
		}
		if (!isset($params['returnUrl']))
			$params['returnUrl'] = JURI::root() .
			"index.php?option=com_jshopping&controller=checkout&task=step7&act=return&js_paymentclass=pm_payping"; 
		$orders = JModelLegacy::getInstance('orders', 'JshoppingModel'); 
		
		include(dirname(__FILE__)."/adminparamsform.php");
	}


	function checkTransaction($pmconfigs, $order, $act)
	{

		if ($act == 'return')
		{
		}
		if ($act == 'notify')
		{
		}
		$jshopConfig = &JSFactory::getConfig();

		include_once 'lib/payping.class.php';

		$payping1 = new Payping();

		$Inputs = JFactory::getApplication()->input->getArray(
			array('refid' => 'STRING',
				  'code' => 'STRING',
				  'clientrefid' => 'STRING',
				  'cardnumber' => 'STRING',
				  'cardhashpan' => 'STRING'));
		
		$transaction = $Inputs['refid'];		
		$transactiondata = array('Refid'=>$Data['refid'], 'code'=>$Inputs['code'], 'cardnumber'=>$Inputs['cardnumber'], 'cardhashpan'=>$Inputs['cardhashpan']);

		$token = $pmconfigs['token'];
		$Amount = floor(round($order->order_total, 0) / $pmconfigs['currency']); // Toman
		$result = $payping1->Verify($Inputs['refid'], $Amount, $token);
		
		return array($result[0], $result[1] . '. ' . _JSHOP_ORDER_NUMBER . ': ' . $order->order_number . ' ' . _JSHOP_PM_PAYPING_PAPINGCLASS_REFERAL_CODE_LABLE . ': ' . $Inputs['refid'], $transaction, $transactiondata);		
	}


	function showEndForm($pmconfigs, $order)
	{    
        $jshopConfig = &JSFactory::getConfig(); 
		
		$notify_url = JURI::root() . "index.php?option=com_jshopping&controller=checkout&task=step7&act=notify&js_paymentclass=pm_payping&no_lang=1";

        $cancel_return = JURI::root() . "index.php?option=com_jshopping&controller=checkout&task=step7&act=cancel&js_paymentclass=pm_payping";
		
		$payping1 = new Payping();
		
        $payping1->ReturnPath = $pmconfigs['returnUrl'];
		$payping1->Token = $pmconfigs['token'];
		$payping1->Currency = $pmconfigs['currency'];

		$code = $payping1->prepPayment($order);
		
		$order->setPaymentParamsData(array('payment_code' => $code));
		$order->store();
?>
        <html>
        <head>
        	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
        </head>
        <body>
			<table align="center" >
				<thead>
					<tr>
     				<th>
					<strong>
						<?php echo _JSHOP_PM_PAYPING_ENDFORM_PAYMENT_CREATED_MSG ?>
					</strong>
					</th>
					</tr>
				</thead>
				<tbody align="center">
					<tr>
					<td>
						<b>
						<?php echo _JSHOP_ORDER_NUMBER . ': ' ?>
						</b>
						<i><?php echo $order->order_number ?></i>
					</td>
					</tr>
					<tr>
					<td>
						<b>
						<?php echo _JSHOP_PM_PAYPING_ENDFORM_PAYMENT_PAYMENT_CODE_LABLE . ': ' ?>
						</b>
						<i><?php echo $code ?></i>
					</td>
					</tr>
					<tr>
					<td>
						<h6 class="card-title"><?php echo(_JSHOP_PM_PAYPING_PAPINGCLASS_FINAL_PAYMENT_MSG) ?></h6>
					</td>
					</tr>
					<tr>
					<td>
						<a class="button btn btn-primary" href="<?php echo "https://api.payping.ir/v2/pay/gotoipg/" . $code; ?>" >
						<?php echo(_JSHOP_PM_PAYPING_PAPINGCLASS_FINAL_PAYMENT_BOTTOM_LABLE); ?>
						</a>
					</td>
					</tr>
				</tbody>		
			</table>
			<?php //print _JSHOP_PM_PAYPING_ENDFORM_SEND_TO_BANK; ?>
			<br />
		</body>
		</html>

<?php
		//die();
	}	
	
	
	function getUrlParams($pmconfigs)
	{
		$params = array(); 
		
		$hash = JFactory::getApplication()->input->getString("clientrefid");

		$params['order_id'] = Payping::getOrderidFromDB($hash);
		
		$params['hash'] = $hash;

		$params['checkHash'] = 1;

		$params['checkReturnParams'] = $pmconfigs['checkdatareturn'];
		
		return $params;

  }   

}

?>
