<?php
/**
 * @version      1.00
 * @author       Ali Derakhshan
 * @package      pm_payping
 * @copyright    Copyright (C) 2020
 * @license      GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');

define(_JSHOP_PM_PAYPING_TOKEN_LABLE, 'Token (Bearer)');
define(_JSHOP_PM_PAYPING_TOKEN_TOOLTIP, 'Bearer token that recived form payping website.');
define(_JSHOP_PM_PAYPING_Return_URL_LABLE, 'Return URL');
define(_JSHOP_PM_PAYPING_Return_URL_TOOLTIP, 'The return url that used to take the token. Note that if you change the Alias the part of js_paymentclass must be equal to it');
define(_JSHOP_PM_PAYPING_CONFIRM_PAYMENT_AFTER_RETURN, 'Verify the payment after return from bank.');
define(_JSHOP_PM_PAYPING_ENDFORM_SEND_TO_BANK, 'Redirectiong to the bank');
define(_JSHOP_PM_PAYPING_ENDFORM_PAYMENT_CREATED_MSG, 'Your peyment created');
define(_JSHOP_PM_PAYPING_ENDFORM_PAYMENT_PAYMENT_CODE_LABLE, 'Peyment Code');
define(_JSHOP_PM_PAYPING_PAPINGCLASS_DESCRIPTION, 'Purchase from the store with the order number');
define(_JSHOP_PM_PAYPING_PAPINGCLASS_CONFIG_ERROR, 'Please check the payping port settings');
define(_JSHOP_PM_PAYPING_PAPINGCLASS_NO_CODE_ERROR, 'Transaction failed - Error description: No reference code.');
define(_JSHOP_PM_PAYPING_PAPINGCLASS_NOT_SUCCESSFUL_ERROR, 'Transaction failed, error description: ');
define(_JSHOP_PM_PAYPING_PAPINGCLASS_CONECTION_TO_PAYPING_ERROR, 'Error in connectiong to payping, error description: ');
define(_JSHOP_PM_PAYPING_PAPINGCLASS_VERIFY_NOT_SUCCESSFUL_ERROR, 'Transaction failed - Error description: ');
define(_JSHOP_PM_PAYPING_PAPINGCLASS_REFERAL_CODE_LABLE, 'Your tracking code');
define(_JSHOP_PM_PAYPING_PAPINGCLASS_TRX_SUCCESSFUL_MSG, 'Transaction accomplished');
define(_JSHOP_PM_PAYPING_PAPINGCLASS_TRX_ERORR_400_MSG, 'Code 400: There is a problem sending the request');
define(_JSHOP_PM_PAYPING_PAPINGCLASS_TRX_ERORR_401_MSG, 'Code 401: No access');
define(_JSHOP_PM_PAYPING_PAPINGCLASS_TRX_ERORR_403_MSG, 'Code 403: Unauthorized access');
define(_JSHOP_PM_PAYPING_PAPINGCLASS_TRX_ERORR_404_MSG, 'Code 404: The requested item is not available');
define(_JSHOP_PM_PAYPING_PAPINGCLASS_TRX_ERORR_500_MSG, 'Code 500: There was a problem with the server');
define(_JSHOP_PM_PAYPING_PAPINGCLASS_TRX_ERORR_503_MSG, 'Code 503: The server is currently unable to respond');
define(_JSHOP_PM_PAYPING_PAPINGCLASS_TRX_ERORR_NOT_EXPECTED_ERORR_MSG, 'An unexpected error occurred');
define(_JSHOP_PM_PAYPING_PAPINGCLASS_TRX_ERORR_hck2_MSG, 'Please use allowable characters');
define(_JSHOP_PM_PAYPING_PAPINGCLASS_TRX_ERORR_notff_MSG, 'Order not found');
define(_JSHOP_PM_PAYPING_PAPINGCLASS_TRX_ERORR_CODE_MSG, 'error code');
define(_JSHOP_PM_PAYPING_PAPINGCLASS_FINAL_PAYMENT_MSG, 'Paying through banking portals through payment aid of <i>Payping<i>');
define(_JSHOP_PM_PAYPING_PAPINGCLASS_FINAL_PAYMENT_BOTTOM_LABLE, 'Click to pay');
define(_JSHOP_PM_PAYPING_PAPINGCLASS_TOMAN_CURRENCY_LABLE, 'Toman');
define(_JSHOP_PM_PAYPING_PAPINGCLASS_RIAL_CURRENCY_LABLE, 'Rial');
define(_JSHOP_PM_PAYPING_PAPINGCLASS_PAYMENT_AMOUNT_LABLE, 'Payment amount');
?>
