<?php
/**
 * @version      1.00
 * @author       Ali Derakhshan
 * @package      pm_payping
 * @copyright    Copyright (C) 2020
 * @license      GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');

?>

<div class="col100">
<fieldset class="adminform">
<table class="admintable" width = "100%" >
 <tr>
   <td style="width:350px;" class="key">
     <?php echo _JSHOP_PM_PAYPING_TOKEN_LABLE;?>
   </td>
   <td>
     <input type = "text" class = "inputbox" name = "pm_params[token]" size="45" value = "<?php echo $params['token']?>" />
     <?php echo JHTML::tooltip(_JSHOP_PM_PAYPING_TOKEN_TOOLTIP);?>             
   </td>
 </tr>
 <tr>
   <td style="width:350px;" class="key">
     <?php echo _JSHOP_PM_PAYPING_Return_URL_LABLE;?>
   </td>
   <td>
     <input type = "text" class = "inputbox" name = "pm_params[returnUrl]" size="45" value = "<?php echo $params['returnUrl']; ?>" />
     <?php echo JHTML::tooltip(_JSHOP_PM_PAYPING_Return_URL_TOOLTIP);?>             
   </td>
 </tr>
	<tr>
   <td class="key">
     <?php echo _JSHOP_CURRENCY_PARAMETERS;?>
   </td>
   <td>
     <?php              
     print JHTML::_('select.genericlist', array('1' => _JSHOP_PM_PAYPING_PAPINGCLASS_TOMAN_CURRENCY_LABLE, '10' => _JSHOP_PM_PAYPING_PAPINGCLASS_RIAL_CURRENCY_LABLE), 'pm_params[currency]', 'class = "inputbox" size = "1"', 'currency', 'name', $params['currency'] );
     echo " ".JHTML::tooltip('Select the currency');
     ?>
   </td>
 </tr>
 <tr>
   <td class="key">
     <?php echo _JSHOP_TRANSACTION_END;?>
   </td>
   <td>
     <?php              
     print JHTML::_('select.genericlist', $orders->getAllOrderStatus(), 'pm_params[transaction_end_status]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['transaction_end_status'] );
     echo " ".JHTML::tooltip('Select the order status to which the actual order is set, if the transection was successful.');
     ?>
   </td>
 </tr>
 <tr>
   <td class="key">
     <?php echo _JSHOP_TRANSACTION_PENDING;?>
   </td>
   <td>
     <?php 
     echo JHTML::_('select.genericlist',$orders->getAllOrderStatus(), 'pm_params[transaction_pending_status]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['transaction_pending_status']);
     echo " ".JHTML::tooltip('The order Status to which Orders are set, which have no completed Payment Transaction.');
     ?>
   </td>
 </tr>
 <tr>
   <td class="key">
     <?php echo _JSHOP_TRANSACTION_FAILED;?>
   </td>
   <td>
     <?php 
     echo JHTML::_('select.genericlist',$orders->getAllOrderStatus(), 'pm_params[transaction_failed_status]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['transaction_failed_status']);
     echo " ".JHTML::tooltip('Select an order status for failed transactions.');
     ?>
   </td>
 </tr>
 <tr>
   <td class="key">
     <?php echo _JSHOP_PM_PAYPING_CONFIRM_PAYMENT_AFTER_RETURN;?>
   </td>
   <td>
     <?php              
     print JHTML::_('select.booleanlist', 'pm_params[checkdatareturn]', 'class = "inputbox" size = "1"', $params['checkdatareturn']);     
     ?>
   </td>
 </tr>
</table>
</fieldset>
</div>
<div class="clr"></div>