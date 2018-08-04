<?php
class HF18_Final_Model_Standard extends Mage_Payment_Model_Method_Abstract {
    protected $_code  = 'smart_voucher';
    protected $_formBlockType = 'hf18_final/form_smartvoucher';
    protected $_infoBlockType = 'hf18_final/info_smartvoucher';
    protected $_isInitializeNeeded      = true;
    protected $_canUseInternal          = false;
    protected $_canUseForMultishipping  = false;
    public function assignData($data)
    {
        $info = $this->getInfoInstance();
        if ($data->getSmartVoucher())
        {
            $info->setSmartVoucher($data->getSmartVoucher());
        }
        return $this;
    }
    /**
     * Validate payment method
     *
     * @return $this|Mage_Payment_Model_Abstract
     * @throws Mage_Core_Exception
     * @throws Varien_Exception
     */
    public function validate()
    {
        parent::validate();
        $info = $this->getInfoInstance();
        $code=$info->getSmartVoucher();
        //Get collection for input code
        $code_search=Mage::getModel('hf18_final/voucher')->getCollection()->addFieldToFilter('code', array('eq' => $code));
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        //Query with Binary to compare uppercase or lowercase
        $query=$code_search->getSelect()->where(' code =BINARY ?', $code);
        $smart_code =$read->query($query)->fetchAll();
        if (!$info->getSmartVoucher())
        {
            $errorMsg = $this->_getHelper()->__("Smart voucher is a required field.");
        }
        else {
            $vouchers = $smart_code;
            $quoteTotal = Mage::getSingleton('checkout/session')->getQuote()->getGrandTotal();
            $today = date("Y-m-d");
            // Find voucher which is suitable condition (Code, active)
            if(!$vouchers) {
                $errorMsg = $this->_getHelper()->__("Voucher code is not correct.");
            }
            else if($vouchers[0]['active'] == 0)
            {
                $errorMsg = $this->_getHelper()->__("Voucher code is inactive.");
            }
            else {
                $voucher = $vouchers[0];
                //Setting Customer Group to assign Voucher
                $customerGroupStr = $voucher['customer_group'];
                $customerIdStr = $voucher['customer_id'];
                $isLoggedIn = Mage::getSingleton('customer/session')->isLoggedIn();
                $flag = [1];
                if(strlen($customerGroupStr) != 0 || strlen($customerIdStr) != 0)
                {
                    $flag = [];
                }
                if(strlen($customerGroupStr) != 0)
                {
                    $customerGroupArr =  explode(",",$customerGroupStr);
                    $customerGroupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
                    if($isLoggedIn && in_array($customerGroupId, $customerGroupArr))
                    {
                        array_push($flag,1);
                    }
                    else if(!$isLoggedIn && in_array(0, $customerGroupArr))
                    {
                        array_push($flag,1);
                    }
                }
                if(strlen($customerIdStr) != 0 && $isLoggedIn)
                {
                    $customerIdArr = explode(",",$customerIdStr);
                    $customerId = Mage::getSingleton('customer/session')->getCustomer()->getId();
                    if(in_array($customerId, $customerIdArr))
                    {
                        array_push($flag,1);
                    }
                }
                if(!in_array(1, $flag))
                {
                    $errorMsg = $this->_getHelper()->__("You don't have enough conditions to use this voucher .");
                }
                else{
                    // Compare with grand total value
                    if($quoteTotal > $voucher['value']) {
                        $errorMsg = $this->_getHelper()->__("This voucher is not enough to checkout.");
                    }
                    // Compare code's active duration with current day
                    if($voucher['started_at'] > $today ) {
                        $errorMsg = $this->_getHelper()->__("This voucher is not up to date.");
                    }
                    if($voucher['expire_at']){
                        if($voucher['expire_at'] < $today){
                            $errorMsg = $this->_getHelper()->__("This voucher can not use in this period.");
                        }
                    }
                }
            }
        }
        if ($errorMsg)
        {
            Mage::throwException($errorMsg);
        }
        return $this;
    }
}
