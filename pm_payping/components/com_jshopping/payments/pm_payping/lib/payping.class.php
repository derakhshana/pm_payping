<?php

/**
 * Abzarware
 *
 * payping getway class
 *
 * @copyright	(c) 2020 Ali Derakhshan
 * @author		Ali Derakhshan <ali_drn[at]yahoo[dot]com>
 *
 * @license		http://www.opensource.org/licenses/gpl-3.0.html
 * @version		1.0
 */

Class Payping
{


	/**
	 * Payping token for OAuth2
	 *
	 * @var integer
	 */
	public $Token;
	
	/**
	 * Sep price payment amount
	 *
	 * @var integer
	 */
	public $Currency;
	
	/**
	 * Return URL in from Sep
	 *
	 * @var string
	 */
	public $ReturnPath;

	

	
	/**
	 * Constructors
	 */
	public function __construct()
	{		

	}

	/* 
	* retives the order id from orders table by order hash if exist
	*
	* Return order id or NULL if not exist.
	*/
	public static function getOrderidFromDB($Hash)
	{
		if (!$Hash || empty($Hash))
			return(null);
		//Obtain JDatabase static connection
		$oDb = JFactory::getDbo();
		$oQuery = $oDb->getQuery(true);

		$oQuery->select(array('order_id'))
			   ->from('#__jshopping_orders')
			   ->where('order_hash = \'' . $Hash . '\'');

		$oDb->setQuery($oQuery);

		$result = $oDb->loadObjectList();

		if (empty($result))
			return(null);

		return $result[0]->order_id;		
	}

	function getGateMsg ($msgId) {
		switch($msgId){
			case 200 :
				return _JSHOP_PM_PAYPING_PAPINGCLASS_TRX_SUCCESSFUL_MSG;
				break ;
			case 400 :
				return _JSHOP_PM_PAYPING_PAPINGCLASS_TRX_ERORR_400_MSG;
				break ;
			case 401 :
				return _JSHOP_PM_PAYPING_PAPINGCLASS_TRX_ERORR_401_MSG;
				break;
			case 403 :
				return _JSHOP_PM_PAYPING_PAPINGCLASS_TRX_ERORR_403_MSG;
				break;
			case 404 :
				return _JSHOP_PM_PAYPING_PAPINGCLASS_TRX_ERORR_404_MSG;
				break;
			case 500 :
				return _JSHOP_PM_PAYPING_PAPINGCLASS_TRX_ERORR_500_MSG;
				break;
			case 503 :
				return _JSHOP_PM_PAYPING_PAPINGCLASS_TRX_ERORR_503_MSG;
				break;
			case	'1':
			case	'error':
				$out = _JSHOP_PM_PAYPING_PAPINGCLASS_TRX_ERORR_NOT_EXPECTED_ERORR_MSG . _JSHOP_PM_PAYPING_PAPINGCLASS_TRX_ERORR_CODE_MSG . ': ' . $msgId;
				break;
			case	'hck2':
				$out = _JSHOP_PM_PAYPING_PAPINGCLASS_TRX_ERORR_hck2_MSG;
				break;
			case	'notff':
				$out = _JSHOP_PM_PAYPING_PAPINGCLASS_TRX_ERORR_notff_MSG;
				break;
			default: 
				$out = _JSHOP_PM_PAYPING_PAPINGCLASS_TRX_ERORR_NOT_EXPECTED_ERORR_MSG . _JSHOP_PM_PAYPING_PAPINGCLASS_TRX_ERORR_CODE_MSG . ': ' . $msgId;
				break;
		}
		return $out;
	}
	
	/**
	 * Verify Payment
	 *
	 * @refid  the retured id to verify peyment
	 * @amount the amount of peyment in toman
	 *
	 * @return Status verify
	 */
	public function Verify($refid, $amount, $token)
	{
		$dataSend = array('refId' => $refid, 'amount' => $amount);
		try
		{
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://api.payping.ir/v2/pay/verify",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => json_encode($dataSend),
				CURLOPT_HTTPHEADER => array(
					"accept: application/json",
					"authorization: Bearer " . $token,
					"cache-control: no-cache",
					"content-type: application/json",
				),
			));
			$response = curl_exec($curl);
			$err = curl_error($curl);
			$header = curl_getinfo($curl);
			curl_close($curl);
			if ($err)
			{
				$msg= _JSHOP_PM_PAYPING_PAPINGCLASS_CONECTION_TO_PAYPING_ERROR . '<br />' . $err ;
				return array(0, $msg);
			}
			else
			{
				if ($header['http_code'] == 200)
				{
					$msg = $this->getGateMsg($header['http_code']);
					$msg .= _JSHOP_PM_PAYPING_PAPINGCLASS_REFERAL_CODE_LABLE . $refid;
					return array(1, $msg);
				} 
				elseif ($header['http_code'] == 400)
				{
					$msg= _JSHOP_PM_PAYPING_PAPINGCLASS_VERIFY_NOT_SUCCESSFUL_ERROR .  implode('. ',array_values (json_decode($response, true))) ;					
					return array(0, $msg);
				}  else {
					$msg= _JSHOP_PM_PAYPING_PAPINGCLASS_VERIFY_NOT_SUCCESSFUL_ERROR . $this->getGateMsg($header['http_code']);
					return array(0, $msg);
				}
			}
		} catch (Exception $e)
		{
			$msg= _JSHOP_PM_PAYPING_PAPINGCLASS_VERIFY_NOT_SUCCESSFUL_ERROR . '<br />Internal erorr: ' . $e->getMessage();
			return array(0, $msg);
		}
	}
	
	/**
	 * function to make a payment by using order info and token
	 * Returns the 'code' that payping returns if succeed!
	 * 
	 */
	function prepPayment( $order )
    {
		$app	= JFactory::getApplication();
        $vars = new JObject();
        $vars->order_hash = $order->order_hash;
        $vars->order_number = $order->order_number;
        $vars->orderpayment_amount = $order->order_total;
		$vars->token = $this->Token;
		$vars->currency = $this->Currency;
		$var->payerName = $order->f_name . ' ' . $order->l_name;
        $vars->Email = $order->email;
		if ($vars->token == null || $vars->token == '')
		{
			$link = JRoute::_(JURI::root(). "index.php?option=com_jshopping&controller=checkout" );
			$app->redirect($link, '<h3>' . _JSHOP_PM_PAYPING_PAPINGCLASS_CONFIG_ERROR . '</h3>', $msgType='Error');
		}
		else{
			$Amount = floor(round($vars->orderpayment_amount, 0)/ $vars->currency); // Toman
			$Description = _JSHOP_PM_PAYPING_PAPINGCLASS_DESCRIPTION . ': ' . $vars->order_number;
			$CallbackURL = $this->ReturnPath;
			
			$dataSend = array('payerName' => $var->payerName, 'Amount' => $Amount, 'payerIdentity'=> $vars->Email, 'returnUrl' => $CallbackURL, 'Description' => $Description, 'clientRefId' => $vars->order_hash);
			try 
			{
				$curl = curl_init();
				curl_setopt_array($curl, array(
						CURLOPT_URL => "https://api.payping.ir/v2/pay",
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => "",
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 30,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => "POST",
						CURLOPT_POSTFIELDS => json_encode($dataSend),
						CURLOPT_HTTPHEADER => array(
							"accept: application/json",
							"authorization: Bearer " .$vars->token,
							"cache-control: no-cache",
							"content-type: application/json"),
					)
				);
				$response = curl_exec($curl);
				$header = curl_getinfo($curl);
				$err = curl_error($curl);
				curl_close($curl);
				if ($err)
				{
					$link = JRoute::_( "index.php?option=com_jshopping&controller=checkout" );
					$app->redirect($link, '<h3>' . _JSHOP_PM_PAYPING_PAPINGCLASS_NOT_SUCCESSFUL_ERROR . "<br /> cURL Error #:" . $err . '</h3>', $msgType='Error');
				}
				else
				{
					if ($header['http_code'] == 200) {
						$response = json_decode($response, true);
						if (isset($response["code"]) and $response["code"] != '')
						{								 
							$code = $response["code"];
							return $code;
						}
						else
						{
							$link = JRoute::_( "index.php?option=com_jshopping&controller=checkout" );
							$app->redirect($link, '<h3>' . _JSHOP_PM_PAYPING_PAPINGCLASS_NO_CODE_ERROR . '</h3>', $msgType='Error');
						}
					} elseif ($header['http_code'] == 400) {
						$link = JRoute::_( "index.php?option=com_jshopping&controller=checkout" );
						$app->redirect($link, '<h3>' . _JSHOP_PM_PAYPING_PAPINGCLASS_NOT_SUCCESSFUL_ERROR . implode('. ', array_values (json_decode($response, true))) . '</h3>', $msgType='Error');
					} else {
						$link = JRoute::_( "index.php?option=com_jshopping&controller=checkout" );
						$app->redirect($link, '<h3>' . _JSHOP_PM_PAYPING_PAPINGCLASS_NOT_SUCCESSFUL_ERROR . $this->getGateMsg($header['http_code']). '(' . $header['http_code'] . ')' . '</h3>', $msgType='Error');
					}
				}
			} catch (Exception $e) {
				$link = JRoute::_("index.php?option=com_jshopping&controller=checkout");
				$app->redirect($link, '<h3>' . _JSHOP_PM_PAYPING_PAPINGCLASS_NOT_SUCCESSFUL_ERROR . '<br />' . $e->getMessage() .'</h3>', $msgType = 'Error');
			}
		}
    }

	
}